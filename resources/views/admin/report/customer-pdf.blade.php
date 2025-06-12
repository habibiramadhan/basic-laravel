<!-- resources/views/admin/report/customer-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        
        .report-title {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        
        .report-period {
            font-size: 12px;
            color: #666;
        }
        
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        
        .summary-item {
            text-align: center;
        }
        
        .summary-number {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        
        .summary-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
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
            background-color: #007bff;
            font-weight: bold;
            color: white;
        }
        
        .amount {
            text-align: right;
            font-weight: bold;
        }
        
        .center {
            text-align: center;
        }
        
        .rank-1 { background-color: #fff3cd; }
        .rank-2 { background-color: #e2e3e5; }
        .rank-3 { background-color: #f8d7da; }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .generated-info {
            margin-top: 20px;
            font-size: 10px;
            color: #666;
        }
        
        .customer-tier {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .tier-gold { background-color: #ffd700; color: #333; }
        .tier-silver { background-color: #c0c0c0; color: #333; }
        .tier-bronze { background-color: #cd7f32; color: white; }
        .tier-regular { background-color: #e9ecef; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ setting('site_name', 'Sewa Alat Berat') }}</div>
        <div class="report-title">LAPORAN CUSTOMER</div>
        <div class="report-period">
            Periode: {{ $start_date->format('d F Y') }} - {{ $end_date->format('d F Y') }}
        </div>
    </div>
    
    <div class="summary">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-number">{{ $summary['total_customer_active'] }}</div>
                <div class="summary-label">Customer Aktif</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ $summary['total_booking'] }}</div>
                <div class="summary-label">Total Booking</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</div>
                <div class="summary-label">Total Revenue</div>
            </div>
        </div>
        
        <table style="margin-top: 15px; border: none;">
            <tr style="border: none;">
                <td style="border: none; padding: 5px 0;"><strong>Rata-rata per Customer:</strong></td>
                <td style="border: none; padding: 5px 0;">{{ $summary['avg_booking_per_customer'] }} booking</td>
                <td style="border: none; padding: 5px 0;">Rp {{ number_format($summary['avg_spent_per_customer'], 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
    
    @if($customers->count() > 0)
    <table>
        <thead>
            <tr>
                <th width="5%">Rank</th>
                <th width="25%">Nama Customer</th>
                <th width="15%">Kontak</th>
                <th width="10%">Tier</th>
                <th width="10%">Total Booking</th>
                <th width="15%">Total Spent</th>
                <th width="10%">Avg/Booking</th>
                <th width="10%">Loyalitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $index => $customer)
            @php
                $rank = $index + 1;
                $avgPerBooking = $customer->total_booking > 0 ? ($customer->total_spent ?? 0) / $customer->total_booking : 0;
                
                // Determine tier based on total spent
                $totalSpent = $customer->total_spent ?? 0;
                if ($totalSpent >= 50000000) {
                    $tier = 'Gold';
                    $tierClass = 'tier-gold';
                } elseif ($totalSpent >= 20000000) {
                    $tier = 'Silver';
                    $tierClass = 'tier-silver';
                } elseif ($totalSpent >= 5000000) {
                    $tier = 'Bronze';
                    $tierClass = 'tier-bronze';
                } else {
                    $tier = 'Regular';
                    $tierClass = 'tier-regular';
                }
                
                // Loyalitas berdasarkan jumlah booking
                if ($customer->total_booking >= 10) {
                    $loyalitas = 'Very High';
                } elseif ($customer->total_booking >= 5) {
                    $loyalitas = 'High';
                } elseif ($customer->total_booking >= 3) {
                    $loyalitas = 'Medium';
                } else {
                    $loyalitas = 'Low';
                }
            @endphp
            <tr class="{{ $rank <= 3 ? 'rank-' . $rank : '' }}">
                <td class="center">{{ $rank }}</td>
                <td>
                    {{ $customer->nama_lengkap }}
                    @if($rank == 1)
                        <strong style="color: gold;">👑</strong>
                    @elseif($rank == 2)
                        <strong style="color: silver;">🥈</strong>
                    @elseif($rank == 3)
                        <strong style="color: #cd7f32;">🥉</strong>
                    @endif
                </td>
                <td>{{ $customer->no_telepon }}</td>
                <td>
                    <span class="customer-tier {{ $tierClass }}">{{ $tier }}</span>
                </td>
                <td class="center">{{ $customer->total_booking }}</td>
                <td class="amount">Rp {{ number_format($customer->total_spent ?? 0, 0, ',', '.') }}</td>
                <td class="amount">Rp {{ number_format($avgPerBooking, 0, ',', '.') }}</td>
                <td class="center">{{ $loyalitas }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 20px; font-size: 10px; color: #666;">
        <strong>Keterangan:</strong><br>
        - <strong>Tier:</strong> Gold (≥50jt), Silver (≥20jt), Bronze (≥5jt), Regular (<5jt)<br>
        - <strong>Loyalitas:</strong> Very High (≥10 booking), High (≥5), Medium (≥3), Low (<3)<br>
        - Ranking berdasarkan total spent (revenue dari booking selesai)
    </div>
    @else
    <div style="text-align: center; padding: 40px; color: #666;">
        Tidak ada customer aktif pada periode yang dipilih
    </div>
    @endif
    
    <div class="generated-info">
        <strong>Laporan dibuat pada:</strong> {{ now()->format('d F Y H:i') }} WIB<br>
        <strong>Dibuat oleh:</strong> {{ auth()->user()->nama_lengkap }}
    </div>
    
    <div class="footer">
        {{ setting('site_name', 'Sewa Alat Berat') }} - {{ setting('contact_address', '') }}<br>
        Telepon: {{ setting('contact_phone', '') }} | Email: {{ setting('contact_email', '') }}
    </div>
</body>
</html>