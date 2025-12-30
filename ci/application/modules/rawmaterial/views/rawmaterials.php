
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
                            
                            
                            <a href="<?= base_url() ?>rawmaterial/addrawmaterial" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Material</button>
                            </a>
                                
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
                            <div class="mb-3">

                            <div class="row">
                                <div class="col-6">
                                    <a href="<?= base_url() ?>rawmaterial/rawmateriallist/0" class="btn <?php if($active == '0'){ echo "btn-primary"; }else{ echo "btn-light"; } ?> " data-toggle="tab">Active Materials</a>

                                    <a href="<?= base_url() ?>rawmaterial/rawmateriallist/1" class="btn <?php if($active == '1'){ echo "btn-primary"; }else{ echo "btn-light"; } ?>" data-toggle="tab">Deleted Materials</a>
                                </div>
                                <div class="col-6" align="right">
                                    <!--<a href="<?php echo base_url(); ?>inventory/csvproductexport/<?php echo $active; ?>" target="_blank" class="ms-1">
                                        <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-file-excel"></i> Export Products to CSV</button>
                                    </a>-->
                                </div>
                            </div>
                            
                            </div>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Material</th>
                                        <?php 
                                        if($inventorysettings)
                                        {
                                            if($inventorysettings->is_categorywise == 1)
                                            {
                                        ?>
                                        <th>Category</th>
                                        <?php 
                                            }
                                        }
                                        ?>
                                        <th>Unit</th>
                                        <?php 
                                        if($inventorysettings)
                                        {
                                            if($inventorysettings->is_hsn == 1)
                                            {
                                        ?>
                                        <th>HSN</th>
                                        <?php 
                                            }
                                        }
                                        ?>
                                        <th><?= $this->isvatgstname ?></th>
                                        <th>CESS</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($productlist)
                                    {
                                        $k=1;
                                        foreach($productlist as $stvl)
                                        {
                                            ?>
                                            <tr>
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
                                                    <?= $stvl->pd_productname ?> <?= $stvl->pd_size ?> <?= $stvl->pd_brand ?></td>
                                                <?php 
                                                if($inventorysettings)
                                                {
                                                    if($inventorysettings->is_categorywise == 1)
                                                    {
                                                ?>
                                                <td><?= $stvl->pc_categoryname ?></td>
                                                <?php 
                                                    }
                                                }
                                                ?>
                                                <td><?= $stvl->un_unitname ?></td>
                                                <?php 
                                                if($inventorysettings)
                                                {
                                                    if($inventorysettings->is_hsn == 1)
                                                    {
                                                ?>
                                                <td><?= $stvl->pd_hsnno ?></td>
                                                <?php 
                                                    }
                                                }
                                                ?>
                                                <td><?= $stvl->tb_taxband ?></td>
                                                <td><?= $stvl->pd_cess ?></td>
                                                <td>
                                                   
                                                    <?php if($stvl->pd_isactive): ?>
                                                        <a href="<?php echo site_url('rawmaterial/enabledisablematerial/' . $stvl->pd_productid); ?>" class="text-success" onclick="return confirm('Are you sure?')"><i class="fas fa-check"></i> Enable</a>
                                                        <?php else: ?>
                                                        <a class="text-primary" href="<?php echo site_url('rawmaterial/addrawmaterial/' . $stvl->pd_productid); ?>"><i class="fas fa-pen"></i> Edit</a>
                                                    &nbsp;
                                                        <a href="<?php echo site_url('rawmaterial/enabledisablematerial/' . $stvl->pd_productid .'/1'); ?>" onclick="return confirm('Are you sure?')" class="ml-2 text-danger"><i class="fas fa-times"></i> Disable</a>
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

    <!-- import modal content -->
        <div id="importformmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Import Products</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?php echo base_url(); ?>inventory/importproducts" name="importform" id="importform" class="addformvalidate" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="editid" id="editid">

                    <div class="modal-body">
                        <input type="file" class="form-control" name="productcsv" id="productcsv">

                        <div class="mt-2">
                            .csv file upto 5mb (<a href="<?= base_url() ?>components/productimport.csv" target="_blank"><i class="fas fa-download"></i>download sample file</a>)
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light listbtns" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-blue listbtns">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    
    <script type="text/javascript">
    function importproductfun()
    {
        $('#importformmodal').modal('show');
    }
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

    function groupcreateselect(val)
    {
        if(val == '1')
        {
            $('#maingroupdiv').show();
        }else{
            $('#maingroupdiv').hide();
        }
    }

    function editdetailsfun(prdid)
    {
        $.ajax({
          url: '<?php echo site_url('inventory/getproductdetails') ?>',
          type: 'POST',
          dataType: 'JSON',
          data: {prdctid: prdid},
        })
        .done(function(result) {
          // console.log("success");
          $('#standard-modalLabel').html('Update Category');
          $('#editid').val(result.pc_productcategoryid);
          $("#categoryname").val(result.pc_categoryname);
          //$("#taxvalue").val(result.tb_tax);
          if(result.pc_issub == 0)
          {
            $("#maincheck").prop("checked", true);
            $("#subcheck").button("refresh");
            $("#maincheck").button("refresh");

            $('#maingroupdiv').hide();
          }
          else{
            $("#maincheck").prop("checked", false);
            $("#subcheck").attr('checked', 'checked');

            $("#subcheck").button("refresh");
            $("#maincheck").button("refresh");

            $("#maincategoryid").val(result.pc_maincategoryid);
            $('#maingroupdiv').show();
          }

          
            $("#notes").val(result.pc_description);

            $("#addformmodal").modal('show');

        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    }
    
    
</script>