<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserLoginListener
{
    public function handle(Login $event): void
    {
        if (Cart::instance('cart')->count() > 0){
            Cart::instance('cart')->store($event->user->id . "_cart");
        }
    }
}
