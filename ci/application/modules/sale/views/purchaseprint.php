<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="icon" href="<?= assets_url() ?>assets/img/favicon.png" type="image/x-icon"/>
 <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>components/css/reportstyle.css">
 <style type="text/css">

   .page-footer, .page-footer-space {
    height: 0px;
  }
  .page-footer {
    position: fixed;
    bottom: 0;
    width: 97%;
    /*background: yellow; /* for demo */
  }

  .page-header {
    height: 190px;
    width: 98%;
    margin-left: 5px;
  }
  .page-header-space{
    height: 190px;
  }
 </style>
</head>

<body style="-webkit-print-color-adjust: exact;">

<?php 
if($newprint == 1)
{
?>
<a href="<?= base_url() ?>purchase/purchasehistory"><button class="printButtonClass">Back</button></a>
<?php 
}
?>

<div class="page-header">
    <div style="width: 97%">
    <table border="0" width="98%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center"><u>Purchase Bill</u></td>
        </tr>
    </table>

    <table border="0" width="98%" cellpadding="0" cellspacing="0">
        <tr>
            <td>Bill No: <?= $purchasedet->pm_purchaseno ?></td>
            <td align="right">DATE: <?php echo date('d/m/Y', strtotime($purchasedet->pm_date)) ?> <?php echo date('H:i', strtotime($purchasedet->pm_time)) ?></td>
        </tr>
    </table>
    <table border="1" width="98%" style="border-collapse: collapse; margin-top: 5px;" cellpadding="5" cellspacing="0">
      <tbody>
        <tr valign="top">
            <td width="50%" align="left" valign="top">
                <h4 style="margin: 0px;"><?= $businessdet[0]->bu_unitname ?> </h4>
                <?= $businessdet[0]->bu_address ?><br/>
                Ph: <?= $businessdet[0]->bu_phone ?><br/>
                Email: <?= $businessdet[0]->bu_email ?>
            </td>
            <td>
               <h4 style="margin: 0px;"> <?php 
                echo $purchasedet->sp_name;
                ?></h4>
                <?= $purchasedet->sp_contactperson ?><br/>
                <?= $purchasedet->sp_address ?><br/>
                Ph: <?= $purchasedet->sp_mobile ?><br/>
                Email: <?= $purchasedet->sp_email ?> <br/>
                GSTIN : <?= $purchasedet->sp_gstno ?>
            </td>
        </tr>
    </tbody>
    </table>

    <table width="100%" style="margin-top: 5px;">
        <tr>
            <td width="50%">Invoice No: <?= $purchasedet->pm_invoiceno ?></td>
            <td>Vehicle No: <?= $purchasedet->pm_vehicleno ?></td>
        </tr>
    </table>
    
    </div>
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
            if($purchasedet->sp_state == '4028')
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
            if($purchasedet->sp_state == '4028')
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
            <tr>
                <td align="center"><?= $kn ?></td>

                <td><?php echo $prvl->pd_productname . ' ' . $prvl->pd_productcode; ?></td>
                <td align="center"><?php echo $prvl->ps_purchaseprice ?></td>
                <td align="center"><?php echo $prvl->ps_qty ?></td>
                <?php 
                if($purchasedet->sp_state == '4028')
                {
                    $colspnno = '9';
                ?>
                <td align="center"><?php echo $prvl->ps_gstpercent/2 ?></td>
                <td align="center"><?php echo $prvl->ps_totalgst/2 ?></td>
                <td align="center"><?php echo $prvl->ps_gstpercent/2 ?></td>
                <td align="center"><?php echo $prvl->ps_totalgst/2 ?></td>
                <?php 
                }else{
                    $colspnno = '7';
                ?>
                <td align="center"><?php echo $prvl->ps_gstpercent ?></td>
                <td align="center"><?php echo $prvl->ps_totalgst ?></td>
                <?php 
                }
                ?>
                <td align="center"><?php echo $prvl->ps_discountamnt * $prvl->ps_qty; ?></td>
                <td align="center"><?php echo $prvl->ps_totalamount ?></td>
        </tr>
        <?php
        $kn++;
    }
}
?>
    <tr>
        <td colspan="<?= $colspnno ?>" align="right">Total</td>
        <th><?= $purchasedet->pm_totalamount ?></th>
    </tr>
    <tr>
        <td colspan="<?= $colspnno ?>" align="right">Discount</td>
        <th><?= $purchasedet->pm_discount ?></th>
    </tr>
    <tr>
        <td colspan="<?= $colspnno ?>" align="right">Old Balance</td>
        <th><?= $purchasedet->pm_oldbalance ?></th>
    </tr>
    <tr>
        <td colspan="<?= $colspnno ?>" align="right">Grand Total</td>
        <th><?= $purchasedet->pm_grandtotal ?></th>
    </tr>
    <tr>
        <td colspan="<?= $colspnno ?>" align="right">Paid Amount</td>
        <th><?= $purchasedet->pm_paidamount ?></th>
    </tr>
    <tr>
        <td colspan="<?= $colspnno ?>" align="right">Balance Amount</td>
        <th><?= $purchasedet->pm_balanceamount ?></th>
    </tr>
    <tr>
        <td colspan="10" align="right">Grand Total(in words): <b>Rs <?php echo convert_numbertowords($purchasedet->pm_grandtotal); ?> Only</b></td>
    </tr>
    <tr>
        <td colspan="10" align="left">Purchase Note: <b><?= $purchasedet->pm_purchasenote ?></b></td>
    </tr>
</table>

</div>
</td>
</tr>
</tbody>

<script>
 window.print();
</script>
</body>

</html>