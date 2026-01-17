<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Service Receipt - <?= $entry->sr_code ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .receipt-header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .receipt-header p {
            font-size: 11px;
            color: #555;
        }
        .receipt-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            background: #f0f0f0;
            padding: 8px;
            margin-bottom: 15px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .info-row .label {
            color: #666;
            font-size: 11px;
        }
        .info-row .value {
            font-weight: bold;
        }
        .section {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .section-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 8px;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .code-box {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            padding: 10px;
            background: #f8f9fa;
            border: 2px dashed #007bff;
            margin-bottom: 15px;
        }
        .status-box {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-inprogress { background: #cce5ff; color: #004085; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-delivered { background: #d1d1d1; color: #383838; }

        .two-col {
            display: flex;
            gap: 15px;
        }
        .two-col > div {
            flex: 1;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .signature-box {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box > div {
            width: 45%;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 40px;
            padding-top: 5px;
            font-size: 11px;
        }
        @media print {
            body {
                padding: 10px;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="no-print" style="text-align: center; margin-bottom: 20px;">
    <button onclick="window.print()" style="padding: 10px 30px; font-size: 14px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 5px;">
        Print Receipt
    </button>
    <button onclick="window.close()" style="padding: 10px 30px; font-size: 14px; cursor: pointer; background: #6c757d; color: white; border: none; border-radius: 5px; margin-left: 10px;">
        Close
    </button>
</div>

<!-- Receipt Header -->
<div class="receipt-header">
    <?php if(isset($businessdet) && is_object($businessdet)): ?>
    <h1><?= htmlspecialchars($businessdet->bu_unitname) ?></h1>
    <p><?= htmlspecialchars($businessdet->bu_address) ?></p>
    <p>Phone: <?= htmlspecialchars($businessdet->bu_phone) ?></p>
    <?php else: ?>
    <h1>Service Receipt</h1>
    <?php endif; ?>
</div>

<div class="receipt-title">SERVICE REGISTER RECEIPT</div>

<!-- Service Code -->
<div class="code-box">
    <?= $entry->sr_code ?>
</div>

<!-- Dates and Status -->
<div class="two-col">
    <div class="section">
        <div class="section-title">IN Details</div>
        <div class="info-row">
            <span class="label">Date:</span>
            <span class="value"><?= date('d-M-Y', strtotime($entry->sr_indate)) ?></span>
        </div>
        <div class="info-row">
            <span class="label">Time:</span>
            <span class="value"><?= date('h:i A', strtotime($entry->sr_intime)) ?></span>
        </div>
    </div>
    <div class="section">
        <div class="section-title">OUT Details</div>
        <?php if($entry->sr_outdate): ?>
        <div class="info-row">
            <span class="label">Date:</span>
            <span class="value"><?= date('d-M-Y', strtotime($entry->sr_outdate)) ?></span>
        </div>
        <div class="info-row">
            <span class="label">Time:</span>
            <span class="value"><?= date('h:i A', strtotime($entry->sr_outtime)) ?></span>
        </div>
        <?php else: ?>
        <div class="info-row">
            <span class="label">Status:</span>
            <?php
            $statusclass = '';
            $statustext = '';
            switch($entry->sr_status) {
                case 0: $statusclass = 'status-pending'; $statustext = 'Pending'; break;
                case 1: $statusclass = 'status-inprogress'; $statustext = 'In Progress'; break;
                case 2: $statusclass = 'status-completed'; $statustext = 'Ready for Pickup'; break;
                case 3: $statusclass = 'status-delivered'; $statustext = 'Delivered'; break;
            }
            ?>
            <span class="status-box <?= $statusclass ?>"><?= $statustext ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Customer Details -->
<div class="section">
    <div class="section-title">Customer Details</div>
    <div class="info-row">
        <span class="label">Name:</span>
        <span class="value"><?= htmlspecialchars($entry->sr_customername) ?></span>
    </div>
    <div class="info-row">
        <span class="label">Phone:</span>
        <span class="value"><?= htmlspecialchars($entry->sr_phone) ?></span>
    </div>
    <?php if($entry->sr_address): ?>
    <div class="info-row">
        <span class="label">Address:</span>
        <span class="value"><?= htmlspecialchars($entry->sr_address) ?></span>
    </div>
    <?php endif; ?>
</div>

<!-- Device Details -->
<div class="section">
    <div class="section-title">Device Details</div>
    <div class="info-row">
        <span class="label">Device Name:</span>
        <span class="value"><?= htmlspecialchars($entry->sr_printername) ?></span>
    </div>
    <?php if($entry->sr_printertype): ?>
    <div class="info-row">
        <span class="label">Type:</span>
        <span class="value"><?= htmlspecialchars($entry->sr_printertype) ?></span>
    </div>
    <?php endif; ?>
    <?php if($entry->sr_serialno): ?>
    <div class="info-row">
        <span class="label">Serial No:</span>
        <span class="value"><?= htmlspecialchars($entry->sr_serialno) ?></span>
    </div>
    <?php endif; ?>
</div>

<!-- Complaint/Reason -->
<div class="section">
    <div class="section-title">Complaint / Reason</div>
    <p style="margin: 0;"><?= nl2br(htmlspecialchars($entry->sr_reason)) ?></p>
</div>

<!-- Service Details (if delivered) -->
<?php if($entry->sr_status == 3 || $entry->sr_servicecost > 0 || $entry->sr_remarks): ?>
<div class="section">
    <div class="section-title">Service Details</div>
    <?php if($entry->sr_servicecost > 0): ?>
    <div class="info-row">
        <span class="label">Service Cost:</span>
        <span class="value" style="font-size: 14px;">Rs. <?= number_format($entry->sr_servicecost, 2) ?></span>
    </div>
    <?php endif; ?>
    <?php if($entry->sr_remarks): ?>
    <div class="info-row" style="display: block;">
        <span class="label">Remarks:</span><br>
        <span class="value" style="font-weight: normal;"><?= nl2br(htmlspecialchars($entry->sr_remarks)) ?></span>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Signature Boxes -->
<div class="signature-box">
    <div>
        <div class="signature-line">Customer Signature</div>
    </div>
    <div>
        <div class="signature-line">Authorized Signature</div>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>Thank you for your business!</p>
    <p>Please keep this receipt for collecting your device.</p>
    <p style="margin-top: 5px; font-size: 9px;">Printed on: <?= date('d-M-Y h:i A') ?></p>
</div>

<script>
    // Auto print on page load (optional - uncomment if needed)
    // window.onload = function() { window.print(); }
</script>

</body>
</html>
