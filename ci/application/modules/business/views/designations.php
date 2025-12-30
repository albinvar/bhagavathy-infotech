
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
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Designation</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Designations</h4>
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
                                        <th>Designation</th>
                                        <th>Notes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($designations)
                                    {
                                        $k=1;
                                        foreach($designations as $stvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->ut_usertype ?></td>
                                                <td><?= $stvl->ut_notes ?></td>
                                                <td>
                                                    <a class="text-primary" href="javascript:void(0)" onclick="editdetailsfun('<?= $stvl->ut_usertypeid ?>')"><i class="fas fa-pen"></i> Edit</a>
                                                    &nbsp;
                                                    <?php if($stvl->ut_isactive): ?>
                                                        <a href="<?php echo site_url('business/enabledisabledesignation/' . $stvl->ut_usertypeid); ?>" class="text-success" onclick="return confirm('Are you sure?')"><i class="fas fa-check"></i> Enable</a>
                                                        <?php else: ?>
                                                        <a href="<?php echo site_url('business/enabledisabledesignation/' . $stvl->ut_usertypeid .'/1'); ?>" onclick="return confirm('Are you sure?')" class="ml-2 text-danger"><i class="fas fa-times"></i> Disable</a>
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
                        <h4 class="modal-title" id="standard-modalLabel">Add New Designation</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?php echo base_url(); ?>business/addingdesignation" name="addingform" id="addingform" class="addformvalidate" method="post">
                        <input type="hidden" name="editid" id="editid">

                    <div class="modal-body">

                    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Designation</label>
                                    <input type="text" name="designation" required class="form-control" id="designationval" placeholder="Designation">
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-7" class="form-label">Notes</label>
                                    <textarea class="form-control" id="notesval" name="notes" placeholder="Notes"></textarea>
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
        $('#editid').val("");
        $("#designationval").val("");
        $('#standard-modalLabel').html('Add New Designation');
        $("#notesval").val("");
        $('#addformmodal').modal('show');
    }

    function editdetailsfun(typeid)
    {
        $.ajax({
          url: '<?php echo site_url('business/getdesignationdetails') ?>',
          type: 'POST',
          dataType: 'JSON',
          data: {typeid: typeid},
        })
        .done(function(result) {
            $('#standard-modalLabel').html('Update Designation');
          // console.log("success");
          $('#editid').val(result.ut_usertypeid);
          $("#designationval").val(result.ut_usertype);
          $("#notesval").val(result.ut_notes);

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