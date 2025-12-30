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
                            
                            <a href="<?= base_url() ?>reports/billwiseprofitreportcsv/<?= $type ?>/<?= $fromdate ?>/<?= $todate ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-file-excel"></i> Export to CSV</button>
                            </a>

                            <a href="<?= base_url() ?>reports/billwiseprofitreport/<?= $type ?>/<?= $fromdate ?>/<?= $todate ?>/1"  target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-print"></i> Print</button>
                            </a>

                        </div>
                        <h4 class="page-title"><?= $title ?></h4>
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
                                    window.location.href= '<?= base_url() ?>reports/billwiseprofitreport/'+type+'/'+fromdate+'/'+todate;
                                }
                            </script>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th width="20px">#</th>
                                        <th>Bill No</th>
                                        <th>Bill Date</th>
                                        <th>Purchase Price</th>
                                        <th>Sale Price</th>
                                        <th>Profit</th>
                                        
                                    </tr>
                                    
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    $totalpurchase = 0;
                                    $totalsaleprice = 0;
                                    $totalprofit = 0;

                                    if($billlist)
                                    {
                                        $k=1;
                                        foreach($billlist as $blvl)
                                        {
                                            $biltot = $this->retlslv->getbillsalesumbyid($blvl->rb_retailbillid);
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $blvl->rb_billprefix . " " . $blvl->rb_billno ?></td>
                                                <td><?= date('d-M-Y', strtotime($blvl->rb_date)) . " " . date('H:i', strtotime($blvl->rb_time)) ?></td>
                                                <td>
                                                    <?php 
                                                    echo price_roundof($biltot->totpurchase);
                                                    $totalpurchase = $totalpurchase + $biltot->totpurchase;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    echo price_roundof($biltot->totsale);
                                                    $totalsaleprice = $totalsaleprice + $biltot->totsale;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $itemprofit = $biltot->totsale-$biltot->totpurchase;
                                                    echo price_roundof($itemprofit);
                                                    $totalprofit = $totalprofit + $itemprofit;
                                                    ?>
                                                </td>
                                                
                                                
                                                
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
                                        <th><?= price_roundof($totalpurchase) ?></th>
                                        <th><?= price_roundof($totalsaleprice) ?></th>
                                        
                                        <th><?= price_roundof($totalprofit) ?></th>
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