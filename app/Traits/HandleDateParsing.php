<?php

namespace App\Traits;

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

trait HandleDateParsing
{
    public function parseImportDate($date)
    {
        return is_numeric($date)
            ? Date::excelToDateTimeObject($date)->format('Y-m-d')
            : Carbon::parse($date)->format('Y-m-d');
    }
}
