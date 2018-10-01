<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Events\OrderShipped;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //
    public function ship($orderId) {
        $order = Order::findOrFail($OrderId);

        event(new OrderShipped($order));
    }

}
