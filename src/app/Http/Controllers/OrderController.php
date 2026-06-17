<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\OrderAddress;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;

class OrderController extends Controller
{
    public function create($itemId)
    {
        $item = Item::findOrFail($itemId);
        $profile = auth()->user()->profile;

        if (!$profile) {
            return redirect('/mypage/profile');
        }

        $orderAddress = session('order_address_' . $itemId, [
            'postal_code' => $profile->postal_code,
            'address' => $profile->address,
            'building_name' => $profile->building_name,
        ]);

        return view('orders.create', compact('item', 'profile', 'orderAddress'));
    }

    public function store(PurchaseRequest $request, $itemId)
    {
        $item = Item::findOrFail($itemId);

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentMethod = $request->payment_method;

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

    public function updateAddress(AddressRequest $request, $itemId)
    {
        auth()->user()->profile()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building_name' => $request->building_name,
            ]
        );

        session([
            'order_address_' . $itemId => [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building_name' => $request->building_name,
            ]
        ]);

        return redirect('/item/' . $itemId . '/order');
    }

    public function success($itemId)
    {
        $item = Item::findOrFail($itemId);

        $order = Order::create([
            'buyer_user_id' => auth()->id(),
            'item_id' => $item->id,
            'payment_method' => request('payment_method'),
            'order_status' => 1,
            'ordered_at' => now(),
        ]);

        $orderAddress = session('order_address_' . $itemId);

        if ($orderAddress) {
            OrderAddress::create([
                'order_id' => $order->id,
                'postal_code' => $orderAddress['postal_code'],
                'address' => $orderAddress['address'],
                'building_name' => $orderAddress['building_name'],
            ]);
        }

        $item->update([
            'is_sold' => true,
        ]);

        return redirect('/');
    }
}
