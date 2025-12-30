
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
                            <a href="<?= base_url() ?>business/suppliers" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="far fa-arrow-alt-circle-left"></i> Back</button>
                            </a>
                        </div>
                        <h4 class="page-title"><?= $title ?></h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="formmainheading">Supplier Details</h4>

                            <form id="businessuserform" class="addformvalidate" name="businessuserform" method="post" action="<?php echo site_url('business/addsupplierprocess') ?>" enctype="multipart/form-data">
                            <input type="hidden" id="editid" name="editid" value="<?= $editid ?>">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Company Name *</label>

                                        <input type="text" required
                                            value="<?=(isset($editdata)) ? $editdata->sp_name : ''?>"
                                            data-parsley-minlength="1" class="form-control" name="companyname" id="companyname"
                                            placeholder="Company Name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>City</label>
                                        <input type="text" value="<?=(isset($editdata)) ? $editdata->sp_city : ''?>" class="form-control" name="city" id="city"
                                            placeholder="City">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label>Address</label>

                                        <input type="text" value="<?=(isset($editdata)) ? $editdata->sp_address : ''?>" data-parsley-minlength="1" class="form-control" name="address" id="address" placeholder="Address">
                                    </div>
                                </div>

                               
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country *</label>
                                        <select class="form-select" name="country" id="country" onchange="statelistfunf(this.value)" required>
                                            <?php
                                            if($countries)
                                            {
                                                foreach($countries as $cnval)
                                                {
                                                    ?>
                                                    <option <?php if(isset($editdata)){ if($editdata->sp_country == $cnval->id){ echo "selected"; } }else{ if($cnval->id == '101'){ echo "selected"; }} ?> value="<?= $cnval->id ?>"><?= $cnval->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State *</label>
                                        <select class="form-select" required="required" name="state" id="state">
                                            <option value="">Select State</option>
                                            <?php
                                            if($states)
                                            {
                                                foreach($states as $stval)
                                                {
                                                    ?>
                                                    <option <?php if(isset($editdata)){ if($editdata->sp_state == $stval->id){ echo "selected"; } } ?> value="<?= $stval->id ?>"><?= $stval->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" id="phone" value="<?=(isset($editdata)) ? $editdata->sp_contactnumber : ''?>" name="phone" placeholder="Phone Number">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Mobile</label>

                                        <input type="text" required 
                                            data-parsley-minlength="1" class="form-control" value="<?=(isset($editdata)) ? $editdata->sp_mobile : ''?>" name="mobile" id="mobile"
                                            placeholder="Mobile">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Email</label>
                                        <input type="text" class="form-control" id="email" value="<?=(isset($editdata)) ? $editdata->sp_email : ''?>" name="email" placeholder="Email">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Website</label>

                                        <input type="text" class="form-control" name="website" value="<?=(isset($editdata)) ? $editdata->sp_website : ''?>" id="website"
                                            placeholder="Website">
                                    </div>
                                </div>
                            </div>

                            
                            <h4> Contact Person Details </h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Contact Person Name</label>
                                        <input type="text" required class="form-control" value="<?=(isset($editdata)) ? $editdata->sp_contactperson : ''?>" id="contactperson" name="contactperson" placeholder="Contact Person Name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Contact Person Phone</label>

                                        <input type="text" required
                                            data-parsley-minlength="1" class="form-control" value="<?=(isset($editdata)) ? $editdata->sp_contactphone : ''?>" name="personphone" id="personphone"
                                            placeholder="Phone">
                                    </div>
                                </div>
                            </div>
                            
                            
                            <h4> Account Details </h4>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label><?= $this->isvatgstname ?> Number</label>
                                        <input type="text"  class="form-control" id="gstnumber" value="<?=(isset($editdata)) ? $editdata->sp_gstno : ''?>" name="gstnumber" placeholder="<?= $this->isvatgstname ?>">
                                    </div>
                                </div>

                                <?php 
                                $isledgerentry= 0;
                                if(isset($supledgr))
                                {
                                    if($supledgr)
                                    {
                                        $isledgerentry= 1;
                                    }
                                }
                                ?>
                                <input type="hidden" name="isledgerentry" id="isledgerentry" value="<?= $isledgerentry ?>">
                                <?php
                                if($isledgerentry == 0)
                                {
                                ?>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Balance Amount</label>
                                        <input type="number" value="0" class="form-control" value="<?=(isset($editdata)) ? $editdata->sp_balanceamount : ''?>" id="balanceamnt" name="balanceamnt" placeholder="Amount">
                                    </div>
                                </div>
                                <?php 
                                }
                                ?>
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

    <script type="text/javascript">
        function statelistfunf(country)
        {
            $('#state').empty();
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>business/getstateliststajax",
                data: { 'countryid': country },
                success: function(data){
                    // Parse the returned json data
                    var opts = $.parseJSON(data);
                    $('#state').append('<option value="">Select State</option>');
                    $.each(opts, function(i, d) {
                        $('#state').append('<option value="' + d.id + '">' + d.name + '</option>');
                    });
                }
            });
        }
    </script>