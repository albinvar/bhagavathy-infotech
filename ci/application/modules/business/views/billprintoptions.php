
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
                        <h4 class="page-title">Bill Print Options</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="formmainheading mt-0">Bill Print Details</h4>

                            <form id="businessuserform" class="addformvalidate" name="businessuserform" method="post" action="<?php echo site_url('business/updatebillprintdetails') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="editid" value="<?=(($billprintdet)) ? $billprintdet->bp_printsettingid : ''?>">
                            
                            <div class="row">
                                <div class="col-md-3 mt-2">
                                    <label>Order number prefix</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_orderprefix : ''?>" class="form-control" id="bp_orderprefix" name="bp_orderprefix">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Retail bill number prefix</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_retailprefix : ''?>" class="form-control" id="bp_retailprefix" name="bp_retailprefix">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Wholesale bill number prefix</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_wholesaleprefix : ''?>" class="form-control" id="bp_wholesaleprefix" name="bp_wholesaleprefix">
                                </div>

                                <?php 
                                if($inventorysettings)
                                {
                                    if($inventorysettings->is_isfourrate == 1)
                                    {
                                        ?>
                                        <div class="col-md-3 mt-2">
                                            <label>C Sale prefix</label>
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_csaleprefix : ''?>" class="form-control" id="bp_csaleprefix" name="bp_csaleprefix">
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <label>D Sale prefix</label>
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_dsaleprefix : ''?>" class="form-control" id="bp_dsaleprefix" name="bp_dsaleprefix">
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                                
                                
                                <div class="col-md-3 mt-2">
                                    <label>Proforma bill number prefix</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_proformaprefix : ''?>" class="form-control" id="bp_proformaprefix" name="bp_proformaprefix">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Wholesale proforma bill number prefix</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_wholesaleproformaprefix : ''?>" class="form-control" id="bp_wholesaleproformaprefix" name="bp_wholesaleproformaprefix">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Quotation bill number prefix</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_quotationprefix : ''?>" class="form-control" id="bp_quotationprefix" name="bp_quotationprefix">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Wholesale quotation bill number prefix</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_wholesalequotationprefix : ''?>" class="form-control" id="bp_wholesalequotationprefix" name="bp_wholesalequotationprefix">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Sale return prefix</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_salereturnprefix : ''?>" class="form-control" id="bp_salereturnprefix" name="bp_salereturnprefix">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Service bill number prefix</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_servicebillprefix : ''?>" class="form-control" id="bp_servicebillprefix" name="bp_servicebillprefix">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Purchase bill number prefix</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_purchasebillprefix : ''?>" class="form-control" id="bp_purchasebillprefix" name="bp_purchasebillprefix">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Purchase order bill number prefix</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_purchaseorderprefix : ''?>" class="form-control" id="bp_purchaseorderprefix" name="bp_purchaseorderprefix">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Purchase return prefix</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="text" value="<?=(($billprintdet)) ? $billprintdet->bp_purchasereturnprefix : ''?>" class="form-control" id="bp_purchasereturnprefix" name="bp_purchasereturnprefix">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Default page size</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <select class="w-100 form-control" name="bp_defaultpagesize" id="bp_defaultpagesize">
                                        <option <?php if($billprintdet){ if($billprintdet->bp_defaultpagesize==1){ echo "selected"; } } ?> value="1">A4</option>
                                        <option <?php if($billprintdet){ if($billprintdet->bp_defaultpagesize==2){ echo "selected"; } } ?> value="2">A5</option>
                                        <option <?php if($billprintdet){ if($billprintdet->bp_defaultpagesize==3){ echo "selected"; } } ?> value="3">Thermal</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Remark field in billing</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                     <div class="form-group ">
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_remarkcolumn == 1){ echo "checked"; }} ?> name="remarkcolumn" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_remarkcolumn == 0){ echo "checked"; }} ?> name="remarkcolumn" value="0"> No</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Hide purchase price field</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                     <div class="form-group ">
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_hidepurchaseprice == 1){ echo "checked"; }} ?> name="bp_hidepurchaseprice" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_hidepurchaseprice == 0){ echo "checked"; }} ?> name="bp_hidepurchaseprice" value="0"> No</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Hide vehicle number field</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                     <div class="form-group ">
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_hidevehiclenumber == 1){ echo "checked"; }} ?> name="bp_hidevehiclenumber" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_hidevehiclenumber == 0){ echo "checked"; }} ?> name="bp_hidevehiclenumber" value="0"> No</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Hide eway bill number field</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                     <div class="form-group ">
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_hideewaybillno == 1){ echo "checked"; }} ?> name="bp_hideewaybillno" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_hideewaybillno == 0){ echo "checked"; }} ?> name="bp_hideewaybillno" value="0"> No</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Hide delivery date field</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                     <div class="form-group ">
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_hidedeliverydate == 1){ echo "checked"; }} ?> name="bp_hidedeliverydate" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_hidedeliverydate == 0){ echo "checked"; }} ?> name="bp_hidedeliverydate" value="0"> No</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Hide purchase order details</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                     <div class="form-group ">
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_hidepodetails == 1){ echo "checked"; }} ?> name="bp_hidepodetails" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_hidepodetails == 0){ echo "checked"; }} ?> name="bp_hidepodetails" value="0"> No</label>
                                    </div>
                                </div>


                                <div class="col-md-3 mt-2">
                                    <label>Need Duplication Invoice</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                     <div class="form-group ">
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_needdupinvoice == 1){ echo "checked"; }} ?> name="bp_needdupinvoice" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_needdupinvoice == 0){ echo "checked"; }} ?> name="bp_needdupinvoice" value="0"> No</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>Need Triplicate Invoice</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                     <div class="form-group ">
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_needtripinvoice == 1){ echo "checked"; }} ?> name="bp_needtripinvoice" value="1"> Yes</label> &nbsp; &nbsp;
                                        <label><input type="radio" <?php if($billprintdet){ if($billprintdet->bp_needtripinvoice == 0){ echo "checked"; }} ?> name="bp_needtripinvoice" value="0"> No</label>
                                    </div>
                                </div>
                                
                            </div>
                            <br/>

                           
                            
                            
                            <div class="row text-right mt-1">
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