
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
                            
                            <a href="<?= base_url() ?>purchase/dashboard" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Puchase</button>
                            </a>

                            
                                
                        </div>
                        <h4 class="page-title">Purchase List</h4>
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
                                    window.location.href= '<?= base_url() ?>purchase/purchasehistory/'+fromdate+'/'+todate;
                                }
                            </script>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>BillNo</th>
                                        <th>Bill Date</th>
                                        <th>Supplier</th>
                                        <th>Phone</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Discount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    $alltotalamount =0;
                                    $alldiscount = 0;
                                    if($purchaselist)
                                    {
                                        $k=1;
                                        foreach($purchaselist as $stvl)
                                        {
                                            $alltotalamount+= $stvl->pm_totalamount;
                                            $alldiscount+= $stvl->pm_discount;
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->pm_purchaseno ?></td>
                                                <td><?= date('d-M-Y', strtotime($stvl->pm_date)) ?> <?= date('H:i', strtotime($stvl->pm_time)) ?></td>
                                                <td><?= $stvl->sp_name ?></td>
                                                <td><?= $stvl->sp_mobile ?></td>
                                                <td><a href="javascript:void(0)" onclick="viewbillitemfun('<?= $stvl->pm_purchaseid ?>')" class="text-primary"><i class="fas fa-eye"></i> View</a></td>
                                                <td><?= $stvl->pm_totalamount ?></td>
                                                <td><?= $stvl->pm_discount ?></td>
                                                <td>
                                                    <a href="<?= base_url() ?>purchase/purchaseprint/<?= $stvl->pm_purchaseid ?>" target="_blank" class="text-primary"><i class="fas fa-print"></i> Print</a> &nbsp;
                                                    <a href="<?= base_url() ?>" onclick="return confirm('Are you sure?')" class="text-danger"><i class="fas fa-trash"></i> Delete</a>
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
                                        <th colspan="6" align="right" style="text-align: right;">Total</th>
                                        <th><?= $alltotalamount ?></th>
                                        <th><?= $alldiscount ?></th>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            
            
        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Add modal content -->
        <div id="viewitemmmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Bill Item Details</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body" id="itemdetailsdiv">

                       
                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light listbtns" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    
    <script type="text/javascript">
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

        $('#viewitemmmodal').modal('show');
    }


</script>