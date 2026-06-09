<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Comment;
use App\Models\Favorite;

class ItemController extends Controller
{
    public function index()
    {
        $isMylist = request('tab') === 'mylist';
        $keyword = request('keyword');

        if (request('tab') === 'mylist') {
            if (!auth()->check()) {
                $items = collect();

                return view('items.index', compact(
                    'items',
                    'isMylist'
                ));
            }

            $items = Item::whereHas('favorites', function ($query) {
                $query->where('user_id', auth()->id());
            })
                ->when($keyword, function ($query, $keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->get();

            return view('items.index', compact(
                'items',
                'isMylist'
            ));
        }

        $items = Item::query()
            ->when(auth()->check(), function ($query) {
                $query->where('user_id', '!=', auth()->id());
            })
            ->when($keyword, function ($query, $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->get();

        return view('items.index', compact(
            'items',
            'isMylist'
        ));
    }

    public function show($itemId)
    {
        // dd($item);
        $item = Item::with(['categories', 'comments.user'])
            ->findOrFail($itemId);
        // dd($item);
        $isLiked = false;

        if (auth()->check()) {
            $isLiked = Favorite::where('user_id', auth()->id())
                ->where('item_id', $item->id)
                ->exists();
        }

        $likesCount = Favorite::where('item_id', $item->id)->count();

        $commentsCount = $item->comments->count();

        return view('items.show', compact(
            'item',
            'isLiked',
            'likesCount',
            'commentsCount'
        ));
    }
}
