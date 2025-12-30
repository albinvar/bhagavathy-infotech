
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
                            
                            <a href="<?= base_url() ?>inventory/stocktransfer" class="ms-1 finyearaddbutton">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Stock Transfer</button>
                            </a>

                            
                                
                        </div>
                        <h4 class="page-title">Stock Transfer History</h4>
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
                                    window.location.href= '<?= base_url() ?>inventory/stocktransferlist/'+fromdate+'/'+todate;
                                }
                            </script>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Transfer Date</th>
                                        <th>Transfer From</th>
                                        <th>Transfer To</th>
                                        <th>Items</th>
                                        <!--<th>Transfered By</th>-->
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    $alltotalamount =0;
                                    if($transferlist)
                                    {
                                        $k=1;
                                        foreach($transferlist as $stvl)
                                        {
                                            $alltotalamount+= $stvl->st_totalamount;
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= date('d-M-Y H:i', strtotime($stvl->st_updatedon)) ?></td>
                                                <td><?= $stvl->fromname ?>(<?= $stvl->fromcode ?>)</td>
                                                <td><?= $stvl->toname ?>(<?= $stvl->tocode ?>)</td>
                                                <td><a href="javascript:void(0)" onclick="viewbillitemfun('<?= $stvl->st_stocktransferid ?>')" class="text-primary"><i class="fas fa-eye"></i> View</a></td>
                                                <!--<td></td>-->
                                               
                                            </tr>
                                            <?php
                                            $k++;
                                        }
                                    }
                                    ?>
                                    
                                </tbody>
                                
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
                        <h4 class="modal-title" id="standard-modalLabel">Transfer Item Details</h4>
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
          url: '<?php echo site_url('inventory/getitemdetails') ?>',
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