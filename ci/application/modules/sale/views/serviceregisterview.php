<!-- ============================================================== -->
<!-- Service Register - View/Edit Entry -->
<!-- ============================================================== -->
<link href="<?= base_url() ?>components/css/dashboardstyle.css" rel="stylesheet" type="text/css" id="app-style"/>
<style>
.info-label { color: #6c757d; font-size: 12px; margin-bottom: 2px; }
.info-value { font-weight: 500; font-size: 14px; }
.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.status-pending { background-color: #fff3cd; color: #856404; }
.status-inprogress { background-color: #cce5ff; color: #004085; }
.status-completed { background-color: #d4edda; color: #155724; }
.status-delivered { background-color: #d1d1d1; color: #383838; }
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
                            <?php
                            $hash = sha1('UseBiller@#$%^' . $entry->sr_id);
                            if($entry->sr_status < 3):
                            ?>
                            <a href="<?= base_url() ?>sale/serviceregisterout/<?= $entry->sr_id ?>/<?= $hash ?>" class="ms-1">
                                <button type="button" class="btn btn-success waves-effect waves-light listbtns"><i class="fas fa-truck"></i> Deliver</button>
                            </a>
                            <?php endif; ?>
                            <a href="<?= base_url() ?>sale/serviceregisterprint/<?= $entry->sr_id ?>/<?= $hash ?>" target="_blank" class="ms-1">
                                <button type="button" class="btn btn-info waves-effect waves-light listbtns"><i class="fas fa-print"></i> Print</button>
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
                        <div class="card-body p-3 dashoboardform">
                            <form action="<?= base_url() ?>sale/updateserviceregister" method="POST" name="serviceregisterform" id="serviceregisterform">
                            <input type="hidden" name="id" value="<?= $entry->sr_id ?>">
                            <input type="hidden" name="hash" value="<?= $hash ?>">

                            <!-- Header Row -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="info-label">Service Code</div>
                                    <div class="info-value" style="font-size: 20px; color: #007bff;"><?= $entry->sr_code ?></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-label">In Date & Time</div>
                                    <div class="info-value"><?= date('d-M-Y', strtotime($entry->sr_indate)) ?> at <?= date('h:i A', strtotime($entry->sr_intime)) ?></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-label">Current Status</div>
                                    <?php
                                    $statusclass = '';
                                    $statustext = '';
                                    switch($entry->sr_status) {
                                        case 0: $statusclass = 'status-pending'; $statustext = 'Pending'; break;
                                        case 1: $statusclass = 'status-inprogress'; $statustext = 'In Progress'; break;
                                        case 2: $statusclass = 'status-completed'; $statustext = 'Completed'; break;
                                        case 3: $statusclass = 'status-delivered'; $statustext = 'Delivered'; break;
                                    }
                                    ?>
                                    <span class="status-badge <?= $statusclass ?>"><?= $statustext ?></span>
                                </div>
                            </div>

                            <hr class="mb-3">

                            <!-- Customer Section -->
                            <h5 class="text-primary mb-3"><i class="fas fa-user"></i> Customer Details</h5>

                            <div class="row">
                                <div class="col-md-3">
                                    <label>Customer Type</label>
                                    <select class="w-100 inputfieldcss form-control" name="existcustomer" id="existcustomer" onchange="toggleCustomerType()" <?= ($entry->sr_status == 3) ? 'disabled' : '' ?>>
                                        <option value="0" <?= ($entry->sr_existcustomer == 0) ? 'selected' : '' ?>>Walk-in Customer</option>
                                        <option value="1" <?= ($entry->sr_existcustomer == 1) ? 'selected' : '' ?>>Existing Customer</option>
                                    </select>
                                    <input type="hidden" name="customerid" id="customerid" value="<?= $entry->sr_customerid ?>">
                                </div>

                                <div class="col-md-9" id="existingcustdiv" style="<?= ($entry->sr_existcustomer == 1) ? '' : 'display: none;' ?>">
                                    <label>Select Customer</label>
                                    <select class="w-100 inputfieldcss form-control" name="selectedcustomer" id="selectedcustomer" onchange="fillCustomerDetails()" <?= ($entry->sr_status == 3) ? 'disabled' : '' ?>>
                                        <option value="">-- Select Customer --</option>
                                        <?php if($customerlist): foreach($customerlist as $cst): ?>
                                        <option value="<?= $cst->ct_cstomerid ?>"
                                            data-name="<?= htmlspecialchars($cst->ct_name) ?>"
                                            data-phone="<?= htmlspecialchars($cst->ct_phone) ?>"
                                            data-address="<?= htmlspecialchars($cst->ct_address) ?>"
                                            <?= ($entry->sr_customerid == $cst->ct_cstomerid) ? 'selected' : '' ?>>
                                            <?= $cst->ct_name ?> - <?= $cst->ct_phone ?>
                                        </option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3" id="walkincustdiv">
                                <div class="col-md-4">
                                    <label>Customer Name</label>
                                    <input type="text" name="customername" id="customername" value="<?= htmlspecialchars($entry->sr_customername) ?>" class="w-100 inputfieldcss form-control" <?= ($entry->sr_status == 3 || $entry->sr_existcustomer == 1) ? 'readonly' : '' ?>>
                                </div>
                                <div class="col-md-4">
                                    <label>Phone Number</label>
                                    <input type="text" name="customerphone" id="customerphone" value="<?= htmlspecialchars($entry->sr_phone) ?>" class="w-100 inputfieldcss form-control" <?= ($entry->sr_status == 3 || $entry->sr_existcustomer == 1) ? 'readonly' : '' ?>>
                                </div>
                                <div class="col-md-4">
                                    <label>Address</label>
                                    <input type="text" name="customeraddress" id="customeraddress" value="<?= htmlspecialchars($entry->sr_address) ?>" class="w-100 inputfieldcss form-control" <?= ($entry->sr_status == 3 || $entry->sr_existcustomer == 1) ? 'readonly' : '' ?>>
                                </div>
                            </div>

                            <hr class="mt-4 mb-3">

                            <!-- Printer/Device Section -->
                            <h5 class="text-primary mb-3"><i class="fas fa-print"></i> Printer/Device Details</h5>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Printer/Device Name</label>
                                    <input type="text" name="printername" id="printername" value="<?= htmlspecialchars($entry->sr_printername) ?>" class="w-100 inputfieldcss form-control" <?= ($entry->sr_status == 3) ? 'readonly' : '' ?>>
                                </div>
                                <div class="col-md-4">
                                    <label>Type</label>
                                    <?php
                                    $typeOptions = array('Laser Printer', 'Inkjet Printer', 'Dot Matrix Printer', 'Thermal Printer', 'Multifunction Printer', 'Plotter', 'Scanner', 'Copier', 'UPS', 'Computer', 'Laptop', 'Monitor');
                                    $isOther = !empty($entry->sr_printertype) && !in_array($entry->sr_printertype, $typeOptions);
                                    ?>
                                    <select name="printertype" id="printertype" class="w-100 inputfieldcss form-control" onchange="toggleOtherType()" <?= ($entry->sr_status == 3) ? 'disabled' : '' ?>>
                                        <option value="">-- Select Type --</option>
                                        <?php foreach($typeOptions as $opt): ?>
                                        <option value="<?= $opt ?>" <?= ($entry->sr_printertype == $opt) ? 'selected' : '' ?>><?= $opt ?></option>
                                        <?php endforeach; ?>
                                        <option value="Other" <?= $isOther ? 'selected' : '' ?>>Other</option>
                                    </select>
                                    <input type="text" name="printertypeother" id="printertypeother" value="<?= $isOther ? htmlspecialchars($entry->sr_printertype) : '' ?>" placeholder="Enter device type" class="w-100 inputfieldcss form-control mt-2" style="<?= $isOther ? '' : 'display: none;' ?>" <?= ($entry->sr_status == 3) ? 'readonly' : '' ?>>
                                </div>
                                <div class="col-md-4">
                                    <label>Serial Number</label>
                                    <input type="text" name="serialno" id="serialno" value="<?= htmlspecialchars($entry->sr_serialno) ?>" class="w-100 inputfieldcss form-control" <?= ($entry->sr_status == 3) ? 'readonly' : '' ?>>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label>Reason/Complaint</label>
                                    <textarea name="reason" id="reason" rows="3" class="w-100 inputfieldcss form-control" <?= ($entry->sr_status == 3) ? 'readonly' : '' ?>><?= htmlspecialchars($entry->sr_reason) ?></textarea>
                                </div>
                            </div>

                            <hr class="mt-4 mb-3">

                            <!-- Service Details -->
                            <h5 class="text-primary mb-3"><i class="fas fa-cogs"></i> Service Details</h5>

                            <div class="row">
                                <div class="col-md-3">
                                    <label>Status</label>
                                    <select name="status" id="status" class="w-100 inputfieldcss form-control" <?= ($entry->sr_status == 3) ? 'disabled' : '' ?>>
                                        <option value="0" <?= ($entry->sr_status == 0) ? 'selected' : '' ?>>Pending</option>
                                        <option value="1" <?= ($entry->sr_status == 1) ? 'selected' : '' ?>>In Progress</option>
                                        <option value="2" <?= ($entry->sr_status == 2) ? 'selected' : '' ?>>Completed</option>
                                        <?php if($entry->sr_status == 3): ?>
                                        <option value="3" selected>Delivered</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Service Cost</label>
                                    <input type="number" step="0.01" name="servicecost" id="servicecost" value="<?= $entry->sr_servicecost ?>" class="w-100 inputfieldcss form-control" <?= ($entry->sr_status == 3) ? 'readonly' : '' ?>>
                                </div>
                                <div class="col-md-3">
                                    <label>Out Date</label>
                                    <input type="text" value="<?= ($entry->sr_outdate) ? date('d-M-Y', strtotime($entry->sr_outdate)) : '-' ?>" class="w-100 inputfieldcss form-control" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label>Out Time</label>
                                    <input type="text" value="<?= ($entry->sr_outtime) ? date('h:i A', strtotime($entry->sr_outtime)) : '-' ?>" class="w-100 inputfieldcss form-control" readonly>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label>Remarks / Notes</label>
                                    <textarea name="remarks" id="remarks" rows="2" class="w-100 inputfieldcss form-control" <?= ($entry->sr_status == 3) ? 'readonly' : '' ?>><?= htmlspecialchars($entry->sr_remarks) ?></textarea>
                                </div>
                            </div>

                            <hr class="mt-4 mb-3">

                            <!-- Submit Button -->
                            <?php if($entry->sr_status < 3): ?>
                            <div class="row">
                                <div class="col-md-12" align="center">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="fas fa-save"></i> Update Entry
                                    </button>
                                    <a href="<?= base_url() ?>sale/serviceregisterhistory" class="btn btn-secondary btn-lg px-4 ms-2">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i> This entry has been delivered and cannot be modified.
                            </div>
                            <?php endif; ?>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
function toggleCustomerType() {
    var existcustomer = $('#existcustomer').val();
    if(existcustomer == '1') {
        $('#existingcustdiv').show();
        $('#walkincustdiv').find('input').prop('readonly', true);
    } else {
        $('#existingcustdiv').hide();
        $('#walkincustdiv').find('input').prop('readonly', false);
        $('#customerid').val(0);
    }
}

function fillCustomerDetails() {
    var selected = $('#selectedcustomer option:selected');
    if(selected.val() != '') {
        $('#customerid').val(selected.val());
        $('#customername').val(selected.data('name'));
        $('#customerphone').val(selected.data('phone'));
        $('#customeraddress').val(selected.data('address'));
    }
}

function toggleOtherType() {
    var printertype = $('#printertype').val();
    if(printertype == 'Other') {
        $('#printertypeother').show().focus();
    } else {
        $('#printertypeother').hide().val('');
    }
}
</script>
