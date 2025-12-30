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
            <td align="center"><u><?= $title ?></u></td>
        </tr>
    </table>

    <table border="0" width="98%" cellpadding="0" cellspacing="0">
        <tr>
            <td>Bill No: <?= $purchasedet->rb_billno ?></td>
            <td align="right">DATE: <?php echo date('d/m/Y', strtotime($purchasedet->rb_date)) ?> <?php echo date('H:i', strtotime($purchasedet->rb_time)) ?></td>
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
            <th>Unit Price</th>
            <th>Total Qty</th>
            
            <th rowspan="2">Total Price</th>
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
                <td align="center"><?php echo $prvl->rbs_unitprice ?></td>
                <td align="center"><?php echo $prvl->rbs_qty ?></td>
                
                <td align="center"><?php echo $prvl->rbs_totalamount ?></td>
        </tr>
        <?php
        $kn++;
    }
}
?>
    <tr>
        <td colspan="4" align="right">Total</td>
        <th><?= $purchasedet->rb_totalamount ?></th>
    </tr>
    
    <tr>
        <td colspan="10" align="right">Grand Total(in words): <b>Rs <?php echo convert_numbertowords($purchasedet->rb_totalamount); ?> Only</b></td>
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