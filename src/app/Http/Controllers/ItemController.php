<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\PurchaseHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $weekAgo = Carbon::now()->subWeek();
        $now = Carbon::now();
        $items = Item::where([
            ['created_at', '>=', $weekAgo],
            ['created_at', '<=', $now],
        ])->get();
        foreach ($items as $item) {
            if (PurchaseHistory::where('item_id', $item->id)->exists()) {
                $key = $items->search($item);
                $items->pull($key);
            }
        }
        if (Auth::check()) {
            $favorites = Favorite::with('item')->where('user_id', Auth::user()->id)->get();
            return view('index', compact('items', 'favorites'));
        }
        return view('index', compact('items'));
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        if ($keyword === null) {
            $items = null;
        } else {
            $items = Item::with('category')
                ->Where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('brand', 'LIKE', '%' . $keyword . '%')
                ->orWhereHas('category', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%');
                })
                ->get();
        }
        return view('search', compact('items', 'keyword'));
    }

    public function detail(Item $item_id)
    {
        $item = Item::with('category', 'status')->where('id', $item_id->id)->first();
        $favorites = Favorite::where('item_id', $item->id);
        $favoriteCount = $favorites->count();
        $purchaseFlag = PurchaseHistory::where('item_id', $item_id->id)->exists();
        $comments = Comment::with('user.profile')->where('item_id', $item->id)->get()->sortByDesc('created_at');
        $favoriteFlag = null;
        if (Auth::check()) {
            $favoriteFlag = $favorites->where('user_id', Auth::user()->id)->exists();
        }
        return view('item', compact('item', 'favoriteCount', 'favoriteFlag', 'comments', 'purchaseFlag'));
    }


    public function storeComment(CommentRequest $request, Item $item_id)
    {
        $comment = $request->only('comment');
        $comment['user_id'] = Auth::user()->id;
        $comment['item_id'] = $item_id->id;
        Comment::create($comment);
        return back()->with('message', 'コメントを送信しました');
    }

    public function destroyComment(Comment $comment_id)
    {
        Comment::destroy($comment_id->id);
        return back()->with('message', 'コメントを削除しました');
    }

    public function storeFavorite(Item $item_id)
    {
        $user_id = Auth::user()->id;
        $favoriteData = Favorite::where('user_id', $user_id)->where('item_id', $item_id->id)->first();
        if ($favoriteData === null) {
            $favorite['user_id'] = $user_id;
            $favorite['item_id'] = $item_id->id;
            Favorite::create($favorite);
            return back();
        }
        return back();
    }

    public function destroyFavorite(Item $item_id)
    {
        Favorite::where('user_id', Auth::user()->id)->where('item_id', $item_id->id)->delete();
        return back();
    }
}
