
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
                <div class="col-lg-4 col-xl-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <!--<img src="assets/images/users/user-1.jpg" class="rounded-circle avatar-lg img-thumbnail"
                            alt="profile-image">-->

                            <h4 class="mb-0"><?= $businessdet->bu_unitname ?></h4>
                            <p class="text-muted"><?= $businessdet->bt_businesstype ?></p>

                            <!--<button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Follow</button>
                            <button type="button" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Message</button>-->

                            <div class="text-start mt-3">
                               
                                <p class="text-muted mb-2 font-13"><strong>Address :</strong> <span class="ms-2"><?= $businessdet->bu_address ?></span></p>
                            
                                <p class="text-muted mb-2 font-13"><strong>Phone :</strong><span class="ms-2"><?= $businessdet->bu_phone ?></span></p>
                            
                                <p class="text-muted mb-2 font-13"><strong><?= $this->isvatgstname ?> No :</strong> <span class="ms-2"><?= $businessdet->bu_gstnumber ?></span></p>
                            
                                <p class="text-muted mb-1 font-13"><strong>Other License Number :</strong> <span class="ms-2"><?= $businessdet->ap_otherlicenceno ?></span></p>

                                <p class="text-muted mb-2 font-13"><strong>Financial Year :</strong><br/><span class="">
                                    <?php 
                                    if($businessdet->ap_financialyearname != "")
                                    {
                                    ?>
                                    <?= $businessdet->ap_financialyearname ?> (<?php echo date('d-M-Y', strtotime($businessdet->ap_startdate)) ?> - <?php echo date('d-M-Y', strtotime($businessdet->ap_enddate)) ?>)
                                    <?php 
                                    }
                                    ?>
                                </span></p>

                                <p class="text-muted mb-2 font-13"><strong>Start Transaction Date :</strong><span class="ms-2"><?= $businessdet->ap_transcationstartdate ?></span></p>
                            </div>                                    

                            
                        </div>                                 
                    </div> <!-- end card -->

                </div> <!-- end col-->

                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group">
                                <a href="<?= base_url() ?>accounts/accountgroups/<?= $businessdet->bu_businessunitid ?>"><li class="list-group-item"><i class="fas fa-angle-right"></i> Account Group </li></a>

                                <a href="<?= base_url() ?>accounts/accountledger/<?= $businessdet->bu_businessunitid ?>"><li class="list-group-item"><i class="fas fa-angle-right"></i> Create Ledger </li></a>

                                <li class="list-group-item"><a href="<?= base_url() ?>accounts/accountjournals/<?= $businessdet->bu_businessunitid ?>"><i class="fas fa-angle-right"></i> Create Journal </a> </li>

                                <div class="dropdown">
                                  <li class="list-group-item dropdown-toggle" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <a href="javascript:void(0)"><i class="fas fa-angle-right"></i> Vouchers</a>
                                  </li>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <li class="list-group-item"><a href="<?= base_url() ?>accounts/vouchers/1">Payment Voucher</a></li>
                                    <li class="list-group-item"><a href="<?= base_url() ?>accounts/vouchers/2">Receiver Voucher</a></li>
                                    <li class="list-group-item"><a href="<?= base_url() ?>accounts/vouchers/3">Contra Voucher</a></li>
                                    <li class="list-group-item"><a href="<?= base_url() ?>accounts/vouchers/4">Journal Voucher</a></li>
                                    <li class="list-group-item"><a href="<?= base_url() ?>accounts/vouchers/5">Other Voucher</a></li>
                                  </ul>
                                </div>


                                <li class="list-group-item"><a href="#"><i class="fas fa-angle-right"></i> Trail balance</a> </li>
                                <li class="list-group-item"><a href="#"><i class="fas fa-angle-right"></i> Balance sheet</a> </li>
                                <li class="list-group-item"><a href="#"><i class="fas fa-angle-right"></i> Profit and loss</a> </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>

            
            
        </div> <!-- container -->

    </div> <!-- content -->
