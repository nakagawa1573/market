<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\PurchaseHistory;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $sells = Item::where('user_id', Auth::user()->id)->get();
        $purchases = PurchaseHistory::with('item')->where('user_id', Auth::user()->id)->get();
        return view('mypage', compact('sells', 'purchases'));
    }

    public function storeComment(CommentRequest $request, Item $item_id)
    {
        $comment = $request->only('comment');
        $comment['user_id'] = Auth::user()->id;
        $comment['item_id'] = $item_id->id;
        Comment::create($comment);
        return back()->with('message', 'コメントを送信しました');
    }

    public function storeFavorite(Item $item_id)
    {
        $favorite['user_id'] = Auth::user()->id;
        $favorite['item_id'] = $item_id->id;
        Favorite::create($favorite);
        return back();
    }

    public function destroy(Item $item_id)
    {
        Favorite::where('user_id', Auth::user()->id)->where('item_id', $item_id->id)->delete();
        return back();
    }
}
