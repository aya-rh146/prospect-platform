<?php

namespace App\Exports;

use App\Models\Prospect;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProspectsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Prospect::query();

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($this->request->filled('city') && in_array($this->request->city, ['Tangier', 'Tetouan', 'Rabat', 'Kenitra'])) {
            $query->where('city', $this->request->city);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'ID',
            'الاسم الكامل',
            'رقم الهاتف',
            'البريد الإلكتروني',
            'المدينة',
            'تاريخ الإضافة',
        ];
    }

    public function map($prospect): array
    {
        return [
            $prospect->id,
            $prospect->full_name,
            $prospect->phone_number,
            $prospect->email,
            $prospect->city,
            $prospect->created_at->format('d/m/Y H:i'),
        ];
    }
}