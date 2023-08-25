<?php

if (!function_exists('cart')) {
    function cart()
    {
        return app()->make(\App\Services\CartService::class);
    }
}
