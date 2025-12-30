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
                            
                            <a href="<?= base_url() ?>reports/taxpercentagereportcsv/<?= $type ?>/<?= $fromdate ?>/<?= $todate ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-file-excel"></i> Export to CSV</button>
                            </a>

                            <a href="<?= base_url() ?>reports/taxpercentagereport/<?= $type ?>/<?= $fromdate ?>/<?= $todate ?>/1"  target="_blank" class="ms-1">
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
                                    window.location.href= '<?= base_url() ?>reports/taxpercentagereport/'+type+'/'+fromdate+'/'+todate;
                                }
                            </script>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th width="20px">#</th>
                                        <th>Tax Band</th>
                                        <th>Tax %</th>
                                        <!--<th>Total Qty</th>-->
                                        <th>Taxable Amt </th>
                                        <th>Tax Amt</th>
                                        <th>Total Amt</th>
                                        <?php if($this->isvatgst == 0){ ?>
                                        <th>CGST</th>
                                        <th>SGST</th>
                                        <th>IGST</th>
                                    <?php } ?>
                                    </tr>
                                    
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    $totalqty=0;
                                    $totaltaxableamt =0;
                                    $totaltaxamt = 0;
                                    $totalamount = 0;

                                    $totalcgst =0;
                                    $totalsgst = 0;
                                    $totaligst = 0;

                                    if($taxbands)
                                    {
                                        $k=1;
                                        foreach($taxbands as $txvl)
                                        {
                                            $prdcttot = $this->retlslv->gettaxvaluekeralasalesum($txvl->tb_tax, $type, $fromdate, $todate);
                                            $prdcttotcgst = $this->retlslv->gettaxvalueoutkeralasalesum($txvl->tb_tax, $type, $fromdate, $todate);
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $txvl->tb_taxband ?></td>
                                                <td><?= $txvl->tb_tax ?></td>
                                                <!--<td>
                                                    <?php 
                                                    $totalqty = $totalqty + $prdcttot->totqty + $prdcttotcgst->totqty;
                                                    echo $prdcttot->totqty + $prdcttotcgst->totqty;
                                                    ?>
                                                </td>-->
                                                <td>
                                                    <?php 
                                                    $totaltaxableamt = $totaltaxableamt + $prdcttot->totnet + $prdcttotcgst->totnet;
                                                    echo price_roundof($prdcttot->totnet + $prdcttotcgst->totnet);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $totaltaxamt = $totaltaxamt + $prdcttot->totgst + $prdcttotcgst->totgst;
                                                    echo price_roundof($prdcttot->totgst + $prdcttotcgst->totgst);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $totalamount = $totalamount + $prdcttot->totamnt + $prdcttotcgst->totamnt;
                                                    echo price_roundof($prdcttot->totamnt + $prdcttotcgst->totamnt);
                                                    ?>
                                                </td>
                                                <?php if($this->isvatgst == 0){ ?>
                                                <td>
                                                    <?php 
                                                    $totalcgst = $totalcgst + ($prdcttot->totgst/2);
                                                    echo price_roundof($prdcttot->totgst/2);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $totalsgst = $totalsgst + ($prdcttot->totgst/2);
                                                    echo price_roundof($prdcttot->totgst/2);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $totaligst = $totaligst + ($prdcttotcgst->totgst);
                                                    echo price_roundof($prdcttotcgst->totgst);
                                                    ?>
                                                </td>
                                            <?php } ?>
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
                                        <!--<td><?= $totalqty ?></td>-->
                                        <th><?= price_roundof($totaltaxableamt) ?></th>
                                        <th><?= price_roundof($totaltaxamt) ?></th>
                                        
                                        <th><?= price_roundof($totalamount) ?></th>
                                        <?php if($this->isvatgst == 0){ ?>
                                        <th><?= price_roundof($totalcgst) ?></th>
                                        <th><?= price_roundof($totalsgst) ?></th>
                                        <th><?= price_roundof($totaligst) ?></th>
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