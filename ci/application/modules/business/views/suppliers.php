
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
                            
                            <a href="<?= base_url() ?>business/addsupplier" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Supplier</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Supplier List</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Company Name</th>
                                        <th><?= $this->isvatgstname ?> No</th>
                                        <th>Contact Person</th>
                                        <!--<th>Email</th>-->
                                        <th>Phone</th>
                                        <th>Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($suppliers)
                                    {
                                        $k=1;
                                        foreach($suppliers as $stvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->sp_name ?></td>
                                                <td><?= $stvl->sp_gstno ?></td>
                                                <td><?= $stvl->sp_contactperson ?></td>
                                                <!--<td><?= $stvl->sp_email ?></td>-->
                                                <td><?= $stvl->sp_mobile ?></td>
                                                <td><?= price_roundof($stvl->sp_balanceamount) ?>
                                                    <a href="<?= base_url() ?>business/supplierpayhistory/<?= $stvl->sp_supplierid ?>" class="text-success"><i class="fas fa-history"></i> History</a>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" onclick="viewdetailsfun('<?= $stvl->sp_supplierid ?>')" class="text-primary"><i class="fas fa-eye"></i> View</a> &nbsp;
                                                    <?php if($stvl->sp_isactive): ?>
                                                        <a href="<?php echo site_url('business/enabledisablesupplier/' . $stvl->sp_supplierid); ?>" class="text-success" onclick="return confirm('Are you sure?')"><i class="fas fa-check"></i> Enable</a>
                                                        <?php else: ?>
                                                            <a class="text-info" href="<?php echo site_url('business/addsupplier/' . $stvl->sp_supplierid); ?>"><i class="fas fa-pen"></i> Edit</a> &nbsp;
                                                            <?php 
                                                            if($stvl->sp_balanceamount > 0)
                                                            {
                                                            ?>
                                                            <a class="text-warning" href="javascript:void(0)" onclick="paymentaddfun('<?= $stvl->sp_supplierid ?>', '<?= $stvl->sp_balanceamount ?>')"><i class="fas fa-money-check-alt"></i> Pay</a> &nbsp;
                                                            <?php 
                                                            }
                                                            ?>
                                                            
                                                        <a href="<?php echo site_url('business/enabledisablesupplier/' . $stvl->sp_supplierid .'/1'); ?>" onclick="return confirm('Are you sure?')" class="ml-2 text-danger"><i class="fas fa-times"></i> Disable</a>
                                                       <?php endif; ?>
                                                </td>
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
        <div id="viewdetailmmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Supplier Details</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body" id="viewdetailsdiv">

                       
                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light listbtns" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    <!-- Payment modal content -->
        <div id="paymentmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Supplier Payment</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?php echo base_url(); ?>business/addingsupplierpayment" name="addingform" id="addingform" class="addformvalidate" method="post">
                        <input type="hidden" name="supplierid" id="supplierid">
                        <input type="hidden" name="supoldbalance" id="supoldbalance">
                    <div class="modal-body">
                       
                       <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Amount</label>
                                    <input type="number" step="any" name="paidamount" required class="form-control" id="paidamount">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Select Payment Method</label>
                                    <select class="w-100 form-control" name="paymethod" id="paymethod">
                                        <option value="4">Cash</option>
                                        <option value="3">Bank</option>
                                        <!--<option value="3">UPI</option>-->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Notes</label>
                                    <textarea name="paynote" id="paynote" class="form-control"></textarea>
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
    function paymentaddfun(supid, blnce)
    {
        $('#supplierid').val(supid);
        $('#supoldbalance').val(blnce);
        $('#paidamount').val(blnce);
        $('#paymentmodal').modal('show');
    }
    function viewdetailsfun(usrid)
    {
        $.ajax({
          url: '<?php echo site_url('business/getsupplierdetails') ?>',
          type: 'POST',
          dataType: 'html',
          data: {supplierid: usrid},
        })
        .done(function(result) {
          // console.log("success");
          $("#viewdetailsdiv").html(result);

        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });

        $('#viewdetailmmodal').modal('show');
    }
    
    
</script>