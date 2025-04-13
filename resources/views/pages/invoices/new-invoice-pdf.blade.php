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
    <div class="title">TAX INVOICE</div>

    <!-- Invoice Info -->
    <table class="no-border">
        <tr>
            <td><strong>Invoice No:</strong> {{ $i['invoice_number'] }}</td>
            <td class="center"><strong>Beat:</strong> {{ $i['beat_name'] ?? ($i['customer']->beat_name ?? '-') }}</td>
            <td style="text-align:right;"><strong>Date:</strong> {{ $i['date'] }}</td>
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
                <th>Rate</th>
                <th>Case</th>
                <th>Pcs</th>
                <th>GST%</th>
                <th>GST</th>
                <th>Net Amt</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($i['items'] as $in => $item)

            <tr>
                <td>{{ ++$in }}</td>
                <td>{{ $item['product_hsn'] }}</td>
                <td>{{ $item['product_description'] }}</td>
                <td>{{ $item['rate'] }}</td>
                <td class="bold">{{ $item['box'] }}</td>
                <td class="bold">{{ $item['pcs'] }}</td>
                <td>{{ $item['gst_rate'] }}</td>
                <td>{{ $item['gst_amt'] }}</td>
                <td>{{ $item['net_amt'] }}</td>
            </tr>
            @endforeach
            <!-- Total Row -->
            <tr class="bold">
                <td colspan="4" class="center">Total</td>
                <td class="bold">{{ $i['boxtotal'] }}</td> <!-- Total Box -->
                <td class="bold">{{ $i['pcstotal'] }}</td> <!-- Total Pcs -->
                <td></td> <!-- GST% -->
                <td>{{ $i['totalgst'] }}</td> <!-- GST -->
                <td>{{ $i['totalnetamt'] }}</td> <!-- Total Net Amt -->
            </tr>
        </tbody>
    </table>

    <br>
    <table>
        <thead>
            <tr>
                <th>Taxable Amt</th>
                <th>CGST Amt</th>
                <th>SGST Amt</th>
                <th>IGST Desc</th>
                <th>CESS Amt</th>
                <th>State CESS Amt</th>
                <th>Total Invoice Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $i['taxableamt'] }}</td>
                <td>{{ $i['totalgst'] / 2 }}</td>
                <td>{{ $i['totalgst'] / 2 }}</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td class="bold">{{ $i['taxableamt'] + $i['totalgst'] }}</td>
            </tr>
        </tbody>
    </table>
    
    @if ($index < count($invoices) - 1)
    <div class="page-break"></div>
@endif
@endforeach
</body>
</html>
