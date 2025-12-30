
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
                            <input type="hidden" id="editid" name="editid" value="<?= $editid ?>">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Business Unit</label>
                                        <select class="form-select" name="businessunitid" id="businessunitid" required>
                                            
                                            <option value="<?= $this->buid ?>"><?= $this->global_bu_name ?></option>
                                                    
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
                                                    <option <?php if(isset($editdata)){ if($editdata->at_usertypeid == $utval->ut_usertypeid){ echo "selected"; } } ?> value="<?= $utval->ut_usertypeid ?>"><?= $utval->ut_usertype ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                 <?php 
                                    if($inventorysettings)
                                    {
                                        if($inventorysettings->is_godown == 1)
                                        {
                                            ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Select Godown</label>
                                                    <select class="form-select" name="godownid" id="godownid">
                                                        <option value="">Select Godown</option>
                                                        <?php
                                                        if($godowns)
                                                        {
                                                            foreach($godowns as $gdval)
                                                            {
                                                                ?>
                                                                <option <?php if(isset($editdata)){ if($editdata->at_godownid == $gdval->gd_godownid){ echo "selected"; } } ?> value="<?= $gdval->gd_godownid ?>"><?= $gdval->gd_godownname ?>(<?= $gdval->gd_godowncode ?>)</option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                
                            </div>

                            


                            <h4> Contact Details </h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Name</label>
                                        <input type="text" required class="form-control" id="firstname" name="firstname" placeholder="First Name" value="<?=(isset($editdata)) ? $editdata->at_name : ''?>">
                                    </div>
                                </div>

                                <!--<div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Last Name</label>
                                        <input type="text" required class="form-control" id="lastname" name="lastname" placeholder="Last Name">
                                    </div>
                                </div>-->
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Phone</label>

                                        <input type="text" required
                                            value="<?=(isset($editdata)) ? $editdata->at_phone : ''?>"
                                            data-parsley-minlength="1" class="form-control" name="phone" id="phone"
                                            placeholder="Phone">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Email</label>
                                        <input type="text"
                                            value="<?=(isset($editdata)) ? $editdata->at_email : ''?>"
                                            data-parsley-type="email" class="form-control" name="email" id="email"
                                            placeholder="Email">
                                    </div>
                                </div>
                            </div>

                            <?php 
                            if(!isset($editdata))
                            {
                            ?>
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
                            <?php 
                            }
                            ?>

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