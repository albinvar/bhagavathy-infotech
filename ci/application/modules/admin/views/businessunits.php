
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
                            <a href="<?= base_url() ?>admin/addbusinessunit" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Business Unit</button>
                            </a>
                        </div>
                        <h4 class="page-title">Business Units</h4>
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
                                        <th>Unit Name</th>
                                        <th>Business</th>
                                        <th>Business Type</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($businessunits)
                                    {
                                        $k=1;
                                        foreach($businessunits as $bvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $bvl->bu_unitname ?></td>
                                                <td><?= $bvl->bs_name ?></td>
                                                <td><?= $bvl->bt_businesstype ?></td>
                                                <td><?= $bvl->bu_address ?></td>
                                                <td><?= $bvl->bu_phone ?></td>
                                                <td>
                                                    <?php if($bvl->bu_isactive): ?>
                                                        <a href="<?php echo site_url('admin/enabledisablebustype/' . $bvl->bu_businessunitid); ?>" class="text-success" onclick="return confirm('Are you sure?')"><i class="fas fa-check"></i> Enable</a>
                                                        <?php else: ?>
                                                        <a href="<?php echo site_url('admin/enabledisablebustype/' . $bvl->bu_businessunitid .'/1'); ?>" onclick="return confirm('Are you sure?')" class="ml-2 text-danger"><i class="fas fa-times"></i> Disable</a>
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
                        <h4 class="modal-title" id="standard-modalLabel">Add Business Type</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?php echo base_url(); ?>admin/addingbusinesstype" name="renewchiropodiform" id="renewchiropodiform" class="form-horizontal" method="post" onsubmit="return validateForm()">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Business Type</label>
                                    <input type="text" name="butype" required class="form-control" id="butype" placeholder="Type">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <label for="field-7" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea>
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