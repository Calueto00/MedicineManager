<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            font-size: 28px;
            margin: 0;
        }
        .header p {
            font-size: 12px;
            color: #666;
            margin: 5px 0 0 0;
        }
        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .info div {
            flex: 1;
            min-width: 200px;
            margin-bottom: 10px;
        }
        .info strong {
            display: block;
            color: #007bff;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            color: #007bff;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status.paid {
            background-color: #28a745;
            color: #fff;
        }
    </style>
    <title>Recibo de Consulta</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Recibo de Consulta</h1>
            <p>Gerado em {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="info">
            <div>
                <strong>Paciente:</strong> {{ $invoice->patient->user->name ?? 'N/A' }}
            </div>
            <div>
                <strong>Médico:</strong> {{ $invoice->doctor->user->name ?? 'N/A' }}
            </div>
            <div>
                <strong>Data da Consulta:</strong> {{ $invoice->appointment->data ?? 'N/A' }}
            </div>
            <div>
                <strong>Método de Pagamento:</strong> {{ ucfirst($invoice->payment_method) }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Consulta Médica</td>
                    <td>{{ number_format($invoice->amount, 2, ',', '.') }} Kz</td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            Total Pago: {{ number_format($invoice->amount, 2, ',', '.') }} Kz
        </div>

        <div class="footer">
            <p><strong>Estado:</strong> <span class="status {{ strtolower($invoice->status) }}">{{ ucfirst($invoice->status) }}</span></p>
            <p>Obrigado pela sua visita. Este recibo é oficial e confirma o pagamento realizado.</p>
        </div>
    </div>
</body>
</html>
