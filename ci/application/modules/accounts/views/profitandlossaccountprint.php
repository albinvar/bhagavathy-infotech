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
                        <td>Profit and Loss Account<br/> <?= $this->finname ?>
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



<table id="basic" class="table table-dark table-sm w-100" style="margin-top: 15px;">
    <thead>
        <tr>
            <th class="text-center borderright">Dr</th>
            <th class="text-center ">Cr</th>
        </tr>
    </thead>

    <tbody>
        <tr valign="top">
            <td class="borderright">
                <table id="basic" class="table table-sm table-borderless w-100">
                    <thead class="theadbgcolor" style="background-color: #ccc4c4">
                        <tr>
                            <th style="text-align: left;">Particulars</th>
                            <th style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $netprofit = 0;
                        if($drledgers)
                        {
                            foreach($drledgers as $drvl)
                            {
                                $ldgrdebit = $this->ldgrentr->gettotalledgertotalby_type_finyear($drvl->al_ledgerid, 0, $this->finyearid, $this->buid);
                                $ldgrcredit = $this->ldgrentr->gettotalledgertotalby_type_finyear($drvl->al_ledgerid, 1, $this->finyearid, $this->buid);
                                ?>
                                <tr>
                                    <td>To <?= $drvl->al_ledger ?></td>
                                    <td style="text-align: right;">
                                        <?php 
                                            echo show_currency_amount($ldgrdebit-$ldgrcredit);
                                            $netprofit = $netprofit + ($ldgrdebit-$ldgrcredit);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <th style="border-top: 1px #7c7878 solid; text-align: left;">Total</th>
                            <th style="text-align: right; border-top: 1px #7c7878 solid;"><?php echo show_currency_amount($netprofit);  ?></th>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td width="50%">
                <table id="basic" class="table table-sm table-borderless w-100">
                    <thead class="theadbgcolor" style="background-color: #ccc4c4">
                        <tr>
                            <th style="text-align: left;">Particulars</th>
                            <th style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $netloss=0;
                        if($crledgers)
                        {
                            foreach($crledgers as $crvl)
                            {
                                $ldgrdebit = $this->ldgrentr->gettotalledgertotalby_type_finyear($crvl->al_ledgerid, 0, $this->finyearid, $this->buid);
                                $ldgrcredit = $this->ldgrentr->gettotalledgertotalby_type_finyear($crvl->al_ledgerid, 1, $this->finyearid, $this->buid);
                                ?>
                                <tr>
                                    <td>By <?= $crvl->al_ledger ?></td>
                                    <td style="text-align: right;">
                                        <?php 
                                        echo show_currency_amount($ldgrcredit-$ldgrdebit); 
                                        $netloss = $netloss + ($ldgrcredit-$ldgrdebit);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <th style="border-top: 1px #7c7878 solid; text-align: left;">Total</th>
                            <th style="text-align: right; border-top: 1px #7c7878 solid;"><?php echo show_currency_amount($netloss);  ?></th>
                        </tr>
                    </tbody>
                </table>
            </td>
            
        </tr>
        <tr>
            <td class="borderright">
                <table id="basic" class="table table-sm w-100">
                    <tr>
                        <tr>
                            <th style="text-align: left;">To Net Profit</th>
                            <th style="text-align: right;"><?php 
                            if($netprofit > $netloss)
                            {
                                $profit = $netprofit - $netloss;
                            }else{
                                $profit = 0;
                            }
                            echo show_currency_amount($profit);  
                            ?></th>
                        </tr>
                    </tr>
                </table>
            </td>
            <td>
                <table id="basic" class="table table-sm w-100">
                    <tr>
                        <tr>
                            <th style="text-align: left;">To Net Loss</th>
                            <th style="text-align: right;"><?php 
                            if($netprofit < $netloss)
                            {
                                $loss = $netloss - $netprofit;
                            }else{
                                $loss = 0;
                            }
                            echo show_currency_amount($loss);    
                            ?></th>
                        </tr>
                    </tr>
                </table>
            </td>
        </tr>
        
    </tbody>
    <tfoot>
        
        
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