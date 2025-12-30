
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<style type="text/css">
.theadbgcolor{
    background-color: #5d5e62;
    color: #FFF;
}
.borderright{
    border-right: 1px #7c7878 solid;
}
</style>

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            
                            <!--<a href="<?= base_url() ?>accounts/accountledger/<?= $ledgerdet->al_buid ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="far fa-arrow-alt-circle-left"></i> Back</button>
                            </a>-->
                            <a href="<?= base_url() ?>accounts/balancesheet/1"  target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-print"></i> Print</button>
                            </a>
                        </div>
                        <h4 class="page-title">Balance Sheet</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                           <!-- <h4 class="formmainheading mt-0">Profit and Loss Account</h4>-->


                            

                            <table id="basic" class="table table-dark table-sm w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center borderright">LIABILITIES</th>
                                        <th class="text-center ">ASSETS</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <tr>
                                        <td class="borderright">
                                            <table id="basic" class="table table-sm table-borderless w-100">
                                                <thead class="theadbgcolor">
                                                    <tr>
                                                        <th class="text-left">Particulars</th>
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
                                                <thead class="theadbgcolor">
                                                    <tr>
                                                        <th class="text-left">Particulars</th>
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
                                                        <th>TOTAL LIABILITIES</th>
                                                        <th style="text-align: right;"><?php echo show_currency_amount($netliability);  ?></th>
                                                    </tr>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table id="basic" class="table table-sm w-100">
                                                <tr>
                                                    <tr>
                                                        <th>TOTAL ASSETS</th>
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
                            

                            <div align="right">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            
        </div> <!-- container -->

    </div> <!-- content -->