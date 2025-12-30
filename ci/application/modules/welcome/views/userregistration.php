<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8" />
        <title>Finova User Registration</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= base_url() ?>components/images/FINOVA.png">

        <!-- Bootstrap css -->
        <link href="<?= base_url() ?>components/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- App css -->
        <link href="<?= base_url() ?>components/css/app.min.css" rel="stylesheet" type="text/css" id="app-style"/>
        <!-- icons -->
        <link href="<?= base_url() ?>components/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- Head js -->
        <script src="<?= base_url() ?>components/js/head.js"></script>

    </head>

    <body class="authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-9">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                                
                                <div class="text-center mb-2">
                                    <div class="auth-logo">
                                        <a href="index.html" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="<?= base_url() ?>components/images/FINOVO.png" alt="" height="65">
                                            </span>
                                        </a>
                    
                                        <a href="index.html" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                               <img src="<?= base_url() ?>components/images/FINOVO.png" alt="" height="65">
                                            </span>
                                        </a>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12"  align="center">
                                        <h4 class="mt-0">Registration Form</h4>
                                        Please fill all mandatory fields.
                                    </div>
                                </div>

                                <?php if ($this->session->flashdata('errormessage') != null && $this->session->flashdata('errormessage') != '') {?>
                        
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    
                                        <?php echo $this->session->flashdata('errormessage'); ?>
                                    </div>
                                    
                                  <?php } ?>

                                <form action="<?php echo site_url('welcome/userregistrationprocess') ?>" class="addformvalidate" name="registrationform" method="post">
                                <div class="row mt-2">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">First Name*</label>
                                            <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Enter your First name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">Last Name</label>
                                            <input class="form-control" type="text" id="lastname" name="lastname" placeholder="Enter your Last name" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="emailaddress" class="form-label">Email address*</label>
                                            <input class="form-control" type="email" id="email" name="email" required placeholder="Enter your email">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone*</label>
                                            <input class="form-control" type="text" id="phone" name="phone" required placeholder="Phone Number">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="alternatephone" class="form-label">Alternate Phone</label>
                                            <input class="form-control" type="text" id="alternatephone" name="alternatephone" placeholder="Phone Number">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="businesstype" class="form-label">Type of Business*</label>
                                            <input class="form-control" type="text" required id="businesstype" name="businesstype" placeholder="Type of Business">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="businessname" class="form-label">Name of Business*</label>
                                            <input class="form-control" type="text" id="businessname" name="businessname" required placeholder="Name of Business">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="gstnumber" class="form-label">Type of Tax</label><br/>
                                            <label><input type="radio" id="gstnumber" name="gstnumber" checked="checked" value="GST"> GST</label> &nbsp; &nbsp;
                                            <label><input type="radio" name="gstnumber" value="VAT"> VAT</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address of Business*</label>
                                            <textarea class="form-control" name="address" id="address" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="notes" class="form-label">Notes</label>
                                            <textarea class="form-control" name="notes" id="notes"></textarea>
                                        </div>
                                    </div>
                                            
                                                
                                                
                                                

                                                

                                                

                                                <div class="mb-0">
                                                    <button class="btn btn-success float-sm-end" type="submit"> Submit </button>
                                                    <div class="form-check pt-1">
                                                        <input type="checkbox" class="form-check-input" required="required" name="acceptterms" value="1" id="checkbox-signup">
                                                        <label class="form-check-label" for="checkbox-signup">I accept <a href="javascript: void(0);" class="text-dark">Terms and Conditions</a></label>
                                                    </div>
                                                </div>
                                            
                                        
                                    </div> <!-- end col -->
                                </div>
                                </form>
                                <!-- end row-->

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
            <script>document.write(new Date().getFullYear())</script> &copy; Powered by <a href="#" class="text-white-50">Finova</a> 
        </footer>

        <!-- Vendor js -->
        <script src="<?= base_url() ?>components/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="<?= base_url() ?>components/js/app.min.js"></script>
         <!-- Plugin js-->
        <script src="<?= base_url() ?>components/libs/parsleyjs/parsley.min.js"></script>
        
        <script type="text/javascript">
            $(function() {
                 $(".addformvalidate").parsley();

                 $(".datetime-datepicker").flatpickr({enableTime:!0,dateFormat:"d-M-Y H:i"});
            });
        </script>
    </body>

</html>