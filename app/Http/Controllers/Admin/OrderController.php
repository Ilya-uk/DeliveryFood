<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderFilterRequest;
use App\Mail\OrderUpdate;
use App\Models\Courier;
use App\Models\Order;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;
use function view;

class OrderController extends Controller
{
    public function index(OrderFilterRequest $request)
    {
        $ordersQuery = Order::query();



        if ($request->filled('price_from')) {
            $ordersQuery->where('summa', '>=', $request->price_from);
        }

        if ($request->filled('price_to')) {
            $ordersQuery->where('summa', '<=', $request->price_to);
        }
        if ($request->filled('status')) {
            $ordersQuery->where('status', '=', $request->status);
        }
        $orders = $ordersQuery->OrderBy('id', 'DESC')->whereIn('status', [1, 2, 3, 4])
            ->Paginate(5)->withPath($request->getUri());
        return view('auth.orders.index', compact('orders'));


    }


    public function update(Request $request, Order $order)
    {
        $params = $request->all();
        $order->status = 2;
        $order->update($params);

        $courier = Courier::where('courier_id', $request->courier_id)->first();
        $i = $courier->count_orders;
        $courier->count_orders = $i + 1;
        $courier->update();

        Mail::to($order->email)->send(new OrderUpdate($order));

        return redirect()->route('orders');
    }

    public function complete(Order $order)
    {
        $order->status = 3;
        $order->update();

        $courier = Courier::where('courier_id', $order->courier_id)->first();
        $i = $courier->count_orders;
        $courier->count_orders = $i - 1;
        $courier->update();

        return redirect()->route('orders');
    }

    public function show(Order $order)
    {
        $products = $order->products()->withTrashed()->get();
        $couriers = Courier::all();

        return view('auth.orders.show', compact('order', 'products', 'couriers'));
    }

    public function cancel(Order $order)
    {
        $order->status = 4;
        $order->update();

        return redirect()->route('orders');

    }

    public function wordAdminExport(Request $request)
    {
        $templateProcessor = new TemplateProcessor('word-template/admin.docx');
        $firstOrder = Order::where('status', 3)->first()->created_at;
        $dateFirst = date('d.m.Y', strtotime($request->date_from));
        $dateLast = date('d.m.Y', strtotime($request->date_to));
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $orders = Order::whereBetween('created_at', [$request->date_from, $request->date_to . ' 23:59:59'])->get();
            $templateProcessor->setValue('first_date', $dateFirst);
            $templateProcessor->setValue('last_date', $dateLast);
        }

        if (!$request->filled('date_from') && $request->filled('date_to')) {
            $orders = Order::whereBetween('created_at', [$firstOrder, $request->date_to . ' 23:59:59'])->get();
            $templateProcessor->setValue('first_date', $orders->where('status', 3)->first()->created_at->format('d.m.Y'));
            $templateProcessor->setValue('last_date', $dateLast);
        }

        if ($request->filled('date_from') && !$request->filled('date_to')) {
            $orders = Order::whereBetween('created_at', [$request->date_from, Carbon::now()])->get();
            $templateProcessor->setValue('first_date', $dateFirst);
            $templateProcessor->setValue('last_date', Carbon::now()->format('d.m.Y'));
        }

        if (!$request->filled('date_from') && !$request->filled('date_to')) {
            $orders = Order::all();
            $templateProcessor->setValue('first_date', $orders->where('status', 3)->first()->created_at->format('d.m.Y'));
            $templateProcessor->setValue('last_date', Carbon::now()->format('d.m.Y'));
        }

        if (!empty(Auth::user()->name)) {
            $templateProcessor->setValue('user', Auth::user()->name);
        }
        $templateProcessor->setValue('date_now', Carbon::now()->format('d.m.Y'));

        $styleFont = array('size' => 12, 'name' => 'Times New Roman');
        $styleCenter = array('align' => 'center');

        $table = new Table(array('borderSize' => 6, 'align' => 'center', 'valign' => 'center', 'unit' => TblWidth::TWIP));
        $table->addRow();
        $table->addCell()->addText('№', $styleFont, $styleCenter);
        $table->addCell()->addText('Номер заказа', $styleFont, $styleCenter);
        $table->addCell()->addText('Имя клиента', $styleFont, $styleCenter);
        $table->addCell()->addText('Номер телефона', $styleFont, $styleCenter);
        $table->addCell()->addText('Email', $styleFont, $styleCenter);
        $table->addCell()->addText('Адрес', $styleFont, $styleCenter);
        $table->addCell()->addText('Сумма', $styleFont, $styleCenter);
        $table->addCell()->addText('Дата заказа', $styleFont, $styleCenter);

        $i = 0;
        $sum = 0;
        $countOrders = 0;
        foreach ($orders as $order) {
            if ($order->status == 3) {
                $table->addRow();
                $table->addCell()->addText($i + 1, $styleFont, $styleCenter);
                $table->addCell()->addText($order->id, $styleFont, $styleCenter);
                $table->addCell()->addText($order->name, $styleFont);
                $table->addCell()->addText($order->phone, $styleFont,);
                $table->addCell()->addText($order->email, $styleFont,);
                $table->addCell()->addText('Ул.' . $order->street . ' д.' . $order->house . ' кв.' . $order->apartment, $styleFont,);
                $table->addCell()->addText($order->summa . ' ₽', $styleFont, $styleCenter);
                $table->addCell()->addText($order->created_at->format('d.m.Y'), $styleFont);
                $sum += $order->summa;
                $countOrders++;
                $i++;
            }
        }
        if ($countOrders >= 1) {
            $templateProcessor->setValue('sum', $sum . '₽');
            $templateProcessor->setComplexBlock('table', $table);

            $fileName = 'Журнал учета продаж ' . Carbon::now()->format('d.m.Y');
            $templateProcessor->saveAs($fileName . '.docx');

            return response()->download($fileName . '.docx')->deleteFileAfterSend(true);
        } else {
            session()->flash('warning', 'За данный период нет заказов!');
            return redirect()->route('orders');
        }

    }
}
