
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
                            <a href="<?= base_url() ?>sale/csvsalehistory/<?= $type ?>/<?= $godownid ?>/<?= $salesperson ?>/<?= $customer ?>/<?= $fromdate ?>/<?= $todate ?>" target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-file-excel"></i> Export to CSV</button>
                            </a> 

                             <a href="<?= base_url() ?>sale/printsalehistory/<?= $type ?>/<?= $godownid ?>/<?= $salesperson ?>/<?= $customer ?>/<?= $fromdate ?>/<?= $todate ?>" target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-print"></i> Print</button>
                            </a>  

                            <a href="<?= base_url() ?>sale/dashboard/<?= $type ?>" class="ms-1 finyearaddbutton">
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
                                <?php 
                                if($inventorysettings)
                                {
                                    if($inventorysettings->is_godown == 1)
                                    {
                                ?>
                                <div class="col-md-2">
                                    Select Godown:
                                    <select name="godownid" id="godownid" required="required" class="w-100 inputfieldcss pagesearchselect" data-toggle="select2">
                                        <option <?php if($godownid=='0'){ echo "selected"; }  ?> value="0">All</option>
                                        <?php 
                                        if($godowns)
                                        {
                                            foreach($godowns as $gdvl)
                                            {
                                                ?>
                                                <option <?php if($godownid==$gdvl->gd_godownid){ echo "selected"; }  ?> value="<?= $gdvl->gd_godownid ?>"><?= $gdvl->gd_godownname ?> (<?= $gdvl->gd_godowncode ?>)</option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php
                                    }
                                }
                                ?>
                                <div class="col-md-2">
                                    Select Sales Person:
                                    <select class="w-100 inputfieldcss pagesearchselect" data-toggle="select2" name="salesperson" id="salesperson">
                                        <option <?php if($salesperson == 'all'){ echo "selected"; } ?> value="all">All</option>
                                        <?php 
                                        if($userlist)
                                        {
                                            foreach($userlist as $usrvl)
                                            {
                                                ?>
                                                <option <?php if($salesperson == $usrvl->at_authid){ echo "selected"; } ?> value="<?= $usrvl->at_authid ?>"><?= $usrvl->at_name ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    Select Customer:
                                    <select class="w-100 inputfieldcss pagesearchselect" data-toggle="select2" name="customer" id="customer">
                                        <option <?php if($customer == 'all'){ echo "selected"; } ?> value="all">All</option>
                                        <option <?php if($customer == '0'){ echo "selected"; } ?> value="0">Walk in Customers</option>
                                        <?php 
                                        if($customers)
                                        {
                                            foreach($customers as $cstvl)
                                            {
                                                ?>
                                                <option <?php if($customer == $cstvl->ct_cstomerid){ echo "selected"; } ?> value="<?= $cstvl->ct_cstomerid ?>"><?= $cstvl->ct_name ?> (<?= $cstvl->ct_address ?>)</option>
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
                                    if($('#godownid').val())
                                    {
                                        var godownid = $('#godownid').val();
                                    }
                                    else{
                                        var godownid = 0;
                                    }
                                    var salesperson = $('#salesperson').val();
                                    var customer = $('#customer').val();
                                    var fromdate = $('#fromdate').val();
                                    var todate = $('#todate').val();
                                    window.location.href= '<?= base_url() ?>sale/salehistory/<?= $type ?>/'+godownid+'/'+salesperson+'/'+customer+'/'+fromdate+'/'+todate;
                                }
                            </script>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>BillNo</th>
                                        <th>Bill Date</th>
                                        <th>Customer</th>
                                        <!--<th>Phone</th>-->
                                        <th>Items</th>
                                        <th>Total</th>
                                        <?php 
                                        if($type != 3){
                                        ?>
                                        <th>Discount</th>
                                        <?php 
                                        }
                                        ?>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    $alltotalamount =0;
                                    $alldiscount = 0;
                                    if($retaillist)
                                    {
                                        $k=1;
                                        foreach($retaillist as $stvl)
                                        {
                                            $alltotalamount+= $stvl->rb_grandtotal;
                                            $alldiscount+= $stvl->rb_discount;
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->rb_billprefix ?><?= $stvl->rb_billno ?></td>
                                                <td><?= date('d-M-Y', strtotime($stvl->rb_date)) ?> <?= date('H:i', strtotime($stvl->rb_time)) ?></td>
                                                <td>
                                                    <?php 
                                                if($stvl->rb_existcustomer == 1)
                                                {
                                                    $custdet = $this->cstmr->getcustomerdetailsbyid($stvl->rb_customerid);
                                                    echo $custdet->ct_name;
                                                    $phone = $custdet->ct_phone;
                                                }else{
                                                echo $stvl->rb_customername;
                                                $phone = $stvl->rb_phone;
                                                
                                                }
                                                ?>
                                                </td>
                                                <!--<td><?= $phone ?></td>-->
                                                <td><a href="javascript:void(0)" onclick="viewbillitemfun('<?= $stvl->rb_retailbillid ?>')" class="text-primary"><i class="fas fa-eye"></i> View</a></td>
                                                <td><?= price_roundof($stvl->rb_grandtotal) ?></td>
                                                <?php 
                                                if($type != 3){
                                                ?>
                                                <td><?= price_roundof($stvl->rb_discount) ?></td>
                                                <?php 
                                                }
                                                ?>
                                                <td>
                                                    <a href="<?= base_url() ?>sale/saleprint/<?= $stvl->rb_retailbillid ?>/0/<?= $stvl->rb_billingtype ?>/<?= $stvl->rb_pagesize ?>" target="_blank" class="text-primary"><i class="fas fa-print"></i> Print</a> 

                                                    <?php 
                                                    /*if($type != 3)
                                                    {*/
                                                    ?>
                                                    
                                                    
                                                    <?php 
                                                    if($type == 0 || $type == 1 || $type == 7 || $type == 8)
                                                    {
                                                        if($stvl->rb_partialreturn == 0)
                                                        {
                                                            if($dupprint == 1)
                                                            {
                                                                ?>
                                                                &nbsp; <a href="<?= base_url() ?>sale/saleprintdup/<?= $stvl->rb_retailbillid ?>/0/<?= $stvl->rb_billingtype ?>/<?= $stvl->rb_pagesize ?>/1" target="_blank" class="text-primary"><i class="fas fa-print"></i> Dup Print</a> 
                                                                <?php
                                                            }
                                                            if($tripprint == 1)
                                                            {
                                                                ?>
                                                                &nbsp; <a href="<?= base_url() ?>sale/saleprintdup/<?= $stvl->rb_retailbillid ?>/0/<?= $stvl->rb_billingtype ?>/<?= $stvl->rb_pagesize ?>/2" target="_blank" class="text-primary"><i class="fas fa-print"></i> Trip Print</a> 
                                                                <?php
                                                            }
                                                    ?>
                                                    <br/>
                                                    <a href="<?= base_url() ?>sale/dashboard/<?= $type ?>/<?= $stvl->rb_retailbillid ?>"  class="text-info"><i class="fas fa-edit"></i> Edit</a> &nbsp;
                                                    
                                                    <a href="<?= base_url() ?>sale/dashboardreturn/<?= $type ?>/<?= $stvl->rb_retailbillid ?>/1" class="text-secondary"><i class="fas fa-undo"></i> Return</a>
                                                    <?php 
                                                        }else{
                                                            echo "(Returned)";
                                                        }
                                                    }else{
                                                        
                                                        if($stvl->rb_orderstatus == 1)
                                                        {
                                                            echo "<br/><i>(Order Confirmed)</i>";
                                                        }else{
                                                    ?>
                                                    <a href="<?= base_url() ?>sale/dashboard/<?= $type ?>/<?= $stvl->rb_retailbillid ?>"  class="text-info"><i class="fas fa-edit"></i> Edit</a> 
                                                    <br/>
                                                    <a href="<?= base_url() ?>sale/confirmdashboard/<?= $type ?>/<?= $stvl->rb_retailbillid ?>" class="text-secondary"><i class="fas fa-comment"></i> Confirm Order</a>
                                                    <?php 
                                                        }
                                                    }
                                                    //}
                                                    ?>
                                                    &nbsp;<a href="javascript:void(0)" onclick="viewfullsaledetails('<?= $stvl->rb_retailbillid ?>')" class="text-warning"><i class="fas fa-eye"></i> View</a>

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
                                        <th><?= price_roundof($alltotalamount) ?></th>
                                        <?php 
                                        if($type != 3){
                                        ?>
                                        <th><?= price_roundof($alldiscount) ?></th>
                                        <?php 
                                        }
                                        ?>
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
          url: '<?php echo site_url('sale/getbillitemdetails') ?>',
          type: 'POST',
          dataType: 'html',
          data: {billid: billid, type: <?= $type ?>},
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