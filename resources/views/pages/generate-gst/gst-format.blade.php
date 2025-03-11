<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 5px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 10px }
        .title { font-size: 20px; font-weight: bold; text-align: center; margin-bottom: 10px; }
        .section { border: 1px solid #999797; padding: 10px; margin-top: 10px; }
        .details, .items, .summary, .supplier-recipient { width: 100%; border-collapse: collapse; font-size: 12px; }
        .details td, .items th, .items td, .summary td, .summary th, .supplier-recipient td { border: 1px solid #000; padding: 5px; }
        .summary{
            margin-top: 5px
        }
        .items th, .summary th { background-color: #ddd; text-align: left; }
        .summary tr:last-child td { font-weight: bold; }
        .total { text-align: right; font-weight: bold; }
        h3 { font-size: 14px; margin-top: 0; }
        @page { size: A4; margin: 10mm; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="title">Tax Invoice</div>
        
        <div class="section">
            <h3>Transaction Details</h3>
            <p><strong>Document No.:</strong> 3059</p>
            <p><strong>Document Date:</strong> 01-03-2025</p>
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
                        <strong>DEB ENTERPRISE</strong><br>
                        GSTIN: 19GDKPD1370P1Z1<br>
                        47/1, DR.C.C.C.ROAD, BHADRESWAR, HOOGHLY 712124, WEST BENGAL<br>
                        Phone: 9038477792
                    </td>
                    <td>
                        <strong>UNIQUE ENTERPRISE</strong><br>
                        GSTIN: 19AOAPK0062L1Z0<br>
                        141/A, SAFUIPARA, BAIDYAPARA, KOLKATA 700078, WEST BENGAL
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="section">
            <h3>Details of Goods / Services</h3>
            <table class="items">
                <tr>
                    <th>Sl No</th><th>Item Description</th><th>HSN Code</th><th>Quantity</th><th>Unit</th><th>Unit Price (Rs)</th><th>Discount (Rs)</th><th>Taxable Amount (Rs)</th><th>Tax Rate (GST + Cess | State CESS + Cess Non.Advol)</th><th>Other Charges</th><th>Total</th>
                </tr>
                <tr>
                    <td>1</td><td>KG Mustard Oil 1 ltr Pch-Strong</td><td>15149920</td><td>4000</td><td>NOS</td><td>135.710</td><td>0.00</td><td>542856</td><td>5.00 + 0.00 | 0.00 + 0.00</td><td>0.00</td><td>570000.00</td>
                </tr>
            </table>
            
            <table class="summary">
                <tr>
                    <th>Tax'ble Amt</th><th>CGST Amt</th><th>SGST Amt</th><th>IGST Amt</th><th>CESS Amt</th><th>State CESS</th><th>Discount</th><th>Other Charges</th><th>Round off Amt</th><th>Tot Inv. Amt</th>
                </tr>
                <tr>
                    <td>542856.00</td><td>13571.40</td><td>13571.40</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>1.20</td><td><strong>570000.00</strong></td>
                </tr>
            </table>
        </div>        
    </div>
</body>
</html>