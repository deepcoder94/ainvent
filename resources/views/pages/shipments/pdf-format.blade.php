<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipment</title>
    <style>
        @page {
            size: A4; /* Set paper size to A4 */
            margin: 20mm; /* Adjust margins to fit within A4 */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-size: 10px; /* Adjust font size for A4 */
            line-height: 1.4;
        }

        /* Invoice section (Company & Customer Details) */
        .invoice-info {
            margin-top: 1px;
            font-size: 12px;
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
            padding: 6px; /* Adjusted padding for better readability */
            text-align: left;
        }

        .invoice-details th {
            background-color: #f2f2f2;
        }

        .invoice-details td {
            word-wrap: break-word;
        }

        /* Total Row Styling */
        .invoice-details .total-row {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 8px;
            margin-top: 20px;
        }

    </style>
</head>
<body>

    <!-- Invoice Header (Company and Invoice Details) -->
    <div class="invoice-header">
        <!-- You can add your logo or invoice heading here -->
        <h2>Shipment Invoice <span style="font-size: 12px; font-weight: normal; margin-left: 10px;">{{ $currentDate }}</span></h2>
    </div>

    <!-- Invoice Items Table -->
    <table class="invoice-details">
        <thead>
            <tr>
                <th>Sl.</th>
                <th>Item Code</th>
                <th>Product Name</th>
                <th>Case</th>
                <th>Pieces</th>
                <th>Total Qty</th>
                <th>Total Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($finalitems as $i => $item)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $item['item_code'] }}</td>
                    <td>{{ $item['product_description'] }}</td>
                    <td>{{ $item['case_count'] }}</td>
                    <td>{{ $item['piece_count'] }}</td>
                    <td>{{ $item['qty_count'] }}</td>
                    <td>{{ $item['product_total_amount'] }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td></td>
                <td>Total</td>
                <td></td>
                <td>{{ $shipmentCaseTotal }}</td>
                <td>{{ $shipmentPcTotal }}</td>
                <td>{{ $shipmentQtyTotal }}</td>
                <td>{{ $shipmentTotal }}</td>
            </tr>            
        </tbody>
    </table>

    <!-- Footer (optional) -->
    <div class="footer">
    </div>

</body>
</html>
