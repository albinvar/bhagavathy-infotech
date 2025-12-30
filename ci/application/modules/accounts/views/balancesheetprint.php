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
                        <td>Balance Sheet<br/> <?= $this->finname ?>
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
            <th class="text-center borderright">LIABILITIES</th>
            <th class="text-center ">ASSETS</th>
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
                        $netliability=0;
                        if($branchledgers)
                        {
                            $brchtotal=0;
                            ?>
                            <tr>
                                <td><b>Branch/ Division</b></td>
                                <td></td>
                            </tr>
                            <?php
                            foreach($branchledgers as $crvl)
                            {
                                $ldgrdebit = $this->ldgrentr->gettotalledgertotalby_type_finyear($crvl->al_ledgerid, 0, $this->finyearid, $this->buid);
                                $ldgrcredit = $this->ldgrentr->gettotalledgertotalby_type_finyear($crvl->al_ledgerid, 1, $this->finyearid, $this->buid);
                                ?>
                                <tr>
                                    <td><?= $crvl->al_ledger ?></td>
                                    <td style="text-align: right;">
                                        <?php 
                                        echo show_currency_amount($ldgrcredit-$ldgrdebit); 
                                        $netliability = $netliability + ($ldgrcredit-$ldgrdebit);
                                        $brchtotal = $brchtotal + ($ldgrcredit-$ldgrdebit);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td style="border-top: 1px #7c7878 solid;"><b>Total Branch/ Division</b></td>
                                <td style="text-align: right; border-top: 1px #7c7878 solid;"><?php echo show_currency_amount($brchtotal); ?></td>
                            </tr>
                            <?php
                        }
                        if($capitalledgers)
                        {
                            $capitaltotal=0;
                            ?>
                            <tr>
                                <td><b>Capital Account</b></td>
                                <td></td>
                            </tr>
                            <?php
                            foreach($capitalledgers as $crvl)
                            {
                                $ldgrdebit = $this->ldgrentr->gettotalledgertotalby_type_finyear($crvl->al_ledgerid, 0, $this->finyearid, $this->buid);
                                $ldgrcredit = $this->ldgrentr->gettotalledgertotalby_type_finyear($crvl->al_ledgerid, 1, $this->finyearid, $this->buid);
                                ?>
                                <tr>
                                    <td><?= $crvl->al_ledger ?></td>
                                    <td style="text-align: right;">
                                        <?php 
                                        echo show_currency_amount($ldgrcredit-$ldgrdebit); 
                                        $netliability = $netliability + ($ldgrcredit-$ldgrdebit);
                                        $capitaltotal = $capitaltotal + ($ldgrcredit-$ldgrdebit);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td style="border-top: 1px #7c7878 solid;"><b>Total Capital Account</b></td>
                                <td style="text-align: right; border-top: 1px #7c7878 solid;"><?php echo show_currency_amount($capitaltotal); ?></td>
                            </tr>
                            <?php
                        }
                        if($currntliabiltyledgers)
                        {
                            $curntliabltytotal = 0;
                            ?>
                            <tr>
                                <td><b>Current Liabilities</b></td>
                                <td></td>
                            </tr>
                            <?php
                            foreach($currntliabiltyledgers as $crvl)
                            {
                                $ldgrdebit = $this->ldgrentr->gettotalledgertotalby_type_finyear($crvl->al_ledgerid, 0, $this->finyearid, $this->buid);
                                $ldgrcredit = $this->ldgrentr->gettotalledgertotalby_type_finyear($crvl->al_ledgerid, 1, $this->finyearid, $this->buid);
                                ?>
                                <tr>
                                    <td><?= $crvl->al_ledger ?></td>
                                    <td style="text-align: right;">
                                        <?php 
                                        echo show_currency_amount($ldgrcredit-$ldgrdebit); 
                                        $netliability = $netliability + ($ldgrcredit-$ldgrdebit);
                                        $curntliabltytotal = $curntliabltytotal + ($ldgrcredit-$ldgrdebit);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td style="border-top: 1px #7c7878 solid;"><b>Total Current Liabilities</b></td>
                                <td style="text-align: right; border-top: 1px #7c7878 solid;"><?php echo show_currency_amount($curntliabltytotal); ?></td>
                            </tr>
                            <?php
                        }
                        if($loansledgers)
                        {
                            $loantotal = 0;
                            ?>
                            <tr>
                                <td><b>Loans (Liability)</b></td>
                                <td></td>
                            </tr>
                            <?php
                            foreach($loansledgers as $crvl)
                            {
                                $ldgrdebit = $this->ldgrentr->gettotalledgertotalby_type_finyear($crvl->al_ledgerid, 0, $this->finyearid, $this->buid);
                                $ldgrcredit = $this->ldgrentr->gettotalledgertotalby_type_finyear($crvl->al_ledgerid, 1, $this->finyearid, $this->buid);
                                ?>
                                <tr>
                                    <td><?= $crvl->al_ledger ?></td>
                                    <td style="text-align: right;">
                                        <?php 
                                        echo show_currency_amount($ldgrcredit-$ldgrdebit); 
                                        $netliability = $netliability + ($ldgrcredit-$ldgrdebit);
                                        $loantotal = $loantotal + ($ldgrcredit-$ldgrdebit);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td style="border-top: 1px #7c7878 solid;"><b>Total Loans (Liability)</b></td>
                                <td style="text-align: right; border-top: 1px #7c7878 solid;"><?php echo show_currency_amount($loantotal); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        
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
                        $netasset = 0;
                        if($currntassetledgers)
                        {
                            $currtotal=0;
                            ?>
                            <tr>
                                <td><b>Current Assets</b></td>
                                <td></td>
                            </tr>
                            <?php
                            foreach($currntassetledgers as $drvl)
                            {
                                $ldgrdebit = $this->ldgrentr->gettotalledgertotalby_type_finyear($drvl->al_ledgerid, 0, $this->finyearid, $this->buid);
                                $ldgrcredit = $this->ldgrentr->gettotalledgertotalby_type_finyear($drvl->al_ledgerid, 1, $this->finyearid, $this->buid);
                                ?>
                                <tr>
                                    <td><?= $drvl->al_ledger ?></td>
                                    <td style="text-align: right;">
                                        <?php 
                                            echo show_currency_amount($ldgrdebit-$ldgrcredit);
                                            $netasset = $netasset + ($ldgrdebit-$ldgrcredit);
                                            $currtotal = $currtotal + ($ldgrdebit-$ldgrcredit);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td style="border-top: 1px #7c7878 solid;"><b>Total Current Assets</b></td>
                                <td style="text-align: right; border-top: 1px #7c7878 solid;"><?php echo show_currency_amount($currtotal); ?></td>
                            </tr>
                            <?php
                        }

                        if($fixedasstledgers)
                        {
                            $fixtotal=0;
                            ?>
                            <tr>
                                <td><b>Fixed Assets</b></td>
                                <td></td>
                            </tr>
                            <?php
                            foreach($fixedasstledgers as $drvl)
                            {
                                $ldgrdebit = $this->ldgrentr->gettotalledgertotalby_type_finyear($drvl->al_ledgerid, 0, $this->finyearid, $this->buid);
                                $ldgrcredit = $this->ldgrentr->gettotalledgertotalby_type_finyear($drvl->al_ledgerid, 1, $this->finyearid, $this->buid);
                                ?>
                                <tr>
                                    <td><?= $drvl->al_ledger ?></td>
                                    <td style="text-align: right;">
                                        <?php 
                                            echo show_currency_amount($ldgrdebit-$ldgrcredit);
                                            $netasset = $netasset + ($ldgrdebit-$ldgrcredit);
                                            $fixtotal = $fixtotal + ($ldgrdebit-$ldgrcredit);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td style="border-top: 1px #7c7878 solid;"><b>Total Fixed Assets</b></td>
                                <td style="text-align: right; border-top: 1px #7c7878 solid;"><?php echo show_currency_amount($fixtotal); ?></td>
                            </tr>
                            <?php
                        }

                        if($investmntledgers)
                        {
                            $invsttotal = 0;
                            ?>
                            <tr>
                                <td><b>Investments</b></td>
                                <td></td>
                            </tr>
                            <?php
                            foreach($investmntledgers as $drvl)
                            {
                                $ldgrdebit = $this->ldgrentr->gettotalledgertotalby_type_finyear($drvl->al_ledgerid, 0, $this->finyearid, $this->buid);
                                $ldgrcredit = $this->ldgrentr->gettotalledgertotalby_type_finyear($drvl->al_ledgerid, 1, $this->finyearid, $this->buid);
                                ?>
                                <tr>
                                    <td><?= $drvl->al_ledger ?></td>
                                    <td style="text-align: right;">
                                        <?php 
                                            echo show_currency_amount($ldgrdebit-$ldgrcredit);
                                            $netasset = $netasset + ($ldgrdebit-$ldgrcredit);
                                            $invsttotal = $invsttotal + ($ldgrdebit-$ldgrcredit);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td style="border-top: 1px #7c7878 solid;"><b>Total Investments</b></td>
                                <td style="text-align: right; border-top: 1px #7c7878 solid;"><?php echo show_currency_amount($invsttotal); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        
                    </tbody>
                </table>
            </td>
            
        </tr>
        <tr>
            <td class="borderright">
                <table id="basic" class="table table-sm w-100">
                    <tr>
                        <tr>
                            <th style="text-align: left;">TOTAL LIABILITIES</th>
                            <th style="text-align: right;"><?php echo show_currency_amount($netliability);  ?></th>
                        </tr>
                    </tr>
                </table>
            </td>
            <td>
                <table id="basic" class="table table-sm w-100">
                    <tr>
                        <tr>
                            <th style="text-align: left;">TOTAL ASSETS</th>
                            <th style="text-align: right;"><?php echo show_currency_amount($netasset);  ?></th>
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