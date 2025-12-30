<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Cash Bill - <?= $billedet->sb_billno ?></title>
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
			font-size: 18px;
			font-weight: bold;
			padding: 8px 20px;
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
			min-height: 80px;
		}

		.customer-right {
			padding: 10px 15px;
			vertical-align: top;
		}

		.dotted-line {
			border-bottom: 1px dotted #000;
			display: inline-block;
			min-width: 200px;
		}

		.bill-no {
			font-size: 20px;
			color: #8B0000;
			font-weight: bold;
		}

		.items-table {
			width: 100%;
			border-collapse: collapse;
		}

		.items-table th {
			border: 1px solid #8B0000;
			padding: 8px;
			text-align: center;
			font-weight: bold;
			background-color: #fff;
		}

		.items-table td {
			border: 1px solid #8B0000;
			padding: 8px;
			vertical-align: top;
		}

		.items-table .sno-col {
			width: 50px;
			text-align: center;
		}

		.items-table .particulars-col {
			width: 55%;
		}

		.items-table .qty-col {
			width: 60px;
			text-align: center;
		}

		.items-table .amount-col {
			width: 100px;
			text-align: right;
		}

		.total-row td {
			font-weight: bold;
		}

		.footer-section {
			border-top: 1px solid #8B0000;
		}

		.rupees-section {
			padding: 15px;
			border-right: 1px solid #8B0000;
			min-height: 60px;
		}

		.signature-section {
			padding: 15px;
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
			margin-bottom: 10px;
		}

		@media print {
			.printButtonClass {
				display: none;
			}
		}
	</style>
</head>

<body>

<?php
if($newprint == 1)
{
?>
<a href="<?= base_url() ?>sale/servicebillhistory"><button class="printButtonClass">Back</button></a>
<?php
}
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
				<div class="cash-bill-label">CASH BILL</div>
			</td>
		</tr>
	</table>

	<!-- Customer & Bill Details Section -->
	<table width="100%" cellpadding="0" cellspacing="0" class="customer-section">
		<tr>
			<td width="65%" class="customer-left" valign="top">
				<div style="margin-bottom: 10px;"><strong>To</strong></div>
				<div style="margin-bottom: 8px;">
					M/s. <span class="dotted-line"><?= $billedet->sb_customername ?></span>
				</div>
				<div style="margin-bottom: 8px;">
					<span class="dotted-line"><?= $billedet->sb_place ?></span>
				</div>
				<div>
					<span class="dotted-line">Ph: <?= $billedet->sb_phone ?></span>
				</div>
			</td>
			<td width="35%" class="customer-right" valign="top">
				<div style="margin-bottom: 15px;">
					<strong>No.</strong> <span class="bill-no"><?= $billedet->sb_billno ?></span>
				</div>
				<div>
					<strong>Date :</strong> <?= date('d/m/Y', strtotime($billedet->sb_date)) ?>
				</div>
			</td>
		</tr>
	</table>

	<!-- Items Table -->
	<table class="items-table">
		<thead>
			<tr>
				<th class="sno-col">S.No</th>
				<th class="particulars-col">Particulars</th>
				<th class="qty-col">Qty.</th>
				<th class="amount-col">Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$kn = 1;
			$minRows = 15; // Minimum rows to display for proper bill height
			$itemCount = 0;

			if (!empty($billprodcts)) {
				foreach ($billprodcts as $prvl) {
					$itemCount++;
					?>
					<tr>
						<td class="sno-col"><?= $kn ?></td>
						<td class="particulars-col">
							<?= $prvl->sbs_productname ?>
							<?php if(!empty($prvl->sbs_complaint)) { ?>
							<br/><small>(<?= $prvl->sbs_complaint ?>)</small>
							<?php } ?>
						</td>
						<td class="qty-col">1</td>
						<td class="amount-col"><?= number_format($prvl->sbs_price, 2) ?></td>
					</tr>
					<?php
					$kn++;
				}
			}

			// Add empty rows to maintain bill height
			for ($i = $itemCount; $i < $minRows; $i++) {
				?>
				<tr>
					<td class="sno-col">&nbsp;</td>
					<td class="particulars-col">&nbsp;</td>
					<td class="qty-col">&nbsp;</td>
					<td class="amount-col">&nbsp;</td>
				</tr>
				<?php
			}
			?>

			<!-- Total Row -->
			<tr class="total-row">
				<td colspan="2" style="text-align: right; padding-right: 20px;"><strong>TOTAL</strong></td>
				<td class="qty-col"><strong><?= $itemCount ?></strong></td>
				<td class="amount-col"><strong><?= number_format($billedet->sb_grandtotal, 2) ?></strong></td>
			</tr>
		</tbody>
	</table>

	<!-- Footer Section -->
	<table width="100%" cellpadding="0" cellspacing="0" class="footer-section">
		<tr>
			<td width="60%" class="rupees-section" valign="top">
				<div style="margin-bottom: 10px;">
					<strong>Rupees:</strong> <?= convert_numbertowords($billedet->sb_grandtotal) ?> Only
				</div>
				<div class="dotted-line" style="width: 90%;"></div>
			</td>
			<td width="40%" class="signature-section" valign="bottom">
				<div style="margin-top: 30px;">For <?= $businessdet[0]->bu_unitname ?></div>
			</td>
		</tr>
	</table>
</div>

<script>
	window.print();
</script>

</body>
</html>
