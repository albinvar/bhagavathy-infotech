
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
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Operation</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Production Operations</h4>
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
                                        <th>Operation</th>
                                        <th>Description</th>
                                        <th>Internal/External</th>
                                        <th>Priority</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($operations)
                                    {
                                        $k=1;
                                        foreach($operations as $stvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->po_operation ?></td>
                                                <td><?= $stvl->po_description ?></td>
                                                <td>
                                                    <?php 
                                                    if($stvl->po_isexternal == '0')
                                                    {
                                                        ?>
                                                        <span class="badge bg-primary">Internal</span>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <span class="badge bg-danger">External</span>
                                                        <?php
                                                    }
                                                    ?>
                                                    </td>
                                                <td><?= $stvl->po_priority ?></td>
                                                <td>
                                                    <a class="text-primary" href="javascript:void(0)" onclick="editdetailsfun('<?= $stvl->po_operationid ?>')"><i class="fas fa-pen"></i> Edit</a>
                                                    &nbsp;
                                                    <?php if($stvl->po_isactive): ?>
                                                        <a href="<?php echo site_url('production/enabledisableoperation/' . $stvl->po_operationid); ?>" class="text-success" onclick="return confirm('Are you sure?')"><i class="fas fa-check"></i> Enable</a>
                                                        <?php else: ?>
                                                        <a href="<?php echo site_url('production/enabledisableoperation/' . $stvl->po_operationid .'/1'); ?>" onclick="return confirm('Are you sure?')" class="ml-2 text-danger"><i class="fas fa-times"></i> Disable</a>
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

                    <form action="<?php echo base_url(); ?>production/addingoperation" name="addingform" id="addingform" class="addformvalidate" method="post">
                        <input type="hidden" name="editid" id="editid">

                    <div class="modal-body">

                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Operation Name</label>
                                    <input type="text" name="operationname" required class="form-control" id="operationname" placeholder="Operation Name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-7" class="form-label">Is External Operation?</label><br/>

                                    <label class="form-check-label" for="customRadio1"><input type="radio" id="customRadio1" value="0" checked="checked" name="isexternal" id="internalcheck" class="form-check-input"> No</label>
                                    &nbsp; &nbsp;
                                    <label class="form-check-label" for="customRadio2"><input type="radio" id="customRadio2" value="1" name="isexternal" id="externalcheck" class="form-check-input"> Yes</label>
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

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Priority</label>
                                    <input type="number" name="operationpriority" required class="form-control" id="operationpriority" value="0">
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
        $('#standard-modalLabel').html('Add New Operation');
        $('#editid').val("");
        $("#operationname").val("");
        $("#internalcheck").prop("checked", true);
        $("#notes").val("");
        $("#operationpriority").val(0);
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
          url: '<?php echo site_url('production/getoperationdetails') ?>',
          type: 'POST',
          dataType: 'JSON',
          data: {operationid: catid},
        })
        .done(function(result) {
          // console.log("success");
          $('#standard-modalLabel').html('Update Operation Details');
          $('#editid').val(result.po_operationid);
          $("#operationname").val(result.po_operation);
          //$("#taxvalue").val(result.tb_tax);
          if(result.po_isexternal == 1)
          {
            $("#externalcheck").prop("checked", true);
          }
          else{
            $("#internalcheck").prop("checked", true);
          }
          $("#notes").val(result.po_description);
          $("#operationpriority").val(result.po_priority);

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