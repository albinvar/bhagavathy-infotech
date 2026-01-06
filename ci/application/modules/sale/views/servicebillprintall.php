<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Service Bills - <?= $customername ? $customername : 'All Customers' ?></title>
	<style type="text/css">
		@page {
			size: A4;
			margin: 10mm;
		}

		body {
			font-family: Arial, sans-serif;
			font-size: 12px;
			margin: 0;
			padding: 10px;
			-webkit-print-color-adjust: exact;
			print-color-adjust: exact;
		}

		.bill-container {
			width: 100%;
			max-width: 700px;
			margin: 0 auto;
			border: 2px solid #8B0000;
			padding: 0;
		}

		.header-section {
			padding: 10px 15px;
			border-bottom: 1px solid #8B0000;
		}

		.business-name {
			font-size: 24px;
			font-weight: bold;
			color: #8B0000;
			margin: 0;
		}

		.tagline-box {
			display: inline-block;
			border: 1px solid #000;
			padding: 2px 8px;
			font-size: 11px;
			font-weight: bold;
			margin: 5px 0;
		}

		.address-line {
			font-size: 11px;
			margin: 5px 0;
		}

		.mobile-numbers {
			text-align: right;
			font-size: 12px;
			font-weight: bold;
		}

		.cash-bill-label {
			background-color: #D4A5A5;
			color: #8B0000;
			font-size: 16px;
			font-weight: bold;
			padding: 6px 15px;
			text-align: center;
			border: 1px solid #8B0000;
			margin-top: 5px;
		}

		.customer-section {
			border-bottom: 1px solid #8B0000;
		}

		.customer-left {
			padding: 10px 15px;
			border-right: 1px solid #8B0000;
			min-height: 60px;
		}

		.customer-right {
			padding: 10px 15px;
			vertical-align: top;
		}

		.dotted-line {
			border-bottom: 1px dotted #000;
			display: inline-block;
			min-width: 150px;
		}

		.items-table {
			width: 100%;
			border-collapse: collapse;
		}

		.items-table th {
			border: 1px solid #8B0000;
			padding: 6px;
			text-align: center;
			font-weight: bold;
			background-color: #f5f5f5;
			font-size: 11px;
		}

		.items-table td {
			border: 1px solid #8B0000;
			padding: 5px 8px;
			vertical-align: top;
			font-size: 11px;
		}

		.items-table .sno-col {
			width: 35px;
			text-align: center;
		}

		.items-table .date-col {
			width: 70px;
			text-align: center;
		}

		.items-table .billno-col {
			width: 45px;
			text-align: center;
		}

		.items-table .particulars-col {
			width: auto;
		}

		.items-table .amount-col {
			width: 80px;
			text-align: right;
		}

		.total-row td {
			font-weight: bold;
			background-color: #f5f5f5;
		}

		.footer-section {
			border-top: 1px solid #8B0000;
		}

		.rupees-section {
			padding: 10px 15px;
			border-right: 1px solid #8B0000;
		}

		.signature-section {
			padding: 10px 15px;
			text-align: center;
			font-weight: bold;
			color: #8B0000;
		}

		.printButtonClass {
			background-color: #4CAF50;
			color: white;
			padding: 10px 20px;
			border: none;
			cursor: pointer;
			margin: 5px;
			border-radius: 4px;
		}

		.printButtonClass.back-btn {
			background-color: #6c757d;
		}

		.no-print-controls {
			text-align: center;
			margin-bottom: 20px;
		}

		@media print {
			.no-print-controls {
				display: none;
			}
			body {
				padding: 0;
			}
		}
	</style>
</head>

<body>

<div class="no-print-controls">
	<a href="<?= base_url() ?>sale/servicebillhistory/<?= $fromdate ?>/<?= $todate ?>"><button class="printButtonClass back-btn">Back to List</button></a>
	<button class="printButtonClass" onclick="window.print()">Print Consolidated Bill</button>
</div>

<?php if($billlist && count($billlist) > 0):
	// Calculate totals
	$grandTotal = 0;
	$totalFreight = 0;
	$totalItems = 0;
	$allItems = array();

	// Collect all items with their bill info
	foreach($billlist as $bill) {
		$grandTotal += $bill->sb_grandtotal;
		$totalFreight += $bill->sb_freight;

		if(isset($billproducts[$bill->sb_servicebillid]) && $billproducts[$bill->sb_servicebillid]) {
			foreach($billproducts[$bill->sb_servicebillid] as $item) {
				$allItems[] = array(
					'date' => $bill->sb_date,
					'billno' => $bill->sb_billno,
					'productname' => $item->sbs_productname,
					'complaint' => $item->sbs_complaint,
					'price' => $item->sbs_price
				);
				$totalItems++;
			}
		}
	}

	// Get first bill's customer info (they should be same when filtered by customer)
	$firstBill = $billlist[0];
?>

<div class="bill-container">
	<!-- Header Section -->
	<table width="100%" cellpadding="0" cellspacing="0" class="header-section">
		<tr>
			<td width="65%" valign="top">
				<div class="business-name"><?= $businessdet[0]->bu_unitname ?></div>
				<div class="tagline-box">PRINTERS SALES - SERVICE SOLUTION</div>
				<div class="address-line"><?= $businessdet[0]->bu_address ?></div>
			</td>
			<td width="35%" valign="top">
				<div class="mobile-numbers">
					Mob: <?= $businessdet[0]->bu_phone ?>
					<?php if(!empty($businessdet[0]->bu_mobile)) { ?>
					<br/><?= $businessdet[0]->bu_mobile ?>
					<?php } ?>
				</div>
				<div class="cash-bill-label">CONSOLIDATED STATEMENT</div>
			</td>
		</tr>
	</table>

	<!-- Customer & Period Details Section -->
	<table width="100%" cellpadding="0" cellspacing="0" class="customer-section">
		<tr>
			<td width="60%" class="customer-left" valign="top">
				<div style="margin-bottom: 8px;"><strong>To</strong></div>
				<div style="margin-bottom: 6px;">
					M/s. <span class="dotted-line"><?= $customername ? $customername : $firstBill->sb_customername ?></span>
				</div>
				<?php if($firstBill->sb_place): ?>
				<div style="margin-bottom: 6px;">
					<span class="dotted-line"><?= $firstBill->sb_place ?></span>
				</div>
				<?php endif; ?>
				<div>
					Ph: <span class="dotted-line"><?= $firstBill->sb_phone ?></span>
				</div>
			</td>
			<td width="40%" class="customer-right" valign="top">
				<div style="margin-bottom: 8px;">
					<strong>Period:</strong> <?= date('d/m/Y', strtotime($fromdate)) ?> - <?= date('d/m/Y', strtotime($todate)) ?>
				</div>
				<div style="margin-bottom: 8px;">
					<strong>Total Bills:</strong> <?= count($billlist) ?>
				</div>
				<div>
					<strong>Print Date:</strong> <?= date('d/m/Y') ?>
				</div>
			</td>
		</tr>
	</table>

	<!-- Items Table -->
	<table class="items-table">
		<thead>
			<tr>
				<th class="sno-col">S.No</th>
				<th class="date-col">Date</th>
				<th class="billno-col">Bill#</th>
				<th class="particulars-col">Particulars</th>
				<th class="amount-col">Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$kn = 1;
			foreach ($allItems as $item) {
				?>
				<tr>
					<td class="sno-col"><?= $kn ?></td>
					<td class="date-col"><?= date('d/m/y', strtotime($item['date'])) ?></td>
					<td class="billno-col"><?= $item['billno'] ?></td>
					<td class="particulars-col">
						<?= $item['productname'] ?>
						<?php if(!empty($item['complaint'])) { ?>
						<br/><small style="color: #666;">(<?= $item['complaint'] ?>)</small>
						<?php } ?>
					</td>
					<td class="amount-col"><?= number_format($item['price'], 2) ?></td>
				</tr>
				<?php
				$kn++;
			}

			// Add freight row if there's freight
			if($totalFreight > 0) {
			?>
			<tr>
				<td class="sno-col"></td>
				<td class="date-col"></td>
				<td class="billno-col"></td>
				<td class="particulars-col"><em>Freight Charges</em></td>
				<td class="amount-col"><?= number_format($totalFreight, 2) ?></td>
			</tr>
			<?php } ?>

			<!-- Total Row -->
			<tr class="total-row">
				<td colspan="4" style="text-align: right; padding-right: 15px;"><strong>GRAND TOTAL</strong></td>
				<td class="amount-col"><strong><?= number_format($grandTotal, 2) ?></strong></td>
			</tr>
		</tbody>
	</table>

	<!-- Footer Section -->
	<table width="100%" cellpadding="0" cellspacing="0" class="footer-section">
		<tr>
			<td width="60%" class="rupees-section" valign="top">
				<div>
					<strong>Rupees:</strong> <?= convert_numbertowords($grandTotal) ?> Only
				</div>
			</td>
			<td width="40%" class="signature-section" valign="bottom">
				<div style="margin-top: 20px;">For <?= $businessdet[0]->bu_unitname ?></div>
			</td>
		</tr>
	</table>
</div>

<?php else: ?>
<div style="text-align: center; padding: 50px;">
	<h3>No bills found for the selected criteria.</h3>
	<a href="<?= base_url() ?>sale/servicebillhistory"><button class="printButtonClass back-btn">Back to List</button></a>
</div>
<?php endif; ?>

</body>
</html>
