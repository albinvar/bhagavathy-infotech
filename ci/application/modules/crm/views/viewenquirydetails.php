<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <a href="<?= base_url() ?>crm/enquirylist/<?= $editdata->en_status ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-backward"></i> Back</button>
                            </a>
                        </div>
                        <h4 class="page-title">Enquiry Details of #<?= $editdata->en_enquiryprefix ?><?= $editdata->en_enquiryno ?> 
                        <?php 
                        if($editdata->en_isactive == 1)
                        {
                            ?>
                            <span class="badge bg-soft-danger text-danger">Deleted</span>
                            <?php 
                        }else{
                            if($editdata->en_status == 0)
                            {
                                ?>
                            <span class="badge bg-soft-info text-info">New</span>
                            <?php 
                            }else if($editdata->en_status == 1){
                            ?>
                            <span class="badge bg-soft-warning text-warning">Followup</span>
                            <?php 
                            }else if($editdata->en_status == 2){
                            ?>
                            <span class="badge bg-soft-success text-success">Confirmed</span>
                            <?php 
                            }
                            else if($editdata->en_status == 3){
                            ?>
                            <span class="badge bg-soft-secondary text-secondary">Cancelled</span>
                            <?php 
                            }
                            else if($editdata->en_status == 4){
                            ?>
                            <span class="badge bg-soft-primary text-primary">Completed</span>
                            <?php 
                            }
                        }
                        ?>
                    </h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="font-family-primary fw-semibold">Enquiry No: <?= $editdata->en_enquiryprefix ?><?= $editdata->en_enquiryno ?></h5>
                            
                            <p class="mb-2"><span class="fw-semibold me-2">Customer Name:</span> 
                            	<?php 
                                    $pharr = array();
                                    if($editdata->en_existingcust == 1)
                                    {
                                        echo $editdata->ct_name;
                                        if($editdata->ct_phone != "")
                                        {
                                            $pharr[] = $editdata->ct_phone;
                                        }
                                        if($editdata->ct_mobile != "")
                                        {
                                            $pharr[] = $editdata->ct_mobile;
                                        }
                                    }else{
                                        echo $editdata->en_firstname;
                                        if($editdata->en_mobile != "")
                                        {
                                            $pharr[] = $editdata->en_mobile;
                                        }
                                        if($editdata->en_phone != "")
                                        {
                                            $pharr[] = $editdata->en_phone;
                                        }
                                    }
                                    ?>
                            	</p>
                            <p class="mb-2"><span class="fw-semibold me-2">Phone Number:</span> <?= implode(', ', $pharr) ?></p>
                            <p class="mb-2"><span class="fw-semibold me-2">Enquiry Date:</span> <?= date('d-M-Y H:i', strtotime($editdata->en_addedon)) ?></p>
                            <p class="mb-2"><span class="fw-semibold me-2">Added By:</span> <?= $editdata->addedby ?></p>
                            <p class="mb-2"><span class="fw-semibold me-2">Subject:</span> <?= $editdata->en_subject ?></p>
                            <p class="mb-2"><span class="fw-semibold me-2">Enquiry:</span> <?php echo $editdata->en_enquiry; ?></p>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            
                            <!--<a href="javascript:void(0)" onclick="addoperationfun()" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Operation</button>
                            </a>-->
                            
                        </div>
                        <h4 class="page-title">Followup Details</h4>
                    </div>
                </div>
            </div>  

            <?php
            if($editdata->en_status == 4)
            {
                ?>
                <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Completed</h4>

                                    <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><span class="fw-semibold me-2">Completed Comments:</span> <?= $editdata->en_completedcomments ?></p>
                                        <p class="mb-2"><span class="fw-semibold me-2">Completed On:</span> <?=  date('d-M-Y H:i', strtotime($editdata->en_completedon)) ?></p>
                                        <p class="mb-0"><span class="fw-semibold me-2">Completed By:</span> <?= $editdata->completedby ?></p>
                                        
                                    </div>

                                   
                                    </div>

                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                <?php
            }

            if($followups)
            {
            	foreach($followups as $follvl)
            	{
            		?>
            		<div class="row">
		                <div class="col-lg-12">
		                    <div class="card">
		                        <div class="card-body">
                                    

                                    <div class="row">
                                    <div class="col-md-12">
    		                            <p class="mb-2"><span class="fw-semibold me-2">Followup Date:</span> <?= date('d-M-Y H:i', strtotime($follvl->ef_updatedon)) ?></p>
    		                            <p class="mb-2"><span class="fw-semibold me-2">Followup Notes:</span> <?= $follvl->ef_followupnote ?></p>

    		                            <p class="mb-2"><span class="fw-semibold me-2">Status:</span> <?php 
                                        if($follvl->ef_status == 1)
                                        {
                                            ?>
                                            <span class="badge bg-soft-warning text-warning">Followup</span>
                                            <?php 
                                            }else if($follvl->ef_status == 2){
                                            ?>
                                            <span class="badge bg-soft-success text-success">Confirmed</span>
                                            <?php 
                                            }
                                            else if($follvl->ef_status == 3){
                                            ?>
                                            <span class="badge bg-soft-secondary text-secondary">Cancelled</span>
                                            <?php
                                        }
                                        ?></p>
                                        <?php 
                                        if($follvl->ef_status == 1)
                                        {
                                        ?>
                                        <p class="mb-2"><span class="fw-semibold me-2">Next Followup Date:</span> <?= date('d-M-Y H:i', strtotime($follvl->ef_nextfollowupdate)) ?></p>
                                        <?php 
                                        }
                                        ?>

                                        <p class="mb-0"><span class="fw-semibold me-2">Updated By:</span> <?= $follvl->at_name ?></p>
                                    </div>

                                    
                                    </div>

		                        </div>
		                    </div>
		                </div> <!-- end col -->
		            </div>
            		<?php
            	}
            }else{
            	?>
            	<div class="row">
	                <div class="col-lg-12">
	                    <div class="card">
	                        <div class="card-body">
	                        	No Followup details updated...
	                        </div>
	                    </div>
	                </div>
	            </div>
            	<?php
            }
            ?>
            
            
        </div> <!-- container -->

    </div> <!-- content -->


<!-- Add modal content -->
    <div id="addformmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Start Operation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="<?php echo base_url(); ?>production/startingoperation" name="addingform" id="addingform" class="addformvalidate" method="post">
                    
                <div class="modal-body">

                    
                    <div class="row">
                        
                    
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="field-7" class="form-label">Operation start time</label><br/>
                                <div class="row">
                                    <div class="col-md-6">
                                    <input type="date" name="opstartdate" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                    <input type="time" name="opstarttime" value="<?php echo date('H:i'); ?>" class="form-control col-md-6" style="width: 130px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="field-3" class="form-label">Operation Cost</label>
                                <input type="number" step="any" name="operationcost" class="form-control" id="operationcost" value="0">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="field-3" class="form-label">Expected Completion Time</label>
                                <div class="row">
                                    <div class="col-md-6">
                                    <input type="date" name="expcompletiondate" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                    <input type="time" name="expcompletiontime" value="<?php echo date('H:i'); ?>" class="form-control col-md-6" style="width: 130px;">
                                    </div>
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


    <div id="finishformmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel2">Operation Finished Details</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="<?php echo base_url(); ?>production/finishingoperation" name="addingform" id="addingform" class="addformvalidate" method="post">
                    
                <div class="modal-body">

                    
                    <div class="row">
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="field-7" class="form-label">Finished time</label><br/>
                                <div class="row">
                                    <div class="col-md-6">
                                    <input type="date" name="finisheddate" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                    <input type="time" name="finishedtime" value="<?php echo date('H:i'); ?>" class="form-control col-md-6" style="width: 130px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="field-3" class="form-label">Operation Final Cost</label>
                                <input type="number" step="any" name="finaloperationcost" class="form-control" id="finaloperationcost" value="0">
                            </div>
                        </div>

                        

                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="field-7" class="form-label">Finished Notes</label>
                                <textarea class="form-control" id="finishednotes" name="finishednotes" placeholder="Notes"></textarea>
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
    function addoperationfun()
    {
        $('#addformmodal').modal('show');
    }
    function finisheddetails(opetnid, oprtname)
    {
        $('#standard-modalLabel2').html(oprtname + ' Finished Details');
        $('#productionoprtnid').val(opetnid);
        $('#finishformmodal').modal('show');
    }
    function finishoperationfun()
    {
        $('#finishedproductionmodal').modal('show');
    }
</script>