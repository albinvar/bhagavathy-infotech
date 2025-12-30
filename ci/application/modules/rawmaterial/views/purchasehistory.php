
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
                            
                            <?php 
                            if($type == 0)
                            {
                            ?>
                            <a href="<?= base_url() ?>rawmaterial/dashboard" class="ms-1 finyearaddbutton">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Purchase Materials</button>
                            </a>
                            <?php 
                            }else{
                                ?>
                                <a href="<?= base_url() ?>rawmaterial/dashboard/1" class="ms-1 finyearaddbutton">
                                    <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Purchase Order</button>
                                </a>
                                <?php
                            }
                            ?>
                            
                                
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
                                <div class="col-md-2">
                                    Supplier:
                                    <select class="form-control" name="supplierid" id="supplierid">
                                        <option <?php if($supplierid == 0){ echo "selected"; } ?> value="0">All</option>
                                        <?php 
                                        if($suppliers)
                                        {
                                            foreach($suppliers as $spvl)
                                            {
                                                ?>
                                                <option <?php if($supplierid == $spvl->sp_supplierid){ echo "selected"; } ?> value="<?= $spvl->sp_supplierid ?>"><?= $spvl->sp_name ?></option>
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
                                    var supplierid = $('#supplierid').val();
                                    var fromdate = $('#fromdate').val();
                                    var todate = $('#todate').val();
                                    window.location.href= '<?= base_url() ?>rawmaterial/purchasehistory/<?= $type ?>/'+supplierid+'/'+fromdate+'/'+todate;
                                }
                            </script>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th width="20px">#</th>
                                        <th width="50px">BillNo</th>
                                        <th>Bill Date</th>
                                        <th>Supplier</th>
                                        <!--<th>Phone</th>-->
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
                                                <td><?= $stvl->pm_purchaseprefix ?><?= $stvl->pm_purchaseno ?></td>
                                                <td><?= date('d-M-Y', strtotime($stvl->pm_date)) ?> <?= date('H:i', strtotime($stvl->pm_time)) ?></td>
                                                <td><?= $stvl->sp_name ?></td>
                                                <!--<td><?= $stvl->sp_mobile ?></td>-->
                                                <td><a href="javascript:void(0)" onclick="viewbillitemfun('<?= $stvl->pm_purchaseid ?>')" class="text-primary"><i class="fas fa-eye"></i> View</a></td>
                                                <td><?= $stvl->pm_totalamount ?></td>
                                                <td><?= $stvl->pm_discount ?></td>
                                                <td>
                                                    <a href="<?= base_url() ?>rawmaterial/purchaseprint/<?= $stvl->pm_purchaseid ?>/<?= $type ?>" target="_blank" class="text-primary"><i class="fas fa-print"></i> Print</a> &nbsp;
                                                    <?php 
                                                    if($stvl->pm_partialreturn != 1)
                                                    {
                                                        if($stvl->pm_postatus == 0)
                                                        {
                                                    ?>
                                                    <!--<a href="javascript:void(0)" onclick="purchasereturnfun('<?= $stvl->pm_purchaseid ?>', '<?= $stvl->pm_purchaseno ?>', '<?= $stvl->pm_paidamount ?>')" class="text-secondary"><i class="fas fa-undo"></i> Full Return</a>-->  
                                                    

                                                    <a href="<?= base_url() ?>rawmaterial/dashboard/<?= $type ?>/<?= $stvl->pm_purchaseid ?>"  class="text-info"><i class="fas fa-edit"></i> Edit</a>
                                                    <?php } ?> <br/>
                                                    <?php 
                                                    if($type == 0)
                                                    {
                                                    ?>
                                                    <a href="<?= base_url() ?>rawmaterial/dashboard/0/<?= $stvl->pm_purchaseid ?>/1" class="text-secondary"><i class="fas fa-undo"></i> Return</a>
                                                    <?php 
                                                    }
                                                    }else{
                                                        echo "<br/> <i>(Returned)</i>";
                                                    }
                                                    if($type == 0)
                                                    {
                                                    ?>

                                                    &nbsp;
                                                    <a href="javascript:void(0)" onclick="viewpurchasedetails('<?= $stvl->pm_purchaseid ?>')" class="text-info"><i class="fas fa-eye"></i> View</a>
                                                    <?php 
                                                    }
                                                    if($type == 1)
                                                    {
                                                        if($stvl->pm_postatus == 1)
                                                        {
                                                            echo "<i>(Order Confirmed)</i>";
                                                        }else{
                                                    ?>
                                                    <a href="<?= base_url() ?>rawmaterial/confirmdashboard/0/<?= $stvl->pm_purchaseid ?>" class="text-secondary"><i class="fas fa-comment"></i> Confirm Order</a>
                                                    <?php 
                                                        }
                                                    }
                                                    ?>
                                                    <!--&nbsp;
                                                    <a href="#" onclick="return confirm('Are you sure?')" class="text-danger"><i class="fas fa-trash"></i> Delete</a>-->
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

    <!-- View modal content -->
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

        <!-- Return modal content -->
        <div id="purreturnmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Purchase Return (Bill No: <span id="purchnodiv"></span>)</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <form action="<?php echo base_url(); ?>purchase/returnpurchase" name="addingform" id="addingform" class="addformvalidate" method="post">
                        <input type="hidden" name="returnbillid" id="returnbillid">
                    <div class="modal-body">
                       
                       <div class="row">
                        <div class="col-md-4">
                            Returned On
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="returndate" id="returndate" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-3">
                            <input type="time" class="form-control" name="returntime" id="returntime" value="<?= date('H:i') ?>">
                        </div>
                       </div>

                       <div class="row mt-3">
                        <div class="col-md-4">
                            Return Paid Amount
                        </div>
                        <div class="col-md-3">
                            <select class="w-100 form-control" name="paymethod" id="paymethod">
                                <option value="4">Cash</option>
                                <option value="3">Bank</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" step="any" class="form-control" name="returnpaidamount" id="returnpaidamount" >
                        </div>
                        
                       </div>

                       <div class="row mt-3">
                        <div class="col-md-4">
                            Return Comments
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" required="required" name="returncomments" id="returncomments"></textarea>
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