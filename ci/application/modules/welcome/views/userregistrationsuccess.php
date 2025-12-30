<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8" />
        <title>Finova Finanace Management Systems</title>
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
                                                <img src="<?= base_url() ?>components/images/FINOVA.png" alt="" height="65">
                                            </span>
                                        </a>
                    
                                        <a href="index.html" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                               <img src="<?= base_url() ?>components/images/FINOVA.png" alt="" height="65">
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-12"  align="center">
                                        <h4 class="mt-0">Thank you...</h4>
                                        <p>399+18% gst = 471/- monthly</p>
                                        To proceed for login please pay by qr.
                                    </div>
                                </div>

                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-sm-3" align="center">
                                                
                                                <img src="<?= base_url() ?>components/vsoftqr.png" width="65%">
    
                                           
                                        </div>
                                    </div> <!-- end col -->

                                    
                                </div>
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