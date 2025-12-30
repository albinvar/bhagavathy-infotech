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
<a href="<?= base_url() ?>purchase/purchaseorderhistory"><button class="printButtonClass">Back</button></a>
<?php 
}
?>

<div class="page-header">
    <div style="width: 97%">
    <table border="0" width="98%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center"><u>Purchase Order</u></td>
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
                <b><?= $purchasedet->sp_contactperson ?></b>, 
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
            <td>Invoice No: <?= $purchasedet->pm_invoiceno ?></td>
            <td>Vehicle No: <?= $purchasedet->pm_vehicleno ?></td>

            <td>Expected Delivery: <?= date('d-M-Y', strtotime($purchasedet->pm_expecteddelivery)) ?></td>
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
            <th class="wd-5p-f">Sl No</th>
            <th align="left">Item Name</th>
            <th>Qty</th>
            
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
                <td align="center"><?php echo $prvl->ps_qty ?></td>
                
        </tr>
        <?php
        $kn++;
    }
}
?>
    
    <tr>
        <td colspan="10" align="left">Purchase Note: <b><?= $purchasedet->pm_purchasenote ?></b></td>
    </tr>
</table>
<br/>
<table width="100%">
    <tr>
        <td width="50%"><b>Recived in good condition: </b>
            <br/><br/>

        </td>
        <td>For And On Behalf Of 
            <br/><br/>
        </td>
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