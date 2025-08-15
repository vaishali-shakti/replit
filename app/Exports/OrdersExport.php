<?php

namespace App\Exports;

use App\Models\OrderManagement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class OrdersExport implements FromView
{
    protected $orders;
    public function __construct(Collection $orders)
    {
        $this->orders = $orders;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        return view('exports.excel_generate', [
            'orders' => $this->orders,
        ]);
    }
}
