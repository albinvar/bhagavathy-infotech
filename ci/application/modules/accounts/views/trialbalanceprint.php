<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="icon" href="<?= assets_url() ?>assets/img/favicon.png" type="image/x-icon"/>
 <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>components/css/reportstyle.css">
 <style type="text/css">

  .page-footer-space {
    height: 40px;
    padding: 0px;

    margin-bottom: 0px;
  }
  .page-footer {
    height: 40px;
    position: fixed;
    bottom: 0;
    width: 96%;
    padding-top: 10px;
    margin-bottom: 0px;
    border-top: 1px #808080 solid;
    /*background: yellow; /* for demo */
  }

  @media print {
  .table-blue-fotter {
    
    
  }
}

  .page-header {
    height: 110px;
    width: 97%;
    margin-left: 5px;
    margin-top: 5px;

  }
  .page-header-space{
    height: 110px;
  }
  .billitemstr{
    font-size: 12px;
    min-height: 250px;
  }


  @page {
    margin: 0px;
    padding: 0px;
  }

  @page
   {
    size: A4;
  }
  </style>

</head>

<body style="-webkit-print-color-adjust: exact;">



<div class="page-header">
    <div style="width: 97%">
    <table border="0" width="98%" cellpadding="0" cellspacing="0">
        

        <tr>
            <td width="50%">
                <?php 
                if($this->bulogo != "")
                {
                    ?>
                <img src="<?= base_url() ?>uploads/business/<?= $this->bulogo ?>" height="95px" alt="user-image">
                <?php 
                }
                ?>
            </td>
            
            <td width="50%" align="right" style="font-size: font-size: 13px;">
                <table width="100%">
                    <tr valign="top">
                        <td>
                            <b><?= $businessdet->bu_unitname ?></b><br/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td>Trail Balance<br/>
                            (<?= date('d-m-Y', strtotime($fromdate)) ?> - <?= date('d-m-Y', strtotime($todate)) ?>)
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
    </table>

    
    </div>
</div>

<div class="page-footer">
    <div align="center" style="font-size: 12px; ">
        <i><?= $businessdet->bu_address ?>, 
       GSTIN: <b><?= $businessdet->bu_gstnumber ?></b></i></div>
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

          <div class="page">




<table border="1" width="100%" style="border-collapse: collapse; font-size: 13px;" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>#</th>
            <th>Ledger Name</th>
            <th>Debit</th>
            <th>Credit</th>
        </tr>
    </thead>

    <tbody>
        <?php 
        $totcredit = 0;
        $totdebit = 0;

        if($ledgers)
        {
            $k=1;
            
            foreach($ledgers as $bvl)
            {
                $ldgrdebit = $this->ldgrentr->gettotalledgertotalby_type_date($bvl->al_ledgerid, 0, $fromdate, $todate, $this->buid);
                $ldgrcredit = $this->ldgrentr->gettotalledgertotalby_type_date($bvl->al_ledgerid, 1, $fromdate, $todate, $this->buid);
                ?>
                <tr>
                    <td><?= $k ?></td>
                    <td><?= $bvl->al_ledger ?></td>
                    <td><?php
                    $totdebit = $totdebit + $ldgrdebit;
                    echo show_currency_amount($ldgrdebit);
                     ?></td>
                    <td><?php 
                    $totcredit = $totcredit + $ldgrcredit;
                    echo show_currency_amount($ldgrcredit);
                     ?></td>
                    
                </tr>
                <?php
                $k++;
            }
        }
        ?>
        

    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th align="right">Total</th>
            <th style="text-align: left;"><?= show_currency_amount($totdebit) ?></th>
            <th style="text-align: left;"><?= show_currency_amount($totcredit) ?></th>
        </tr>
        <tr>
            <th></th>
            <th align="right">Difference</th>
            <th colspan="2" style="text-align: left;">
                <?php
                $difference = $totdebit - $totcredit;
                if($difference <0)
                {
                    echo "<span class='text-danger'>" . show_currency_amount($difference) . "</spna>";
                }else{
                    echo "<span class='text-success'>" . show_currency_amount(abs($difference)) . "</spna>";
                }
                ?>
            </th>
        </tr>
    </tfoot>
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