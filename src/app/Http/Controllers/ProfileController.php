<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile;

        return view('profile', compact(
            'user',
            'profile'
        ));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'name' => $request->name,
        ]);

        $profile = $user->profile;

        $imagePath = $profile->image_path ?? null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('profiles', 'public');
        }

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building_name' => $request->building,
                'image_path' => $imagePath,
            ]
        );

        return redirect('/');
    }

    public function index()
    {
        $user = Auth::user();

        $tab = request('tab');

        if ($tab === 'buy') {
            $items = Item::whereHas('order', function ($query) use ($user) {
                $query->where('buyer_user_id', $user->id);
            })->get();
        } else {
            $items = Item::where('user_id', $user->id)->get();
        }

        return view('mypage.index', compact(
            'user',
            'items',
            'tab'
        ));
    }
}
