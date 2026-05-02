<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $medicalRecord->invoice_number }}</title>
    <style>
        body { font-family: sans-serif; line-height: 1.5; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; }
        .header { margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
        .company-info { float: left; }
        .invoice-info { float: right; text-align: right; }
        .clear { clear: both; }
        .table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; margin-top: 20px; }
        .table th { background: #f8f9fa; border-bottom: 1px solid #ddd; padding: 10px; font-size: 14px; }
        .table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 13px; }
        .total-section { float: right; width: 250px; margin-top: 20px; }
        .total-row { display: block; text-align: right; margin-bottom: 5px; }
        .grand-total { font-size: 18px; font-weight: bold; color: #007bff; border-top: 2px solid #eee; padding-top: 10px; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; }
        .badge { padding: 3px 8px; background: #e9ecef; border-radius: 4px; font-size: 11px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div class="company-info">
                <h2 style="margin:0; color: #007bff;">Klinik Ash-Shihhah</h2>
                <p style="margin:0; font-size: 12px;">Bekam & Terapi Kesehatan<br>Jl. Alamat Klinik No. 123, Bekasi</p>
            </div>
            <div class="invoice-info">
                <h3 style="margin:0;">INVOICE</h3>
                <p style="margin:0; font-size: 12px;">
                    No: {{ $medicalRecord->invoice_number }}<br>
                    Tanggal: {{ $medicalRecord->treatment_date->format('d/m/Y') }}
                </p>
            </div>
            <div class="clear"></div>
        </div>

        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <strong style="font-size: 12px; color: #777;">DIBERIKAN KEPADA:</strong><br>
                    <span style="font-size: 16px; font-weight: bold;">{{ $medicalRecord->patient->name }}</span><br>
                </td>
                <td style="width: 50%; vertical-align: top; text-align: right;">
                    <strong style="font-size: 12px; color: #777;">TENAGA MEDIS:</strong><br>
                    <span style="font-size: 14px;">{{ $medicalRecord->employee->name }}</span>
                </td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>Layanan / Tindakan</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Harga</th>
                    <th style="text-align: right;">Diskon</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicalRecord->items as $item)
                <tr>
                    <td>{{ $item->treatment_name }}</td>
                    <td style="text-align: center;">{{ $item->qty }}</td>
                    <td style="text-align: right;">{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td style="text-align: right; color: #dc3545;">{{ $item->discount > 0 ? '-' . number_format($item->discount, 0, ',', '.') : '0' }}</td>
                    <td style="text-align: right;">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span style="float:left;">Grand Total:</span>
                <span class="grand-total">Rp {{ number_format($medicalRecord->total_cost, 0, ',', '.') }}</span>
            </div>
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
        
        <div style="margin-top: 40px; font-size: 13px;">
            <strong>Keluhan:</strong><br>
            <p style="font-style: italic; color: #555;">"{{ $medicalRecord->complaint ?: '-' }}"</p>
        </div>

        <div class="footer">
            <p>Terima kasih telah mempercayakan kesehatan Anda kepada kami.<br>
            <em>Semoga lekas sembuh dan sehat selalu.</em></p>
        </div>
    </div>
</body>
</html>