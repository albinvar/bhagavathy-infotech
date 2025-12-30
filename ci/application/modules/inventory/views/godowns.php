
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
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New <?= $title ?></button>
                            </a>
                                
                        </div>
                        <h4 class="page-title"><?= $title ?>s</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="mb-3">

                <div class="row">
                    <div class="col-6">
                        <a href="<?= base_url() ?>inventory/godowns/0" class="btn <?php if($type == '0'){ echo "btn-primary"; }else{ echo "btn-light"; } ?> " data-toggle="tab">Godowns</a>

                        <a href="<?= base_url() ?>inventory/godowns/1" class="btn <?php if($type == '1'){ echo "btn-primary"; }else{ echo "btn-light"; } ?>" data-toggle="tab">Departments</a>
                    </div>
                    <div class="col-6" align="right">
                        <!--<a href="<?php echo base_url(); ?>inventory/csvproductexport/<?php echo $active; ?>" target="_blank" class="ms-1">
                            <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-file-excel"></i> Export Products to CSV</button>
                        </a>-->
                    </div>
                </div>
                
                </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th><?= $title ?> Name</th>
                                        <th>Address</th>
                                        <th>Racks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($godowns)
                                    {
                                        $k=1;
                                        foreach($godowns as $stvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->gd_godowncode ?></td>
                                                <td><?= $stvl->gd_godownname ?></td>
                                                <td><?= $stvl->gd_address ?></td>
                                                <td><?= $stvl->gd_racknumbers ?></td>
                                                <td>
                                                    <!--<a class="text-primary" href="javascript:void(0)" onclick="editdetailsfun('<?= $stvl->gd_godownid ?>')"><i class="fas fa-pen"></i> Edit</a>-->
                                                    &nbsp;
                                                    <?php if($stvl->gd_isactive): ?>
                                                        <a href="<?php echo site_url('inventory/enabledisablegodown/' . $stvl->gd_godownid); ?>" class="text-success" onclick="return confirm('Are you sure?')"><i class="fas fa-check"></i> Enable</a>
                                                        <?php else: ?>
                                                        <a href="<?php echo site_url('inventory/enabledisablegodown/' . $stvl->gd_godownid .'/1'); ?>" onclick="return confirm('Are you sure?')" class="ml-2 text-danger"><i class="fas fa-times"></i> Disable</a>
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Add <?= $title ?></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?php echo base_url(); ?>inventory/addinggodown" name="addingform" id="addingform" class="addformvalidate" method="post">
                        <input type="hidden" name="editid" id="editid">
                        <input type="hidden" name="type" id="type" value="<?= $type ?>">

                    <div class="modal-body">

                       <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label"><?= $title ?> Code</label>
                                    <input type="text" name="code" required class="form-control" id="code" placeholder="<?= $title ?> Code">
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label"><?= $title ?> Name</label>
                                    <input type="text" name="godownname" required class="form-control" id="godownname" placeholder="<?= $title ?> Name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" id="address" placeholder="Address">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Rack Numbers</label>
                                    <input type="number" name="racknumbers" class="form-control" value="0" id="racknumbers">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Gate Pass Required?</label>
                                    <div class="form-group ">
                                        <label><input type="radio" name="gatepass" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" name="gatepass" value="0"> No</label>
                                    </div>

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
        $('#standard-modalLabel').html('Add New Godown');
        $('#editid').val("");
        /*$("#categoryname").val("");
        $("#maincheck").prop("checked", true);
        $('#maingroupdiv').hide();
        $("#notes").val("");*/
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
          url: '<?php echo site_url('inventory/getcategorydetails') ?>',
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