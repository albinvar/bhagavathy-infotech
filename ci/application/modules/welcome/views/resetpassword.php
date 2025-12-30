	<!-- Loader -->
	<div id="global-loader">
	    <img src="<?=base_url()?>components/img/loader.svg" class="loader-img" alt="Loader">
	</div>
	<!-- /Loader -->

	<!-- Page -->
	<div class="page">

	    <div class="container-fluid">
	        <div class="row no-gutter">
	            <!-- The image half -->
	            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
	                <div class="row wd-100p mx-auto text-center">
	                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
	                        <img src="<?=base_url()?>components/img/logo.png"
	                            class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
	                    </div>
	                </div>
	            </div>
	            <!-- The content half -->
	            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
	                <div class="login d-flex align-items-center py-2">
	                    <!-- Demo content-->
	                    <div class="container p-0">
	                        <div class="row">
	                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
	                                <div class="card-sigin">
	                                    <div class="mb-5 d-flex"> <a href="<?=base_url()?>"><img
	                                                src="<?=base_url()?>components/img/favicon.png"
	                                                class="sign-favicon ht-40" alt="logo"></a>
	                                        <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">Cri<span>Ck</span>M</h1>
	                                    </div>
	                                    <div class="card-sigin">
	                                        <div class="main-signup-header">
	                                            <h2>Reset Password</h2>
	                                            <h5 class="font-weight-semibold mb-4">You can set a new password for your
	                                                account</h5>
	                                            <form class="pt-3" autocomplete="off" data-parsley-validate
	                                                id="signinform">
	                                                <input type="hidden" id="authid" value="<?=$authid?>" />
	                                                <input type="hidden" id="auth" value="<?=$auth?>" />
	                                                <div class="form-group">
	                                                    <label>New Password</label> <input class="form-control" required
	                                                        id="signupPassword" placeholder="New Password" type="password">
	                                                </div>
                                                  <div class="form-group">
	                                                    <label>Confirm Password</label> <input class="form-control" required
                                                      data-parsley-equalto="#signupPassword" id="signupconfPassword" placeholder="Confirm Password" type="password">
	                                                </div>
	                                                <button class="btn btn-main-primary btn-block"
	                                                    id="ResetPasswordButton">Submit</button>

	                                            </form>

	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div><!-- End -->
	                </div>
	            </div><!-- End -->
	        </div>
	    </div>

	</div>
	<!-- End Page -->