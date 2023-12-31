<?php

namespace Database\Seeders;

use App\Imports\DataImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$con = Storage::disk('import');
        //$files = $con->files('sales');
        Excel::import(new DataImport, storage_path('import/sales/sales-data-01.xlsx'));
        // foreach ($files as $file) {
        //     Excel::import(new DataImport, storage_path('import/'.$file));
        // }
    }
}
