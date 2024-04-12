<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\PurchaseHistory;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class TransactionController extends Controller
{
    public function show(Item $item_id)
    {
        $item = $item_id;
        return view('purchase', compact('item'));
    }

    public function buy(Item $item_id)
    {
        $purchase = ['user_id' => Auth::user()->id, 'item_id' => $item_id->id];
        $count = PurchaseHistory::where($purchase)->count();
        if ($count === 0) {
            PurchaseHistory::create($purchase);
            return redirect('/');
        }
        return redirect('/');
    }

    public function create()
    {
        $statuses = Status::all();
        $categories = Category::all();
        return view('sell', compact('statuses', 'categories'));
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
