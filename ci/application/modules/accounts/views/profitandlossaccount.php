
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
                            <a href="<?= base_url() ?>accounts/profitandlossaccount/1"  target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-print"></i> Print</button>
                            </a>
                        </div>
                        <h4 class="page-title">Profit and Loss Account</h4>
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
                                        <th class="text-center borderright">Dr</th>
                                        <th class="text-center ">Cr</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <tr>
                                        <td class="borderright" width="50%">
                                            <table id="basic" class="table table-sm table-borderless w-100">
                                                <thead class="theadbgcolor">
                                                    <tr>
                                                        <th class="text-left">Particulars</th>
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
                                                        <th style="border-top: 1px #7c7878 solid;">Total</th>
                                                        <th style="text-align: right; border-top: 1px #7c7878 solid;"><?php echo show_currency_amount($netprofit);  ?></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table id="basic" class="table table-sm table-borderless w-100">
                                                <thead class="theadbgcolor">
                                                    <tr>
                                                        <th class="text-left">Particulars</th>
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
                                                        <th style="border-top: 1px #7c7878 solid;">Total</th>
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
                                                        <th>To Net Profit</th>
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
                                                        <th>To Net Loss</th>
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
                            

                            <div align="right">

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            
            
        </div> <!-- container -->

    </div> <!-- content -->
