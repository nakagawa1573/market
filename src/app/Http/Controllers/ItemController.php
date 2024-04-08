<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category', 'status')->get();
        if (Auth::check()) {
            $favorites = Favorite::with('item')->where('user_id', Auth::user()->id)->get();
            return view('index', compact('items', 'favorites'));
        }
        return view('index', compact('items'));
    }

    public function detail(Item $item_id)
    {
        $item = Item::with('category', 'status')->where('id', $item_id->id)->first();
        $favorites = Favorite::where('item_id', $item->id)->get();
        $favoriteCount = $favorites->count();
        $user_id = Auth::user()->id;
        foreach ($favorites as $favorite) {
            if ($favorite->user_id == $user_id) {
                $favoriteFlag = true;
                break;
            }else{
                $favoriteFlag = false;
            }
        }
        $commentCount = Comment::where('item_id', $item->id)->count();
        return view('item', compact('item', 'favoriteCount', 'favoriteFlag', 'commentCount'));
    }
}
