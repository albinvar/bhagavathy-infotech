
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
                            <a href="<?= base_url() ?>accounts/profiles" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="far fa-arrow-alt-circle-left"></i> Back</button>
                            </a>
                        </div>
                        <h4 class="page-title">Account Profile</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="formmainheading">Account Profile Details</h4>

                            <form id="businessuserform" class="addformvalidate" name="businessuserform" method="post" action="<?php echo site_url('accounts/updateaccountprofiledetails') ?>" enctype="multipart/form-data">
                            <input type="hidden" id="buid" name="buid" value="<?= $buid ?>">
                            <input type="hidden" id="accproid" name="accproid" value="<?= $businessdet->ap_accprofileid ?>">
                            
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Profile Name</label>
                                        <input type="text" required
                                            value="<?=(isset($businessdet)) ? $businessdet->bu_unitname : ''?>"
                                            class="form-control" id="unitname" name="unitname" placeholder="Profile Name">
                                    </div>

                                    <label>Country</label>
                                    <select class="form-select" name="country" id="country" onchange="statelistfunf(this.value)" required>
                                            <?php
                                            if($countries)
                                            {
                                                foreach($countries as $cnval)
                                                {
                                                    ?>
                                                    <option <?php if(isset($businessdet)){ if($businessdet->bu_country == $cnval->id){ echo "selected"; } } else{ if($cnval->id == '101'){ echo "selected"; }} ?> value="<?= $cnval->id ?>"><?= $cnval->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="clubaddress">Address</label>
                                        <textarea class="form-control" id="unitaddress" name="unitaddress" rows="4" required
                                            placeholder="Address"><?=(isset($businessdet)) ? $businessdet->bu_address : ''?></textarea>
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
                                                    <option <?php if(isset($businessdet)){ if($businessdet->bu_state == $stval->id){ echo "selected"; } } ?> value="<?= $stval->id ?>"><?= $stval->name ?></option>
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
                                        <label><?= $this->isvatgstname ?> No</label>

                                        <input type="text" value="<?=(isset($businessdet)) ? $businessdet->bu_gstnumber : ''?>" data-parsley-minlength="1" class="form-control" name="gstno" id="gstno" placeholder="<?= $this->isvatgstname ?> Number">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Other License Number</label>
                                        <input type="text"
                                            value="<?=(isset($businessdet)) ? $businessdet->ap_otherlicenceno : ''?>" class="form-control" name="otherlicence" id="otherlicence" placeholder="Other License Number">
                                    </div>
                                </div>
                                
                            </div>

                            <!--<div class="row">

                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label>Financial Year</label>
                                        <input type="text" required
                                            value="<?=(isset($businessdet)) ? $businessdet->ap_financialyearname : ''?>"
                                            data-parsley-minlength="1" class="form-control" name="financialyear" id="financialyear" placeholder="Financial Year">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label>Financial Start Date</label>
                                        <input type="date" value="<?=(isset($businessdet)) ? $businessdet->ap_startdate : ''?>" data-parsley-minlength="1" class="form-control" name="startfinancialyear" id="startfinancialyear" placeholder="Financial Start Date">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label>Financial End Date</label>

                                        <input type="date" value="<?=(isset($businessdet)) ? $businessdet->ap_enddate : ''?>" data-parsley-minlength="1" class="form-control" name="endfinancialyear" id="endfinancialyear" placeholder="Financial End Date">
                                    </div>
                                </div>
                            </div>-->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Unit Logo</label>
                                        <input type="file" class="form-control" name="unitlogo" id="unitlogo" >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Start Transaction Date</label>
                                        <input type="date" value="<?=(isset($businessdet)) ? $businessdet->ap_transcationstartdate : ''?>" data-parsley-type="email" class="form-control" name="transcationstart" id="transcationstart" placeholder="Start Transaction Date">
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

<script type="text/javascript">
    function statelistfunf(val) {
        $('#state').empty();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>accounts/getcountrystatesajax",
            data: { 'countryid': val},
            success: function(data){
                // Parse the returned json data
                var opts = $.parseJSON(data);
                // Use jQuery's each to iterate over the opts value
                $.each(opts, function(i, d) {
                    // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                    $('#state').append('<option value="' + d.id + '">' + d.name + '</option>');

                    //$('#shopids').SumoSelect({ selectAll: true }).sumo.reload();
                });


            }
        });
    }
</script>