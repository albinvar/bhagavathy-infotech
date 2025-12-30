
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
                            
                            <a href="javascript:void(0)" onclick="additemfun()" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Category</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Material Categories</h4>
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
                                        <th>Category Name</th>
                                        <th>Main Category</th>
                                        <th>Import Id</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($categories)
                                    {
                                        $k=1;
                                        foreach($categories as $stvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->pc_categoryname ?></td>
                                                <td>
                                                    <?php 
                                                    if($stvl->pc_issub == '0')
                                                    {
                                                        ?>
                                                        <span class="badge bg-primary">Main</span>
                                                        <?php
                                                    }else{
                                                        $mmaincat = $this->prdcat->getrowbyid($stvl->pc_maincategoryid);
                                                        if($mmaincat)
                                                        {
                                                            echo $mmaincat->pc_categoryname;
                                                        }
                                                    }
                                                    ?>
                                                    </td>
                                                <td><?= $stvl->pc_productcategoryid ?></td>
                                                <td><?= $stvl->pc_description ?></td>
                                                <td>
                                                    <!--<a class="text-primary" href="javascript:void(0)" onclick="editdetailsfun('<?= $stvl->pc_productcategoryid ?>')"><i class="fas fa-pen"></i> Edit</a>-->
                                                    &nbsp;
                                                    <?php if($stvl->pc_isactive): ?>
                                                        <a href="<?php echo site_url('rawmaterial/enabledisablecategory/' . $stvl->pc_productcategoryid); ?>" class="text-success" onclick="return confirm('Are you sure?')"><i class="fas fa-check"></i> Enable</a>
                                                        <?php else: ?>
                                                        <a href="<?php echo site_url('rawmaterial/enabledisablecategory/' . $stvl->pc_productcategoryid .'/1'); ?>" onclick="return confirm('Are you sure?')" class="ml-2 text-danger"><i class="fas fa-times"></i> Disable</a>
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

                    <form action="<?php echo base_url(); ?>rawmaterial/addingcategory" name="addingform" id="addingform" class="addformvalidate" method="post">
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

    function groupcreateselect(val)
    {
        if(val == '1')
        {
            $('#maingroupdiv').show();
        }else{
            $('#maingroupdiv').hide();
        }
    }

    function editdetailsfun(catid)
    {
        $.ajax({
          url: '<?php echo site_url('rawmaterial/getcategorydetails') ?>',
          type: 'POST',
          dataType: 'JSON',
          data: {catid: catid},
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