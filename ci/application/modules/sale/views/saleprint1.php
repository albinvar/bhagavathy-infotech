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
    height: 30px;
    position: fixed;
    bottom: 0;
    width: 97%;
    border-top: 0px;
    padding: 0px;
    margin-bottom: 0px;
    /*background: yellow; /* for demo */
  }

  .page-header {
    height: 265px;
    width: 98%;
    margin-left: 5px;
    margin-top: 5px;
  }
  .page-header-space{
    height: 265px;
  }
  .billitemstr{
    font-size: 13px;
    min-height: 250px;
  }

  .emtycellstyle{
    border-bottom: 0px;
    border-top: 0px; 
    height: 28px;
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
  </style>
  <?php 
}else{
 ?>
 <style type="text/css">
  @page
   {
    size: A4;
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
            <td width="20%">
                <?php 
                if($this->bulogo != "")
                {
                    ?>
                <img src="<?= base_url() ?>uploads/business/<?= $this->bulogo ?>" width="100%" alt="user-image">
                <?php 
                }
                ?>
            </td>
            <td align="center"><u>
                <?php 
                if($type == 2){
                    echo "Proforma Invoice";
                }else{
                    echo "Tax Invoice";
                }
                ?>
            </u></td>
            <td width="20%" align="right">
                <?php 
                if($businessdet->bu_franchiselogo != "")
                {
                    ?>
                <img src="<?= base_url() ?>uploads/business/<?= $businessdet->bu_franchiselogo ?>" width="80%" alt="user-image">
                <?php 
                }
                ?>
            </td>
        </tr>
    </table>

    <table border="0" width="98%" cellpadding="0" cellspacing="0" style="margin-top: 5px;">
        <tr>
            <td>Invoice No: <?= $purchasedet->rb_billprefix ?><?= $purchasedet->rb_billno ?></td>
            <td align="right">DATE: <?php echo date('d/m/Y', strtotime($purchasedet->rb_date)) ?> <?php echo date('H:i', strtotime($purchasedet->rb_time)) ?></td>
        </tr>
    </table>
    <table border="1" width="98%" style="border-collapse: collapse; margin-top: 5px;" cellpadding="5" cellspacing="0">
      <tbody>
        <tr valign="top">
            <td width="50%" align="left" valign="top">
                <h4 style="margin: 0px;"><?= $businessdet->bu_unitname ?> </h4>
                <?= $businessdet->bu_address ?><br/>
                <?php
                $phnarr = array();
                if($businessdet->bu_phone != "")
                {
                    $phnarr[] = $businessdet->bu_phone;
                }
                if($businessdet->bu_mobile != "")
                {
                    $phnarr[] = $businessdet->bu_mobile;
                }
                ?>
                Ph: <?= implode(', ', $phnarr) ?><br/>
                Email: <?= $businessdet->bu_email ?><br/>
                GSTIN: <?= $businessdet->bu_gstnumber ?>
            </td>
            <td>
                <?php 
                if($purchasedet->rb_existcustomer == 1)
                {
                    $custdet = $this->cstmr->getcustomerdetailsbyid($purchasedet->rb_customerid);
                    ?>
                    <h4 style="margin: 0px;"> <?php 
                    echo $custdet->ct_name;
                    ?></h4>
                    <?= $custdet->ct_address ?><br/>
                    Ph: <?= $custdet->ct_phone ?><br/>
                    GSTIN : <?= $custdet->ct_gstin ?>
                    <?php
                }else{
                ?>
               <h4 style="margin: 0px;"> <?php 
                echo $purchasedet->rb_customername;
                ?></h4>
                <?= $purchasedet->rb_address ?><br/>
                Ph: <?= $purchasedet->rb_phone ?><br/>
                GSTIN : <?= $purchasedet->rb_gstno ?>
                <?php 
                }
                ?>
            </td>
        </tr>
    </tbody>
    </table>

    <table width="100%" style="margin-top: 5px;">
        <tr>
            <td width="50%">Sale Person: <?= $purchasedet->rb_salesperson ?></td>
            <td>Vehicle No: <?= $purchasedet->rb_vehicleno ?></td>
        </tr>
    </table>
    
    </div>
</div>

<div class="page-footer">
    <div align="center" style="font-size: 12px; "><i>This is a computer generated invoice</i></div>
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
        <tr>
            <th class="wd-5p-f" rowspan="2">Sl No</th>
            <th rowspan="2" align="left">Item Name</th>
            <th rowspan="2">Unit Price</th>
            <th rowspan="2">Total Qty</th>
            <?php 
            if($purchasedet->rb_state == '4028' || $purchasedet->rb_state == '')
            {
            ?>
            <th colspan="2">CGST</th>
            <th colspan="2">SGST</th>
            <?php 
            }else{
            ?>
            <th colspan="2">IGST</th>
            <?php 
            }
            ?>
            <th rowspan="2">Discount</th>
            <th rowspan="2">Total Price</th>
        </tr>
        <tr>
            <?php 
            if($purchasedet->rb_state == '4028' || $purchasedet->rb_state == '')
            {
            ?>
            <th>%</th>
            <th>Amt</th>
            <th>%</th>
            <th>Amt</th>
            <?php 
            }else{
            ?>
            <th>%</th>
            <th>Amt</th>
            <?php 
            }
            ?>
        </tr>

    </thead>
    <?php
    $kn=1;
    if (!empty($purchaseprodcts)) {
        foreach ($purchaseprodcts as $prvl) {
            ?>
            <tr class="billitemstr">
                <td align="center"><?= $kn ?></td>

                <td><?php echo $prvl->pd_productname . ' ' . $prvl->pd_productcode; ?> 
                <?php 
                if($remarkfield == 1 && $prvl->rbs_remarks != "")
                {
                   echo '- ' . $prvl->rbs_remarks;
                }
                ?>
                </td>
                <td align="center"><?php echo $prvl->rbs_netamount ?></td>
                <td align="center"><?php echo $prvl->rbs_qty ?></td>
                <?php 
                if($purchasedet->rb_state == '4028' || $purchasedet->rb_state == '')
                {
                    $colspnno = '9';
                ?>
                <td align="center"><?php echo $prvl->rbs_gstpercent/2 ?></td>
                <td align="center"><?php echo $prvl->rbs_totalgst/2 ?></td>
                <td align="center"><?php echo $prvl->rbs_gstpercent/2 ?></td>
                <td align="center"><?php echo $prvl->rbs_totalgst/2 ?></td>
                <?php 
                }else{
                    $colspnno = '7';
                ?>
                <td align="center"><?php echo $prvl->rbs_gstpercent ?></td>
                <td align="center"><?php echo $prvl->rbs_totalgst ?></td>
                <?php 
                }
                ?>
                <td align="center"><?php echo $prvl->rbs_totaldiscount; ?></td>
                <td align="center"><?php echo $prvl->rbs_totalamount ?></td>
        </tr>
        <?php
        $kn++;
    }
}
$emptycell = 10-$kn;
for($n=0; $n<=$emptycell; $n++)
{
    ?>
    <tr>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <?php 
        if($purchasedet->rb_state == '4028' || $purchasedet->rb_state == '')
        {
            $colspnno = '9';
        ?>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <?php 
        }else{
            $colspnno = '7';
        ?>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
        <?php 
        }
        ?>
        <td class="emtycellstyle"></td>
        <td class="emtycellstyle"></td>
    </tr>
    <?php
}
?>
    <tr>
        <td colspan="<?= $colspnno ?>" align="right">Total</td>
        <th><?= $purchasedet->rb_totalamount ?></th>
    </tr>

    <tr>
        <td rowspan="5" colspan="4">
            Company's Bank Details<br/>
            Bank: <b><?= $businessdet->bu_bankname ?></b><br/>
            Acc No: <b><?= $businessdet->bu_accountnumber ?></b><br/>
            IFSC: <b><?= $businessdet->bu_ifsccode ?></b><br/>
            Branch: <b><?= $businessdet->bu_bankbranch ?></b>
        </td>
        <td colspan="<?= $colspnno-4 ?>" align="right">Discount</td>
        <th><?= $purchasedet->rb_discount ?></th>
    </tr>
    <tr>
        <td colspan="<?= $colspnno-4 ?>" align="right">Old Balance</td>
        <th><?= $purchasedet->rb_oldbalance ?></th>
    </tr>
    <tr>
        <td colspan="<?= $colspnno-4 ?>" align="right">Grand Total</td>
        <th><?= $purchasedet->rb_grandtotal ?></th>
    </tr>
    <tr>
        <td colspan="<?= $colspnno-4 ?>" align="right">Paid Amount</td>
        <th><?= $purchasedet->rb_paidamount ?></th>
    </tr>
    <tr>
        <td colspan="<?= $colspnno-4 ?>" align="right">Balance Amount</td>
        <th><?= $purchasedet->rb_balanceamount ?></th>
    </tr>
    <tr>
        <td colspan="10" align="right">Grand Total(in words): <b>Rs <?php echo convert_numbertowords($purchasedet->rb_grandtotal); ?> Only</b></td>
    </tr>
    <tr>
        <td colspan="10" align="left">Payment Method: <b><?php 
        switch($purchasedet->rb_paymentmethod)
        {
            case 4: 
                echo "Cash";
                break;
            case 3: 
                echo "Bank";
                break;
            case 3: 
                echo "UPI";
                break;
        }
        ?></b></td>
    </tr>
</table>

<table border="1" width="100%" style="border-collapse: collapse;" cellpadding="5" cellspacing="0">
    <tr>
        <td width="60%">
            <span style="text-decoration: underline;">Declaration</span><br/>
            We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.
        </td>
        <td align="right">
            for <b><?= $businessdet->bu_unitname ?></b>
            <br/>
            <?php 
                if($businessdet->bu_companyseal != "")
                {
                    ?>
                <img src="<?= base_url() ?>uploads/business/<?= $businessdet->bu_companyseal ?>" width="50px"  alt="user-image">
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