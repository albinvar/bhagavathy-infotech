
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
                            <a href="<?= base_url() ?>business/staff" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="far fa-arrow-alt-circle-left"></i> Back</button>
                            </a>
                        </div>
                        <h4 class="page-title">Add Staff</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="formmainheading">Staff Details</h4>

                            <form id="businessuserform" class="addformvalidate" name="businessuserform" method="post" action="<?php echo site_url('business/addstaffprocess') ?>" enctype="multipart/form-data">
                            <input type="hidden" id="editid" name="editid" value="<?=(isset($id)) ? $id : ''?>">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Business Unit</label>
                                        <select class="form-select" name="businessunitid" id="businessunitid" required>
                                            <?php
                                            if($buunits)
                                            {
                                                foreach($buunits as $buval)
                                                {
                                                    ?>
                                                    <option value="<?= $buval->bu_businessunitid ?>"><?= $buval->bu_unitname ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Designation</label>
                                        <select class="form-select" name="usertypeid" id="usertypeid" required>
                                            <?php
                                            if($usertypes)
                                            {
                                                foreach($usertypes as $utval)
                                                {
                                                    ?>
                                                    <option value="<?= $utval->ut_usertypeid ?>"><?= $utval->ut_usertype ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>

                            


                            <h4> Contact Details </h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>First Name</label>
                                        <input type="text" required class="form-control" id="firstname" name="firstname" placeholder="First Name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Last Name</label>
                                        <input type="text" required class="form-control" id="lastname" name="lastname" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Phone</label>

                                        <input type="text" required
                                            value="<?=(isset($propertydata)) ? $propertydata->fc_phone : ''?>"
                                            data-parsley-minlength="1" class="form-control" name="phone" id="phone"
                                            placeholder="Phone">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Email</label>
                                        <input type="text"
                                            value="<?=(isset($propertydata)) ? $propertydata->fc_email : ''?>"
                                            data-parsley-type="email" class="form-control" name="email" id="email"
                                            placeholder="Email">
                                    </div>
                                </div>
                            </div>

                            
                            <h4> Login Details </h4>

                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Username</label>
                                        <input type="text" required  class="form-control" id="username" name="username" placeholder="Username">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Password</label>
                                        <input type="password" required class="form-control" id="password" name="password" placeholder="Password">
                                    </div>
                                </div>
                            </div>

                            <div class="row text-right mt-3">
                                <div class="col-md-12 text-center pull-right">
                                    <button type="submit" class="btn btn-primary mr-2 addfacilitySubmit listbtns"
                                        id="addfacilitySubmit">Submit</button>
                                    <a href="javascript:history.go(-1);" class="btn btn-secondary listbtns">Cancel</a>
                                </div>
                            </div>

                        </form>

                        </div>
                    </div>
                </div>
            </div>

            
            
        </div> <!-- container -->

    </div> <!-- content -->