
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
                            
                            <a href="<?= base_url() ?>business/addcustomer" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Customer</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Customer List</h4>
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
                                        <th>Customer Name</th>
                                        <th>Phone</th>
                                        <!--<th>Email</th>-->
                                        <!--<th>Address</th>-->
                                        <th>Type</th>
                                        <th>Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($customers)
                                    {
                                        $k=1;
                                        foreach($customers as $stvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->ct_name ?></td>
                                                <td><?php 
                                                $pharr = array();
                                                if($stvl->ct_phone != "")
                                                {
                                                    $pharr[] = $stvl->ct_phone;
                                                }
                                                if($stvl->ct_mobile != "")
                                                {
                                                    $pharr[] = $stvl->ct_mobile;
                                                }
                                                echo implode(', ', $pharr);
                                                ?></td>
                                                <!--<td><?= $stvl->ct_email ?></td>-->
                                                <!--<td><?= $stvl->ct_address ?></td>-->
                                                <td>
                                                    <?php 
                                                    if($stvl->ct_type == 0)
                                                    {
                                                        echo 'B2C';
                                                    }else{
                                                        echo 'B2B (' . $stvl->ct_gstin . ')';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= price_roundof($stvl->ct_balanceamount) ?>
                                                    <a href="<?= base_url() ?>business/customerpayhistory/<?= $stvl->ct_cstomerid ?>" class="text-success"><i class="fas fa-history"></i> History</a>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" onclick="viewdetailsfun('<?= $stvl->ct_cstomerid ?>')" class="text-primary"><i class="fas fa-eye"></i> View</a> &nbsp;
                                                    <?php if($stvl->ct_isactive): ?>
                                                        <a href="<?php echo site_url('business/enabledisablecustomer/' . $stvl->ct_cstomerid); ?>" class="text-success" onclick="return confirm('Are you sure?')"><i class="fas fa-check"></i> Enable</a>
                                                        <?php else: ?>
                                                            <a class="text-info" href="<?php echo site_url('business/addcustomer/' . $stvl->ct_cstomerid); ?>"><i class="fas fa-pen"></i> Edit</a> &nbsp;

                                                            <?php 
                                                            if($stvl->ct_balanceamount > 0)
                                                            {
                                                            ?>
                                                            <a class="text-warning" href="javascript:void(0)" onclick="paymentaddfun('<?= $stvl->ct_cstomerid ?>', '<?= $stvl->ct_balanceamount ?>')"><i class="fas fa-money-check-alt"></i> Pay</a> &nbsp;
                                                            <?php 
                                                            }
                                                            ?>

                                                        <a href="<?php echo site_url('business/enabledisablecustomer/' . $stvl->ct_cstomerid .'/1'); ?>" onclick="return confirm('Are you sure?')" class="ml-2 text-danger"><i class="fas fa-times"></i> Disable</a>
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
                        <h4 class="modal-title" id="standard-modalLabel">Customer Details</h4>
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
                        <h4 class="modal-title" id="standard-modalLabel">Customer Payment</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?php echo base_url(); ?>business/addingcustomerpayment" name="addingform" id="addingform" class="addformvalidate" method="post">
                        <input type="hidden" name="customerid" id="customerid">
                        <input type="hidden" name="custoldbalance" id="custoldbalance">
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
    function paymentaddfun(cusid, blnce)
    {
        $('#customerid').val(cusid);
        $('#custoldbalance').val(blnce);
        $('#paidamount').val(blnce);
        $('#paymentmodal').modal('show');
    }
    function viewdetailsfun(usrid)
    {
        $.ajax({
          url: '<?php echo site_url('business/getcustomerdetails') ?>',
          type: 'POST',
          dataType: 'html',
          data: {customerid: usrid},
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