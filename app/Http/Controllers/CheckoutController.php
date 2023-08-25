<?php

namespace App\Http\Controllers;

use App\Exceptions\CommonException;
use App\Mail\OrderSuccessMail;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('frontend.checkout.checkout');
    }

    public function checkout(Request $request)
    {
        try {
            DB::beginTransaction();
            $cart = cart()->getContent();

            $order = Order::create([
                'email' => $request->input('email-address'),
                'status' => 'placed',
            ]);

            foreach ($cart as $id => $item) {
                $orderItem = OrderItem::create([
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'amount' => $item['amount'],
                    'product_id' => $id,
                    'order_id' => $order->id,
                ]);
            }

            DB::commit();

//            cart()->destroy();
            Mail::to($order->email)
                ->queue(new OrderSuccessMail($order));

            return redirect()->route('checkout.success');
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function success()
    {
        return view('frontend.checkout.success');
    }
}
