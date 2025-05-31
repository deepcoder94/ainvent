<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        @page { margin: 30px 20px; }
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        .no-border td { border: none; padding: 2px; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .title { font-size: 16px; font-weight: bold; text-align: center; margin-bottom: 10px; }
        .page-break {
            page-break-before: always;
        }

    </style>
</head>
<body>
    @foreach ($invoices as $index => $i)
    <!-- Invoice Title -->
    <div class="title">INVOICE Preview</div>
    <!-- Invoice Info -->
    <table class="no-border">
        <tr>
            <td><strong>Request No:</strong> {{ $i['request_id'] }}</td>
            <td class="center"><strong>Beat:</strong> {{ $i['beat_name'] ?? ($i['customer']->beat_name ?? '-') }}</td>
        </tr>
    </table>

    <br>

    <table class="no-border">
        <tr>
            <td width="50%">
                <div class="bold">{{ $i['distributor']->name }}</div>
                <div>{{ $i['distributor']->address }}</div>
                <div>GSTIN: {{ $i['distributor']->gst_number }}</div>
                <div>PH: {{ $i['distributor']->phone_number }}</div>    
            </td>
            <td width="50%" style="text-align:right;">
                <div class="bold">{{ $i['customer']->customer_name }}</div>
                <div>{{ $i['customer']->customer_address }}</div>
                <div>GSTIN: {{ $i['customer']->customer_gst }}</div>
                <div>Phone: {{ $i['customer']->customer_phone }}</div>
            </td>

        </tr>
    </table>

    <br>


    <table>
        <thead>
            <tr>
                <th>Sr.</th>
                <th>HSN</th>
                <th>Description</th>
                <th>Entry Rate</th>
                <th>Rate</th>
                <th>Case</th>
                <th>Pcs</th>
                <th>Net Amt</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($i['items'] as $in => $item)

            <tr>
                <td>{{ ++$in }}</td>
                <td>{{ $item['product_hsn'] }}</td>
                <td>{{ $item['product_description'] }}</td>
                <td>{{ $item['entry_rate'] }}</td>
                <td>{{ $item['rate'] }}</td>
                <td class="bold">{{ $item['box'] }}</td>
                <td class="bold">{{ $item['pcs'] }}</td>
                <td>{{ round($item['amount']) }}</td>
            </tr>
            @endforeach
            <!-- Total Row -->
            <tr class="bold">
                <td colspan="5" class="center">Total</td>
                <td class="bold">{{ $i['boxtotal'] }}</td> <!-- Total Box -->
                <td class="bold">{{ $i['pcstotal'] }}</td> <!-- Total Pcs -->
                <td>{{ round($i['grandTotal']) }}</td> <!-- Total Net Amt -->
            </tr>
        </tbody>
    </table>

    @if ($index < count($invoices) - 1)
    <div class="page-break"></div>
@endif
@endforeach
</body>
</html>
