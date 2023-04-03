<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MonthlyReportExport implements FromCollection,WithHeadings
{
    use Exportable;
    protected $reports;

    public function __construct($reports)
    {
        $this->reports = $reports;
    }

    public function collection()
    {
        return $this->reports;
    }

    public function headings(): array
    {
        return ['User', 'Token', 'Number','Service', 'Counter', 'Date','Called at', 'Served at','Waiting Time','Served Time','Total Time','Status'];
    }
}
