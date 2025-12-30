
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
                            
                            <a href="<?= base_url() ?>production/productionstart" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Start Production</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Production History</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="mb-2">
                <a href="<?= base_url() ?>production/productionhistory/0"><button type="button" class="btn btn-primary waves-effect waves-light">
                    Active<span class="btn-label-right"><?= $activeproductioncnt ?></span>
                </button></a>

                <a href="<?= base_url() ?>production/productionhistory/1"><button type="button" class="btn btn-success waves-effect waves-light">
                    Finished<span class="btn-label-right"><?= $finishedproductioncnt ?></span>
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
                                        <h4 class="header-title"><?= $subtitle ?></h4>
                                    </div>
                                </div>
                            </div>  

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Production No</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Materials</th>
                                        <?php
                                        if($finished == 0)
                                        {
                                        ?>
                                        <th>Status</th>
                                        <?php 
                                        }
                                        ?>
                                        <th>Start Date</th>
                                        <?php
                                        if($finished == 1)
                                        {
                                        ?>
                                        <th>Finished Date</th>
                                        <?php 
                                        }
                                        ?>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($productions)
                                    {
                                        $k=1;
                                        foreach($productions as $stvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->pm_productionprefix ?><?= $stvl->pm_productionno ?></td>
                                                <td><?= $stvl->pd_productname ?> (<?= $stvl->pd_productcode ?>)</td>
                                                <td><?= $stvl->pm_qty ?></td>
                                                <td>
                                                    <a href="javascript:void(0)" onclick="viewbillitemfun('<?= $stvl->pm_productionid ?>')" class="text-primary"><i class="fas fa-eye"></i> View</a>
                                                </td>
                                                <?php
                                                if($finished == 0)
                                                {
                                                ?>
                                                <td>
                                                    <?php 
                                                    if($stvl->pm_status == 0)
                                                    {
                                                    ?>
                                                    <span class="badge bg-primary">New</span>
                                                    <?php 
                                                    }else{
                                                        ?>
                                                        <span class="badge bg-warning"><?= $stvl->po_operation ?></span>
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                                </td>
                                                <?php 
                                                }
                                                ?>
                                                <td><?= date('d-M-Y H:i', strtotime($stvl->pm_startdate)) ?></td>
                                                <?php
                                                if($finished == 1)
                                                {
                                                ?>
                                                <td><?= date('d-M-Y H:i', strtotime($stvl->pm_finishedtime)) ?></td>
                                                <?php 
                                                }
                                                ?>
                                                <td>
                                                    <a href="<?= base_url() ?>production/viewproductiondetails/<?= $stvl->pm_productionid ?>" class="ml-2 text-primary"><i class="fas fa-eye"></i> View</a>
                                                    <?php
                                                    if($finished == 0)
                                                    {
                                                    ?>
                                                    &nbsp;
                                                    <a class="text-warning" href="<?= base_url() ?>production/productionstart/<?= $stvl->pm_productid ?>/<?= $stvl->pm_qty ?>/<?= $stvl->pm_productionid ?>" ><i class="fas fa-pen"></i> Edit</a>
                                                    <?php 
                                                    }
                                                    if($stvl->pm_deliverynote != 1)
                                                    {
                                                    ?>
                                                    <br/>
                                                    <a class="text-secondary" href="<?= base_url() ?>production/deliverynote/<?= $stvl->pm_productid ?>/<?= $stvl->pm_qty ?>/<?= $stvl->pm_productionid ?>" ><i class="fas fa-print"></i> Delivery Note</a>
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

    <!-- View modal content -->
        <div id="viewitemmmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Material Details</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body" id="itemdetailsdiv">

                       
                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light listbtns" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    
    <script type="text/javascript">
    
    function viewbillitemfun(billid)
    {
        $.ajax({
          url: '<?php echo site_url('production/getproductionitemdetails') ?>',
          type: 'POST',
          dataType: 'html',
          data: {billid: billid},
        })
        .done(function(result) {
          // console.log("success");
          $("#itemdetailsdiv").html(result);

        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
        $('#standard-modalLabel').html('Material Details');
        $('#viewitemmmodal').modal('show');
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

    
    
</script>