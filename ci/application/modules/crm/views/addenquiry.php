
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
                            <a href="<?= base_url() ?>crm/enquirylist" class="ms-1">
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

                            <h4 class="formmainheading">Enquiry Details</h4>

                            <form id="businessuserform" class="addformvalidate" name="businessuserform" method="post" action="<?php echo site_url('crm/addenquiryprocess') ?>" enctype="multipart/form-data">
                            <input type="hidden" id="editid" name="editid" value="<?= $editid ?>">

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="customercheck"> <b>Enquiry Number: <?php if(isset($editdata)){ echo $editdata->en_enquiryprefix . $editdata->en_enquiryno; }else{ echo $enquiryno; } ?></b>
                                    <input type="hidden" value="<?php if(isset($editdata)){ echo $editdata->en_enquiryno; }else{ echo $enquiryno; } ?>"   name="enquirynumber" id="enquirynumber"></label>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label for="customercheck"> <b>Already existing customer?</b>
                                    <input type="checkbox" value="1" <?php if(isset($editdata)){ if($editdata->en_existingcust == 1){ echo "checked"; } } ?>  name="customercheck" id="customercheck"></label>
                                </div>
                            </div>

                            <div id="walkincustdiv" <?php if(isset($editdata)){ if($editdata->en_existingcust == 1){ ?> style="display: none;" <?php } } ?>>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Customer Name *</label>

                                        <input type="text" required
                                            value="<?=(isset($editdata)) ? $editdata->en_firstname : ''?>"
                                            data-parsley-minlength="1" class="form-control" name="customername" id="customername"
                                            placeholder="Customer Name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>City</label>
                                        <input type="text" value="<?=(isset($editdata)) ? $editdata->en_city : ''?>" class="form-control" name="city" id="city"
                                            placeholder="City">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label>Address</label>

                                        <input type="text" value="<?=(isset($editdata)) ? $editdata->en_address : ''?>" data-parsley-minlength="1" class="form-control" name="address" id="address" placeholder="Address">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country *</label>
                                        <select class="form-select pagesearchselect" name="country" id="country" onchange="statelistfunf(this.value)" required>
                                            <?php
                                            if($countries)
                                            {
                                                foreach($countries as $cnval)
                                                {
                                                    ?>
                                                    <option <?php if(isset($editdata)){ if($editdata->en_country == $cnval->id){ echo "selected"; } }else{ if($cnval->id == $businessdet->bu_country){ echo "selected"; }} ?> value="<?= $cnval->id ?>"><?= $cnval->name ?></option>
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
                                        <select class="form-select pagesearchselect" required="required" name="state" id="state">
                                            <option value="">Select State</option>
                                            <?php
                                            if($states)
                                            {
                                                foreach($states as $stval)
                                                {
                                                    ?>
                                                    <option <?php if(isset($editdata)){ if($editdata->en_state == $stval->id){ echo "selected"; } }else{ if($stval->id == $businessdet->bu_state){ echo "selected"; }} ?> value="<?= $stval->id ?>"><?= $stval->name ?></option>
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
                                        <input type="text" value="<?=(isset($editdata)) ? $editdata->en_phone : ''?>" class="form-control" id="phone" name="phone" placeholder="Phone Number">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Mobile*</label>

                                        <input type="text" required  value="<?=(isset($editdata)) ? $editdata->en_mobile : ''?>" data-parsley-minlength="1" class="form-control" name="mobile" id="mobile"
                                            placeholder="Mobile">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Email</label>
                                        <input type="text" class="form-control" value="<?=(isset($editdata)) ? $editdata->en_email : ''?>" id="email" name="email" placeholder="Email">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Select Type</label>
                                        <select class="form-control" onchange="changecustomerfun(this.value)" name="customertype" id="customertype">
                                            <option <?php if(isset($editdata)){ if($editdata->en_customertype==0){ echo "selected"; } } ?> value="0">B2C</option>
                                            <option <?php if(isset($editdata)){ if($editdata->en_customertype==1){ echo "selected"; } } ?> value="1">B2B</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6" id="gstdiv" <?php if(isset($editdata)){ if($editdata->en_customertype==0){ ?> style="display: none;" <?php }}else{ ?> style="display: none;" <?php  } ?>>
                                    <div class="form-group ">
                                        <label><?= $this->isvatgstname ?> No</label>
                                        <input type="text" class="form-control" value="<?=(isset($editdata)) ? $editdata->en_gstno : ''?>" id="gstno" name="gstno" placeholder="<?= $this->isvatgstname ?>">
                                    </div>
                                </div>
                                
                            </div>

                        </div>

                        <div id="existcustdiv" <?php if(isset($editdata)){ if($editdata->en_existingcust == 0){ ?> style="display: none;" <?php } }else{ ?> style="display: none;" <?php } ?>>
                            <div class="row mt-2 mb-2">
                                <div class="col-md-6">
                                    <label>Select Customer*</label> <br/>
                                    <select class="form-select pagesearchselect form-control" name="customerid" id="customerid" style="width: 100%">
                                        <option value="">Select Customer</option>
                                        <?php
                                        if($customers)
                                        {
                                            foreach($customers as $ctval)
                                            {
                                                ?>
                                                <option <?php if(isset($editdata)){ if($editdata->en_customerid == $ctval->ct_cstomerid){ echo "selected"; } } ?> value="<?= $ctval->ct_cstomerid ?>"><?= $ctval->ct_name ?> (<?= $ctval->ct_address ?>)</option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label>Subject *</label>

                                        <input type="text" required="required" value="<?=(isset($editdata)) ? $editdata->en_subject : ''?>" data-parsley-minlength="1" class="form-control" name="subject" id="subject" placeholder="Subject">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Enquiry Details</label>
                                    <div id="snow-editor" style="height: 150px; width: 100%;">
                                        <?=(isset($editdata)) ? $editdata->en_enquiry : ''?>
                                    </div>

                                    <textarea style="display: none;" name="enquirydetails" id="enquirydetails"></textarea>
                                </div>
                            </div>

                            
                            
                            <div class="row text-right mt-3">
                                <div class="col-md-12 text-center pull-right">
                                    <button type="submit" class="btn btn-primary mr-2 addfacilitySubmit listbtns"
                                        id="addfacilitySubmit" onclick="copytext()">Submit</button>
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
function copytext()
{
    $("#enquirydetails").val($(".ql-editor").html());
}

var chech = document.getElementById('customercheck');
chech.onchange=function()
{
    if(this.checked)
    {
        $('#suppliertextbox').val("");
        $('#customerid').val(0);
        $('#customername').prop('required',false);
        $('#mobile').prop('required',false);
        $('#customerid').prop('required',true);
        $('#walkincustdiv').hide();
        $('#existcustdiv').show();
    }
    else
    {
        $('#customerid').val(0);
        $('#customername').prop('required',true);
        $('#mobile').prop('required',true);
        $('#customerid').prop('required',false);
        
        $('#walkincustdiv').show();
        $('#existcustdiv').hide();
    }
}




        function changecustomerfun(valu)
        {
            if(valu == 1)
            {
                $('#gstdiv').show();
            }else{
                $('#gstdiv').hide();
            }
        }
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