<!-- resources/views/admin/report/booking-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #FFC107;
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
            color: #FFC107;
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
            color: #FFC107;
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
            background-color: #FFC107;
            font-weight: bold;
            color: #333;
        }
        
        .status-pending { background-color: #fff3cd; }
        .status-dikonfirmasi { background-color: #d1ecf1; }
        .status-berlangsung { background-color: #d4edda; }
        .status-selesai { background-color: #e2e3e5; }
        .status-dibatalkan { background-color: #f8d7da; }
        
        .amount {
            text-align: right;
            font-weight: bold;
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
        <div class="report-title">LAPORAN BOOKING</div>
        <div class="report-period">
            Periode: {{ $start_date->format('d F Y') }} - {{ $end_date->format('d F Y') }}
            @if($status_filter)
                <br>Filter Status: {{ ucfirst($status_filter) }}
            @endif
        </div>
    </div>
    
    <div class="summary">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-number">{{ $summary['total_booking'] }}</div>
                <div class="summary-label">Total Booking</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</div>
                <div class="summary-label">Total Revenue</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ $summary['selesai'] }}</div>
                <div class="summary-label">Booking Selesai</div>
            </div>
        </div>
        
        <table style="margin-top: 15px; border: none;">
            <tr style="border: none;">
                <td style="border: none; padding: 5px 0;">Pending: {{ $summary['pending'] }}</td>
                <td style="border: none; padding: 5px 0;">Dikonfirmasi: {{ $summary['dikonfirmasi'] }}</td>
                <td style="border: none; padding: 5px 0;">Berlangsung: {{ $summary['berlangsung'] }}</td>
                <td style="border: none; padding: 5px 0;">Dibatalkan: {{ $summary['dibatalkan'] }}</td>
            </tr>
        </table>
    </div>
    
    @if($bookings->count() > 0)
    <table>
        <thead>
            <tr>
                <th width="12%">Kode Booking</th>
                <th width="18%">Customer</th>
                <th width="20%">Alat</th>
                <th width="15%">Periode</th>
                <th width="8%">Durasi</th>
                <th width="15%">Total Harga</th>
                <th width="12%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr class="status-{{ $booking->status_pemesanan }}">
                <td>{{ $booking->kode_booking }}</td>
                <td>{{ $booking->user->nama_lengkap }}</td>
                <td>{{ $booking->alat->nama_alat }}</td>
                <td>
                    {{ $booking->tanggal_mulai->format('d/m/Y') }} -
                    {{ $booking->tanggal_selesai->format('d/m/Y') }}
                </td>
                <td>{{ $booking->durasi_hari }} hari</td>
                <td class="amount">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                <td>{{ ucfirst($booking->status_pemesanan) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="text-align: center; padding: 40px; color: #666;">
        Tidak ada data booking pada periode yang dipilih
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