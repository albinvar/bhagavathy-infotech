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
					<div class="col-md-6 col-lg-6 col-xl-6 d-none d-md-flex bg-primary-transparent">
						<div class="row wd-100p mx-auto text-center">
							<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
								<img src="<?=base_url()?>components/img/logo.png" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
							</div>
						</div>
					</div>
					<!-- The content half -->
					<div class="col-md-6 col-lg-6 col-xl-6">

						<div class="login d-flex align-items-center py-2">
			              <!-- Demo content-->
			              <div class="container p-0">
			                <div class="row">
			                  <div class="col-md-11 col-lg-11 col-xl-10 mx-auto ">
			                    <div class="card-sigin bg-white" style="padding: 40px;">
			                      <div class="mb-5 d-flex"> <a href="index.html"><img src="http://cricket.novahealthcare.ie/components/img/logo.png" class="sign-favicon ht-40" alt="logo"></a></div>
			                      <div class="card-sigin">
			                        <div class="main-signup-header">
			                          <h2>Forget Password</h2>
			                          <h5 class="font-weight-semibold mb-4">Please enter your registered email address or username</h5>
			                         
			                          <?php if (isset($msg) && $msg != '') { ?>
			                            <div class="alert alert-danger mg-b-0" role="alert">
			                              <button aria-label="Close" class="close" data-dismiss="alert" type="button">
			                                <span aria-hidden="true">&times;</span>
			                              </button>
			                              <strong></strong> <?php echo $msg; ?>
			                            </div>
			                          
			                          <?php } elseif (isset($successmsg) && $successmsg != '') { ?>
			                            <div class="alert alert-success" role="alert">
			                              <button aria-label="Close" class="close" data-dismiss="alert" type="button">
			                                 <span aria-hidden="true">&times;</span>
			                              </button>
			                              <strong></strong> <?php echo $successmsg; ?>.
			                            </div>
			                          
			                          <?php } ?>

			                          <form class="pt-3" autocomplete="off" data-parsley-validate id="signinform">
											<div class="form-group">
												<label>Username/Email</label> <input class="form-control"  required id="signupuserName" placeholder="Username/Email" type="text">
											</div>
											<button class="btn btn-main-primary btn-block" id="ForGetPassword">Submit</button>
											
										</form>

			                          

			                          <div class="main-signin-footer mt-5">
			                            <p>Already Registered? <a href="<?=base_url()?>welcome/index">Login</a></p>
			                          </div>
			                        </div>
			                      </div>
			                    </div>
			                  </div>
			                </div>
			              </div><!-- End -->
			            </div>

						

					</div>
				</div>
			</div>

		</div>
		<!-- End Page -->
		<?php $this->view('signindashboard/footer') ?>
		

