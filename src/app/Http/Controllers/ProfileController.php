<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\Item;

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
        $user = auth()->user();

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
                'building_name' => $request->building_name,
                'image_path' => $imagePath,
            ]
        );

        return redirect('/');
    }

    public function index()
    {
        $user = auth()->user();
        $tab = request('tab');

        $items = $tab === 'buy'
            ? $this->getPurchasedItems($user->id)
            : $this->getExhibitedItems($user->id);

        return view('mypage.index', compact(
            'user',
            'items',
            'tab'
        ));
    }

    private function getPurchasedItems($userId)
    {
        return Item::whereHas('order', function ($query) use ($userId) {
            $query->where('buyer_user_id', $userId);
        })->get();
    }

    private function getExhibitedItems($userId)
    {
        return Item::where('user_id', $userId)->get();
    }
}
