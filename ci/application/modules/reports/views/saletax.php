
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
                            
                            <a href="<?= base_url() ?>reports/saletaxcsv/<?= $type ?>/<?= $fromdate ?>/<?= $todate ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-file-excel"></i> Export to CSV</button>
                            </a>

                            <a href="<?= base_url() ?>reports/saletax/<?= $type ?>/<?= $fromdate ?>/<?= $todate ?>/1"  target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-print"></i> Print</button>
                            </a>

                        </div>
                        <h4 class="page-title"><?= $title ?> Report</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row mb-2">
                                <div class="col-md-3">
                                    Type:
                                    <select class="form-control" name="type" id="type">
                                        <option <?php if($type == 'all'){ echo "selected"; } ?> value="all">All</option>
                                        <option <?php if($type == '0'){ echo "selected"; } ?> value="0">Retail</option>
                                        <option <?php if($type == '1'){ echo "selected"; } ?> value="1">Wholesale</option>
                                        <?php 
                                        if($inventorysettings)
                                        {
                                            if($inventorysettings->is_isfourrate == 1)
                                            {
                                                ?>
                                        <option <?php if($type == '7'){ echo "selected"; } ?> value="7">C Sale</option>
                                        <option <?php if($type == '8'){ echo "selected"; } ?> value="8">D Sale</option>
                                        <?php 
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
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
                                    var type = $('#type').val();
                                    var fromdate = $('#fromdate').val();
                                    var todate = $('#todate').val();
                                    window.location.href= '<?= base_url() ?>reports/saletax/'+type+'/'+fromdate+'/'+todate;
                                }
                            </script>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th width="20px" rowspan="2">#</th>
                                        <th width="50px" rowspan="2">BillNo</th>
                                        <th rowspan="2">Bill Date</th>
                                        <th <?php if($this->isvatgst == 0){ ?> colspan="3" <?php } ?> class="text-center">Sale</th>
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
                                    if($salelist)
                                    {
                                        $k=1;
                                        foreach($salelist as $stvl)
                                        {

                                            if(($stvl->rb_state == $businessdet->bu_state || $stvl->rb_state == '') || $businessdet->bu_country != '101')
                                            {
                                                $pucgst = $stvl->rb_totalgstamnt/2;
                                                $pusgst = $stvl->rb_totalgstamnt/2;
                                                $puigst = 0;
                                            }else{
                                                $pucgst = 0;
                                                $pusgst = 0;
                                                $puigst = $stvl->rb_totalgstamnt;
                                            }
                                            $totalpcgst = $totalpcgst + $pucgst;
                                            $totalpsgst = $totalpsgst + $pusgst;
                                            $totalpigst = $totalpigst + $puigst;

                                            $retcgst = 0;
                                            $retsgst = 0;
                                            $retigst = 0;
                                            if($stvl->rb_partialreturn == 1)
                                            {
                                                $retrndet = $this->retlmstr->getsalereturndetails($stvl->rb_retailbillid);
                                                if($retrndet)
                                                {
                                                    if(($stvl->rb_state == $businessdet->bu_state || $stvl->rb_state == '') || $businessdet->bu_country != '101')
                                                    {
                                                        $retcgst = $retrndet->rb_totalgstamnt/2;
                                                        $retsgst = $retrndet->rb_totalgstamnt/2;
                                                        $retigst = 0;
                                                    }else{
                                                        $retcgst = 0;
                                                        $retsgst = 0;
                                                        $retigst = $retrndet->rb_totalgstamnt;
                                                    }
                                                    $totalrtcgst = $totalrtcgst + $retcgst;
                                                    $totalrtsgst = $totalrtsgst + $retsgst;
                                                    $totalrtigst = $totalrtigst + $retigst;
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->rb_billprefix ?><?= $stvl->rb_billno ?></td>
                                                <td><?= date('d-M-Y', strtotime($stvl->rb_date)) ?> <?= date('H:i', strtotime($stvl->rb_time)) ?></td>

                                                <?php if($this->isvatgst == 0){ ?>
                                                <td><?= $pucgst ?></td>
                                                <td><?= $pusgst ?></td>
                                                <td><?= $puigst ?></td>
                                                <td><?= $retcgst ?></td>
                                                <td><?= $retsgst ?></td>
                                                <td><?= $retigst ?></td>
                                                <?php 
                                                }else{
                                                    ?>
                                                    <td align="center"><?= $puigst ?></td>
                                                    <td align="center"><?= $retigst ?></td>
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