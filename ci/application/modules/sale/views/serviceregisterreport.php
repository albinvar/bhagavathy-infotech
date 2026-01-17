<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Service Register Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.3;
            padding: 15px;
        }
        .report-header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .report-header h1 {
            font-size: 16px;
            margin-bottom: 3px;
        }
        .report-header h2 {
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 5px;
        }
        .report-header p {
            font-size: 10px;
            color: #555;
        }
        .report-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 10px;
        }
        .register-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .register-table th,
        .register-table td {
            border: 1px solid #333;
            padding: 5px 4px;
            text-align: left;
            vertical-align: top;
        }
        .register-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 10px;
            text-align: center;
        }
        .register-table td {
            font-size: 10px;
        }
        .register-table .sl-no {
            width: 30px;
            text-align: center;
        }
        .register-table .code-col {
            width: 70px;
            font-weight: bold;
        }
        .register-table .date-col {
            width: 75px;
            text-align: center;
        }
        .register-table .customer-col {
            width: 120px;
        }
        .register-table .device-col {
            width: 130px;
        }
        .register-table .reason-col {
            width: auto;
        }
        .register-table .status-col {
            width: 70px;
            text-align: center;
        }
        .register-table .cost-col {
            width: 60px;
            text-align: right;
        }
        .status-pending { color: #856404; }
        .status-inprogress { color: #004085; }
        .status-completed { color: #155724; }
        .status-delivered { color: #383838; }

        .summary-box {
            margin-top: 15px;
            padding: 10px;
            background: #f8f8f8;
            border: 1px solid #ddd;
        }
        .summary-box table {
            width: 100%;
        }
        .summary-box td {
            padding: 3px 5px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .no-print {
            margin-bottom: 15px;
            text-align: center;
        }
        @media print {
            body {
                padding: 5px;
            }
            .no-print {
                display: none;
            }
            .register-table th,
            .register-table td {
                padding: 3px 2px;
                font-size: 9px;
            }
        }
        @page {
            size: landscape;
            margin: 10mm;
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()" style="padding: 10px 30px; font-size: 14px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 5px;">
        Print Register
    </button>
    <button onclick="window.close()" style="padding: 10px 30px; font-size: 14px; cursor: pointer; background: #6c757d; color: white; border: none; border-radius: 5px; margin-left: 10px;">
        Close
    </button>
</div>

<!-- Report Header -->
<div class="report-header">
    <?php if(isset($businessdet) && is_object($businessdet)): ?>
    <h1><?= htmlspecialchars($businessdet->bu_unitname) ?></h1>
    <p><?= htmlspecialchars($businessdet->bu_address) ?> | Phone: <?= htmlspecialchars($businessdet->bu_phone) ?></p>
    <?php endif; ?>
    <h2>SERVICE REGISTER</h2>
    <p>
        Period: <?= date('d-M-Y', strtotime($fromdate)) ?> to <?= date('d-M-Y', strtotime($todate)) ?>
        <?php
        $statusLabel = 'All Status';
        if($status === '0' || $status === 0) $statusLabel = 'Pending';
        elseif($status === '1' || $status === 1) $statusLabel = 'In Progress';
        elseif($status === '2' || $status === 2) $statusLabel = 'Completed';
        elseif($status === '3' || $status === 3) $statusLabel = 'Delivered';
        ?>
        | Status: <?= $statusLabel ?>
    </p>
</div>

<!-- Register Table -->
<table class="register-table">
    <thead>
        <tr>
            <th class="sl-no">Sl</th>
            <th class="code-col">Code</th>
            <th class="date-col">In Date</th>
            <th class="customer-col">Customer Details</th>
            <th class="device-col">Device Details</th>
            <th class="reason-col">Reason/Complaint</th>
            <th class="status-col">Status</th>
            <th class="date-col">Out Date</th>
            <th class="cost-col">Cost</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalCost = 0;
        $pendingCount = 0;
        $inProgressCount = 0;
        $completedCount = 0;
        $deliveredCount = 0;

        if($registerlist):
            $sl = 1;
            foreach($registerlist as $item):
                $totalCost += $item->sr_servicecost;

                // Count by status
                switch($item->sr_status) {
                    case 0: $pendingCount++; break;
                    case 1: $inProgressCount++; break;
                    case 2: $completedCount++; break;
                    case 3: $deliveredCount++; break;
                }

                // Status text and class
                $statusClass = '';
                $statusText = '';
                switch($item->sr_status) {
                    case 0: $statusClass = 'status-pending'; $statusText = 'Pending'; break;
                    case 1: $statusClass = 'status-inprogress'; $statusText = 'In Progress'; break;
                    case 2: $statusClass = 'status-completed'; $statusText = 'Completed'; break;
                    case 3: $statusClass = 'status-delivered'; $statusText = 'Delivered'; break;
                }
        ?>
        <tr>
            <td class="sl-no"><?= $sl ?></td>
            <td class="code-col"><?= $item->sr_code ?></td>
            <td class="date-col">
                <?= date('d-M-Y', strtotime($item->sr_indate)) ?><br>
                <small><?= date('h:i A', strtotime($item->sr_intime)) ?></small>
            </td>
            <td class="customer-col">
                <strong><?= htmlspecialchars($item->sr_customername) ?></strong><br>
                <?= htmlspecialchars($item->sr_phone) ?>
                <?php if($item->sr_address): ?><br><small><?= htmlspecialchars($item->sr_address) ?></small><?php endif; ?>
            </td>
            <td class="device-col">
                <?= htmlspecialchars($item->sr_printername) ?>
                <?php if($item->sr_printertype): ?><br><small>Type: <?= htmlspecialchars($item->sr_printertype) ?></small><?php endif; ?>
                <?php if($item->sr_serialno): ?><br><small>S/N: <?= htmlspecialchars($item->sr_serialno) ?></small><?php endif; ?>
            </td>
            <td class="reason-col"><?= htmlspecialchars($item->sr_reason) ?></td>
            <td class="status-col"><span class="<?= $statusClass ?>"><?= $statusText ?></span></td>
            <td class="date-col">
                <?php if($item->sr_outdate): ?>
                <?= date('d-M-Y', strtotime($item->sr_outdate)) ?><br>
                <small><?= date('h:i A', strtotime($item->sr_outtime)) ?></small>
                <?php else: ?>
                -
                <?php endif; ?>
            </td>
            <td class="cost-col"><?= ($item->sr_servicecost > 0) ? number_format($item->sr_servicecost, 2) : '-' ?></td>
        </tr>
        <?php
            $sl++;
            endforeach;
        else:
        ?>
        <tr>
            <td colspan="9" style="text-align: center; padding: 20px;">No records found for the selected period.</td>
        </tr>
        <?php endif; ?>
    </tbody>
    <?php if($registerlist): ?>
    <tfoot>
        <tr>
            <th colspan="8" style="text-align: right;">Total Service Cost:</th>
            <th class="cost-col"><?= number_format($totalCost, 2) ?></th>
        </tr>
    </tfoot>
    <?php endif; ?>
</table>

<!-- Summary Box -->
<?php if($registerlist): ?>
<div class="summary-box">
    <table>
        <tr>
            <td><strong>Total Entries:</strong> <?= count($registerlist) ?></td>
            <td><strong>Pending:</strong> <?= $pendingCount ?></td>
            <td><strong>In Progress:</strong> <?= $inProgressCount ?></td>
            <td><strong>Completed:</strong> <?= $completedCount ?></td>
            <td><strong>Delivered:</strong> <?= $deliveredCount ?></td>
            <td><strong>Total Cost:</strong> Rs. <?= number_format($totalCost, 2) ?></td>
        </tr>
    </table>
</div>
<?php endif; ?>

<!-- Footer -->
<div class="footer">
    <p>Printed on: <?= date('d-M-Y h:i A') ?></p>
</div>

</body>
</html>
