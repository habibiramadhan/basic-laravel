<!-- resources/views/admin/report/equipment-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Performa Alat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #17a2b8;
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
            color: #17a2b8;
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
            color: #17a2b8;
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
            background-color: #17a2b8;
            font-weight: bold;
            color: white;
        }
        
        .status-tersedia { background-color: #d4edda; }
        .status-disewa { background-color: #fff3cd; }
        .status-maintenance { background-color: #f8d7da; }
        
        .amount {
            text-align: right;
            font-weight: bold;
        }
        
        .center {
            text-align: center;
        }
        
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
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ setting('site_name', 'Sewa Alat Berat') }}</div>
        <div class="report-title">LAPORAN PERFORMA ALAT</div>
        <div class="report-period">
            Periode: {{ $start_date->format('d F Y') }} - {{ $end_date->format('d F Y') }}
        </div>
    </div>
    
    <div class="summary">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-number">{{ $summary['total_alat'] }}</div>
                <div class="summary-label">Total Alat</div>
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
                <td style="border: none; padding: 5px 0;">Tersedia: {{ $summary['alat_tersedia'] }}</td>
                <td style="border: none; padding: 5px 0;">Disewa: {{ $summary['alat_disewa'] }}</td>
                <td style="border: none; padding: 5px 0;">Maintenance: {{ $summary['alat_maintenance'] }}</td>
            </tr>
        </table>
    </div>
    
    @if($alats->count() > 0)
    <table>
        <thead>
            <tr>
                <th width="25%">Nama Alat</th>
                <th width="15%">Kategori</th>
                <th width="15%">Merk/Model</th>
                <th width="10%">Status</th>
                <th width="10%">Total Booking</th>
                <th width="15%">Revenue</th>
                <th width="10%">Utilisasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alats as $alat)
            <tr class="status-{{ $alat->status }}">
                <td>{{ $alat->nama_alat }}</td>
                <td>{{ $alat->kategori->nama_kategori }}</td>
                <td>{{ $alat->merk }} {{ $alat->model }}</td>
                <td>{{ ucfirst($alat->status) }}</td>
                <td class="center">{{ $alat->total_booking }}</td>
                <td class="amount">Rp {{ number_format($alat->total_revenue ?? 0, 0, ',', '.') }}</td>
                <td class="center">
                    @php
                        $days = $start_date->diffInDays($end_date) + 1;
                        $utilization = $days > 0 ? round(($alat->total_booking / $days) * 100, 1) : 0;
                    @endphp
                    {{ $utilization }}%
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 20px; font-size: 10px; color: #666;">
        <strong>Keterangan:</strong><br>
        - Utilisasi = (Total Booking / Jumlah Hari dalam Periode) x 100%<br>
        - Revenue hanya dari booking yang berstatus 'selesai'
    </div>
    @else
    <div style="text-align: center; padding: 40px; color: #666;">
        Tidak ada data alat
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