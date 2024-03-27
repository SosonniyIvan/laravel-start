<?php

namespace App\Services\Interface;

use App\Http\Requests\CreateOrderRequest;

interface PaypalServiceInterface
{
    public function create(CreateOrderRequest $request);

    public function capture(string $vendorOrderId);
}
