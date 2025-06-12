<!-- resources/views/admin/report/payment-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #28a745;
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
            color: #28a745;
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
            color: #28a745;
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
            background-color: #28a745;
            font-weight: bold;
            color: white;
        }
        
        .status-pending { background-color: #fff3cd; }
        .status-verified { background-color: #d4edda; }
        .status-rejected { background-color: #f8d7da; }
        
        .metode-upload { background-color: #cce7ff; }
        .metode-whatsapp { background-color: #ccf5cc; }
        
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
        <div class="report-title">LAPORAN PEMBAYARAN</div>
        <div class="report-period">
            Periode: {{ $start_date->format('d F Y') }} - {{ $end_date->format('d F Y') }}
            @if($metode_filter)
                <br>Filter Metode: {{ $metode_filter == 'upload_transfer' ? 'Upload Transfer' : 'WhatsApp' }}
            @endif
            @if($status_filter)
                <br>Filter Status: {{ ucfirst($status_filter) }}
            @endif
        </div>
    </div>
    
    <div class="summary">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-number">{{ $summary['total_payment'] }}</div>
                <div class="summary-label">Total Payment</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">Rp {{ number_format($summary['total_amount'], 0, ',', '.') }}</div>
                <div class="summary-label">Total Amount</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">Rp {{ number_format($summary['verified_amount'], 0, ',', '.') }}</div>
                <div class="summary-label">Verified Amount</div>
            </div>
        </div>
        
        <table style="margin-top: 15px; border: none;">
            <tr style="border: none;">
                <td style="border: none; padding: 5px 0;"><strong>Status:</strong></td>
                <td style="border: none; padding: 5px 0;">Pending: {{ $summary['pending'] }}</td>
                <td style="border: none; padding: 5px 0;">Verified: {{ $summary['verified'] }}</td>
                <td style="border: none; padding: 5px 0;">Rejected: {{ $summary['rejected'] }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 5px 0;"><strong>Metode:</strong></td>
                <td style="border: none; padding: 5px 0;">Upload: {{ $summary['upload_transfer'] }}</td>
                <td style="border: none; padding: 5px 0;">WhatsApp: {{ $summary['whatsapp_confirm'] }}</td>
                <td style="border: none; padding: 5px 0;"></td>
            </tr>
        </table>
    </div>
    
    @if($payments->count() > 0)
    <table>
        <thead>
            <tr>
                <th width="10%">ID</th>
                <th width="15%">Kode Booking</th>
                <th width="20%">Customer</th>
                <th width="12%">Metode</th>
                <th width="15%">Jumlah</th>
                <th width="10%">Status</th>
                <th width="18%">Tanggal/Verifikasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr class="status-{{ $payment->status_bayar }}">
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->pemesanan->kode_booking }}</td>
                <td>{{ $payment->pemesanan->user->nama_lengkap }}</td>
                <td class="metode-{{ str_replace('_', '-', $payment->metode_pembayaran) }}">
                    {{ $payment->metode_pembayaran == 'upload_transfer' ? 'Upload' : 'WhatsApp' }}
                </td>
                <td class="amount">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                <td>{{ ucfirst($payment->status_bayar) }}</td>
                <td>
                    {{ $payment->created_at->format('d/m/Y') }}
                    @if($payment->verified_at)
                        <br><small>Verified: {{ $payment->verified_at->format('d/m/Y') }}</small>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="text-align: center; padding: 40px; color: #666;">
        Tidak ada data pembayaran pada periode yang dipilih
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