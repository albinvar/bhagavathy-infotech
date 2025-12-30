
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style type="text/css">
    .favicon{
        color: #FFD700;
    }
    .addfavritebtn:hover{
        color: #FFD700;
    }
    .activemnu{
        color: blue !important;
    }
</style>
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
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Document</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Document List</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            
            <div class="row">

                <!-- Right Sidebar -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Left sidebar -->
                            <div class="inbox-leftbar">
                                <div class="btn-group d-block mb-2">
                                    <button type="button" class="btn btn-success w-100 waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-plus"></i> Create New</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="addfolderfun()"><i class="mdi mdi-folder-plus-outline me-1"></i> Folder</a>
                                        <!--<a class="dropdown-item" href="#"><i class="mdi mdi-file-plus-outline me-1"></i> File</a>
                                        <a class="dropdown-item" href="#"><i class="mdi mdi-file-document me-1"></i> Document</a>-->
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="additemfun()"><i class="mdi mdi-upload me-1"></i> Choose File</a>
                                    </div>
                                </div>
                                <div class="mail-list mt-3">
                                    <a href="<?= base_url() ?>documents/documentlist" class="list-group-item border-0 <?php if($status == 0 && $folder == 0){ echo 'activemnu'; } ?>"><i class="mdi mdi-folder-outline font-18 align-middle me-2"></i>All Documents</a>
                                    
                                    <a href="<?= base_url() ?>documents/documentlist/1" class="list-group-item border-0 <?php if($status == 1){ echo 'activemnu'; } ?>"><i class="mdi mdi-star-outline font-18 align-middle me-2"></i>Starred</a>

                                    <a href="<?= base_url() ?>documents/documentlist/2" class="list-group-item border-0 <?php if($status == 2){ echo 'activemnu'; } ?> "><i class="mdi mdi-clock-outline font-18 align-middle me-2"></i>Recent</a>
                                    

                                    <?php 
                                    if($folders)
                                    {
                                        foreach ($folders as $fldvl) {
                                            ?>
                                            <a href="<?= base_url() ?>documents/documentlist/0/<?= $fldvl->df_folderid ?>" class="list-group-item border-0 <?php if($folder == $fldvl->df_folderid){ echo 'activemnu'; } ?>"><i class="mdi mdi-folder-outline font-18 align-middle me-2"></i><?= $fldvl->df_foldername ?></a>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <a href="<?= base_url() ?>documents/documentlist/3" class="list-group-item border-0 <?php if($status == 3){ echo 'activemnu'; } ?>"><i class="mdi mdi-delete font-18 align-middle me-2"></i>Deleted Files</a>
                                </div>

                                <!--<div class="mt-5">
                                    <h4><span class="badge rounded-pill p-1 px-2 badge-soft-secondary">FREE</span></h4>
                                    <h6 class="text-uppercase mt-3">Storage</h6>
                                    <div class="progress my-2 progress-sm">
                                        <div class="progress-bar progress-lg bg-success" role="progressbar" style="width: 46%" aria-valuenow="46" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="text-muted font-12 mb-0">7.02 GB (46%) of 15 GB used</p>
                                </div>-->

                            </div>
                            <!-- End Left sidebar -->

                            <div class="inbox-rightbar">
                                
                                
                                <div >
                                    <h5 class="mb-3"><?= $title ?></h5>

                                    <div class="table-responsive">
                                        <table id="basic-datatable" class="table table-centered table-nowrap mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th class="border-0">Name</th>
                                                    <th class="border-0">Notes</th>
                                                    <th class="border-0">Added On</th>
                                                    <!--<th class="border-0">Added By</th>-->
                                                    <th class="border-0" style="width: 80px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?php
                                                if($documents)
                                                {
                                                    foreach ($documents as $docvl) {
                                                        ?>
                                                        <tr>
                                                            <td align="center">
                                                            <?php 
                                                            if($docvl->dc_starred == 0)
                                                            {
                                                                ?>
                                                                <a href="<?= base_url() ?>documents/addtofavourite/<?= $docvl->dc_documentid ?>" class="addfavritebtn" title="Add to Starred" onclick="return confirm('Are you sure?')"><i class="far fa-star"></i></a>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <a href="<?= base_url() ?>documents/removefavourite/<?= $docvl->dc_documentid ?>" title="Remove from Starred" onclick="return confirm('Are you sure?')"><span class="favicon"><i class="fas fa-star"></i></span></a>
                                                                <?php
                                                            }
                                                            ?>
                                                            
                                                        </td>
                                                            <td>
                                                                <i data-feather="file" class="icon-dual"></i>
                                                                <span class="ms-2 fw-semibold"><a href="javascript: void(0);" class="text-reset"><?= $docvl->dc_filename ?></a></span>
                                                            </td>
                                                            <td>
                                                                <span class="font-12"><?= $docvl->dc_description ?></span>
                                                            </td>
                                                            <td><?= date('d-M-Y H:i', strtotime($docvl->dc_addedon)) ?></td>
                                                            
                                                            <td>
                                                                <div class="btn-group dropdown">
                                                                    <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-xs" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <!--<a class="dropdown-item" href="#"><i class="mdi mdi-share-variant me-2 text-muted vertical-middle"></i>Share</a>-->
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="copygrpurlpopupdiv('<?= $docvl->dc_filename ?>')"><i class="mdi mdi-link me-2 text-muted vertical-middle"></i>Get Sharable Link</a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="renamefilename('<?= $docvl->dc_documentid ?>')"><i class="mdi mdi-pencil me-2 text-muted vertical-middle"></i>Rename</a>
                                                                        <a class="dropdown-item" href="<?= base_url() ?>uploads/documents/<?= $this->buid ?>/<?= $docvl->dc_filename ?>" target="_blank"><i class="mdi mdi-download me-2 text-muted vertical-middle"></i>Download</a>
                                                                        <?php 
                                                                        if($docvl->dc_isactive == 0)
                                                                        {
                                                                        ?>
                                                                        <a class="dropdown-item" href="<?php echo site_url('documents/enabledisabledocument/' . $docvl->dc_documentid .'/1'); ?>" onclick="return confirm('Are you sure?')"><i class="mdi mdi-delete me-2 text-muted vertical-middle"></i>Delete</a>
                                                                        <?php 
                                                                        }else{
                                                                            ?>
                                                                            <a class="dropdown-item" href="<?php echo site_url('documents/enabledisabledocument/' . $docvl->dc_documentid .'/0'); ?>" onclick="return confirm('Are you sure?')"><i class="mdi mdi-check me-2 text-muted vertical-middle"></i>Enable</a>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                </div> <!-- end .mt-3-->
                                
                            </div> 
                            <!-- end inbox-rightbar-->

                            <div class="clearfix"></div>
                        </div>
                    </div> <!-- end card -->

                </div> <!-- end Col -->
            </div><!-- End row -->
            
        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Add modal content -->
        <div id="addformmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Add Folder Name</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?php echo base_url(); ?>documents/addingfolder" name="addingform" id="addingform" class="addformvalidate" method="post">
                        <input type="hidden" name="editid" id="editid">

                        <input type="hidden" name="bpage" id="bpage" value="1">

                    <div class="modal-body">

                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Folder Name</label>
                                    <input type="text" name="foldername" required class="form-control" id="foldername" placeholder="Folder Name">
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

   
    <!-- Add modal content -->
        <div id="addattachmemodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel2">Add New Document</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?php echo base_url(); ?>documents/addingattachment" name="addingform" id="addingform" class="addformvalidate" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="editid" id="editid">

                        <input type="hidden" name="bpage" id="bpage" value="1">

                    <div class="modal-body">

                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Select Folder</label>
                                    <select class="form-control" name="folderid" id="folderid">
                                        <option value="">Root Folder</option>
                                        <?php 
                                        if ($folders) {
                                            foreach($folders as $fldvl)
                                            {
                                                ?>
                                                <option value="<?= $fldvl->df_folderid ?>"><?= $fldvl->df_foldername ?></option>
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
                                    <label for="field-3" class="form-label">Select Document</label>
                                    <input type="file" name="docfile" required class="form-control" id="docfile" placeholder="Choose Document">
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-7" class="form-label">Notes</label>
                                    <textarea class="form-control" id="filenotes" name="filenotes" placeholder="Notes"></textarea>
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

    <!------------- Document rename model --------------------->

    <div id="renameattachmemodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel2">Rename Document</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?php echo base_url(); ?>documents/renameattachment" name="addingform" id="addingform" class="addformvalidate" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="fileid" id="fileid">

                        <input type="hidden" name="oldfilename" id="oldfilename">

                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Document Name</label>
                                    <input type="text" name="docfilename" required class="form-control" id="docfilename">
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-7" class="form-label">Notes</label>
                                    <textarea class="form-control" id="docfilenotes" name="docfilenotes" placeholder="Notes"></textarea>
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


<div class="modal" id="copylinkdiv">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel2">Copy Url</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="row col-md-12 ">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span>Link </span>
                                <input type="text"  name="copyurlfield" id="copyurlfield"
                                class="form-control note-codable" />
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button onClick="copygeneratedurl()" class="btn btn-primary listbtns" value="Save" name="addtrainingsubmit">Copy</button>
                <button class="btn ripple btn-secondary listbtns" data-bs-dismiss="modal" type="button">Close</button>
            </div>

        </div>
    </div>
</div>

    <script type="text/javascript">
    function additemfun()
    {
        $('#addattachmemodal').modal('show');
    }
    function addfolderfun()
    {
        $('#standard-modalLabel').html('Add New Folder');
        $('#editid').val("");
        $("#foldername").val("");
        $("#notes").val("");
        $('#addformmodal').modal('show');
    }

    function copygrpurlpopupdiv(imagename) {
        $('#copyurlfield').val('<?= base_url() ?>uploads/documents/<?= $this->buid ?>/'+imagename);
        $('#copylinkdiv').modal('show');
        $('#copyurlfield').select();
    }
    function copygeneratedurl() {
        $('#copyurlfield').select();
        document.execCommand('copy');
    }


    function renamefilename(fileid)
    {
        $.ajax({
          url: '<?php echo site_url('documents/getdocumentdetails') ?>',
          type: 'POST',
          dataType: 'JSON',
          data: {fileid: fileid},
        })
        .done(function(result) {
          // console.log("success");
          $('#fileid').val(result.dc_documentid);
          $("#docfilename").val(result.dc_filename);
          $("#oldfilename").val(result.dc_filename);
          
          $("#docfilenotes").val(result.dc_description);

            $("#renameattachmemodal").modal('show');

        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    }
    
    
    
</script>