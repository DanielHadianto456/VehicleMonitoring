<?php

namespace App\Exports;

use App\Models\ordersModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ordersModel::all();
    }
}
