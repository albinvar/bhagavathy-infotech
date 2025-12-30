    <!-- <iframe src="<?= base_url() ?>components/welcomevoice.mp3" allow="autoplay" id="audio" hidden ></iframe>
    <audio id="player" controls autoplay hidden>
    <source src="<?= base_url() ?>components/welcomevoice.ogg" type="audio/ogg">
    <source src="<?= base_url() ?>components/welcomevoice.mp3" type="audio/mp3">
    </audio> -->

<script>
window.onload = function() {
  document.getElementById("player").play();
}
</script>

<div class="auth-fluid">
            <!--Auth fluid left content -->
            <div class="auth-fluid-form-box">
                <div class="align-items-center d-flex h-100">
                    <div class="p-3">

                        <!-- Logo -->
                        <div class="auth-brand text-center text-lg-start">
                            <div class="auth-logo">
                                
                                    <span class="logo-lg">
                                        <img src="<?= base_url() ?>components/images/FINOVA.png" alt="" height="120">
                                    </span>
                            </div>
                        </div>

                        <!-- title-->
                        <!--<h4 class="mt-0">Sign In</h4>-->
                        <p class="text-muted mb-4 mt-4">Enter your username and password to access account.</p>

                        <?php if ($this->session->flashdata('errormessage') != null && $this->session->flashdata('errormessage') != '') {?>
                        	
                        	<div class="alert alert-danger alert-dismissible fade show" role="alert">
                               
                                <?php echo $this->session->flashdata('errormessage'); ?>
                            </div>
                            
                          <?php } ?>

                        <!-- form -->
                        <form action="<?= base_url() ?>welcome/signinauthentication" method="post" name="loginform">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input class="form-control" type="text" id="username" name="username" required="" placeholder="Enter your username">
                            </div>
                            <div class="mb-3">
                                <a href="#" class="text-muted float-end"><small>Forgot your password?</small></a>
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                                </div>
                            </div>
                            
                            <!--<div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                </div>
                            </div>-->
                            <div class="text-center d-grid">
                                <button class="btn btn-primary" type="submit">Log In </button>
                            </div>

                            </form>

                            <!-- social-->
                            <div class="text-center mt-4">
                                <p class="text-muted font-16">Follow us on</p>
                                <ul class="social-list list-inline mt-3">
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                                    </li>
                                </ul>
                            </div>
                        
                        <!-- end form-->

                        <!-- Footer-->
                        <footer class="footer footer-alt">
                            <p class="text-muted"> Finova Productions </p>
                        </footer>

                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
            <!-- end auth-fluid-form-box-->

            <!-- Auth fluid right content -->
            <div class="auth-fluid-right text-center" style="background-image: url('<?= base_url() ?>components/images/Back_Img2.jpg'); background-size: cover;">
                <div class="auth-user-testimonial">

                    <img src="<?= base_url() ?>components/images/FINOVA.png" alt="" height="140">

                    <h2 class="mb-3 text-white"> Finova — The Future of Financial Management</h2>
                    <p class="lead"><i class="mdi mdi-format-quote-open"></i>
                    Harnessing the capabilities of cutting-edge machine learning and autonomous AI, Finova delivers a seamless ERP solution tailored to modern financial ecosystems. We invite you to explore a future where complexity meets clarity, and innovation powers every transaction. This is more than software — it’s a leap into 2050. Welcome aboard.<i class="mdi mdi-format-quote-close"></i>
                    </p>
                    <!--<h5 class="text-white">
                        Fadlisaad (Ubold Admin User)
                    </h5>-->
                </div> <!-- end auth-user-testimonial-->
            </div>
            <!-- end Auth fluid right content -->
        </div>
        <!-- end auth-fluid-->