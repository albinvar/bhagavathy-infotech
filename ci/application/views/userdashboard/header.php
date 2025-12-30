<!DOCTYPE html>
<html lang="en">
<head>

        <meta charset="utf-8" />
        <title>Finova</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="Vsoft" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= base_url() ?>components/images/FINOVA.png" >

        <!-- Plugins css -->
        <link href="<?= base_url() ?>components/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>components/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />

        <!-- Plugins css -->
        <link href="<?= base_url() ?>components/libs/quill/quill.core.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>components/libs/quill/quill.snow.css" rel="stylesheet" type="text/css" />

        <!-- third party css -->
        <link href="<?= base_url() ?>components/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>components/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>components/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>components/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <!-- third party css end -->

        <link href="<?= base_url() ?>components/libs/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>components/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>components/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />

        <!-- Jquery Toast css -->
        <link href="<?= base_url() ?>components/libs/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet" type="text/css" />

        <link href="<?= base_url() ?>components/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        
        <!-- Bootstrap css -->
        <link href="<?= base_url() ?>components/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- App css -->
        <link href="<?= base_url() ?>components/css/app.min.css" rel="stylesheet" type="text/css" id="app-style"/>
        <link href="<?= base_url() ?>components/css/custom.css" rel="stylesheet" type="text/css" id="app-style"/>

        <!-- icons -->
        <link href="<?= base_url() ?>components/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- Head js -->
        <script src="<?= base_url() ?>components/js/head.js"></script>

        <?php
        $todaydate = date('Y-m-d');
        if(($todaydate >= $this->finstartdate) && ($todaydate <= $this->finenddate))
        {
            
        }else{
            ?>
            <style type="text/css">
                .finyearaddbutton{
                    display: none;
                }
            </style>
            <?php
        }
        ?>

    </head>

    <!-- body start -->
    <body data-layout-mode="default" data-theme="light" data-layout-width="fluid" data-topbar-color="dark" data-menu-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='false'>

        <!-- Begin page -->
        <div id="wrapper">


            <!-- Topbar Start -->
            <div class="navbar-custom">

                

                <div class="container-fluid">
                    <ul class="list-unstyled topnav-menu float-end mb-0">

                        

                        <?php 
                        if ($this->buid) {
                            if($this->withoutlogin == 1)
                            {
                                ?>
                                
                                <?php
                            }else{

                        ?>
                        <li class="dropdown d-inline-block" style="    font-size: 16px; background: #d2d6e9;">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" style="line-height: 20px; padding: 15px 15px;" aria-haspopup="false" aria-expanded="false">
                               <span style="font-size: 11px;">Selected BU:</span> <span style="background-color: #bbbdca"><?php echo $this->global_bu_name; ?> <i class="mdi mdi-chevron-down"></i></span><br/>
                               <?php 
                                if($this->userrole != 1)    
                                {
                                     echo "<span style='font-size:12px;'>(" .$this->finname . ")</span>";
                                }
                                ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                                <?php
                                if (count($this->topbusinessunitdet)) {
                                foreach ($this->topbusinessunitdet as $butpvl) {
                                    if($butpvl->bu_withoutlogin == 0)
                                    {
                                    ?>
                                <!-- item-->
                                <a href="javascript:void(0);" onclick="changebunitpublicid('<?= $butpvl->bu_businessunitid ?>')" class="dropdown-item notify-item <?php if($this->buid == $butpvl->bu_businessunitid){ echo 'active'; } ?>">
                                    <span><?= $butpvl->bu_unitname ?></span>
                                </a>
                                <?php 
                                    }
                                    }
                                }
                                ?>
                                
                            </div>
                        </li>
                    <?php 
                    }
                } ?>

                    <script type="text/javascript">
                        function changebunitpublicid(bunitid) {
                            $.ajax({
                                url: '<?= base_url() ?>accounts/changepublicbuid',
                                type: 'POST',
                                data: {
                                    id: bunitid
                                },
                                success: function(response) {
                                    location.reload();
                                }
                            });
                        }
                    </script>

                        
    
                        <li class="dropdown d-inline-block d-lg-none">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="fe-search noti-icon"></i>
                            </a>
                            <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                                <form class="p-3">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                </form>
                            </div>
                        </li>
    
                        <li class="dropdown d-none d-lg-inline-block">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                                <i class="fe-maximize noti-icon"></i>
                            </a>
                        </li>
    
                        
    
                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="fe-bell noti-icon"></i>
                                <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-lg">
    
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">
                                        <span class="float-end">
                                            <a href="#" class="text-dark">
                                                <small>Clear All</small>
                                            </a>
                                        </span>Notification
                                    </h5>
                                </div>
    
                                <div class="noti-scroll" data-simplebar>
    
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                        <div class="notify-icon">
                                            <img src="<?= base_url() ?>components/images/users/user-1.jpg" class="img-fluid rounded-circle" alt="" /> </div>
                                        <p class="notify-details">Cristina Pride</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Hi, How are you? What about our next meeting</small>
                                        </p>
                                    </a>
    
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Caleb Flakelar commented on Admin
                                            <small class="text-muted">1 min ago</small>
                                        </p>
                                    </a>
    
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon">
                                            <img src="<?= base_url() ?>components/images/users/user-4.jpg" class="img-fluid rounded-circle" alt="" /> </div>
                                        <p class="notify-details">Karen Robinson</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>Wow ! this admin looks good and awesome design</small>
                                        </p>
                                    </a>
    
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-warning">
                                            <i class="mdi mdi-account-plus"></i>
                                        </div>
                                        <p class="notify-details">New user registered.
                                            <small class="text-muted">5 hours ago</small>
                                        </p>
                                    </a>
    
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-info">
                                            <i class="mdi mdi-comment-account-outline"></i>
                                        </div>
                                        <p class="notify-details">Caleb Flakelar commented on Admin
                                            <small class="text-muted">4 days ago</small>
                                        </p>
                                    </a>
    
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-secondary">
                                            <i class="mdi mdi-heart"></i>
                                        </div>
                                        <p class="notify-details">Carlos Crouch liked
                                            <b>Admin</b>
                                            <small class="text-muted">13 days ago</small>
                                        </p>
                                    </a>
                                </div>
    
                                <!-- All-->
                                <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                    View all
                                    <i class="fe-arrow-right"></i>
                                </a>
    
                            </div>
                        </li>
    
                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <?php 
                                if ($this->buid) {
                                if($this->bulogo != "")
                                {
                                    ?>
                                <img src="<?= base_url() ?>uploads/business/<?= $this->bulogo ?>" alt="user-image" class="rounded-circle">
                                <?php 
                                }else{
                                ?>
                                <img src="<?= base_url() ?>components/images/users/user-1.jpg" alt="user-image" class="rounded-circle">
                                <?php 
                                }
                                }else{
                                ?>
                                <img src="<?= base_url() ?>components/images/users/user-1.jpg" alt="user-image" class="rounded-circle">
                                <?php 
                                }
                                ?>
                                <span class="pro-user-name ms-1">
                                    <?= $this->session->userdata('name') ?> <i class="mdi mdi-chevron-down"></i> 
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>
    
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-user"></i>
                                    <span>My Account</span>
                                </a>
    
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-settings"></i>
                                    <span>Settings</span>
                                </a>
    
                                
                                <div class="dropdown-divider"></div>
    
                                <!-- item-->
                                <a href="<?= base_url() ?>welcome/do_logout" class="dropdown-item notify-item">
                                    <i class="fe-log-out"></i>
                                    <span>Logout</span>
                                </a>
    
                            </div>
                        </li>
    
                        
    
                    </ul>
    
                    <!-- LOGO -->
                    <div class="logo-box">
                        
    
                        <a href="javascript:void(0)" class="logo logo-light text-center" style="display: block; text-align: center">
                            <span class="logo-sm">
                                <img src="<?= base_url() ?>components/images/FINOVA.png" alt="" height="32">
                            </span>
                            <span class="logo-lg" >
                                <img src="<?= base_url() ?>components/images/FINOVA.png" alt="" height="75" >
                            </span>
                        </a>
                    </div>
    
                    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                        <li>
                            <button class="button-menu-mobile waves-effect waves-light">
                                <i class="fe-menu"></i>
                            </button>
                        </li>

                        <li>
                            <!-- Mobile menu toggle (Horizontal Layout)-->
                            <a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>   
            
                        
                        
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- end Topbar -->