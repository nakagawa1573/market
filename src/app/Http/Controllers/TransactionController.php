<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellRequest;
use App\Models\Category;
use App\Models\DeliveryAddress;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\PurchaseHistory;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class TransactionController extends Controller
{
    public function show(Item $item_id)
    {
        $item = Item::with('user')->find($item_id->id);
        session(['item' => $item]);
        $user = User::with('profile')->find(Auth::user())->first();
        if (!$user->profile) {
            return back()->with('message', 'マイページからプロフィールの登録をしてください');
        }else{
            $profile = $user->profile->only(['post_code', 'address', 'building']);
        }
        $delivery = DeliveryAddress::where('user_id', $user->id)->first();
        $stripe = new \Stripe\StripeClient(config('cashier.secret'));
        $customerId = $user->stripe_customer_id;
        if (!$customerId) {
            $customerId = $stripe->customers->create([])->id;
            User::find($user->id)->update(['stripe_customer_id' => $customerId]);
        }
        $clientSecret = $stripe->paymentIntents->create([
            'amount' => $item_id->price,
            'customer' => $customerId,
            'currency' => 'jpy',
            'application_fee_amount' => round($item->price * 0.1),
            'transfer_data' => ['destination' => $item->user->stripe_account_id],
        ])->client_secret;
        return view('purchase', compact('clientSecret', 'profile', 'delivery'));
    }

    public function buy(Item $item_id)
    {
        $item = Item::with('user')->where('id', $item_id->id)->first();
        $flag = PurchaseHistory::where('item_id', $item->id)->exists();
        if (!$flag) {
            $purchase = ['user_id' => Auth::user()->id, 'item_id' => $item->id];
            PurchaseHistory::create($purchase);
        }
        return redirect('/');
    }

    public function create()
    {
        if (Auth::user()->stripe_account_id !== null) {
            $statuses = Status::all();
            $categories = Category::all();
            return view('sell', compact('statuses', 'categories'));
        }else {
            $stripe = new StripeController();
            $response = $stripe->store();
            return $response;
        }
    }

    public function store(SellRequest $request)
    {
        DB::beginTransaction();
        $item = $request->only(['status_id', 'brand', 'name', 'description', 'price']);
        $item['user_id'] = Auth::user()->id;
        $img = $request->file('img');
        try {
            if (app()->isLocal() || app()->runningUnitTests()) {
                $path = Storage::disk('public')->put('/items', $img);
            } elseif (app()->isProduction()) {
                $path = Storage::disk('s3')->put('/items', $img);
            }
            $item['img'] = basename($path);
            $item = Item::create($item);
            $itemCategory = ['item_id' => $item->id];
            foreach ($request->category_id as $category_id) {
                $itemCategory['category_id'] = $category_id;
                ItemCategory::create($itemCategory);
            }
            DB::commit();
        } catch (\Exception | QueryException $e) {
            DB::rollback();
            if (isset($path)) {
                Storage::delete($path);
            }
            return back()->with('message', '登録に失敗しました');
        }
        return redirect('/mypage');
    }
}
