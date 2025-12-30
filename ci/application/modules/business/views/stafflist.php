
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
                            <?php 
                            $balance = $businssdet->bs_staffcount - $staffscnt;
                            if($staffscnt < $businssdet->bs_staffcount)
                            {
                                ?>
                                <a href="<?= base_url() ?>business/addstaff" class="ms-1">
                                    <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Staff (<?= $balance ?> available)</button>
                                </a>
                                <?php
                            }
                            ?>
                            
                        </div>
                        <h4 class="page-title">Staff List</h4>
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
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Username</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($staffs)
                                    {
                                        $k=1;
                                        foreach($staffs as $stvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $stvl->at_name ?></td>
                                                <td><?= $stvl->ut_usertype ?></td>
                                                <td><?= $stvl->at_email ?></td>
                                                <td><?= $stvl->at_phone ?></td>
                                                <td><?= $stvl->at_username ?></td>
                                                <td>

                                                    <?php if($stvl->at_isactive): ?>
                                                        <a href="<?php echo site_url('business/enabledisablestaff/' . $stvl->at_authid); ?>" class="text-success" onclick="return confirm('Are you sure?')"><i class="fas fa-check"></i> Enable</a>
                                                        <?php else: ?>
                                                            <a class="text-info" href="<?php echo site_url('business/addstaff/' . $stvl->at_authid); ?>"><i class="fas fa-pen"></i> Edit</a> &nbsp;
                                                            
                                                        <a href="<?php echo site_url('business/enabledisablestaff/' . $stvl->at_authid .'/1'); ?>" onclick="return confirm('Are you sure?')" class="ml-2 text-danger"><i class="fas fa-times"></i> Disable</a>
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