<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Item;
use App\Models\Profile;
use App\Models\PurchaseHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $sells = Item::where('user_id', $userId)->get();
        $purchases = PurchaseHistory::with('item')->where('user_id', $userId)->get();
        $profile = Profile::where('user_id', $userId)->first();
        return view('mypage', compact('sells', 'purchases', 'profile'));
    }

    public function create()
    {
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        return view('profile', compact('profile'));
    }

    public function storeProfile(ProfileRequest $request)
    {
        $profile = $request->only(['name', 'post_code', 'address', 'building']);
        $profile['user_id'] = Auth::user()->id;
        $img = $request->file('img');
        try {
            if (app()->isLocal()) {
                $path = Storage::disk('public')->put('/profiles', $img);
            } elseif (app()->isProduction()) {
                $path = Storage::disk('s3')->put('/profiles', $img);
            }
            $profile['img'] = basename($path);
            Profile::create($profile);
        } catch (\Exception | QueryException $e) {
            if (isset($path)) {
                Storage::delete($path);
            }
            return back()->with('登録に失敗しました');
        }
        return back();
    }

    public function update(ProfileRequest $request)
    {
        $profile = Profile::find(Auth::user()->id);
        $profileData = $request->only(['name', 'post_code', 'address', 'building']);
        $img = $request->file('img');
        if ($img) {
            if (app()->isLocal()) {
                Storage::disk('public')->delete('/profiles', $profile->img);
                $path = Storage::disk('public')->put('/profiles', $img);
            } elseif (app()->isProduction()) {
                Storage::disk('s3')->delete('/profiles', $profile->img);
                $path = Storage::disk('s3')->put('/profiles', $img);
            }
            $profileData['img'] = basename($path);
        }
        $profile->update($profileData);

        return back();
    }
}
