
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
                            
                            <a href="<?= base_url() ?>production/designproductmaterial" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Design Product</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Product Designs</h4>
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
                                        <th>Product</th>
                                        <th>Materials</th>
                                        <th>Average Time (In hrs)</th>
                                        <th>Average Cost</th>
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
                                                <td><?= $stvl->pd_productname ?> (<?= $stvl->pd_productcode ?>)</td>
                                                
                                                <td>
                                                    <a href="javascript:void(0)" onclick="viewbillitemfun('<?= $stvl->pmd_productdesignid ?>')" class="text-primary"><i class="fas fa-eye"></i> View</a>
                                                </td>

                                                <td><?= $stvl->pmd_averagaetime ?></td>
                                                <td><?= $stvl->pmd_averagecost ?></td>
                                                
                                                <td>
                                                    <a class="text-primary" href="<?= base_url() ?>production/designproductmaterial/<?= $stvl->pmd_productdesignid ?>" ><i class="fas fa-pen"></i> Edit</a>
                                                    
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
          url: '<?php echo site_url('production/getbillitemdetails') ?>',
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