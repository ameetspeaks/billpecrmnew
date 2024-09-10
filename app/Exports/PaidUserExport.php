<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Store;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Session;
use DB;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use Maatwebsite\Excel\Sheet;


class PaidUserExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    // public function __construct($storeId)
    // {
    //     $this->storeId = $storeId;
    // }

    public function collection()
    {
        $data = Store::with(['user', 'module'])
        ->where('package_id', '<>', 1)
        ->orderBy('created_at', 'DESC')
        ->get()
        ->map(function($store) {
            return [
                'username' => optional($store->user)->name,
                'whatsapp_no' => optional($store->user)->whatsapp_no,
                'shop_name' => $store->shop_name,
                'module_name' => optional($store->module)->name,
            ];
        });
        
        return collect($data);
    }

    public function headings(): array
    {
        return [
            "User Name",
            "User Phone",
            "Shop Name",
            "Module Name" ,
        ];
    }

    public function styles(Worksheet $sheet)
{
    return [
       // Style the first row as bold text.
       1    => ['font' => ['bold' => true]],
    ];
}
}
