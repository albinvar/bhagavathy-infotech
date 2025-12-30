<!DOCTYPE html>
<html>
<head>
	<title>Print</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<style type="text/css">
		body{
			font-family: arial;
		}
		.printtable{
			border-collapse: collapse;
		}
	</style>
</head>
<body>

	

    <table border="0" width="98%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" colspan="2"><u>
                <?php 
            if($journaldet->je_vouchertype == 1)
            {
                echo "Payment Voucher";
            }
            ?>
            </u></td>
        </tr>

        <tr>
            <td width="50%">
                <?php 
                if($this->bulogo != "")
                {
                    ?>
                <img src="<?= base_url() ?>uploads/business/<?= $this->bulogo ?>" class="imagestyle" height="85px" alt="user-image">
                <?php 
                }
                ?>
            </td>
            
            <td width="50%" align="right" style=" font-size: 13px;">
                <table width="100%">
                    <tr valign="top">
                        <td>
                            <b><?= $businessdet->bu_unitname ?></b><br/>
                            <?= $businessdet->bu_address ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td>State, Code &nbsp; : <?= $businessdet->name ?>, <?= $businessdet->statecode ?></td>
                    </tr>
                    <tr valign="top">
                        <td><?= $this->isvatgstname ?> No &nbsp; : <b><?= $businessdet->bu_gstnumber ?></b></td>
                        
                    </tr>
                    
                </table>
                
            </td>
        </tr>
    </table>

	<table width="100%" style="margin-top: 10px; border-top: 1px #000 solid; padding-top: 10px;">
		<tr>
			<td width="50%">Voucher No: <b><?= $journaldet->je_journalnumber ?></b></td>
			<td align="right">Date: <b><?= date('d-M-Y', strtotime($journaldet->je_date)) ?></b></td>
		</tr>
	</table>
	
<div style="margin-top: 20px;">
<table class="table w-100 printtable" cellpadding="5" width="100%" border="1">
    <thead>
        <tr>
            <th align="left">Particular</th>
            <th align="left">Description</th>
            <th width="14%">Credit/Debit</th>
            <th width="14%">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $totcredit = 0;
        $totdebit = 0;
        if($ledgerdet)
        {
            foreach($ledgerdet as $ldgvl)
            {
                ?>
                <tr>
                    <td>
                        <?= $ldgvl->al_ledger ?>
                    </td>
                    <td><?= $ldgvl->le_note ?></td>
                    <td align="center">
                        <?php 
                        if($ldgvl->le_isdebit == 1)
                        {
                            $totcredit = $totcredit + $ldgvl->le_amount;
                            ?>
                            <span class="badge bg-success">Cr</span>
                            <?php
                        }else{
                            $totdebit = $totdebit + $ldgvl->le_amount;
                            ?>
                            <span class="badge bg-danger">Dr</span>
                            <?php
                        }
                        ?>
                        
                    </td>
                    <td align="center"><?= $ldgvl->le_amount ?></td>
                </tr>
                <?php
            }
        }
        ?>
        
        
    </tbody>
    <!--<tfoot>
        <tr>
            <th colspan="2">Total</th>
            <th colspan="3" align="right">
                Total Credit: <?= $totcredit ?> &nbsp; &nbsp; &nbsp;
                Total Debit: <?= $totdebit ?>
            </th>
        </tr>
    </tfoot>-->
</table>
</div>


<div class="col-md-12" style="margin-top: 20px;">
    Notes: <b><?= $journaldet->je_description ?></b>
</div>

</body>

<script type="text/javascript">
	window.print();
</script>
</html>