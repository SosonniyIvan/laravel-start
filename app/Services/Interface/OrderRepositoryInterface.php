<?php

namespace App\Services\Interface;

use App\Enums\Payment;
use App\Enums\TransactionStatus;
use App\Models\Order;

interface OrderRepositoryInterface
{
    public function create(array $data):Order|bool;


    public function setTransaction(string $vendorOrderId, Payment $payment, TransactionStatus $status): Order;
}
