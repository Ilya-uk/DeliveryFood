<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;

class OrderController extends Controller
{
    // получение списка заказов для клиента
    public function index()
    {
        $orders = Auth::user()->orders()->OrderBy('id', 'DESC')->whereIn('status', [1, 2, 3, 4])->Paginate(5);
        return view('auth.orders.index', compact('orders'));
    }

    //есть ли у пользователя данный заказ
    public function show(Order $order)
    {
        if (!Auth::user()->orders->contains($order)) {
            return redirect()->route('person.orders.index');
        }
        $products = $order->products()->withTrashed()->get();

        return view('auth.orders.show', compact('order', 'products'));
    }

    public function cancel(Order $order)
    {
        $order->status = 4;
        $order->update();

        return redirect()->route('person.orders.index');

    }

    public function wordExport(Order $order)
    {
        $templateProcessor = new TemplateProcessor('word-template/cheque.docx');
        $templateProcessor->setValue('name', $order->name);
        $templateProcessor->setValue('name_phone', $order->phone);
        $templateProcessor->setValue('street', $order->street);
        $templateProcessor->setValue('house', $order->house);
        $templateProcessor->setValue('apartment', $order->apartment);
        $templateProcessor->setValue('updated_at', $order->updated_at->format('d.m.Y H:i'));
        $templateProcessor->setValue('id', $order->id);

        $styleFont = array('size' => 12, 'name' => 'Times New Roman');
        $styleCenter = array('align' => 'center');


        $table = new Table(array('borderSize' => 6, 'align' => 'center', 'valign' => 'center', 'unit' => TblWidth::TWIP));
        $table->addRow();
        $table->addCell(150)->addText('№', $styleFont, $styleCenter);
        $table->addCell(6700)->addText('Наименование', $styleFont);
        $table->addCell(1100)->addText('Кол-во', $styleFont, $styleCenter);
        $table->addCell(750)->addText('Цена', $styleFont, $styleCenter);
        $table->addCell(900)->addText('Итого', $styleFont, $styleCenter);

        $i = 0;
            foreach ($order->products as $product) {
                $table->addRow();
                $table->addCell(150)->addText($i+1 , $styleFont, $styleCenter);
                $table->addCell(7000)->addText($product->name, $styleFont);
                $table->addCell(900)->addText($product->pivot->count, $styleFont, $styleCenter);
                $table->addCell(750)->addText($product->price . '₽', $styleFont, $styleCenter);
                $table->addCell(900)->addText($product->price * $product->pivot->count . '₽', $styleFont, $styleCenter);
                $i++;
            }

        $templateProcessor->setComplexBlock('table', $table);
        $templateProcessor->setValue('full_cost', $order->summa . '₽');
        $templateProcessor->setValue('courier', $order->courier->name);
        $templateProcessor->setValue('courier_phone', $order->courier->phone);

        $fileName = 'Чек №' . $order->id;
        $templateProcessor->saveAs($fileName . '.docx');

        return response()->download($fileName . '.docx')->deleteFileAfterSend(true);
    }


}
