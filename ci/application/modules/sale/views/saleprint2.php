<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="icon" href="<?= assets_url() ?>assets/img/favicon.png" type="image/x-icon"/>
 <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>components/css/reportstyle.css">
 <style type="text/css">

  .page-footer-space {
    height: 35px;
    padding: 0px;
    margin-bottom: 0px;
  }
  .page-footer {
    height: 35px;
    position: fixed;
    bottom: 0;
    width: 97%;
    border-top: 0px;
    padding: 0px;
    margin-bottom: 0px;
    /*background: yellow; /* for demo */
  }

  @media print {
  .table-blue-fotter {
    
    
  }
}

  
  .emtycellstyle{
    border-bottom: 0px;
    border-top: 0px; 
    height: 27px;
  }

  @page {
    margin: 0px;
    padding: 0px;
  }
 </style>

 <?php 
  if($purchasedet->rb_pagesize == 2)
  {
  ?>
  <style type="text/css">
  @page
   {
    size: A5;
  }
  .imagestyle{
    height: 85px;
  }
  .page-header {
    height: 220px;
    width: 95%;
    margin-left: 5px;
    margin-top: 5px;
  }
  .page-header-space{
    height: 220px;
  }
  .tablestyle{
    border-collapse: collapse; 
    margin-top: 5px; 
    font-size: 10px;
  }
  .billitemstr{
    font-size: 10px;
    min-height: 250px;
  }
  .fontstyles{
    font-size: 10px;
  }
  </style>
  <?php 
}else{
 ?>
 <style type="text/css">
  @page
   {
    size: A4;
  }
  .imagestyle{
    height: 95px;
  }
  .page-header {
    height: 270px;
    width: 97%;
    margin-left: 5px;
    margin-top: 5px;
  }
  .page-header-space{
    height: 270px;
  }
  .tablestyle{
    border-collapse: collapse; 
    margin-top: 5px; 
    font-size: 12px;
  }
  .billitemstr{
    font-size: 12px;
    min-height: 250px;
  }
  .fontstyles{
    font-size: 13px;
  }
  </style>
<?php
}
 ?>
</head>

<body style="-webkit-print-color-adjust: exact;">

<?php 
if($newprint == 1)
{
?>
<a href="<?= base_url() ?>sale/salehistory/<?= $type ?>"><button class="printButtonClass">Back</button></a>
<?php 
}
?>

<div class="page-header">
    <div style="width: 97%">
    <table border="0" width="98%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" colspan="2"><u>
                <?php 
                if($type == 0 || $type == 1){
                    echo "<b>TAX INVOICE</b>";
                }else{
                    echo "<b>".$title."</b>";
                }
                ?>
            </u></td>
        </tr>

        <tr>
            <td width="30%">
                <?php 
                if($this->bulogo != "")
                {
                    ?>
                <img src="<?= base_url() ?>uploads/business/<?= $this->bulogo ?>" class="imagestyle" alt="user-image">
                <?php 
                }
                ?>
            </td>
            
            <td width="70%" align="right" style=" font-size: 13px;">
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

    
    <table border="1" width="98%" class="tablestyle" cellpadding="3" cellspacing="0">
      <tbody>
        <tr>
            <td><b>Invoice No:</b> <?= $purchasedet->rb_billprefix ?><?= $purchasedet->rb_billno ?></td>
            <td><b>DATE:</b> <?php echo date('d/m/Y', strtotime($purchasedet->rb_date)) ?> <?php echo date('H:i', strtotime($purchasedet->rb_time)) ?></td>
        </tr>
        <tr valign="top">
            <td width="50%" align="left" valign="top">
                <?php 
                if($purchasedet->rb_existcustomer == 1)
                {
                    $custdet = $this->cstmr->getcustomerdetailsbyid($purchasedet->rb_customerid);
                    ?>
                    <table width="100%">
                        <tr valign="top">
                            <td width="70px"><b>Billed To:</b></td>
                            <td>: <b><?= $custdet->ct_name ?></b></td>
                        </tr>
                        <tr valign="top">
                            <td><b>Address:</b></td>
                            <td>: <?= $custdet->ct_address ?></td>
                        </tr>
                        <tr valign="top">
                            <td><b>Phone:</b></td>
                            <td>: <?= $custdet->ct_mobile ?></td>
                        </tr>
                        <tr valign="top">
                            <td><b><?= $this->isvatgstname ?> No:</b></td>
                            <td>: <b><?= $custdet->ct_gstin ?></b></td>
                        </tr>
                        <tr valign="top">
                            <td><b>State, Code</b></td>
                            <td>: <?= $purchasedet->name ?>, <?= $purchasedet->statecode ?></td>
                        </tr>
                    </table>
                    <?php
                }else{
                ?>
                <table width="100%">
                    <tr valign="top">
                        <td width="70px"><b>Billed To:</b></td>
                        <td>: <b><?= $purchasedet->rb_customername ?></b></td>
                    </tr>
                    <tr valign="top">
                        <td><b>Address:</b></td>
                        <td>: <?= $purchasedet->rb_address ?></td>
                    </tr>
                    <tr valign="top">
                        <td><b>Phone:</b></td>
                        <td>: <?= $purchasedet->rb_phone ?></td>
                    </tr>
                    <tr valign="top">
                        <td><b><?= $this->isvatgstname ?> No:</b></td>
                        <td>: <b><?= $purchasedet->rb_gstno ?></b></td>
                    </tr>
                    <tr valign="top">
                        <td><b>State, Code</b></td>
                        <td>: <?= $purchasedet->name ?>, <?= $purchasedet->statecode ?></td>
                    </tr>
                </table>
                <?php 
                }
                ?>
            </td>
            <td>
                <?php 
                if($purchasedet->rb_existcustomer == 1)
                {
                    $custdet = $this->cstmr->getcustomerdetailsbyid($purchasedet->rb_customerid);
                    ?>
                    <table width="100%">
                        <tr valign="top">
                            <td width="70px"><b>Shipped To:</b></td>
                            <td>: <b><?= $custdet->ct_name ?></b></td>
                        </tr>
                        <tr valign="top">
                            <td><b>Address:</b></td>
                            <td>: <?= $purchasedet->rb_shippingaddress ?></td>
                        </tr>
                        <tr valign="top">
                            <td><b>Phone:</b></td>
                            <td>: <?= $custdet->ct_mobile ?></td>
                        </tr>
                        <tr valign="top">
                            <td><b><?= $this->isvatgstname ?> No:</b></td>
                            <td>: <b><?= $custdet->ct_gstin ?></b></td>
                        </tr>
                        <tr valign="top">
                            <td><b>State, Code</b></td>
                            <td>: <?= $purchasedet->name ?>, <?= $purchasedet->statecode ?></td>
                        </tr>
                    </table>
                    <?php
                }else{
                ?>
                <table width="100%">
                    <tr>
                        <td width="70px"><b>Shipped To:</b></td>
                        <td>: <b><?= $purchasedet->rb_customername ?></b></td>
                    </tr>
                    <tr>
                        <td><b>Address:</b></td>
                        <td>: <?= $purchasedet->rb_shippingaddress ?></td>
                    </tr>
                    <tr>
                        <td><b>Phone:</b></td>
                        <td>: <?= $purchasedet->rb_phone ?></td>
                    </tr>
                    <tr>
                        <td><b><?= $this->isvatgstname ?> No:</b></td>
                        <td>: <b><?= $purchasedet->rb_gstno ?></b></td>
                    </tr>
                    <tr>
                        <td><b>State, Code</b></td>
                        <td>: <?= $purchasedet->name ?>, <?= $purchasedet->statecode ?></td>
                    </tr>
                </table>
                <?php 
                }
                ?>
            </td>
        </tr>
    </tbody>
    </table>
    
    
    </div>
</div>

<div class="page-footer">
    <div align="center" style="font-size: 12px; ">
        
        <i>This is a computer generated <?php 
                if($type == 0 || $type == 1){
                    echo "invoice";
                }else{
                    echo $title;
                }
                ?></i></div>
</div>


<table width="100%">

    <thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td>
          <!--*** CONTENT GOES HERE ***-->

          <div class="page" >


<table border="1" width="100%" style="border-collapse: collapse;" cellpadding="5" cellspacing="0">
    <thead class="bg-gray-300">
        <tr class="fontstyles">
            <th class="wd-5p-f">#</th>
            <th>HSNC</th>
            <th align="left">Description</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Gross<br/>Amount</th>
            
            <th>Disc<br/>(%)</th>
            <th>Disc</th>
            
            <th>Taxable<br/>Amount</th>
            <th>Taxes<br/>(%)</th>
            <th>Taxes</th>
            <th>Total</th>
        </tr>
        
    </thead>
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
                <td><?= $prvl->pd_hsnno ?></td>
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
                ?></td>
                <td align="right"><?php 
                    $grosamnt = $prvl->rbs_qty * $netprdrate; 
                    echo price_roundof($grosamnt);
                    $grosstotal = $grosstotal + $grosamnt;
                ?></td>
                
                <td align="right"><?php echo $prvl->rbs_discountpercent ?></td>
                <td align="right"><?php 
                    echo price_roundof($prvl->rbs_totaldiscount); 
                    $disctotal = $disctotal + $prvl->rbs_totaldiscount;
                ?></td>

                <td align="right"><?php 
                    echo price_roundof($prvl->rbs_nettotal); 
                    $taxableamnt = $taxableamnt+$prvl->rbs_nettotal;
                ?></td>
                <td align="center"><?php 
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
                <td align="right"><?php echo price_roundof($prvl->rbs_totalgst) ?></td>
                
                <td align="right"><?php echo price_roundof($prvl->rbs_totalamount) ?></td>
        </tr>
        <?php
        $kn++;
    }
}

if($purchasedet->rb_pagesize == 2)
{
    $emptycell = 5-$kn;
}else{
    $emptycell = 11-$kn;
}
for($n=0; $n<=$emptycell; $n++)
{
    ?>
    <tr>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
    </tr>
    <?php
}
?>
    <tr class="fontstyles">
        <td colspan="3" align="right">Total</td>
        <th align="right"><?= $totalqty ?></th>
        <th></th>
        <th align="right"><?= price_roundof($grosstotal) ?></th>
        <th></th>
        <th align="right"><?= price_roundof($disctotal) ?></th>
        <th align="right"><?= price_roundof($taxableamnt) ?></th>
        <th></th>
        <th align="right"><?= price_roundof($purchasedet->rb_totalgstamnt) ?></th>
        <th align="right"><?= price_roundof($purchasedet->rb_totalamount) ?></th>
    </tr>

</table>

<table width="100%" class="fontstyles" style="margin-top: 10px; margin-bottom: 10px;">
    <tr valign="top">
        <td width="60%" style="padding-right: 20px;">
            <table width="100%" style="border-top: 1px #000 solid;" >
                <tr>
                    <th align="right">Tax %</th>
                    <th align="right">Taxable Amount</th>
                    <?php 
                    if(($purchasedet->rb_state == $businessdet->bu_state || $purchasedet->rb_state == '') || $businessdet->bu_country != '101')
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
                        if(($purchasedet->rb_state == $businessdet->bu_state || $purchasedet->rb_state == '') || $businessdet->bu_country != '101')
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
                        if(($purchasedet->rb_state == $businessdet->bu_state || $purchasedet->rb_state == '') || $businessdet->bu_country != '101')
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
            
        </td>
        <td >
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
                
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding-right: 20px;">
            Grand Total(in words): <b>Rs <?php echo convert_numbertowords($purchasedet->rb_grandtotal); ?> Only</b>
        </td>
        <td>
            <table width="100%" style="border-top: 1px #000 solid;">
                <tr>
                    <th align="left">Total</th>
                    <th align="right" style="font-size: 15px;"><?= price_roundof($purchasedet->rb_grandtotal) ?></th>
                </tr>
            </table>
        </td>
    </tr>
</table>



<table border="1" width="100%" class="table-blue-fotter" style="border-collapse: collapse;" cellpadding="5" cellspacing="0">
    <tr>
        <td width="60%" class="fontstyles" >
            <table width="100%">
                <tr>
                    <td>
                        <span style="text-decoration: underline;">Payment Details</span><br/>
                        Please remit directly to our bank account<br/>
                        Bank: <b><?= $businessdet->bu_bankname ?></b><br/>
                        Acc No: <b><?= $businessdet->bu_accountnumber ?></b><br/>
                        IFSC: <b><?= $businessdet->bu_ifsccode ?></b><br/>
                        Branch: <b><?= $businessdet->bu_bankbranch ?></b>
                    </td>
                    <td align="right">
                        <?php 
                if($businessdet->bu_qrcode != "")
                {
                    ?>
                <img src="<?= base_url() ?>uploads/business/<?= $businessdet->bu_qrcode ?>" height="85px" style="margin-right: 5px;" alt="user-image">
                <?php 
                }
                ?>
                    </td>
                </tr>
            </table>
            
        </td>
        <td align="right" class="fontstyles">
            for <b><?= $businessdet->bu_unitname ?></b>
            <br/>
            <?php 
                if($businessdet->bu_companyseal != "")
                {
                    ?>
                <img src="<?= base_url() ?>uploads/business/<?= $businessdet->bu_companyseal ?>" width="60px" style="margin-right: 30px;" alt="user-image">
                <?php 
                }
                ?>
            <br/>
            Authorised Signatory
        </td>
    </tr>
</table>



</div>
</td>
</tr>
</tbody>

    <tfoot style="margin: 0px;">
      <tr>
        <td>
          <!--place holder for the fixed-position footer-->
          <div class="page-footer-space">
              
          </div>
        </td>
      </tr>
    </tfoot>
</table>

<script>
 window.print();
</script>
</body>

</html>