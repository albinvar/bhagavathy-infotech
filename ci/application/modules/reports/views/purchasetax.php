<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            
                            <a href="<?= base_url() ?>reports/purchasetaxcsv/<?= $fromdate ?>/<?= $todate ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-file-excel"></i> Export to CSV</button>
                            </a>

                            <a href="<?= base_url() ?>reports/purchasetax/<?= $fromdate ?>/<?= $todate ?>/1"  target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-print"></i> Print</button>
                            </a>

                        </div>
                        <h4 class="page-title">Purchase Tax Report</h4>
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
                            </div>

                            <script type="text/javascript">
                                function filterstockfun()
                                {
                                    var fromdate = $('#fromdate').val();
                                    var todate = $('#todate').val();
                                    window.location.href= '<?= base_url() ?>reports/purchasetax/'+fromdate+'/'+todate;
                                }
                            </script>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th width="20px" rowspan="2">#</th>
                                        <th rowspan="2">BillNo</th>
                                        <th rowspan="2">Bill Date</th>
                                        <th <?php if($this->isvatgst == 0){ ?> colspan="3" <?php } ?> class="text-center">Purchase</th>
                                        <th <?php if($this->isvatgst == 0){ ?> colspan="3" <?php } ?> class="text-center">Return</th>
                                    </tr>
                                    <tr>
                                        <?php if($this->isvatgst == 0){ ?>
                                        <th>CGST</th>
                                        <th>SGST</th>
                                        <th>IGST</th>
                                        <th>CGST</th>
                                        <th>SGST</th>
                                        <th>IGST</th>
                                    <?php }else{
                                        ?>
                                        <th style="text-align: center;">VAT</th>
                                        <th style="text-align: center;">VAT</th>
                                        <?php
                                    } ?>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    $totalpcgst =0;
                                    $totalpsgst = 0;
                                    $totalpigst = 0;

                                    $totalrtcgst =0;
                                    $totalrtsgst = 0;
                                    $totalrtigst = 0;

                                    if($purchaselist)
                                    {
                                        $k=1;
                                        foreach($purchaselist as $stvl)
                                        {

                                            if(($stvl->sp_state == $businessdet->bu_state || $stvl->sp_state == '') || $businessdet->bu_country != '101')
                                            {
                                                $pucgst = $stvl->pm_totalgstamount/2;
                                                $pusgst = $stvl->pm_totalgstamount/2;
                                                $puigst = 0;
                                            }else{
                                                $pucgst = 0;
                                                $pusgst = 0;
                                                $puigst = $stvl->pm_totalgstamount;
                                            }
                                            $totalpcgst = $totalpcgst + $pucgst;
                                            $totalpsgst = $totalpsgst + $pusgst;
                                            $totalpigst = $totalpigst + $puigst;

                                            $rtcgst = 0;
                                            $rtsgst = 0;
                                            $rtigst = 0;
                                            if($stvl->pm_type == 2)
                                            {
                                                if(($stvl->sp_state == $businessdet->bu_state || $stvl->sp_state == '') || $businessdet->bu_country != '101')
                                                {
                                                    $rtcgst = $stvl->pm_totalgstamount/2;
                                                    $rtsgst = $stvl->pm_totalgstamount/2;
                                                    $rtigst = 0;
                                                }else{
                                                    $rtcgst = 0;
                                                    $rtsgst = 0;
                                                    $rtigst = $stvl->pm_totalgstamount;
                                                }
                                            }else{
                                                if($stvl->pm_partialreturn == 1)
                                                {
                                                    $retrndet = $this->purmstr->getpurchasereturndetails($stvl->pm_purchaseid);
                                                    if($retrndet)
                                                    {
                                                        if(($stvl->sp_state == $businessdet->bu_state || $stvl->sp_state == '') || $businessdet->bu_country != '101')
                                                        {
                                                            $rtcgst = $retrndet->pm_totalgstamount/2;
                                                            $rtsgst = $retrndet->pm_totalgstamount/2;
                                                            $rtigst = 0;
                                                        }else{
                                                            $rtcgst = 0;
                                                            $rtsgst = 0;
                                                            $rtigst = $retrndet->pm_totalgstamount;
                                                        }
                                                
                                                    }
                                                }
                                                
                                            }

                                            $totalrtcgst = $totalrtcgst + $rtcgst;
                                            $totalrtsgst = $totalrtsgst + $rtsgst;
                                            $totalrtigst = $totalrtigst + $rtigst;
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->pm_purchaseprefix ?><?= $stvl->pm_purchaseno ?></td>
                                                <td><?= date('d-M-Y', strtotime($stvl->pm_date)) ?> <?= date('H:i', strtotime($stvl->pm_time)) ?></td>

                                                <?php if($this->isvatgst == 0){ ?>
                                                <td><?= $pucgst ?></td>
                                                <td><?= $pusgst ?></td>
                                                <td><?= $puigst ?></td>
                                                <td><?= $rtcgst ?></td>
                                                <td><?= $rtsgst ?></td>
                                                <td><?= $rtigst ?></td>
                                                <?php 
                                                }else{
                                                    ?>
                                                    <td align="center"><?= $puigst ?></td>
                                                    <td align="center"><?= $rtigst ?></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <?php
                                            $k++;
                                        }
                                    }
                                    ?>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" align="right" style="text-align: right;">Total</th>
                                        <?php if($this->isvatgst == 0){ ?>
                                        <th><?= $totalpcgst ?></th>
                                        <th><?= $totalpsgst ?></th>
                                        <th><?= $totalpigst ?></th>
                                        <th><?= $totalrtcgst ?></th>
                                        <th><?= $totalrtsgst ?></th>
                                        <th><?= $totalrtigst ?></th>
                                        <?php 
                                        }else{
                                            ?>
                                            <th style="text-align: center;"><?= $totalpigst ?></th>
                                            <th style="text-align: center;"><?= $totalrtigst ?></th>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            
            
        </div> <!-- container -->

    </div> <!-- content -->

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        
        <!-- Datatable JS -->
         <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> 
       <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
         <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> 
    
    <script type="text/javascript">
    function purchasereturnfun(billid, purchaseno, paidamount)
    {
        $('#purchnodiv').html(purchaseno);
        $('#returnbillid').val(billid);
        $('#returnpaidamount').val(paidamount);
        $('#purreturnmodal').modal('show');
    }

    function viewbillitemfun(billid)
    {
        $.ajax({
          url: '<?php echo site_url('purchase/getbillitemdetails') ?>',
          type: 'POST',
          dataType: 'html',
          data: {billid: billid},
        })
        .done(function(result) {
          // console.log("success");
          $("#itemdetailsdiv").html(result);

        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
        $('#standard-modalLabel').html('Bill Item Details');
        $('#viewitemmmodal').modal('show');
    }

    function viewpurchasedetails(billid)
    {
        $.ajax({
          url: '<?php echo site_url('purchase/getpurchasedetails/1') ?>',
          type: 'POST',
          dataType: 'html',
          data: {billid: billid},
        })
        .done(function(result) {
          // console.log("success");
          $("#itemdetailsdiv").html(result);

        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });

        $('#standard-modalLabel').html('Purchase Details');
        $('#viewitemmmodal').modal('show');
    }

</script>