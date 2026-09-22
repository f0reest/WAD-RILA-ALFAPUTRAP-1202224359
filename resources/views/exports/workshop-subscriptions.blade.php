<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Workshop Subscriptions</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #222; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background: #f4f4f4; }
        .header { display:flex; justify-content:space-between; align-items:center; }
        .title { font-weight:800; font-size:16px; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="title">Workshop Subscriptions</div>
            <div>Generated at: {{ $generatedAt }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Partner</th>
                <th>Location</th>
                <th>Service</th>
                <th>Status</th>
                <th>Monthly Fee</th>
                <th>Starts</th>
                <th>Ends</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscriptions as $s)
                <tr>
                    <td>{{ $s->subscription_code }}</td>
                    <td>{{ $s->partner?->name ?? '-' }}</td>
                    <td>{{ $s->location?->name ?? '-' }}</td>
                    <td>{{ $s->serviceType?->name ?? '-' }}</td>
                    <td>{{ ucfirst($s->status) }}</td>
                    <td>{{ number_format($s->monthly_fee, 2) }}</td>
                    <td>{{ $s->starts_at?->format('Y-m-d') }}</td>
                    <td>{{ $s->ends_at?->format('Y-m-d') }}</td>
                    <td>{{ $s->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>