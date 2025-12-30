
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<style type="text/css">

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
                            <a href="<?= base_url() ?>accounts/trialbalanceprint/<?= $fromdate ?>/<?= $todate ?>"  target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-print"></i> Print</button>
                            </a>
                        </div>
                        <h4 class="page-title">Trail Balance</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row col-md-12 mb-3">
                                <form action="<?= base_url() ?>accounts/trialbalance" method="post" name="filter">
                                    <div class="row mb-2">
                                            <div class="col-md-3">
                                                From Date: 
                                                <input type="date" name="fromdate" value="<?= $fromdate ?>" required="required" class="form-control" id="fromdate">
                                            </div>
                                            <div class="col-md-3">
                                                To Date: 
                                                <input type="date" name="todate" value="<?= $todate ?>" required="required" class="form-control" id="todate">
                                            </div>
                                            <div class="col-md-2">
                                                <br/>
                                                <button type="submit" name="filterbtn" value="1" class="btn btn-blue">Filter</button>
                                            </div>
                                    </div>
                                </form>
                            </div>

                            <table id="basic" class="table dt-responsive nowrap w-100">
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
                                        <th>Total</th>
                                        <th><?= show_currency_amount($totdebit) ?></th>
                                        <th><?= show_currency_amount($totcredit) ?></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th align="right">Difference</th>
                                        <th colspan="2">
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
                            

                            <div align="right">

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            
            
        </div> <!-- container -->

    </div> <!-- content -->


