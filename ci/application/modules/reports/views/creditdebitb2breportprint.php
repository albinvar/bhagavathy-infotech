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
                        <td>Credit Note and Debit Note Report -B2B<br/>
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

          <div class="page" style="border-top: 1px #808080 solid;">

<?php 
$totalgstamt =0;
$totaltaxableamnt = 0;
$totalamount = 0;
$invoices = array();
$invoicewithdate = array();
if($salelist)
{
    foreach($salelist as $prvl)
    {
        if($prvl->rbs_gstpercent != 0)
        {
        if(!in_array($prvl->rb_retailbillid, $invoices))
        {
            $invoices[] = $prvl->rb_retailbillid;
            ${"taxvalues".$prvl->rb_retailbillid} = array();

            $invoicewithdate[] = array('invoiceid' => $prvl->rb_retailbillid, 'date' => $prvl->rb_date);
        }

        if($prvl->rb_customerid == 0)
        {
            $customr = $prvl->rb_customername;
            $custmrgst = $prvl->rb_gstno;
        }else{
            $customr = $prvl->ct_name;
            $custmrgst = $prvl->ct_gstin;
        }
        //$billno = $prvl->rb_billprefix . $prvl->rb_billno;
        $billno = $prvl->rb_billno;
        $totaltaxableamnt = $totaltaxableamnt + $prvl->rbs_nettotal;
        $totalgstamt = $totalgstamt + $prvl->rbs_totalgst;
        $totalamount = $totalamount + $prvl->rbs_totalamount;
        $statecode = $prvl->name . "-".$prvl->statecode;

        if(!in_array($prvl->rbs_gstpercent, ${"taxvalues".$prvl->rb_retailbillid}))
        {
            ${"taxvalues".$prvl->rb_retailbillid}[] = $prvl->rbs_gstpercent;

            ${"taxableamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_nettotal;
            ${"totalamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_totalamount;
            ${"totalgst".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_totalgst;
            ${"cessamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_totalcess;

        }else{
            ${"taxableamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_nettotal + ${"taxableamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent};
            ${"totalamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_totalamount + ${"totalamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent};

            ${"totalgst".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_totalgst + ${"totalgst".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent};

            ${"cessamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_totalcess + ${"cessamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent};
        }

        ${"notetype".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = 'Debit';
        ${"statecode".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $statecode;
        ${"customername".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $customr;
        ${"customergst".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $custmrgst;
        ${"billno".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $billno;
        ${"billdate".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rb_date;
        }
    }
}

if($purchaselist)
{
    foreach($purchaselist as $purvl)
    {
        if($purvl->ps_gstpercent != 0)
        {
        if(!in_array('p'.$purvl->pm_purchaseid, $invoices))
        {
            $invoices[] = 'p'.$purvl->pm_purchaseid;
            ${"taxvaluesp".$purvl->pm_purchaseid} = array();

            $invoicewithdate[] = array('invoiceid' => 'p'.$purvl->pm_purchaseid, 'date' => $purvl->pm_date);
        }

        
        //$billno = $prvl->rb_billprefix . $prvl->rb_billno;
        $billno = $purvl->pm_purchaseno;
        $totaltaxableamnt = $totaltaxableamnt + $purvl->ps_netamount;
        $totalgstamt = $totalgstamt + $purvl->ps_totalgst;
        $totalamount = $totalamount + $purvl->ps_totalamount;
        $statecode = $purvl->name . "-".$purvl->statecode;

        if(!in_array($purvl->ps_gstpercent, ${"taxvaluesp".$purvl->pm_purchaseid}))
        {
            ${"taxvaluesp".$purvl->pm_purchaseid}[] = $purvl->ps_gstpercent;

            ${"taxableamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->ps_netamount;
            ${"totalamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->ps_totalamount;
            ${"totalgstp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->ps_totalgst;
            ${"cessamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = 0;

        }else{
            ${"taxableamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->ps_netamount + ${"taxableamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent};
            ${"totalamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->ps_totalamount + ${"totalamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent};

            ${"totalgstp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->ps_totalgst + ${"totalgstp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent};

            ${"cessamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = 0 + ${"cessamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent};
        }

        ${"notetypep".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = 'Credit';
        ${"statecodep".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $statecode;
        ${"customernamep".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->sp_name;
        ${"customergstp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->sp_gstno;
        ${"billnop".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $billno;
        ${"billdatep".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->pm_date;
        }
    }
}


?>

<div align="right" style="padding: 10px; font-size: 15px; font-weight: bold;">
    <table width="100%">
        <tr>
            <td>Total Taxable Value: <?= price_roundof($totaltaxableamnt) ?></td>
            <td>Total Tax: <?= price_roundof($totalgstamt) ?></td>
            <td>Total Amount: <?= price_roundof($totalamount) ?></td>
        </tr>
    </table>
</div>

<table border="1" width="100%" style="border-collapse: collapse; font-size: 13px;" cellpadding="5" cellspacing="0">
    <thead>
    <tr>
        <th width="20px">#</th>
        <th>GSTIN</th>
        <th>Name of Recipient</th>
        <th>Note Number</th>
        <th>Note Date</th>
        <th>Note Type</th>
        <th>Place of Supply</th>
        <th>Note value</th>
        <th>Tax Percentage</th>
        <th>Taxable Value</th>
        <th>Cess Amt</th>
    </tr>
</thead>

<tbody>
    <?php 
    
    if($invoicewithdate)
    {
        usort($invoicewithdate, function($a, $b) { 
          return strtotime($a['date']) - strtotime($b['date']); 
        });
        $k=1;
        foreach($invoicewithdate as $indatevl)
        {
            $invl = $indatevl['invoiceid'];
            if(${"taxvalues".$invl})
            {
                foreach(${"taxvalues".$invl} as $taxvl)
                {
                    ?>
                    <tr>
                        <td><?= $k ?></td>
                        <td><?= ${"customergst".$invl."-" . $taxvl} ?></td>
                        <td><?= ${"customername".$invl."-" . $taxvl} ?></td>
                        <td><?= ${"billno".$invl."-" . $taxvl} ?></td>
                        <td><?= date('d-m-Y', strtotime(${"billdate".$invl."-" . $taxvl})) ?></td>
                        
                        
                        <td><?= ${"notetype".$invl."-" . $taxvl} ?></td>
                        <td><?= ${"statecode".$invl."-" . $taxvl} ?></td>
                        <td><?= price_roundof(${"totalamnt".$invl."-" . $taxvl}) ?></td>
                        <td><?= $taxvl ?></td>
                        <td><?= price_roundof(${"taxableamnt".$invl."-" . $taxvl}) ?></td>
                        <!--<td><?= price_roundof(${"totalgst".$invl."-" . $taxvl}) ?></td>-->
                        <td><?= price_roundof(${"cessamnt".$invl."-" . $taxvl}) ?></td>
                        
                    </tr>
                    <?php
                    $k++;
                }
            }
            
        }
    }
    ?>
    
</tbody>
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