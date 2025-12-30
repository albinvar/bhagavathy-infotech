
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
                            
                            

                            <a href="<?= base_url() ?>accounts/accountledger/<?= $ledgerdet->al_buid ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="far fa-arrow-alt-circle-left"></i> Back</button>
                            </a>
                        </div>
                        <h4 class="page-title">Ledger Entries</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row mb-2">
                                
                                <div class="col-md-2">
                                    From Date:
                                    <input type="date" class="form-control" name="fromdate" id="fromdate" value="<?= $fromdate ?>">
                                </div>
                                <div class="col-md-2">
                                    To Date:
                                    <input type="date" class="form-control" name="todate" id="todate" value="<?= $todate ?>">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" onclick="filterstockfun()" class="btn btn-blue" style="margin-top: 20px;">Filter</button>
                                </div>

                                <div class="col-md-6" style="text-align: right;">
                                    <a href="<?= base_url() ?>accounts/ledgerentries/<?= $ledgerid ?>/<?= $fromdate ?>/<?= $todate ?>/1" target="_blank" class="ms-1">
                                        <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-print"></i> Print</button>
                                    </a>  
                                </div>
                            </div>

                            <script type="text/javascript">
                                function filterstockfun()
                                {
                                    var fromdate = $('#fromdate').val();
                                    var todate = $('#todate').val();
                                    window.location.href= '<?= base_url() ?>accounts/ledgerentries/<?= $ledgerid ?>/'+fromdate+'/'+todate;
                                }
                            </script>


                            <div class="row col-md-12 mb-3">
                                <div class="col-md-6">
                                    Ledger Name: <b><?= $ledgerdet->al_ledger ?></b>
                                </div>
                                <div class="col-md-6" align="right">
                                    Opening Balance of <?= date('d-M-Y', strtotime($fromdate)) ?>: <b><?php echo show_currency_amount($openingbalance); ?></b>
                                </div>
                            </div>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Dr/Cr</th>
                                        <th>Particular</th>
                                        <th>Dr/Cr</th>
                                        <th>Particular</th>
                                        <th>Amount</th>
                                        <th>Added By</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    $totcredit = 0;
                                        $totdebit = 0;
                                        $closingbalance = 0;
                                    if($ledgerentrie)
                                    {
                                        $k=1;
                                        
                                        foreach($ledgerentrie as $bvl)
                                        {

                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= date('d-M-Y H:i', strtotime($bvl->firstdate)) ?></td>
                                                <td>
                                                    <?php 
                                                    if($bvl->firstdebit == 1)
                                                    {
                                                        $closingbalance = $closingbalance - $bvl->firstamount;
                                                        $totcredit = $totcredit + $bvl->firstamount;
                                                        ?>
                                                        <span class="badge bg-danger">Cr</span>
                                                        <?php
                                                    }else{
                                                        $closingbalance = $closingbalance + $bvl->firstamount;
                                                        $totdebit = $totdebit + $bvl->firstamount;
                                                        ?>
                                                        <span class="badge bg-success">Dr</span>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?= $ledgerdet->al_ledger ?>
                                                </td>

                                                <td>
                                                    <?php 
                                                    if($bvl->journalid != 0)
                                                    {
                                                    if($bvl->seconddebit == 1)
                                                    {
                                                        /*$closingbalance = $closingbalance - $bvl->firstamount;
                                                        $totcredit = $totcredit + $bvl->firstamount;*/
                                                        ?>
                                                        <span class="badge bg-danger">Cr</span>
                                                        <?php
                                                    }else{
                                                        /*$closingbalance = $closingbalance + $bvl->firstamount;
                                                        $totdebit = $totdebit + $bvl->firstamount;*/
                                                        ?>
                                                        <span class="badge bg-success">Dr</span>
                                                        <?php
                                                    }
                                                    }
                                                    ?>
                                                </td>

                                                <td><?php 
                                                if($bvl->journalid != 0)
                                                {
                                                    echo $bvl->secledger;
                                                }else{
                                                    if($bvl->le_issale == 1)
                                                    {
                                                        echo "Sale";
                                                    }
                                                    else if($bvl->le_issale == 2)
                                                    {
                                                        echo "Purchase";
                                                    }else{
                                                        echo "Opening Balance";
                                                    }
                                                }
                                                ?></td>
                                                
                                                 <td><?= show_currency_amount($bvl->firstamount) ?></td>
                                                 <td><?= $bvl->at_name ?></td>
                                                 
                                                
                                            </tr>
                                            <?php
                                            $k++;
                                        }
                                    }
                                    ?>
                                    

                                </tbody>
                            </table>


                            <div class="row col-md-12 mt-2">
                                <div class="col-md-4">
                                    Total Debit: <b><?= show_currency_amount($totdebit) ?></b>
                                    
                                </div>
                                <div class="col-md-4" align="center">
                                    Total Credit: <b><?= show_currency_amount($totcredit) ?></b>
                                </div>
                                <div class="col-md-4" align="right">
                                    Closing Balance: <b><?= show_currency_amount($closingbalance) ?></b>
                                </div>
                            </div>

                            <div align="right">

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            
            
        </div> <!-- container -->

    </div> <!-- content -->



<script type="text/javascript">
    function viewjournalfun(jrnlid)
    {
        $.ajax({
          url: '<?php echo site_url('accounts/getjournaldetails') ?>',
          type: 'POST',
          dataType: 'html',
          data: {journalid: jrnlid},
        })
        .done(function(result) {
          // console.log("success");
          $("#journaldetailsdiv").html(result);

        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });

        $('#viewjournalentrymmodal').modal('show');
    }
    
    
</script>