<!-- ============================================================== -->
<!-- Service Register - Deliver Item (OUT) -->
<!-- ============================================================== -->
<link href="<?= base_url() ?>components/css/dashboardstyle.css" rel="stylesheet" type="text/css" id="app-style"/>
<style>
.info-label { color: #6c757d; font-size: 12px; margin-bottom: 2px; }
.info-value { font-weight: 500; font-size: 14px; }
.detail-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}
</style>

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <a href="<?= base_url() ?>sale/serviceregisterhistory" class="ms-1">
                                <button type="button" class="btn btn-secondary waves-effect waves-light listbtns"><i class="fas fa-arrow-left"></i> Back to List</button>
                            </a>
                        </div>
                        <h4 class="page-title"><i class="fas fa-truck"></i> <?= $title ?></h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-body p-4">

                            <!-- Entry Summary -->
                            <div class="detail-card">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Service Code</div>
                                        <div class="info-value" style="font-size: 24px; color: #007bff; font-weight: bold;"><?= $entry->sr_code ?></div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <div class="info-label">In Date</div>
                                        <div class="info-value"><?= date('d-M-Y', strtotime($entry->sr_indate)) ?> at <?= date('h:i A', strtotime($entry->sr_intime)) ?></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Info -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted"><i class="fas fa-user"></i> Customer</h6>
                                    <p class="mb-0"><strong><?= htmlspecialchars($entry->sr_customername) ?></strong></p>
                                    <p class="mb-0 text-muted"><?= htmlspecialchars($entry->sr_phone) ?></p>
                                    <?php if($entry->sr_address): ?>
                                    <p class="mb-0 text-muted"><?= htmlspecialchars($entry->sr_address) ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted"><i class="fas fa-print"></i> Device</h6>
                                    <p class="mb-0"><strong><?= htmlspecialchars($entry->sr_printername) ?></strong></p>
                                    <?php if($entry->sr_printertype): ?>
                                    <p class="mb-0 text-muted"><?= htmlspecialchars($entry->sr_printertype) ?></p>
                                    <?php endif; ?>
                                    <?php if($entry->sr_serialno): ?>
                                    <p class="mb-0 text-muted">S/N: <?= htmlspecialchars($entry->sr_serialno) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Complaint -->
                            <div class="mb-4">
                                <h6 class="text-muted"><i class="fas fa-exclamation-circle"></i> Original Complaint</h6>
                                <div class="p-3 bg-light rounded">
                                    <?= nl2br(htmlspecialchars($entry->sr_reason)) ?>
                                </div>
                            </div>

                            <hr>

                            <!-- Delivery Form -->
                            <form action="<?= base_url() ?>sale/processservicedelivery" method="POST">
                                <input type="hidden" name="id" value="<?= $entry->sr_id ?>">
                                <input type="hidden" name="hash" value="<?= $hash ?>">

                                <h5 class="text-success mb-3"><i class="fas fa-check-circle"></i> Complete Delivery</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Service Cost</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rs.</span>
                                            <input type="number" step="0.01" name="servicecost" id="servicecost" value="<?= $entry->sr_servicecost ?>" class="form-control form-control-lg" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Delivery Date</label>
                                        <input type="text" class="form-control form-control-lg" value="<?= date('d-M-Y') ?> (Today)" readonly>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label>Remarks / Service Notes</label>
                                        <textarea name="remarks" id="remarks" rows="3" class="form-control" placeholder="Enter any remarks about the service performed..."><?= htmlspecialchars($entry->sr_remarks) ?></textarea>
                                    </div>
                                </div>

                                <hr class="mt-4">

                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success btn-lg px-5" onclick="return confirm('Are you sure you want to mark this item as delivered?')">
                                            <i class="fas fa-truck"></i> Mark as Delivered
                                        </button>
                                        <a href="<?= base_url() ?>sale/serviceregisterhistory" class="btn btn-secondary btn-lg px-4 ms-2">
                                            <i class="fas fa-times"></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
