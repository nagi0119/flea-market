<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Favorite;

class ItemController extends Controller
{
    public function index()
    {
        $isMylist = request('tab') === 'mylist';
        $keyword = request('keyword');

        $items = $isMylist
            ? $this->getMylistItems($keyword)
            : $this->getRecommendedItems($keyword);

        return view('items.index', compact(
            'items',
            'isMylist'
        ));
    }

    public function show($itemId)
    {
        $item = Item::with(['categories', 'comments.user'])
            ->findOrFail($itemId);

        $isLiked = $this->isLiked($item->id);

        $likesCount = Favorite::where('item_id', $item->id)->count();

        $commentsCount = $item->comments->count();

        return view('items.show', compact(
            'item',
            'isLiked',
            'likesCount',
            'commentsCount'
        ));
    }

    private function getMylistItems($keyword)
    {
        if (!auth()->check()) {
            return collect();
        }

        return Item::whereHas('favorites', function ($query) {
            $query->where('user_id', auth()->id());
        })
            ->when($keyword, function ($query, $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->get();
    }

    private function getRecommendedItems($keyword)
    {
        return Item::query()
            ->when(auth()->check(), function ($query) {
                $query->where('user_id', '!=', auth()->id());
            })
            ->when($keyword, function ($query, $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->get();
    }

    private function isLiked($itemId)
    {
        if (!auth()->check()) {
            return false;
        }

        return Favorite::where('user_id', auth()->id())
            ->where('item_id', $itemId)
            ->exists();
    }
}
