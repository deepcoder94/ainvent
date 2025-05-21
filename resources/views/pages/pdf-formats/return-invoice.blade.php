<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        @page {
            size: A6; /* Set paper size to A6 */
            margin: 10mm; /* Adjust margins to fit within A6 */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-size: 12px
        }

        /* Invoice section (Company & Customer Details) */
        .invoice-info {
            margin-top: 1px;
        }

        .invoice-info .left {
            width: 45%;
            float: left;
            margin-right: 10%;
        }

        .invoice-info .right {
            width: 45%;
            float: left;
        }

        /* Clearfix for floated elements */
        .clearfix {
            clear: both;
        }

        /* Table styling for invoice details */
        .invoice-details {
            width: 100%;
            margin: 10px 0;
            border-collapse: collapse;
        }

        .invoice-details th, .invoice-details td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        .invoice-details th {
            background-color: transparent;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    @foreach ($invoices as $index => $i)

    <!-- Invoice Header (Company and Invoice Details) -->
    <div class="invoice-header">
    </div>

    <div class="invoice-info">
        <!-- Left side: Company Information -->
        <div class="left">
            <p>
                <strong>{{ $i['distributor']->name }}</strong><br>
                {{ $i['distributor']->address }}<br/>
                GST: {{ $i['distributor']->gst_number }}<br>
                Phone: {{ $i['distributor']->phone_number }}
            </p>
        </div>

        <!-- Right side: Invoice Information -->
        <div class="right">
            <p>
                <strong>INV NO:</strong> {{ $i['invoice_number'] }}<br/>
                <strong>Date:</strong> {{ $i['date'] }}
            </p>
        </div>
    </div>

    <hr>

    <div class="invoice-info clearfix">
        <!-- Left side: Customer Information -->
        <div class="left">
            <p>
                <strong>{{ $i['customer']->customer_name }}</strong><br>
                {{ $i['customer']->customer_address }}<br/>
                Contact: {{ $i['customer']->customer_phone }}<br>
                GST: {{ $i['customer']->customer_gst }}
            </p>
        </div>

        <!-- Right side: Beat Name Information -->
        <div class="right">
            <p>
                <strong>BEAT:</strong> {{ $i['beat_name'] }}<br/>
            </p>
        </div>
    </div>

    <div class="clearfix"></div>

    <!-- Invoice Items Table -->
    <table class="invoice-details">
        <thead>
            <tr>
                <th>Qty</th>
                <th>Type</th>
                <th>Product Description</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($i['items'] as $item)
                <tr>
                    <td>{{ $item['qty'] }}</td>
                    <td>{{ $item['type'] }}</td>
                    <td>{{ $item['product_description'] }}</td>
                    <td>{{ round($item['rate']) }}</td>
                    <td>{{ round($item['amount']) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">Total</td>
                <td>{{ round($i['total']) }}</td>
            </tr>            
        </tbody>
    </table>    
    @if ($index < count($invoices) - 1)
        <div class="page-break"></div>
    @endif
    @endforeach


</body>
</html>
