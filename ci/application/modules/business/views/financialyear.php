
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
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Financial Year</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Financial Years</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <?php 
                            //echo "year" . $this->finyearid;
                            ?>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($finyears)
                                    {
                                        $k=1;
                                        foreach($finyears as $stvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= date('d-M-Y', strtotime($stvl->ay_startdate)) ?></td>
                                                <td><?= date('d-M-Y', strtotime($stvl->ay_enddate)) ?></td>
                                                <td><?= $stvl->ay_financialname ?></td>
                                                <td>
                                                    <?php 
                                                    if($this->finyearid == $stvl->ay_financialyearid)
                                                    {
                                                        echo "Default";
                                                    }else{
                                                        ?>
                                                        <a class="btn btn-primary btn-sm" href="<?= base_url() ?>business/setfinancialyear/<?= $stvl->ay_financialyearid ?>">Set Year</a>
                                                        <?php
                                                    }
                                                    ?>
                                                    
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
                        <h4 class="modal-title" id="standard-modalLabel">Add New Financial Year</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?php echo base_url(); ?>business/addingfinancialyear" name="addingform" id="addingform" class="addformvalidate" method="post">
                        <input type="hidden" name="editid" id="editid">

                    <div class="modal-body">

                    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Start Date</label>
                                    <input type="date" name="fromdate" required class="form-control" id="fromdate">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">End Date</label>
                                    <input type="date" name="todate" required class="form-control" id="todate" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-7" class="form-label">Name</label>
                                    <input type="text" name="finyearname" required class="form-control" id="finyearname" placeholder="Financial year name">
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
        $("#fromdate").val("");
        $("#todate").val("");
        $("#finyearname").val("");
        $('#addformmodal').modal('show');
    }

    function editdetailsfun(taxid)
    {
        $.ajax({
          url: '<?php echo site_url('business/gettaxdetails') ?>',
          type: 'POST',
          dataType: 'JSON',
          data: {taxid: taxid},
        })
        .done(function(result) {
            $('#standard-modalLabel').html('Update Taxband');
          // console.log("success");
          $('#editid').val(result.tb_taxbandid);
          $("#taxband").val(result.tb_taxband);
          $("#taxvalue").val(result.tb_tax);

            $("#notes").val(result.tb_notes);

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