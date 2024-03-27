<?php

namespace App\Services;

use App\Enums\Payment;
use App\Enums\TransactionStatus;
use App\Http\Requests\CreateOrderRequest;
use App\Services\Interface\OrderRepositoryInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Srmklive\PayPal\Services\PayPal;

class PaypalService implements Interface\PaypalServiceInterface
{
    protected PayPal $paypalClient;

    public function __construct()
    {
        $this->paypalClient = app(Paypal::class);
        $this->paypalClient->setApiCredentials(config('paypal'));
        $this->paypalClient->setAccessToken($this->paypalClient->getAccessToken());
    }

    public function create(CreateOrderRequest $request)
    {
        try{
            DB::beginTransaction();

            $total = Cart::instance('cart')->total();

            $paypalOrder = $this->paypalClient->createOrder([
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => config('paypal.currency'),
                            'value' => $total
                        ]
                    ]
                ]
            ]);

            $request = array_merge(
                  $request->validated(),
                [
                    'vendor_order_id' => $paypalOrder['id'],
                    'total' => $total
                ]
            );

            $order = app(OrderRepositoryInterface::class)->create($request);

            DB::commit();

            return response()->json($order);
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->errorHandler($exception);
        }
    }

    public function capture(string $vendorOrderId)
    {
        try {
            DB::beginTransaction();

            $result = $this->paypalClient->capturePaymentOrder($vendorOrderId);
            $order = app(OrderRepositoryInterface::class)->setTransaction(
                $vendorOrderId,
                Payment::Paypal,
                $this->convertedStatus($result['status'])
            );
            $result['id'] = $order->id;

            DB::commit();

            return response()->json($result);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorHandler($exception);
        }
    }

    protected function errorHandler(\Exception $exception)
    {
        logs()->warning($exception);
        return response()->json(['error' => $exception->getMessage()], 422);
    }

    protected function convertedStatus(string $status): TransactionStatus
    {
        return match ($status){
            "COMPLETED", "APPROVED" => TransactionStatus::Success,
            "CREATED", "SAVED" => TransactionStatus::Pending,
            default => TransactionStatus::Canceled
        };
    }
}
