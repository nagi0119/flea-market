<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function toggle(Item $item)
    {
        $favorite = Favorite::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'item_id' => $item->id,
            ]);
        }

        return back();
    }
}
