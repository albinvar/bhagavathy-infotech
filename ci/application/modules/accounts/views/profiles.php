
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
                        
                        <h4 class="page-title">Accounts Profiles</h4>
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
                                                <td><a href="<?php echo site_url('accounts/accountprofileview/' . $bvl->bu_businessunitid); ?>"><?= $bvl->bu_unitname ?></a></td>
                                                <td><?= $bvl->bt_businesstype ?></td>
                                                <td><?= $bvl->bu_address ?></td>
                                                <td><?= $bvl->bu_phone ?></td>
                                                <td>

                                                    <a class="text-primary" href="<?php echo site_url('accounts/accountprofileview/' . $bvl->bu_businessunitid); ?>" class="ml-2 text-primary"><i class="fas fa-eye"></i> View</a> &nbsp;
                                                    <a class="text-warning" href="<?php echo site_url('accounts/accountprofileupdate/' . $bvl->bu_businessunitid); ?>" class="ml-2 text-primary"><i class="fas fa-pen"></i> Edit</a>
                                                       
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