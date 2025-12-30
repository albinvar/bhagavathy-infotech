<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="icon" href="<?= assets_url() ?>assets/img/favicon.png" type="image/x-icon"/>
 <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>components/css/reportstyle.css">
 <style type="text/css">
 </style>

 <body style="-webkit-print-color-adjust: exact;">
<?php 
if($newprint == 1)
{
?>
<a href="<?= base_url() ?>sale/salehistory/<?= $type ?>"><button class="printButtonClass">Back</button></a>
<?php 
}
?>
 	<table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" colspan="2"><u>
                <?php 
                if($type == 0 || $type == 1){
                    echo "<b>TAX INVOICE</b>";
                }else{
                    echo "<b>".$title."</b>";
                }
                ?>
            </u> <br/>

            <div style="margin-top: 10px;">
            	<b><?= $businessdet->bu_unitname ?></b><br/>
                 <?= $businessdet->bu_address ?><br/>
                 State, Code &nbsp; : <?= $businessdet->name ?>, <?= $businessdet->statecode ?><br/>
                 <?= $this->isvatgstname ?> No &nbsp; : <b><?= $businessdet->bu_gstnumber ?></b>
            </div>
        </td>
        </tr>
        <tr>
        	<td><b>Invoice No:</b> <?= $purchasedet->rb_billprefix ?><?= $purchasedet->rb_billno ?></td>
        	<td align="right"><b>DATE:</b> <?php echo date('d/m/Y', strtotime($purchasedet->rb_date)) ?> <?php echo date('H:i', strtotime($purchasedet->rb_time)) ?></td>
        </tr>

        <tr>
        	<td colspan="2" style="border-top: 1px #000 solid;">
        		<div style="margin-top: 10px;">
        		Details Of Reciever(Billed To): <br/>
        		<?php 
                if($purchasedet->rb_existcustomer == 1)
                {
                    $custdet = $this->cstmr->getcustomerdetailsbyid($purchasedet->rb_customerid);
                    ?>
                    <table width="100%">
                        <tr valign="top">
                            <td><b>Name:</b> <b><?= $custdet->ct_name ?></b></td>
                        </tr>
                        <tr valign="top">
                            <td><b>Address:</b> <?= $custdet->ct_address ?></td>
                        </tr>
                        <tr valign="top">
                            <td><b>Phone:</b> <?= $custdet->ct_mobile ?></td>
                        </tr>
                        <tr valign="top">
                            <td><b><?= $this->isvatgstname ?> No:</b> <b><?= $custdet->ct_gstin ?></b></td>
                        </tr>
                        <tr valign="top">
                            <td><b>State, Code:</b> <?= $purchasedet->name ?>, <?= $purchasedet->statecode ?></td>
                        </tr>
                    </table>
                    <?php
                }else{
                ?>
                <table width="100%">
                    <tr valign="top">
                        <td width="70px"><b>Name:</b> <b><?= $purchasedet->rb_customername ?></b></td>
                    </tr>
                    <tr valign="top">
                        <td><b>Address:</b> <?= $purchasedet->rb_address ?></td>
                    </tr>
                    <tr valign="top">
                        <td><b>Phone:</b> <?= $purchasedet->rb_phone ?></td>
                    </tr>
                    <tr valign="top">
                        <td><b><?= $this->isvatgstname ?> No:</b> <b><?= $purchasedet->rb_gstno ?></b></td>
                    </tr>
                    <tr valign="top">
                        <td><b>State, Code:</b> <?= $purchasedet->name ?>, <?= $purchasedet->statecode ?></td>
                    </tr>
                </table>
                <?php 
                }
                ?>
            </div>
        	</td>
        </tr>
    </table>

    <div style="margin-top: 10px;">
    	<table width="100%" style="border-collapse: collapse;" cellpadding="5" cellspacing="0">
		    <thead class="bg-gray-300">
		        <tr class="fontstyles">
		            <th class="wd-5p-f">#</th>
		            <th align="left">Item</th>
		            <th>Qty</th>
		            <th>Rate</th>
		            <th>Disc</th>
		            <th>Tax<br/>(%)</th>
		            <th>Total</th>
		        </tr>
		        
		    </thead>
		    <tbody>
		    	<?php
    $kn=1;
    $totalqty = 0;
    $grosstotal = 0;
    $disctotal = 0;
    $taxvalues = array();
    $taxableamnt = 0;
    if (!empty($purchaseprodcts)) {
        foreach ($purchaseprodcts as $prvl) {
            ?>
            <tr class="billitemstr">
                <td align="center"><?= $kn ?></td>
                <td><?php echo $prvl->pd_productname . ' ' . $prvl->pd_size. ' ' . $prvl->pd_brand; ?> 
                <?php 
                if($remarkfield == 1 && $prvl->rbs_remarks != "")
                {
                   echo '- ' . $prvl->rbs_remarks;
                }
                ?>
                </td>
                <td align="right"><?php 
                    echo $prvl->rbs_qty;
                    $totalqty = $totalqty + $prvl->rbs_qty;
                ?></td>

                <td align="right"><?php 
                    $netprdrate = $prvl->rbs_netamount + $prvl->rbs_discountamnt;
                    echo price_roundof($netprdrate);

                    $grosamnt = $prvl->rbs_qty * $netprdrate; 
                    $grosstotal = $grosstotal + $grosamnt;
                ?></td>
                
                <td align="right"><?php 
                    echo price_roundof($prvl->rbs_totaldiscount); 
                    $disctotal = $disctotal + $prvl->rbs_totaldiscount;
                ?></td>

                
                <td align="center"><?php 
                	$taxableamnt = $taxableamnt+$prvl->rbs_nettotal;
                    echo $prvl->rbs_gstpercent;
                    if(!in_array($prvl->rbs_gstpercent, $taxvalues))
                    {
                        $taxvalues[] = $prvl->rbs_gstpercent;
                        ${"tottaxableamnt" . $prvl->rbs_gstpercent} = $prvl->rbs_nettotal;
                        ${"tottaxamnt" . $prvl->rbs_gstpercent} = $prvl->rbs_totalgst;
                    }else{
                        ${"tottaxableamnt" . $prvl->rbs_gstpercent} = ${"tottaxableamnt" . $prvl->rbs_gstpercent} + $prvl->rbs_nettotal;
                        ${"tottaxamnt" . $prvl->rbs_gstpercent} = ${"tottaxamnt" . $prvl->rbs_gstpercent} + $prvl->rbs_totalgst;
                    }
                    
                ?></td>
                
                <td align="right"><?php echo price_roundof($prvl->rbs_totalamount) ?></td>
        </tr>
        <?php
        $kn++;
    }
}
?>
		    </tbody>
		    <tfoot style="border-top: 1px #c7c1c1 solid;">
		    	<tr class="fontstyles">
		        <td colspan="2" align="right">Total</td>
		        <th align="right"><?= $totalqty ?></th>
		        <th></th>
		        <th align="right"><?= price_roundof($disctotal) ?></th>
		        <th></th>
		        <th align="right"><?= price_roundof($purchasedet->rb_totalamount) ?></th>
		    </tr>
		    </tfoot>
		</table>

		<div style="margin-top: 15px;">
			<table width="100%" style="border-top: 1px #000 solid;">
                <tr>
                    <th align="left">Gross Amount:</th>
                    <th align="right"><?= price_roundof($grosstotal) ?></th>
                </tr>
                <tr>
                    <th align="left">Discount:</th>
                    <th align="right"><?= price_roundof($disctotal) ?></th>
                </tr>
                <tr>
                    <th align="left">Taxable Amount:</th>
                    <th align="right"><?= price_roundof($taxableamnt) ?></th>
                </tr>
                <tr>
                    <th align="left">Tax:</th>
                    <th align="right"><?= price_roundof($purchasedet->rb_totalgstamnt) ?></th>
                </tr>
                <?php 
                if($purchasedet->rb_freight > 0)
                {
                    ?>
                    <tr>
                        <th align="left">Freight</th>
                        <th align="right"><?= price_roundof($purchasedet->rb_freight) ?></th>
                    </tr>
                    <?php
                }
                ?>
                <tr >
                    <th align="left">Round Off:</th>
                    <th align="right"><?= price_roundof($purchasedet->rb_roundoffvalue) ?></th>
                </tr>

                <tr>
                    <th align="left">Total</th>
                    <th align="right" style="font-size: 15px;"><?= price_roundof($purchasedet->rb_grandtotal) ?></th>
                </tr>
                
            </table>
		</div>

		<div style="margin-top: 15px;">
			<table width="100%" style="border-top: 1px #000 solid;" >
                <tr>
                    <th align="right">Tax %</th>
                    <th align="right">Taxable Amount</th>
                    <?php 
                    if($purchasedet->rb_state == '4028' || $purchasedet->rb_state == '')
                    {
                    ?>
                    <th align="right">SGST</th>
                    <th align="right">CGST</th>
                    <?php 
                    }else{

                    ?>
                    <th align="right">
                        <?php
                        if($this->isvatgst == 0)
                        {
                            echo "IGST";
                        }else{
                            echo "VAT";
                        }
                        ?>
                    </th>
                    <?php 
                    }
                    ?>
                </tr>
                
                <?php
                $txk=0;
                asort($taxvalues, 1);
                $tottaxableamnt = 0;
                $sgsttotal = 0;
                $cgsttotal =0;
                $igsttotal = 0;
                foreach($taxvalues as $txvl)
                {
                    $tottaxableamnt = $tottaxableamnt + price_roundof(${"tottaxableamnt" . $txvl});
                    
                    ?>
                    <tr>
                        <td align="right"><?= $txvl ?></td>
                        <td align="right"><?php echo price_roundof(${"tottaxableamnt" . $txvl}); ?></td>
                        <?php 
                        if($purchasedet->rb_state == '4028' || $purchasedet->rb_state == '')
                        {
                            $sgsttotal = $sgsttotal + price_roundof(${"tottaxamnt" . $txvl}/2);
                            $cgsttotal = $cgsttotal + price_roundof(${"tottaxamnt" . $txvl}/2);
                        ?>
                        <td align="right"><?php echo price_roundof(${"tottaxamnt" . $txvl}/2); ?></td>
                        <td align="right"><?php echo price_roundof(${"tottaxamnt" . $txvl}/2); ?></td>
                        <?php 
                        }else{
                            $igsttotal = $igsttotal + price_roundof(${"tottaxamnt" . $txvl});
                        ?>
                        <td align="right"><?php echo price_roundof(${"tottaxamnt" . $txvl}); ?></td>
                        <?php 
                        }
                        ?>
                    </tr>
                    <?php
                    $txk++;
                }
                if($txk >1)
                {
                    ?>
                    <tr>
                        <th align="right" style="border-top: 1px #000 solid;">Total</th>
                        <th align="right" style="border-top: 1px #000 solid;"><?= $tottaxableamnt ?></th>
                        <?php 
                        if($purchasedet->rb_state == '4028' || $purchasedet->rb_state == '')
                        {
                        ?>
                        <th align="right" style="border-top: 1px #000 solid;"><?= $sgsttotal ?></th>
                        <th align="right" style="border-top: 1px #000 solid;"><?= $cgsttotal ?></th>
                        <?php 
                        }else{
                            ?>
                            <th align="right" style="border-top: 1px #000 solid;"><?= $igsttotal ?></th>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </table>
		</div>

		<div align="center" style="margin-top: 10px; border-top: 1px #000 solid; padding-top: 8px;">
			<b>GRAND TOTAL: <?= price_roundof($purchasedet->rb_grandtotal) ?></b><br/>
			Total Invoice Amount in Words<br/>
			<b>Rs <?php echo convert_numbertowords($purchasedet->rb_grandtotal); ?> Only</b>
		</div>
    </div>

 </body>
 <script>
 window.print();
</script>
</body>

</html>