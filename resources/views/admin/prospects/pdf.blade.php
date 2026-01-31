<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.prospects.title') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3B82F6;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #3B82F6;
            margin: 0;
            font-size: 24px;
        }
        
        .info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        
        .info span {
            margin-right: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #3B82F6;
            color: white;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('messages.prospects.title') }}</h1>
        <p>{{ __('messages.prospects.description') }}</p>
    </div>
    
    <div class="info">
        <span><strong>{{ __('messages.dashboard.stats.total') }}:</strong> {{ $total }}</span>
        <span><strong>{{ __('common.export') }}:</strong> {{ $exportDate }}</span>
        @if($search)
            <span><strong>{{ __('messages.prospects.search_placeholder') }}:</strong> {{ $search }}</span>
        @endif
        @if($city)
            <span><strong>{{ __('messages.prospects.filter_city') }}:</strong> {{ __('cities.' . strtolower($city)) ?? $city }}</span>
        @endif
    </div>
    
    @if($prospects->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('messages.prospects.table.name') }}</th>
                    <th>{{ __('messages.prospects.table.phone') }}</th>
                    <th>{{ __('messages.prospects.table.email') }}</th>
                    <th>{{ __('messages.prospects.table.city') }}</th>
                    <th>{{ __('messages.prospects.table.date') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prospects as $index => $prospect)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $prospect->full_name }}</td>
                        <td>{{ $prospect->phone_number }}</td>
                        <td>{{ $prospect->email ?: __('messages.prospects.no_email') }}</td>
                        <td>{{ __('cities.' . strtolower(trim($prospect->city))) ?? ucfirst(strtolower(trim($prospect->city))) }}</td>
                        <td>{{ $prospect->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            {{ __('messages.prospects.table.empty') }}
        </div>
    @endif
    
    <div class="footer">
        <p>{{ __('messages.prospects.title') }} - {{ __('common.export') }} {{ $exportDate }}</p>
        <p>Prospect Platform - {{ date('Y') }}</p>
    </div>
</body>
</html>
