
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
                            <a href="<?= base_url() ?>accounts/daybookprint/<?= $ledgerid ?>/<?= $fromdate ?>/<?= $todate ?>"  target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-print"></i> Print</button>
                            </a>
                        </div>
                        <h4 class="page-title">Day Book</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row col-md-12 mb-3">
                                <form action="<?= base_url() ?>accounts/daybook" method="post" name="filter">
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                                Select Particular: 
                                                <select class="form-control" name="ledgerid" id="ledgerid">
                                                    <option <?php if($ledgerid == 0){ echo "selected"; } ?> value="0">All</option>
                                                    <?php 
                                                    if($ledgers)
                                                    {
                                                        foreach($ledgers as $ldgvl)
                                                        {
                                                            ?>
                                                            <option <?php if($ledgerid == $ldgvl->al_ledgerid){ echo "selected"; } ?> value="<?= $ldgvl->al_ledgerid ?>"><?= $ldgvl->al_ledger ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
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
                                        <th>Date</th>
                                        <th>Particulars</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    $totcredit = 0;
                                    $totdebit = 0;

                                    if($ledgerentries)
                                    {
                                        $k=1;
                                        
                                        foreach($ledgerentries as $bvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= date('d-M-Y H:i', strtotime($bvl->le_date)) ?></td>
                                                <td><?php
                                                echo $bvl->al_ledger;
                                                 ?></td>
                                                <td><?php 
                                                if($bvl->le_isdebit == 0)
                                                {
                                                    echo show_currency_amount($bvl->le_amount);
                                                    $totdebit = $totdebit + $bvl->le_amount;
                                                }
                                                ?></td>
                                                <td><?php 
                                                if($bvl->le_isdebit == 1)
                                                {
                                                    echo show_currency_amount($bvl->le_amount);
                                                    $totcredit = $totcredit + $bvl->le_amount;
                                                }
                                                ?></td>
                                                
                                            </tr>
                                            <?php
                                            $k++;
                                        }
                                    }else{
                                        ?>
                                        <tr>
                                            <td colspan="6">No Entries...</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>Total</th>
                                        <th><?= show_currency_amount($totdebit) ?></th>
                                        <th><?= show_currency_amount($totcredit) ?></th>
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
