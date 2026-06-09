<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();

        return view('sell.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('items', 'public');
        }

        $item = Item::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'brand_name' => $request->brand_name,
            'description' => $request->description,
            'price' => $request->price,
            'item_condition' => $request->item_condition,
            'image_path' => $imagePath,
            'is_sold' => false,
        ]);

        $item->categories()->attach($request->categories);

        return redirect('/');
    }
}
