
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
                            
                            <!--<a href="<?= base_url() ?>inventory/addproduct" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Product</button>
                            </a>--->

                            <a href="<?= base_url() ?>inventory/productutilization" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-backward"></i> Back</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Products Utilization History</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <table class="table w-100 borderless" style="margin-bottom: 0px;">
                                <tr>
                                    <td>Product Code </td>
                                    <td><b>: <?= $productdet->pd_productcode ?></b></td>
                                
                                    <td>Product Name</td>
                                    <td><b>: <?= $productdet->pd_productname . " " . $productdet->pd_size . " " . $productdet->pd_brand ?></b></td>
                                
                                    <td>HSN</td>
                                    <td><b>: <?= $productdet->pd_hsnno ?></b></td>
                                
                                    <td>Current Stock</td>
                                    <td><b>: <?= $productdet->pd_stock ?></b></td>
                                </tr>
                            </table>
                        </div>
                    </div>

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
                                    <button type="button" onclick="filterproducthistory()" class="btn btn-blue" style="margin-top: 20px;">Filter</button>
                                </div>
                            </div>

                            <script type="text/javascript">
                                function filterproducthistory()
                                {
                                    var fromdate = $('#fromdate').val();
                                    var todate = $('#todate').val();
                                    window.location.href= '<?= base_url() ?>inventory/productutilizehistory/<?= $productid ?>/'+fromdate+'/'+todate;
                                }
                            </script>

                            <?php 
                            $prdcthistory = array();
                            if($purchasehistory)
                            {
                                foreach($purchasehistory as $purval)
                                {
                                    $prdcthistory[] = array('date' => $purval->pm_date, 'time' => $purval->pm_time, 'type' => 1, 'billid' => $purval->pm_purchaseid, 'saletype' => 0, 'prefix' => $purval->pm_purchaseprefix, 'billno' => $purval->pm_purchaseno, 'qty' => $purval->ps_qty);
                                }
                            }
                            if($salehistory)
                            {
                                foreach($salehistory as $purval)
                                {
                                    $prdcthistory[] = array('date' => $purval->rb_date, 'time' => $purval->rb_time, 'type' => 2, 'billid' => $purval->rb_retailbillid, 'saletype' => $purval->rbs_type, 'prefix' => $purval->rb_billprefix, 'billno' => $purval->rb_billno, 'qty' => $purval->rbs_qty);
                                }
                            }
                            ?>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Qty</th>
                                        <th>Bill No</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php
                                    
                                    if(!empty($prdcthistory))
                                    {
                                        usort($prdcthistory, function($a, $b) { 
                                          return strtotime($a['date']) - strtotime($b['date']); 
                                        });
                                        
                                        $k=1;
                                        foreach($prdcthistory as $stvl)
                                        {
                                            ?>
                                            <tr <?php if($stvl['type'] == 1){ ?> style="background-color: #b0f6af;" <?php } ?>>
                                                <td><?= $k ?></td>
                                                <td><?= date('d-M-Y', strtotime($stvl['date'])) ?> <?= date('H:i', strtotime($stvl['time'])) ?></td>
                                                <td><?php 
                                                if($stvl['type'] == 1)
                                                {
                                                    echo "Purchase";
                                                }else{
                                                    echo "Sale";
                                                    if($stvl['saletype'] == 0)
                                                    {
                                                        echo " (Retail)";
                                                    }else{
                                                        echo " (Wholesale)";
                                                    }
                                                }
                                                ?></td>
                                                <td><?= $stvl['qty'] ?></td>
                                                <td><?= $stvl['prefix'] ?> <?= $stvl['billno'] ?></td>
                                               
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
        <div id="addformmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Add Category</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?php echo base_url(); ?>inventory/addingcategory" name="addingform" id="addingform" class="addformvalidate" method="post">
                        <input type="hidden" name="editid" id="editid">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-check-label" for="customRadio1"><input type="radio" id="customRadio1" onclick="groupcreateselect('0')" value="0" checked="checked" name="issubgroup" id="maincheck" class="form-check-input"> Create Main Category</label>
                                    &nbsp; &nbsp;
                                    <label class="form-check-label" for="customRadio2"><input type="radio" id="customRadio2" onclick="groupcreateselect('1')" value="1" name="issubgroup" id="subcheck" class="form-check-input"> Create Sub Category</label>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="maingroupdiv" style="display: none;">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Select Main Category</label>
                                    <select class="form-control searchselect" name="maincategoryid" id="maincategoryid" data-toggle="select2" data-width="100%">
                                        <?php 
                                    if($maincategories)
                                    {
                                        $k=1;
                                        foreach($maincategories as $bvl)
                                        {
                                            ?>
                                            <option value="<?= $bvl->pc_productcategoryid ?>"><?= $bvl->pc_categoryname ?></option>
                                            <?php
                                        }
                                    }
                                            ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Category Name</label>
                                    <input type="text" name="categoryname" required class="form-control" id="categoryname" placeholder="Category Name">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-7" class="form-label">Description</label>
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
    function additemfun()
    {
        $('#standard-modalLabel').html('Add New Category');
        $('#editid').val("");
        $("#categoryname").val("");
        $("#maincheck").prop("checked", true);
        $('#maingroupdiv').hide();
        $("#notes").val("");
        $('#addformmodal').modal('show');
    }

</script>