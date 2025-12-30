
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
                        <h4 class="page-title">Inventory Settings</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="formmainheading">Inventory Settings</h4>

                            <br/>

                            
                            <form id="businessuserform" class="addformvalidate" name="businessuserform" method="post" action="<?php echo site_url('inventory/updateinventorysettings') ?>" enctype="multipart/form-data">
                            <input type="hidden" id="buid" name="buid" value="<?= $this->buid ?>">
                            <input type="hidden" id="inventsettid" name="inventsettid" value="<?php if($inventorysetting){ echo $inventorysetting->is_inventorysettingid; } ?>">
                            
                            <div class="row">
                                <div class="col-md-6" align="right">
                                    <label>Product Category: </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label><input type="radio" required <?php if($inventorysetting){ if($inventorysetting->is_categorywise == 1){ echo "checked"; }} ?> name="prodcategory" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_categorywise == 0){ echo "checked"; }} ?> name="prodcategory" value="0"> No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" align="right">
                                    <label>Product Image Used: </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_image == 1){ echo "checked"; }} ?> name="prodimage" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_image == 0){ echo "checked"; }} ?> name="prodimage" value="0"> No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" align="right">
                                    <label>Product Expiry Date: </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_expirydate == 1){ echo "checked"; }} ?> name="prodexpiry" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_expirydate == 0){ echo "checked"; }} ?> name="prodexpiry" value="0"> No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" align="right">
                                    <label>Barcode/QR: </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_barqr == 1){ echo "checked"; }} ?> name="barqr" value="1"> Bar Code</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_barqr == 2){ echo "checked"; }} ?> name="barqr" value="2"> QR Code</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_barqr == 0){ echo "checked"; }} ?> name="barqr" value="0"> Not Used</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" align="right">
                                    <label>HSN: </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_hsn == 1){ echo "checked"; }} ?> name="prodhsn" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_hsn == 0){ echo "checked"; }} ?> name="prodhsn" value="0"> No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" align="right">
                                    <label>Product Wastage: </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_wastage == 1){ echo "checked"; }} ?> name="prodwastage" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_wastage == 0){ echo "checked"; }} ?> name="prodwastage" value="0"> No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" align="right">
                                    <label>Batch Wise: </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_batchwise == 1){ echo "checked"; }} ?> name="batchwise" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_batchwise == 0){ echo "checked"; }} ?> name="batchwise" value="0"> No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" align="right">
                                    <label>Supplier: </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_supplier == 1){ echo "checked"; }} ?> name="is_supplier" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_supplier == 0){ echo "checked"; }} ?> name="is_supplier" value="0"> No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" align="right">
                                    <label>Godown: </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_godown == 1){ echo "checked"; }} ?> name="is_godown" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_godown == 0){ echo "checked"; }} ?> name="is_godown" value="0"> No</label>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6" align="right">
                                    <label>Four Rates Used: </label>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_isfourrate == 1){ echo "checked"; }} ?> name="is_isfourrate" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($inventorysetting){ if($inventorysetting->is_isfourrate == 0){ echo "checked"; }} ?> name="is_isfourrate" value="0"> No</label>
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
                        

                        </div>
                    </div>
                </div>
            </div>

            
            
        </div> <!-- container -->

    </div> <!-- content -->
