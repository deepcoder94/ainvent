<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Invoice</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 5px;
            }
            .invoice-box {
                max-width: 800px;
                margin: auto;
                padding: 10px;
            }
            .title {
                font-size: 20px;
                font-weight: bold;
                text-align: center;
                margin-bottom: 10px;
            }
            .section {
                border: 1px solid #999797;
                padding: 10px;
                margin-top: 10px;
            }
            .details,
            .items,
            .summary,
            .supplier-recipient {
                width: 100%;
                border-collapse: collapse;
                font-size: 12px;
            }
            .details td,
            .items th,
            .items td,
            .summary td,
            .summary th,
            .supplier-recipient td {
                border: 1px solid #000;
                padding: 5px;
            }
            .summary {
                margin-top: 5px;
            }
            .items th,
            .summary th {
                background-color: #ddd;
                text-align: left;
            }
            .summary tr:last-child td {
                font-weight: bold;
            }
            .total {
                text-align: right;
                font-weight: bold;
            }
            h3 {
                font-size: 14px;
                margin-top: 0;
            }
            @page {
                size: A4;
                margin: 10mm;
            }
        </style>
    </head>
    <body>
        <div class="invoice-box">
            <div class="title">Tax Invoice</div>

            <div class="section">
                <h3>Transaction Details</h3>
                <p><strong>Invoice No.:</strong> {{ $invoice_no }}</p>
                <p><strong>Invoice Date:</strong> {{ $invoice_date }}</p>
            </div>

            <div class="section">
                <h3>Party Details</h3>
                <table class="supplier-recipient">
                    <tr>
                        <th>Supplier Details</th>
                        <th>Recipient Details</th>
                    </tr>
                    <tr>
                        <td>
                            <strong>{{ $supplier_name }}</strong
                            ><br />
                            GSTIN: {{ $supplier_gstin }}<br />
                            {{ $supplier_address }}<br />
                            Phone: {{ $supplier_phone }}
                        </td>
                        <td>
                            <strong>{{ $recepent_name }}</strong
                            ><br />
                            GSTIN: {{ $recepent_gstin }}<br />
                            {{ $recepent_address }}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="section">
                <h3>Details of Goods / Services</h3>
                <table class="items">
                    <tr>
                        <th>Sl No</th>
                        <th>HSN</th>                        
                        <th>Description</th>
                        <th>Rate</th>
                        <th>Qty</th>
                        <th>Disc. (Rs)</th>
                        <th>GST%</th>
                        <th>GST</th>
                        <th>Net Amt.</th>
                    </tr>
                    @foreach ($products as $i => $p)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $p['product_code'] }}</td>
                        <td>{{ $p['product_description'] }}</td>
                        <td>{{ $p['product_unit_price'] }}</td>
                        <td>{{ $p['product_qty'] }}</td>
                        <td>{{ $p['product_discount'] }}</td>
                        <td>{{ $p['gst_rate'] }}</td>
                        <td>{{ ($p['gst_rate']/100)*($p['product_unit_price'] * $p['product_qty']) }}</td>
                        <td>{{ $p['product_total'] }}</td>
                    </tr>                        
                    @endforeach
                </table>

                <table class="summary">
                    <tr>
                        <th>CGST %</th>
                        <th>CGST Amt</th>
                        <th>SGST %</th>
                        <th>SGST Amt</th>
                        <th>Taxable Amt</th>
                        <th>Discount</th>
                        <th>Receivable Amt</th>
                    </tr>
                    <tr>
                        <td>%</td>
                        <td>{{ $gst_cgst }}</td>
                        <td>%</td>
                        <td>{{ $gst_sgst }}</td>
                        <td>{{ $gst_taxable_amt }}</td>
                        <td>{{ $gst_discount }}</td>
                        <td><strong>{{ $gst_total_inv }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
