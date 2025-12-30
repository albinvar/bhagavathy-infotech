
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
                            <!--<a href="<?= base_url() ?>accounts/profiles" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="far fa-arrow-alt-circle-left"></i> Back</button>
                            </a>-->
                        </div>
                        <h4 class="page-title">Update Profile</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="formmainheading mt-0">Unit Profile Details</h4>

                            <form id="businessuserform" class="addformvalidate" name="businessuserform" method="post" action="<?php echo site_url('business/updatebusinessunitprofile') ?>" enctype="multipart/form-data">
                            
                            
                            <div class="row">
                                <div class="col-md-3 mt-2">
                                    <label>Unit Name</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <input type="text" required value="<?=(isset($businessdet)) ? $businessdet->bu_unitname : ''?>" class="form-control" id="unitname" name="unitname">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Address</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <textarea class="form-control" id="unitaddress" name="unitaddress" rows="4" required
                                            placeholder="Address"><?=(isset($businessdet)) ? $businessdet->bu_address : ''?></textarea>
                                </div>
                                
                                <div class="col-md-3 mt-2">
                                    <label>Phone</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <input type="text" value="<?=(isset($businessdet)) ? $businessdet->bu_phone : ''?>" class="form-control" id="phone" name="phone">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Mobile</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <input type="text" required value="<?=(isset($businessdet)) ? $businessdet->bu_mobile : ''?>" class="form-control" id="mobile" name="mobile">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <input type="text" value="<?=(isset($businessdet)) ? $businessdet->bu_email : ''?>" class="form-control" id="email" name="email">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Website</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <input type="text" value="<?=(isset($businessdet)) ? $businessdet->bu_website : ''?>" class="form-control" id="website" name="website">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>GSTIN</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <input type="text" value="<?=(isset($businessdet)) ? $businessdet->bu_gstnumber : ''?>" class="form-control" id="gstnumber" name="gstnumber">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Unit Logo</label><br/>

                                </div>
                                <div class="col-md-2 mt-2">
                                    <?php 
                                    if($businessdet->bu_logo != "")
                                    {
                                        ?>
                                        <img src="<?= base_url() ?>uploads/business/<?= $businessdet->bu_logo ?>" width="100%" alt="user-image" >
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-7 mt-2">
                                    <input type="file" class="form-control" placeholder="Update logo" name="unitlogo" id="unitlogo" >
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Company Seal</label><br/>

                                </div>
                                <div class="col-md-2 mt-2">
                                    <?php 
                                    if($businessdet->bu_companyseal != "")
                                    {
                                        ?>
                                        <img src="<?= base_url() ?>uploads/business/<?= $businessdet->bu_companyseal ?>" width="100%" alt="user-image" >
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-7 mt-2">
                                    <input type="file" class="form-control" placeholder="Company Seal" name="companyseal" id="companyseal" >
                                </div>


                                <div class="col-md-3 mt-2">
                                    <label>Franchise From</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <input type="text" value="<?=(isset($businessdet)) ? $businessdet->bu_franchisefrom : ''?>" class="form-control" id="franchisefrom" name="franchisefrom">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Franchise Logo</label><br/>

                                </div>
                                <div class="col-md-2 mt-2">
                                    <?php 
                                    if($businessdet->bu_franchiselogo != "")
                                    {
                                        ?>
                                        <img src="<?= base_url() ?>uploads/business/<?= $businessdet->bu_franchiselogo ?>" width="100%" alt="user-image" >
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-7 mt-2">
                                    <input type="file" class="form-control" placeholder="Update logo" name="franchiselogo" id="franchiselogo" >
                                </div>

                                
                            </div>
                            <br/>

                           
                            <h4 class="page-title">Bank Details</h4>
                            
                            <div class="row">
                                <div class="col-md-3 mt-2">
                                    <label>Bank Name</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <input type="text" value="<?=(isset($businessdet)) ? $businessdet->bu_bankname : ''?>" class="form-control" id="bankname" name="bankname">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Account Number</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <input type="text" value="<?=(isset($businessdet)) ? $businessdet->bu_accountnumber : ''?>" class="form-control" id="accountnumber" name="accountnumber">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>IFSC Code</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <input type="text" value="<?=(isset($businessdet)) ? $businessdet->bu_ifsccode : ''?>" class="form-control" id="ifsccode" name="ifsccode">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Branch</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <input type="text" value="<?=(isset($businessdet)) ? $businessdet->bu_bankbranch : ''?>" class="form-control" id="branch" name="branch">
                                </div>
                            </div>
                            
                            <div class="row text-right mt-3">
                                <div class="col-md-12 text-center pull-right">
                                    <button type="submit" class="btn btn-primary mr-2 addfacilitySubmit listbtns"
                                        id="addfacilitySubmit">Update</button>
                                </div>
                            </div>

                        </form>

                        </div>
                    </div>
                </div>
            </div>

            
            
        </div> <!-- container -->

    </div> <!-- content -->
