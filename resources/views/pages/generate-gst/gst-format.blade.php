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
                        <th>Item Description</th>
                        <th>HSN Code</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Unit Price (Rs)</th>
                        <th>Discount (Rs)</th>
                        <th>Taxable Amount (Rs)</th>
                        <th>
                            Tax Rate (GST + Cess | State CESS + Cess Non.Advol)
                        </th>
                        <th>Other Charges</th>
                        <th>Total</th>
                    </tr>
                    @foreach ($products as $i => $p)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $p['product_description'] }}</td>
                        <td>{{ $p['product_code'] }}</td>
                        <td>{{ $p['product_qty'] }}</td>
                        <td>{{ $p['product_unit'] }}</td>
                        <td>{{ $p['product_unit_price'] }}</td>
                        <td>{{ $p['product_discount'] }}</td>
                        <td>{{ $p['product_taxable_amt'] }}</td>
                        <td>{{ $p['gst_rate'] }} + {{ $p['cess_rate'] }}<br/>{{ $p['state_cess_rate'] }} + {{ $p['non_advol_rate'] }}</td>
                        <td>{{ $p['product_other_charges'] }}</td>
                        <td>{{ $p['product_total'] }}</td>
                    </tr>                        
                    @endforeach
                </table>

                <table class="summary">
                    <tr>
                        <th>Tax'ble Amt</th>
                        <th>CGST Amt</th>
                        <th>SGST Amt</th>
                        <th>IGST Amt</th>
                        <th>CESS Amt</th>
                        <th>State CESS</th>
                        <th>Discount</th>
                        <th>Other Charges</th>
                        <th>Round off Amt</th>
                        <th>Tot Inv. Amt</th>
                    </tr>
                    <tr>
                        <td>{{ $gst_taxable_amt }}</td>
                        <td>{{ $gst_cgst }}</td>
                        <td>{{ $gst_sgst }}</td>
                        <td>{{ $gst_igst }}</td>
                        <td>{{ $gst_cess }}</td>
                        <td>{{ $gst_state_cess }}</td>
                        <td>{{ $gst_discount }}</td>
                        <td>{{ $gst_other_charges }}</td>
                        <td>{{ $gst_roundoff }}</td>
                        <td><strong>{{ $gst_total_inv }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
