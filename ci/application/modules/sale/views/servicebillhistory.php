
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
                            
                            <a href="<?= base_url() ?>sale/servicebill" class="ms-1 finyearaddbutton">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add <?= $title ?></button>
                            </a>
                            
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

                            <div class="row mb-2">
                                <div class="col-md-2">
                                    From Date:
                                    <input type="date" class="form-control" name="fromdate" id="fromdate" value="<?= $fromdate ?>">
                                </div>
                                <div class="col-md-2">
                                    To Date:
                                    <input type="date" class="form-control" name="todate" id="todate" value="<?= $todate ?>">
                                </div>
                                <div class="col-md-3">
                                    Customer:
                                    <select class="form-control" name="customerid" id="customerid">
                                        <option value="0">All Customers</option>
                                        <?php
                                        if($customerlist)
                                        {
                                            foreach($customerlist as $cstvl)
                                            {
                                                $selected = ($customerid == $cstvl->ct_cstomerid) ? 'selected' : '';
                                                ?>
                                                <option value="<?= $cstvl->ct_cstomerid ?>" <?= $selected ?>><?= $cstvl->ct_name ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" onclick="filterstockfun()" class="btn btn-blue" style="margin-top: 20px;">Filter</button>
                                    <?php if($retaillist && count($retaillist) > 0): ?>
                                    <button type="button" onclick="printAllBills()" class="btn btn-<?= ($customerid > 0) ? 'success' : 'secondary' ?>" style="margin-top: 20px; margin-left: 5px;">
                                        <i class="fas fa-print"></i> Print All (<?= count($retaillist) ?>)
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <script type="text/javascript">
                                function filterstockfun()
                                {
                                    var fromdate = $('#fromdate').val();
                                    var todate = $('#todate').val();
                                    var customerid = $('#customerid').val();
                                    window.location.href= '<?= base_url() ?>sale/servicebillhistory/'+fromdate+'/'+todate+'/'+customerid;
                                }

                                function printAllBills()
                                {
                                    var fromdate = $('#fromdate').val();
                                    var todate = $('#todate').val();
                                    var customerid = $('#customerid').val();
                                    window.open('<?= base_url() ?>sale/servicebillprintall/'+fromdate+'/'+todate+'/'+customerid, '_blank');
                                }
                            </script>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>BillNo</th>
                                        <th>Bill Date</th>
                                        <th>Customer</th>
                                        <th>Phone</th>
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
                                    if($retaillist)
                                    {
                                        $k=1;
                                        foreach($retaillist as $stvl)
                                        {
                                            $alltotalamount+= $stvl->sb_grandtotal;
                                            $allfreight+= $stvl->sb_freight;
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->sb_billno ?></td>
                                                <td><?= date('d-M-Y', strtotime($stvl->sb_date)) ?> <?= date('H:i', strtotime($stvl->sb_time)) ?></td>
                                                <td>
                                                    <?php 
                                                
                                                echo $stvl->sb_customername;
                                                ?>
                                                </td>
                                                <td><?= $stvl->sb_phone ?></td>
                                                <td><a href="javascript:void(0)" onclick="viewbillitemfun('<?= $stvl->sb_servicebillid ?>')" class="text-primary"><i class="fas fa-eye"></i> View</a></td>
                                                <td><?= $stvl->sb_freight ?></td>
                                                <td><?= $stvl->sb_grandtotal ?></td>
                                                <td>
                                                    <a href="<?= base_url() ?>sale/servicebillprint/<?= $stvl->sb_servicebillid ?>/0" target="_blank" class="text-primary"><i class="fas fa-print"></i> Print</a> &nbsp;
                                                    <a href="#" onclick="return confirm('Are you sure?')" class="text-danger"><i class="fas fa-trash"></i> Delete</a>
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
                                        <th><?= $allfreight ?></th>
                                        <th><?= $alltotalamount ?></th>
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
          url: '<?php echo site_url('sale/getservicebillitemdetails') ?>',
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