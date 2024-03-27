<?php

namespace App\Http\Controllers\Ajax\Paypal;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Services\Interface\PaypalServiceInterface;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    public function create(CreateOrderRequest $request)
    {
        return app(PaypalServiceInterface::class)->create($request);
    }

    public function capture(string $vendorOrderId)
    {
        return app(PaypalServiceInterface::class)->capture($vendorOrderId);
    }
}
