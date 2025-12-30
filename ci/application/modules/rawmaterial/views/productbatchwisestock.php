
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

                            <a href="<?= base_url() ?>rawmaterial/productbatchwisestock/<?= $godownid ?>/<?= $categoryid ?>/1"  target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-print"></i> Print</button>
                            </a>
                            
                            <a href="<?= base_url() ?>rawmaterial/addrawmaterial" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Raw Material</button>
                            </a>

                            <a href="<?= base_url() ?>rawmaterial/dashboard" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Purchase Material</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Raw Material Stock</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <?php 
                            if($inventorysettings)
                            {
                                if($inventorysettings->is_batchwise == 1)
                                {
                            ?>
                            <div class="mb-3">

                            <div class="row">
                                <div class="col-12">
                                    <a href="<?= base_url() ?>rawmaterial/productbatchwisestock/1" class="btn btn-primary" data-toggle="tab">Batch Wise Report</a>

                                    <a href="<?= base_url() ?>rawmaterial/productstocks/0" class="btn btn-light " data-toggle="tab">Material Stock</a>

                                    
                                </div>
                            </div>
                            
                            </div>
                            <?php 
                                }
                                ?>
                            <div class="row mb-2">
                                <?php
                                $fltrval = 0;
                                if($inventorysettings->is_godown == 1)
                                {
                                    $fltrval = 1;
                                    ?>
                                <div class="col-md-3">
                                    Select Godown/Department:
                                    <select class="form-control" name="godownid" id="godownid">
                                        <option <?php if($godownid == 0){ ?> selected <?php  } ?> value="0">All</option>
                                        <?php 
                                        if($godowns)
                                        {
                                            foreach($godowns as $gdval)
                                            {
                                                ?>
                                                <option <?php if($godownid == $gdval->gd_godownid){ ?> selected <?php  } ?> value="<?= $gdval->gd_godownid ?>"><?= $gdval->gd_godownname ?>(<?= $gdval->gd_godowncode ?>)</option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                    <?php
                                }else{
                                    ?>
                                    <input type="hidden" name="godownid" id="godownid" value="0">
                                    <?php
                                }
                                if($inventorysettings->is_categorywise == 1)
                                {
                                    $fltrval = 1;
                            ?>
                                <div class="col-md-3">
                                    Select Category:
                                    <select class="form-control" name="categoryid" id="categoryid">
                                        <option <?php if($categoryid == 0){ ?> selected <?php  } ?> value="0">All</option>
                                        <?php 
                                        if($categories)
                                        {
                                            foreach($categories as $ctval)
                                            {
                                                ?>
                                                <option <?php if($categoryid == $ctval->pc_productcategoryid){ ?> selected <?php  } ?> value="<?= $ctval->pc_productcategoryid ?>"><?= $ctval->pc_categoryname ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php 
                                }else{
                                    ?>
                                    <input type="hidden" name="categoryid" id="categoryid" value="0">
                                    <?php
                                }
                                if($fltrval == 1)
                                {
                                ?>
                                <div class="col-md-2">
                                    <button type="button" onclick="filterproducthistory()" class="btn btn-blue" style="margin-top: 20px;">Filter</button>
                                </div>
                            

                            <script type="text/javascript">
                                function filterproducthistory()
                                {
                                    var godownid = $('#godownid').val();
                                    var categoryid = $('#categoryid').val();
                                    window.location.href= '<?= base_url() ?>rawmaterial/productbatchwisestock/'+godownid+'/'+categoryid;
                                }
                            </script>
                            <?php 
                                }
                            ?>

                            
                            </div>
                                <?php
                            }
                            ?>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Product</th>
                                        <!--<th>Category</th>-->
                                        <th>Unit</th>
                                        <th>Batch No</th>
                                        <th>Expiry Date</th>
                                        <!--<th>GST</th>
                                        <th>CESS</th>-->
                                        <th>MRP</th>
                                        <th>Purchase Price</th>
                                        <th>Avail Stock</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    $totalstockamnt = 0;
                                    if($productlist)
                                    {
                                        $k=1;
                                        foreach($productlist as $stvl)
                                        {
                                            ?>
                                            <tr <?php if($stvl->pt_stock <= 0){ ?> style="background-color: #fad2d2;" <?php } ?>>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->pd_productcode ?></td>
                                                <td>
                                                     <?php 
                                                if($inventorysettings)
                                                {
                                                    if($inventorysettings->is_image == 1)
                                                    {
                                                ?>
                                                    <img src="<?= base_url() ?>uploads/products/<?= $stvl->pd_prodimage ?>" onerror="this.onerror=null;this.src='<?= base_url() ?>components/images/no-item.png';" class="listpageprdimg">
                                                    <?php 
                                                    }
                                                }
                                                    ?>
                                                    <?= $stvl->pd_productname ?> <?= $stvl->pd_size ?> <?= $stvl->pd_brand ?>
                                                </td>
                                                <!--<td><?= $stvl->pc_categoryname ?></td>-->
                                                <td><?= $stvl->un_unitname ?></td>
                                                <td><?= $stvl->pt_batchno ?></td>
                                                <td><?= date('d-M-Y', strtotime($stvl->pt_expirydate)) ?></td>
                                               <!-- <td><?= $stvl->pd_hsnno ?></td>
                                                <td><?= $stvl->tb_taxband ?></td>
                                                <td><?= $stvl->pd_cess ?></td>-->
                                                <td><?= $stvl->pt_mrp ?></td>
                                                <td><?php  
                                                echo $purchasrate = price_roundof($stvl->pt_purchaseprice + ($stvl->pt_purchaseprice * $stvl->tb_tax)/100);
                                                ?></td>
                                                <td>
                                                    <?= $stvl->pt_stock ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    echo $totalprice = price_roundof($purchasrate * $stvl->pt_stock);
                                                    $totalstockamnt = $totalstockamnt + $totalprice;
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $k++;
                                        }
                                    }
                                    ?>
                                    

                                </tbody>
                                <tfoot>
                                    <th colspan="5">Total Stock Amount</th>
                                    <th colspan="5"><?= $totalstockamnt ?></th>
                                </tfoot>
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