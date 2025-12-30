<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <a href="<?= base_url() ?>production/productionhistory" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-backward"></i> Back</button>
                            </a>
                        </div>
                        <h4 class="page-title">Production Details of #<?= $editdata->pm_productionprefix ?><?= $editdata->pm_productionno ?> 
                        <?php 
                        if($editdata->pm_finished == 1)
                        {
                            ?>
                        <span class="badge bg-soft-success text-success">Finished</span>
                        <?php 
                        }else{
                        ?>
                        <span class="badge bg-soft-warning text-warning">Ongoing</span>
                        <?php 
                        }
                        ?>
                    </h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Operations</h4>

                            <?php 
                            $completedoperationarray = array();
                            $notfinishedoperation = 0;
                            $operationamounts = 0;
                            if($operationdetails)
                            {
                                foreach($operationdetails as $opdetvl)
                                {
                                    $completedoperationarray[] = $opdetvl->pmo_operationid;
                                    $opcompletionstatus[$opdetvl->pmo_operationid] = $opdetvl->pmo_isfinished;

                                    $topopstarttime[$opdetvl->pmo_operationid] = $opdetvl->pmo_operationstarttime;

                                    if($opdetvl->pmo_isfinished == 0)
                                    {
                                        $notfinishedoperation = 1;
                                    }else{
                                        $topopfinishtime[$opdetvl->pmo_operationid] = $opdetvl->pmo_operationendtime;
                                        $operationamounts = $operationamounts + $opdetvl->pmo_finishedcost;
                                    }
                                }
                                
                            }
                            ?>

                            <div class="track-order-list">
                                <ul class="list-unstyled">
                                    <li class="completed">
                                        <h5 class="mt-0 mb-1">Production Started</h5>
                                        <p class="text-muted"><?= date('d-M-Y H:i', strtotime($editdata->pm_startdate)) ?> </p>
                                    </li>
                                    <?php
                                    if($operations)
                                    {
                                    	foreach($operations as $opvl)
                                    	{
                                    		?>
                                    		<li <?php 
                                            $opstart = 0;
                                            $actop = 0;
                                            if(in_array($opvl->po_operationid, $completedoperationarray)){ $opstart=1; if($opcompletionstatus[$opvl->po_operationid] == 1){ echo 'class="completed"'; }else{ $actop=1; }} ?>>
                                                <?php 
                                                if($actop == 1)
                                                {
                                                    echo '<span class="active-dot dot"></span>';
                                                }
                                                ?>
		                                        <h5 class="mt-0 mb-1"><?= $opvl->po_operation ?></h5>
		                                        <p class="text-muted">
                                                    <?php 
                                                    if($opstart == 1)
                                                    {
                                                        echo "Start Time: " . date('d-M-Y H:i', strtotime($topopstarttime[$opvl->po_operationid]));
                                                        if($opcompletionstatus[$opvl->po_operationid] == 1){
                                                            echo "<br/>Finished Time: " . date('d-M-Y H:i', strtotime($topopfinishtime[$opvl->po_operationid]));
                                                        }
                                                    }else{
                                                        echo "--";
                                                    }
                                                    ?>
                                                </p>
		                                    </li>
                                    		<?php
                                    	}
                                    }
                                    ?>
                                    <!--<li class="completed">
                                        <h5 class="mt-0 mb-1">Packed</h5>
                                        <p class="text-muted">April 22 2019 <small class="text-muted">12:16 AM</small></p>
                                    </li>
                                    <li>
                                        <span class="active-dot dot"></span>
                                        <h5 class="mt-0 mb-1">Shipped</h5>
                                        <p class="text-muted">April 22 2019 <small class="text-muted">05:16 PM</small></p>
                                    </li>-->
                                    <li <?php if($editdata->pm_finished == 1){ ?> class="completed" <?php } ?>>
                                        <h5 class="mt-0 mb-1"> Finished</h5>
                                        <?php 
                                        if($editdata->pm_finished == 1)
                                        {
                                            ?>
                                            <p class="text-muted">Finished time:<br/> <?= date('d-M-Y H:i', strtotime($editdata->pm_finishedtime)) ?></p>
                                            <?php
                                        }else{
                                            ?>
                                            <p class="text-muted">Estimated completion time:<br/> <?= date('d-M-Y H:i', strtotime($editdata->pm_expectedtime)) ?></p>
                                            <?php
                                        }
                                        ?>
                                        
                                    </li>
                                </ul>

                                
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="font-family-primary fw-semibold"><?= $editdata->pd_productname ?> (<?= $editdata->pd_productcode ?>), &nbsp; Qty: <?= $editdata->pm_qty ?> <?= $editdata->un_unitname ?></h5>
                            
                            <p class="mb-2"><span class="fw-semibold me-2">Enquiry No:</span> 
                            	<?php 
                            	if($editdata->pm_enquiryid == 0)
                            	{
                            		echo "Not from enquiry";
                            	}else{
                            		echo $editdata->en_enquiryprefix . $editdata->en_enquiryno;
                            	}
                            	?>
                            	</p>
                            <p class="mb-2"><span class="fw-semibold me-2">Start Date:</span> <?= date('d-M-Y H:i', strtotime($editdata->pm_startdate)) ?></p>
                            <p class="mb-2"><span class="fw-semibold me-2">Comments:</span> <?= $editdata->pm_comments ?></p>
                            <p class="mb-2"><span class="fw-semibold me-2">Expected Completion Date:</span> <?= date('d-M-Y H:i', strtotime($editdata->pm_expectedtime)) ?></p>
                            <p class="mb-0"><span class="fw-semibold me-2">Added By:</span> <?= $editdata->at_name ?></p>

                            <div class="table-responsive mt-2">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                        	<th>#</th>
                                            <th>Material name</th>
                                            <th>Purchase Price</th>
                                            <th>MRP</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
       
								        if($itemdetails)
								        {
								            $k=1;
								            $totamount =0;
								            foreach($itemdetails as $ldgvl)
								            {
								                ?>
								                <tr>
								                    <td>
								                        <?= $k ?>
								                    </td>
								                    
								                    <td><?= $ldgvl->pd_productname ?> <?= $ldgvl->pd_size ?> <?= $ldgvl->pd_brand ?> (<?= $ldgvl->pd_productcode ?>)</td>
								                    
								                    <td><?= $ldgvl->pms_unitprice ?></td>
								                    <td><?= $ldgvl->pms_mrp ?></td>
								                    <td><?= $ldgvl->pms_qty ?></td>
								                    
								                    <td><?php 
								                    $totamount = $totamount + $ldgvl->pms_itemtotalamount;
								                    echo $ldgvl->pms_itemtotalamount; ?></td>
								                    
								                </tr>
								                <?php
								                $k++;
								            }
								            ?>
								            <tr>
								                <th style="text-align: right;" colspan="5">Total Material Cost</th>
								                <th><?= $totamount ?></th>
								            </tr>
								            <?php
								        }
								        ?>

                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <?php 
                            if($editdata->pm_finished != 1)
                            {
                            if($notfinishedoperation != 1)
                            {
                                if(count_variable($operationdetails) > 0)
                                {
                                    ?>
                                    <a href="javascript:void(0)" onclick="finishoperationfun()" class="ms-1">
                                        <button type="button" class="btn btn-success waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Finish production & add to stock</button>
                                    </a>
                                    <?php
                                }
                                if(count_variable($operationdetails) != count_variable($operations))
                                {
                            ?>
                            <a href="javascript:void(0)" onclick="addoperationfun()" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Operation</button>
                            </a>
                            <?php 
                                }
                            }
                            }
                            ?>
                        </div>
                        <h4 class="page-title">Production Operations Details</h4>
                    </div>
                </div>
            </div>  

            <?php
            if($editdata->pm_finished == 1)
            {
                ?>
                <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Production finished & product added to stock
                                    
                                    </h4>

                                    <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><span class="fw-semibold me-2">Finished Time:</span> <?= date('d-M-Y H:i', strtotime($editdata->pm_finishedtime)) ?></p>
                                        <p class="mb-2"><span class="fw-semibold me-2">Finisshed Comments:</span> <?= $editdata->pm_fnishedcomments ?></p>
                                        <p class="mb-2"><span class="fw-semibold me-2">Total Operation Cost:</span> <?= $editdata->pm_operationcost ?></p>
                                        <p class="mb-0"><span class="fw-semibold me-2">Total Material Cost:</span> <?= $editdata->pm_materialcost ?></p>
                                    </div>

                                    <!--<div class="col-md-6">
                                        
                                        
                                        <p class="mb-2"><span class="fw-semibold me-2">Finished Time:</span> <?= date('d-M-Y H:i', strtotime($opdetvl->pmo_operationendtime)) ?></p>
                                        <p class="mb-2"><span class="fw-semibold me-2">Finished Notes:</span> <?= $opdetvl->pmo_finishedcomments ?></p>
                                        <p class="mb-0"><span class="fw-semibold me-2">Finished Cost:</span> <?= $opdetvl->pmo_finishedcost ?></p>
                                        
                                    </div>-->
                                    </div>

                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                <?php
            }

            if($operationdetails)
            {
            	foreach($operationdetails as $opdetvl)
            	{
            		?>
            		<div class="row">
		                <div class="col-lg-12">
		                    <div class="card">
		                        <div class="card-body">
		                            <h4 class="header-title mb-3"><?= $opdetvl->po_operation ?> 
                                    <?php 
                                    if($opdetvl->pmo_isfinished == 1)
                                    {
                                        ?>
                                    <span class="badge bg-soft-success text-success">Finished</span>
                                    <?php 
                                    }else{
                                    ?>
                                    <span class="badge bg-soft-warning text-warning">Ongoing</span>
                                    <?php 
                                    }
                                    ?>
                                    </h4>

                                    <div class="row">
                                    <div class="col-md-6">
    		                            <p class="mb-2"><span class="fw-semibold me-2">Start Time:</span> <?= date('d-M-Y H:i', strtotime($opdetvl->pmo_operationstarttime)) ?></p>
    		                            <p class="mb-2"><span class="fw-semibold me-2">Notes:</span> <?= $opdetvl->pmo_comments ?></p>
    		                            <p class="mb-2"><span class="fw-semibold me-2">Expected Cost:</span> <?= $opdetvl->pmo_cost ?></p>
                                        <p class="mb-0"><span class="fw-semibold me-2">Expected Completion:</span> <?= date('d-M-Y H:i', strtotime($opdetvl->pmo_expectedendtime)) ?></p>
                                    </div>

                                    <div class="col-md-6">
                                        <?php 
                                        if($opdetvl->pmo_isfinished == 1)
                                        {
                                            ?>
                                        
                                        <p class="mb-2"><span class="fw-semibold me-2">Finished Time:</span> <?= date('d-M-Y H:i', strtotime($opdetvl->pmo_operationendtime)) ?></p>
                                        <p class="mb-2"><span class="fw-semibold me-2">Finished Notes:</span> <?= $opdetvl->pmo_finishedcomments ?></p>
                                        <p class="mb-0"><span class="fw-semibold me-2">Finished Cost:</span> <?= $opdetvl->pmo_finishedcost ?></p>
                                        <?php 
                                        }else{
                                            ?>
                                            <div align="left">
                                            <button type="button" onclick="finisheddetails('<?= $opdetvl->pmo_productionoperationid ?>', '<?= $opdetvl->po_operation ?>')" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Finish</button>
                                            </div>
                                            <?php
                                        }
                                        ?>
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
	                        	No operations started...
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
                    <input type="hidden" name="productionid" id="productionid" value="<?= $productionid ?>">

                <div class="modal-body">

                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="field-3" class="form-label">Select Operation</label>
                                <select class="form-control" name="operationid">
                                    <?php 
                                    if($operations)
                                    {
                                        foreach($operations as $opsvl)
                                        {
                                            if(!in_array($opsvl->po_operationid, $completedoperationarray)){
                                            ?>
                                            <option value="<?= $opsvl->po_operationid ?>"><?= $opsvl->po_operation ?></option>
                                            <?php
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    
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
                    <input type="hidden" name="productionid" id="productionid" value="<?= $productionid ?>">
                    <input type="hidden" name="productionoprtnid" id="productionoprtnid" >

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

    <div id="finishedproductionmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel3">Production Finished Details - <?= $editdata->pd_productname ?> (<?= $editdata->pd_productcode ?>), &nbsp; Qty: <?= $editdata->pm_qty ?> <?= $editdata->un_unitname ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="<?php echo base_url(); ?>production/finishedproductiondetail" name="addingform" id="addingform" class="addformvalidate" method="post">
                    <input type="hidden" name="productionid" id="productionid" value="<?= $productionid ?>">

                    <input type="hidden" name="productid" id="productid" value="<?= $editdata->pm_productid ?>">
                    <input type="hidden" name="productqty" id="productqty" value="<?= $editdata->pm_qty ?>">

                <div class="modal-body">

                    
                    <div class="row">

                        <?php 
                        if($inventorysettings)
                        {
                            if($inventorysettings->is_godown == 1)
                            {
                        ?>
                        <div class="col-md-4">
                            <label for="field-7" class="form-label">Select Godown</label>
                            <select name="godownid" class="w-100 inputfieldcss form-control">
                                <option value="">Select Godown</option>
                                <?php 
                                if($godowns)
                                {
                                    foreach($godowns as $gdvl)
                                    {
                                        ?>
                                        <option <?php if(isset($editdata)){ if($editdata->pm_godownind == $gdvl->gd_godownid){ echo "selected"; } } ?> value="<?= $gdvl->gd_godownid ?>"><?= $gdvl->gd_godownname ?> (<?= $gdvl->gd_godowncode ?>)</option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <?php 
                            }
                            if($inventorysettings->is_batchwise == 1)
                            {
                                ?>
                                <div class="col-md-4">
                                    <label for="field-7" class="form-label">Batch No</label>
                                    <input type="text" name="batchno" class="form-control">
                                </div>
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="batchno" value="0">
                                <?php
                            }
                            if($inventorysettings->is_expirydate == 1)
                            {
                                ?>
                                <div class="col-md-4">
                                    <label for="field-7" class="form-label">Expiry Date</label>
                                    <input type="date" name="expirydate" class="form-control">
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="row mt-2">
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
                                <label for="field-3" class="form-label">Operations Cost</label>
                                <input type="number" step="any" name="finalproductioncost" class="form-control" id="finalproductioncost" value="<?= $operationamounts ?>">
                            </div>
                        </div>
                        
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="field-3" class="form-label">Purchase Price(Without Tax/per 1 qty)*</label>
                                <input type="number" step="any" required="required" name="purchaseprice" class="form-control" id="purchaseprice" value="<?= $editdata->pd_purchaseprice ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="field-3" class="form-label">MRP*</label>
                                <input type="number" step="any" name="mrp" class="form-control" id="mrp" value="<?= $editdata->pd_mrp ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="field-7" class="form-label">Finished Notes</label>
                                <textarea class="form-control" id="finishedproductionnotes" name="finishedproductionnotes" placeholder="Notes"></textarea>
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