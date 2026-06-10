<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Profile;

class OrderController extends Controller
{
    public function create($itemId)
    {
        $item = Item::findOrFail($itemId);
        $profile = auth()->user()->profile;

        if (!$profile) {
            return redirect('/mypage/profile');
        }

        return view('orders.create', compact('item', 'profile'));
    }

    public function store($itemId)
    {
        $item = Item::findOrFail($itemId);

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentMethod = request('payment_method');

        if ($paymentMethod == 1) {
            $stripePaymentMethod = 'konbini';
        } else {
            $stripePaymentMethod = 'card';
        }

        $session = Session::create([
            'payment_method_types' => [$stripePaymentMethod],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/order/success/' . $item->id . '?payment_method=' . $paymentMethod),
            'cancel_url' => url('/item/' . $item->id . '/order'),
        ]);

        return redirect($session->url);
    }

    public function editAddress($itemId)
    {
        $item = Item::findOrFail($itemId);
        $profile = auth()->user()->profile;

        return view('orders.address', compact(
            'item',
            'profile'
        ));
    }
    public function updateAddress($itemId)
    {
        Profile::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'postal_code' => request('postal_code'),
                'address' => request('address'),
                'building_name' => request('building'),
            ]
        );

        return redirect('/item/' . $itemId . '/order');
    }
    public function success($itemId)
    {
        $item = Item::findOrFail($itemId);

        Order::create([
            'buyer_user_id' => auth()->id(),
            'item_id' => $item->id,
            'payment_method' => request('payment_method'),
            'order_status' => 1,
            'ordered_at' => now(),
        ]);

        $item->update([
            'is_sold' => true,
        ]);

        return redirect('/');
    }
}
