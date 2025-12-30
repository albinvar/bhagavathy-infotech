
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
                            <a href="<?= base_url() ?>admin/business" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="far fa-arrow-alt-circle-left"></i> Back</button>
                            </a>
                        </div>
                        <h4 class="page-title">Add Business</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="formmainheading">Business Details</h4>

                            <form id="businessuserform" class="addformvalidate" name="businessuserform" method="post" action="<?php echo site_url('admin/addbusinessprocess') ?>" enctype="multipart/form-data">
                            <input type="hidden" id="editid" name="editid" value="<?=(isset($id)) ? $id : ''?>">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Business Name</label>

                                        <input type="text" required
                                            value="<?=(isset($propertydata)) ? $propertydata->fc_name : ''?>"
                                            class="form-control" id="facilityname" name="facilityname" placeholder="Business Name">
                                    </div>

                                    <label>Business Logo</label>
                                    <div class="custom-file">

                                        <input class="custom-file-input" name="facilitylogo" id="facilitylogo" type="file">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="clubaddress">Business Address</label>
                                        <textarea class="form-control" id="facilityaddress" name="facilityaddress" rows="4" required
                                            placeholder="Business Address"><?=(isset($propertydata)) ? $propertydata->fc_address : ''?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group ">
                                        <label>Number of Business Units</label>
                                        <input type="number" required
                                            value="<?=(isset($propertydata)) ? $propertydata->fc_sitesnumber : ''?>"
                                            data-parsley-minlength="1" data-parsley-type="number" name="numberfecilities" onkeypress="return isNumberKey(event)" class="form-control" id="numberfecilities"
                                            placeholder="Number of Business Units">
                                    </div>
                                </div>

                                <div class="col-lg-6 grid-margin grid-margin-lg-0">
                                    <div class="form-group ">
                                        <label>Number of Staff</label>
                                        <input type="number" required
                                            value="<?=(isset($propertydata)) ? $propertydata->fc_sitesnumber : ''?>"
                                            data-parsley-minlength="1" data-parsley-type="number" name="numberofstaff" onkeypress="return isNumberKey(event)" class="form-control" id="numberofstaff"
                                            placeholder="Number of Staff">
                                    </div>
                                </div>
                            </div>


                            <h4> Contact Details </h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Website</label>
                                        <input type="text"
                                            value="<?=(isset($propertydata)) ? $propertydata->fc_website : ''?>"
                                            data-parsley-type="url" class="form-control" name="facilitywebsite" id="facilitywebsite"
                                            placeholder="Business Website" data-parsley-type="url">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Email</label>
                                        <input type="text" required
                                            value="<?=(isset($propertydata)) ? $propertydata->fc_email : ''?>"
                                            data-parsley-type="email" class="form-control" name="facilityemail" id="facilityemail"
                                            placeholder="Business Email">
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Phone</label>

                                        <input type="text" required
                                            value="<?=(isset($propertydata)) ? $propertydata->fc_phone : ''?>"
                                            data-parsley-minlength="1" class="form-control" name="facilityphone" id="facilityphone"
                                            placeholder="Business Phone">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    
                                </div>
                            </div>

                            <h4> Login Details </h4>

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
