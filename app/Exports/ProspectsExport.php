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
        $search = $this->request->query('search');
        $city = $this->request->query('city');

        $query = Prospect::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($city && in_array($city, ['Tangier', 'Tetouan', 'Rabat', 'Kenitra'])) {
            $query->where('city', $city);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'Nom Complet',
            'Téléphone',
            'Email',
            'Ville',
            'Date d\'inscription',
        ];
    }

    public function map($prospect): array
    {
        return [
            $prospect->full_name,
            $prospect->phone_number,
            $prospect->email ?? '-',
            $prospect->city,
            $prospect->created_at->format('d/m/Y H:i'),
        ];
    }
}