
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
                            
                            <a href="<?= base_url() ?>crm/addenquiry" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Enquiry</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Enquiry List</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="mb-2">
                <a href="<?= base_url() ?>crm/enquirylist/0"><button type="button" class="btn btn-info waves-effect waves-light">
                    New<span class="btn-label-right"><?= $newcount ?></span>
                </button></a>

                <a href="<?= base_url() ?>crm/enquirylist/1"><button type="button" class="btn btn-warning waves-effect waves-light">
                    Followup Required<span class="btn-label-right"><?= $followcount ?></span>
                </button></a>

                <a href="<?= base_url() ?>crm/enquirylist/2"><button type="button" class="btn btn-success waves-effect waves-light">
                    Confirmed<span class="btn-label-right"><?= $confirmcount ?></span>
                </button></a>

                <a href="<?= base_url() ?>crm/enquirylist/4"><button type="button" class="btn btn-primary waves-effect waves-light">
                    Completed<span class="btn-label-right"><?= $completedcount ?></span>
                </button></a>

                <a href="<?= base_url() ?>crm/enquirylist/3"><button type="button" class="btn btn-secondary waves-effect waves-light">
                    Cancelled<span class="btn-label-right"><?= $cancelcount ?></span>
                </button></a>

                <a href="<?= base_url() ?>crm/deletedenquirylist"><button type="button" class="btn btn-danger waves-effect waves-light">
                    Deleted<span class="btn-label-right"><?= $deletecount ?></span>
                </button></a>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row mb-2">
                                <div class="col-12">
                                    <div class="page-title-box">
                                        <div class="page-title-right">
                                            
                                            <!--<a href="<?= base_url() ?>crm/addenquiry" class="ms-1">
                                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Enquiry</button>
                                            </a>-->
                                                
                                        </div>
                                        <h4 class="header-title"><?= $title ?></h4>
                                    </div>
                                </div>
                            </div>   

                            
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Enquiry No</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <!--<th>Address</th>-->
                                        <th>Subject</th>
                                        <?php 
                                        if($status == 1)
                                        {
                                            ?>
                                            <th>Follow Up Details</th>
                                            <?php
                                        }
                                        ?>
                                        <!--<th>Status</th>-->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($enquiries)
                                    {
                                        $k=1;
                                        foreach($enquiries as $stvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->en_enquiryprefix ?><?= $stvl->en_enquiryno ?></td>
                                                <td><?= date('d-M-Y H:i', strtotime($stvl->en_addedon)) ?></td>
                                                <td><?php 
                                                $pharr = array();
                                                if($stvl->en_existingcust == 1)
                                                {
                                                    echo $stvl->ct_name;
                                                    if($stvl->ct_phone != "")
                                                    {
                                                        $pharr[] = $stvl->ct_phone;
                                                    }
                                                    if($stvl->ct_mobile != "")
                                                    {
                                                        $pharr[] = $stvl->ct_mobile;
                                                    }
                                                }else{
                                                    echo $stvl->en_firstname;
                                                    if($stvl->en_mobile != "")
                                                    {
                                                        $pharr[] = $stvl->en_mobile;
                                                    }
                                                    if($stvl->en_phone != "")
                                                    {
                                                        $pharr[] = $stvl->en_phone;
                                                    }
                                                }
                                                ?></td>
                                                <td><?php 
                                                echo implode(', ', $pharr);
                                                ?></td>
                                                <!--<td><?= $stvl->ct_email ?></td>-->
                                                <!--<td><?= $stvl->ct_address ?></td>-->
                                                <td>
                                                    <?= $stvl->en_subject ?><br/>
                                                    <a href="javascript:void(0)" onclick="viewdetailsfun('<?= $stvl->en_enquiryid ?>')" class="text-primary"><i class="fas fa-eye"></i> View enquiry</a>
                                                </td>
                                                <?php 
                                                if($status == 1)
                                                {
                                                    $lastfollwp = $this->enqryfllp->getlastfollowupdet($stvl->en_enquiryid);
                                                    ?>
                                                    <td><?= date('d-M-Y H:i', strtotime($lastfollwp->ef_nextfollowupdate)) ?><br/>
                                                        Note: <i><?= $lastfollwp->ef_followupnote ?></i>
                                                        
                                                    </td>
                                                    <?php
                                                }
                                                ?>
                                                <!--<td>
                                                    <span class="badge bg-success">New</span>
                                                </td>-->
                                                <td>
                                                    <a href="<?= base_url() ?>crm/viewenquirydetails/<?= $stvl->en_enquiryid ?>" class="text-primary"><i class="fas fa-eye"></i> View</a> &nbsp;
                                                    <?php 
                                                    if($status != 4)
                                                    {
                                                        ?>
                                                    <?php if($stvl->en_isactive): ?>
                                                        <a href="<?php echo site_url('crm/enabledisableenquiry/' . $stvl->en_enquiryid); ?>" class="text-success" onclick="return confirm('Are you sure?')"><i class="fas fa-check"></i> Enable</a>
                                                        <?php else: ?>
                                                            <a class="text-info" href="<?php echo site_url('crm/addenquiry/' . $stvl->en_enquiryid); ?>"><i class="fas fa-pen"></i> Edit</a> &nbsp;
                                                           
                                                           
                                                        <a href="<?php echo site_url('crm/enabledisableenquiry/' . $stvl->en_enquiryid .'/1'); ?>" onclick="return confirm('Are you sure?')" class="ml-2 text-danger"><i class="fas fa-times"></i> Disable</a> <br/>
                                                        <?php 
                                                        if($status == 2)
                                                        {
                                                            ?>
                                                        <a href="javascript:void(0)" onclick="completeenquiry('<?= $stvl->en_enquiryid ?>', '<?= $stvl->en_enquiryprefix ?><?= $stvl->en_enquiryno ?>')" class="ml-2 text-warning"><i class="fas fa-comments"></i> Complete</a>
                                                        <?php 
                                                        }else{
                                                        ?>
                                                        <a href="javascript:void(0)" onclick="followupenquiry('<?= $stvl->en_enquiryid ?>', '<?= $stvl->en_enquiryprefix ?><?= $stvl->en_enquiryno ?>')" class="ml-2 text-warning"><i class="fas fa-comments"></i> Follow Up</a>
                                                        <?php 
                                                        }
                                                        ?>
                                                       <?php endif;
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
        <div id="viewdetailmmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Enquiry Details</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body" id="viewdetailsdiv">

                       
                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light listbtns" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- Add modal content -->
        <div id="followupdetailmmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel2">Follow Up</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url() ?>crm/addingfollowupdetails" method="post">
                    <div class="modal-body" id="viewdetailfollowdiv">

                       
                        

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary listbtns">Submit</button>
                        <button type="button" class="btn btn-light listbtns" data-bs-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <!-- Add modal content -->
        <div id="completedetailmmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel3">Complete</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url() ?>crm/completingenquiry" method="post">
                    <div class="modal-body" id="viewdetailfollowdiv">

                       
                        <div class="col-md-12 mt-2">
                            Comments*
                            <textarea name="completedcomment" class="form-control" required="required"></textarea>
                            <input type="hidden" name="completeenquiryid" id="completeenquiryid" >
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary listbtns">Submit</button>
                        <button type="button" class="btn btn-light listbtns" data-bs-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

   
    
    <script type="text/javascript">
    function completeenquiry(enqurid, enqno)
    {
        $('#completeenquiryid').val(enqurid);
        $('#standard-modalLabel3').html('Complete -' +enqno);
        $('#completedetailmmodal').modal('show');
    }
    function followupenquiry(enqurid, enqno)
    {
        $.ajax({
          url: '<?php echo site_url('crm/followupenquirypopup') ?>',
          type: 'POST',
          dataType: 'html',
          data: {enquiryid: enqurid},
        })
        .done(function(result) {
          // console.log("success");

          $("#viewdetailfollowdiv").html(result);

        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
        $('#standard-modalLabel2').html('Follow Up -' +enqno);
        $('#followupdetailmmodal').modal('show');
    }
    function viewdetailsfun(enqurid)
    {
        $.ajax({
          url: '<?php echo site_url('crm/getenquirydetails') ?>',
          type: 'POST',
          dataType: 'html',
          data: {enquiryid: enqurid},
        })
        .done(function(result) {
          // console.log("success");
          $("#viewdetailsdiv").html(result);

        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
        $('#standard-modalLabel').html('Enquiry Details');
        $('#viewdetailmmodal').modal('show');
    }
    
    
</script>