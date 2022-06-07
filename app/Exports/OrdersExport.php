<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
//    public function collection()
//    {
//        return Order::all();
//    }

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function view(): View
    {
        $orders = Order::all();
        return view('auth.export.orders', compact('orders'));
    }
}

