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
                            <!--<a href="<?= base_url() ?>sale/csvsalehistory/<?= $type ?>/<?= $godownid ?>/<?= $salesperson ?>/<?= $customer ?>/<?= $fromdate ?>/<?= $todate ?>" target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-file-excel"></i> Export to CSV</button>
                            </a> 

                             <a href="<?= base_url() ?>sale/printsalehistory/<?= $type ?>/<?= $godownid ?>/<?= $salesperson ?>/<?= $customer ?>/<?= $fromdate ?>/<?= $todate ?>" target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-print"></i> Print</button>
                            </a>  

                            <a href="<?= base_url() ?>sale/dashboard/<?= $type ?>" class="ms-1 finyearaddbutton">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add <?= $title ?></button>
                            </a>-->
                            
                        </div>
                        <h4 class="page-title"><?= $title ?> List</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="mb-3">

                            <div class="row">
                                <div class="col-6">
                                    <a href="<?= base_url() ?>production/deliverynotes/0" class="btn <?php if($complete==0){ ?> btn-primary <?php }else{ ?>btn-light<?php } ?> " data-toggle="tab">New Delivery Notes</a>

                                    <a href="<?= base_url() ?>production/deliverynotes/1" class="btn <?php if($complete==1){ ?> btn-primary <?php }else{ ?>btn-light<?php } ?>" data-toggle="tab">Returned Delivery Notes</a>
                                </div>
                                <div class="col-6" align="right">
                                    <!--<a href="http://localhost/usebiller/inventory/csvproductexport/0" target="_blank" class="ms-1">
                                        <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-file-excel"></i> Export Products to CSV</button>
                                    </a>-->
                                </div>
                            </div>
                            
                            </div>

                            <?php if($complete==1){ ?>
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
                                    window.location.href= '<?= base_url() ?>production/deliverynotes/1/'+fromdate+'/'+todate;
                                }
                            </script>
                            <?php 
                            }
                            ?>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>BillNo</th>
                                        <th>Bill Date</th>
                                        <th>Customer</th>
                                        <!--<th>Phone</th>-->
                                        <th>Items</th>
                                        <th>Freight</th>
                                        <th>Total</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    $alltotalamount =0;
                                    $allfreight = 0;
                                    if($deliverynotes)
                                    {
                                        $k=1;
                                        foreach($deliverynotes as $stvl)
                                        {
                                            $alltotalamount+= $stvl->dn_grandtotal;
                                            $allfreight+=$stvl->dn_freight;
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->dn_billprefix ?><?= $stvl->dn_billno ?></td>
                                                <td><?= date('d-M-Y', strtotime($stvl->dn_date)) ?> <?= date('H:i', strtotime($stvl->dn_time)) ?></td>
                                                <td>
                                                    <?php 
                                                if($stvl->dn_existcustomer == 1)
                                                {
                                                    $custdet = $this->cstmr->getcustomerdetailsbyid($stvl->dn_customerid);
                                                    echo $custdet->ct_name;
                                                    $phone = $custdet->ct_phone;
                                                }else{
                                                echo $stvl->dn_customername;
                                                $phone = $stvl->dn_phone;
                                                
                                                }
                                                ?>
                                                </td>
                                                <!--<td><?= $phone ?></td>-->
                                                <td><a href="javascript:void(0)" onclick="viewbillitemfun('<?= $stvl->dn_deliverynoteid ?>')" class="text-primary"><i class="fas fa-eye"></i> View</a></td>
                                                <td><?= price_roundof($stvl->dn_freight) ?></td>
                                                <td><?= price_roundof($stvl->dn_grandtotal) ?></td>
                                                
                                                
                                                <td>
                                                    <a href="<?= base_url() ?>production/deliverynoteprint/<?= $stvl->dn_deliverynoteid ?>" target="_blank" class="text-primary"><i class="fas fa-print"></i> Print</a>&nbsp;

                                                    <?php if($complete==0){ ?>
                                                    <a href="javascript:void(0)" onclick="deliveryreturnfun('<?= $stvl->dn_deliverynoteid ?>')" class="text-secondary"><i class="fas fa-undo"></i> Return</a>
                                                    <?php 
                                                    }
                                                    ?>

                                                    <!--&nbsp; <a href="<?= base_url() ?>sale/dashboard/<?= $stvl->dn_deliverynoteid ?>"  class="text-info"><i class="fas fa-edit"></i> Edit</a> 
                                                    
                                                    &nbsp;<a href="javascript:void(0)" onclick="viewfullsaledetails('<?= $stvl->dn_deliverynoteid ?>')" class="text-warning"><i class="fas fa-eye"></i> View</a>-->
                                                    
                                                    
                                                    <!--<a href="#" onclick="return confirm('Are you sure?')" class="text-danger"><i class="fas fa-trash"></i> Delete</a>-->
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
                                        <th colspan="5" align="right" style="text-align: right;">Total</th>
                                        <th><?= price_roundof($allfreight) ?></th>
                                        <th><?= price_roundof($alltotalamount) ?></th>
                                        
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

        <!-- Add modal content -->
        <div id="returndeliverymodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Return Delivery Note</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <form action="<?php echo base_url(); ?>production/returndeliverynotes" name="addingform" id="addingform" class="addformvalidate" method="post">
                        <input type="hidden" name="editid" id="editid">
                    <div class="modal-body" id="itemdetailsdiv">

                       <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Retrun Date</label>
                                    <input type="date" name="retdate" required class="form-control" id="retdate" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Time</label>
                                    <input type="time" name="rettime" required class="form-control" id="rettime" value="<?= date('H:i') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-7" class="form-label">Return Comments</label>
                                    <textarea class="form-control" id="notes" name="notes" placeholder="Notes"></textarea>
                                </div>
                            </div>
                        </div>
                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light listbtns" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-blue listbtns">Submit</button>
                    </div>
                </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    
    <script type="text/javascript">
    function deliveryreturnfun(billid)
    {
        $('#editid').val(billid);
        $('#returndeliverymodal').modal('show');
    }
    function viewbillitemfun(billid)
    {
        $.ajax({
          url: '<?php echo site_url('production/getdeliveryitemdetails') ?>',
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

    function viewfullsaledetails(billid)
    {
        $.ajax({
          url: '<?php echo site_url('sale/getsalefulldetails') ?>',
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

        $('#standard-modalLabel').html('Sale Details');
        $('#viewitemmmodal').modal('show');
    }
</script>