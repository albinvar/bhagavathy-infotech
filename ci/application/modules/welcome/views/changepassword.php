<!-- main-content opened -->
<div class="main-content horizontal-content">

    <!-- container opened -->
    <div class="container">

        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">Admin</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/
                    Change Password</span>
                </div>
            </div>
            
        </div>
        <!-- breadcrumb -->

        <!-- row opened -->
        <div class="row row-sm">

            <!--/div-->

            <!--div-->
            <div class="col-xl-12">
                <div class="card">


                    <div class="card-body">
                        <h4 class="formmainheading mb-2">Change Password</h4>

                        <div class="formfielddiv">
                            <form class="form-horizontal" id="changepasswordform" name="changepasswordform" method="post" action="<?php echo site_url('welcome/changepasswordprocess') ?>">

                                <!-- ROW OPENED  -->
                                <div class="row row-xs mg-b-20">
                                    <div class="<?php echo lang('formfielddiv_label'); ?>">
                                        <label class="form-label mg-b-0">Password</label>
                                    </div>
                                    <div class="<?php echo lang('formfielddiv_input'); ?>">
                                      <input type="password" required class="form-control" id="password" name="password" placeholder="Password">  
                                  </div>
                              </div>
                              <!-- /ROW CLOSED  -->

                              <!-- ROW OPENED  -->
                              <div class="row row-xs mg-b-20">
                                <div class="<?php echo lang('formfielddiv_label'); ?>">
                                    <label class="form-label mg-b-0">Confirm Password</label>
                                </div>
                                <div class="<?php echo lang('formfielddiv_input'); ?>">
                                    <input type="password" required class="form-control" id="confpassword" name="confpassword" placeholder="Confirm Password">
                                </div>
                            </div>
                            <!-- /ROW CLOSED  -->

                            <!-- ROW OPENED  -->
                            <div class="row row-xs mg-b-20">
                                <div class="<?php echo lang('formfielddiv_label'); ?>">
                                    <label class="form-label mg-b-0"></label>
                                </div>
                                <div class="<?php echo lang('formfielddiv_input'); ?>">
                                    <button class="btn btn-primary mr-2 listbtns addchangepasswordSubmit" id="addchangepasswordSubmit" type="submit">Submit</button>
                                    <a href="javascript:history.go(-1);" class="btn btn-secondary listbtns">Cancel</a>
                                </div>
                            </div>
                            <!-- /ROW CLOSED  -->


                            <div class="row text-right pull-right">
                                <div class="col-md-12 text-center pull-right">
                                    

                                </div>
                            </div>

                        </form>
                    </div>
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->


    </div>
    <!-- /row -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->

<?php $this->view('userdashboard/footer') ?>

<script type="text/javascript">
    $(function() {

        $.validator.addMethod("noSpace", function(value, element) { 
          return value.indexOf(" ") < 0 && value != ""; 
      }, "No space please and don't leave it empty");

        $.validator.addMethod("passwordFormatCheck", function(value, element) {
            var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])");
            return this.optional(element) || strongRegex.test(value);
        }, '<?php echo lang('password_error_text') ?>');


        $("#changepasswordform").validate({
            rules:{
                password: {
                    noSpace: true,
                    required: true,
                    passwordFormatCheck: true
                },
                confpassword: {
                    noSpace: true,
                    required: true,
                    passwordFormatCheck: true,
                    equalTo: '#password'
                }
            },
            submitHandler: function(form) {
                $(".listbtns").prop('disabled', true);
                form.submit();
            },
            invalidHandler: function() {
                $(".listbtns").prop('disabled', false);
            }
        })
    });
    
</script>