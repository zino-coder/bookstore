<?php

namespace App\Services;

class CartService
{
    public function add($id, $name, $price, $amount, $img)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            $cart[$id]['amount'] += $amount;
        } else {
            $cart[$id] = [
                'name' => $name,
                'price' => $price,
                'amount' => $amount,
                'img' => $img,
            ];
        }

        return session()->put('cart', $cart);
    }

    public function remove($id)
    {
        $cart = session()->get('cart');

        unset($cart[$id]);

        return session()->put('cart', $cart);
    }

    public function destroy()
    {
        return session()->forget('cart');
    }

    public function getContent()
    {
        return session()->get('cart', []);
    }

    public function getTotal()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['amount'] * $item['price'];
        }

        return $total;
    }
}
