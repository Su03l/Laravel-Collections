<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>روشتة طبية</title>
    <style>
        body {
            font-family: 'dejavu sans', sans-serif;
            font-size: 12px;
        }
        .container {
            padding: 20px;
            border: 1px solid #ccc;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 0;
        }
        .content {
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #eee;
        }
        .section h3 {
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $hospital->name ?? 'مستشفى الأمل' }}</h1>
            <p>{{ $record->doctor->clinic->name ?? '' }}</p>
        </div>

        <div class="content">
            <p><strong>تاريخ:</strong> {{ $record->created_at->format('Y-m-d') }}</p>
            <p><strong>اسم المريض:</strong> {{ $record->patient->name }}</p>
            <p><strong>الطبيب المعالج:</strong> {{ $record->doctor->name }} ({{ $record->doctor->specialization }})</p>
        </div>

        <div class="section">
            <h3>التشخيص (Diagnosis)</h3>
            <p>{{ $record->diagnosis }}</p>
        </div>

        <div class="section">
            <h3>العلاج (Prescription)</h3>
            <p>{!! nl2br(e($record->prescription)) !!}</p>
        </div>

        <div class="footer">
            @if(isset($qr_code))
                <img src="data:image/svg+xml;base64,{{ $qr_code }}" alt="QR Code">
            @endif
            <p>توقيع الطبيب</p>
            <p>___________________</p>
        </div>
    </div>
</body>
</html>
