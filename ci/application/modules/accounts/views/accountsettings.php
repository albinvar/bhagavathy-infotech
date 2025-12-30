
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
                        <h4 class="page-title">Account Settings</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="formmainheading">Account Settings</h4>

                            <br/>

                            <?php 
                            if(!$profdet)
                            {
                                ?>
                                <div align="center" class="pd-10"><i>Account profile not completed, please <a href="<?= base_url() ?>accounts/accountprofileupdate/<?= $this->buid ?>">click here</a> to complete account profile.</i></div>
                                <?php
                            }else{
                            ?>

                            <form id="businessuserform" class="addformvalidate" name="businessuserform" method="post" action="<?php echo site_url('accounts/updateaccountsettings') ?>" enctype="multipart/form-data">
                            <input type="hidden" id="buid" name="buid" value="<?= $this->buid ?>">
                            <input type="hidden" id="accproid" name="accproid" value="<?= $profdet->ap_accprofileid ?>">
                            
                            <div class="row">
                                <div class="col-md-6" align="right">
                                    <label>Show Currency: </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label><input type="radio" <?php if($profdet->ap_showcurrency == 1){ echo "checked"; } ?> name="showcurrency" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($profdet->ap_showcurrency == 0){ echo "checked"; } ?> name="showcurrency" value="0"> No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" align="right">
                                    <label>Currency Symbol Position: </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label><input type="radio" name="symbolposition" <?php if($profdet->ap_sufprefixsymbol == 1){ echo "checked"; } ?> value="1"> Suffix</label> &nbsp; &nbsp;
                                        <label><input type="radio" name="symbolposition" <?php if($profdet->ap_sufprefixsymbol == 0){ echo "checked"; } ?> value="0"> Prefic</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" align="right">
                                    <label>No of Decimal Points: </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <input type="number" class="form-control" style="width: 100px" name="decimalpoint" value="<?= $profdet->ap_noofdecimal ?>" id="decimalpoint">
                                    </div>
                                </div>
                            </div>

                            

                            
                            <div class="row text-right mt-3">
                                <div class="col-md-12 text-center pull-right">
                                    <button type="submit" class="btn btn-primary mr-2 addfacilitySubmit listbtns"
                                        id="addfacilitySubmit">Submit</button>
                                </div>
                            </div>

                        </form>
                        <?php 
                        }
                        ?>

                        </div>
                    </div>
                </div>
            </div>

            
            
        </div> <!-- container -->

    </div> <!-- content -->
