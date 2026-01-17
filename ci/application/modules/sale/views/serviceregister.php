<!-- ============================================================== -->
<!-- Service Register - New Entry Form -->
<!-- ============================================================== -->
<link href="<?= base_url() ?>components/css/dashboardstyle.css" rel="stylesheet" type="text/css" id="app-style"/>
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
                                <button type="button" class="btn btn-secondary waves-effect waves-light listbtns"><i class="fas fa-list"></i> View History</button>
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
                            <form action="<?= base_url() ?>sale/addserviceregister" method="POST" name="serviceregisterform" id="serviceregisterform">

                            <!-- Header Row -->
                            <div class="row">
                                <div class="col-md-4">
                                    <label><strong>Service Code</strong></label>
                                    <input type="text" name="servicecode" readonly value="<?= $servicecode ?>" class="inputfieldcss form-control" style="font-weight: bold; background-color: #e9ecef;">
                                </div>
                                <div class="col-md-4">
                                    <label>In Date</label>
                                    <input type="date" name="indate" value="<?= $todaydate ?>" class="inputfieldcss form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label>In Time</label>
                                    <input type="time" name="intime" value="<?= $currenttime ?>" class="inputfieldcss form-control" required>
                                </div>
                            </div>

                            <hr class="mt-3 mb-3">

                            <!-- Customer Section -->
                            <h5 class="text-primary mb-3"><i class="fas fa-user"></i> Customer Details</h5>

                            <div class="row">
                                <div class="col-md-3">
                                    <label>Customer Type</label>
                                    <select class="w-100 inputfieldcss form-control" name="existcustomer" id="existcustomer" onchange="toggleCustomerType()">
                                        <option value="0">Walk-in Customer</option>
                                        <option value="1">Existing Customer</option>
                                    </select>
                                    <input type="hidden" name="customerid" id="customerid" value="0">
                                </div>

                                <div class="col-md-9" id="existingcustdiv" style="display: none;">
                                    <label>Select Customer</label>
                                    <select class="w-100 inputfieldcss form-control" name="selectedcustomer" id="selectedcustomer" onchange="fillCustomerDetails()">
                                        <option value="">-- Select Customer --</option>
                                        <?php if($customerlist): foreach($customerlist as $cst): ?>
                                        <option value="<?= $cst->ct_cstomerid ?>"
                                            data-name="<?= htmlspecialchars($cst->ct_name) ?>"
                                            data-phone="<?= htmlspecialchars($cst->ct_phone) ?>"
                                            data-address="<?= htmlspecialchars($cst->ct_address) ?>">
                                            <?= $cst->ct_name ?> - <?= $cst->ct_phone ?>
                                        </option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3" id="walkincustdiv">
                                <div class="col-md-4">
                                    <label>Customer Name <span class="text-danger">*</span></label>
                                    <input type="text" name="customername" id="customername" placeholder="Enter customer name" class="w-100 inputfieldcss form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="customerphone" id="customerphone" placeholder="Enter phone number" class="w-100 inputfieldcss form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Address</label>
                                    <input type="text" name="customeraddress" id="customeraddress" placeholder="Enter address" class="w-100 inputfieldcss form-control">
                                </div>
                            </div>

                            <hr class="mt-4 mb-3">

                            <!-- Printer/Device Section -->
                            <h5 class="text-primary mb-3"><i class="fas fa-print"></i> Printer/Device Details</h5>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Printer/Device Name <span class="text-danger">*</span></label>
                                    <input type="text" name="printername" id="printername" placeholder="e.g., HP LaserJet Pro" class="w-100 inputfieldcss form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Type</label>
                                    <select name="printertype" id="printertype" class="w-100 inputfieldcss form-control" onchange="toggleOtherType()">
                                        <option value="">-- Select Type --</option>
                                        <option value="Laser Printer">Laser Printer</option>
                                        <option value="Inkjet Printer">Inkjet Printer</option>
                                        <option value="Dot Matrix Printer">Dot Matrix Printer</option>
                                        <option value="Thermal Printer">Thermal Printer</option>
                                        <option value="Multifunction Printer">Multifunction Printer</option>
                                        <option value="Plotter">Plotter</option>
                                        <option value="Scanner">Scanner</option>
                                        <option value="Copier">Copier</option>
                                        <option value="UPS">UPS</option>
                                        <option value="Computer">Computer</option>
                                        <option value="Laptop">Laptop</option>
                                        <option value="Monitor">Monitor</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <input type="text" name="printertypeother" id="printertypeother" placeholder="Enter device type" class="w-100 inputfieldcss form-control mt-2" style="display: none;">
                                </div>
                                <div class="col-md-4">
                                    <label>Serial Number</label>
                                    <input type="text" name="serialno" id="serialno" placeholder="Enter serial number" class="w-100 inputfieldcss form-control">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label>Reason/Complaint <span class="text-danger">*</span></label>
                                    <textarea name="reason" id="reason" rows="3" placeholder="Describe the issue or reason for service..." class="w-100 inputfieldcss form-control" required></textarea>
                                </div>
                            </div>

                            <hr class="mt-4 mb-3">

                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-md-12" align="center">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="fas fa-save"></i> Register Service Entry
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
        $('#customername').val('');
        $('#customerphone').val('');
        $('#customeraddress').val('');
        $('#selectedcustomer').val('');
    }
}

function fillCustomerDetails() {
    var selected = $('#selectedcustomer option:selected');
    if(selected.val() != '') {
        $('#customerid').val(selected.val());
        $('#customername').val(selected.data('name'));
        $('#customerphone').val(selected.data('phone'));
        $('#customeraddress').val(selected.data('address'));
    } else {
        $('#customerid').val(0);
        $('#customername').val('');
        $('#customerphone').val('');
        $('#customeraddress').val('');
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

$(document).ready(function() {
    $('#serviceregisterform').on('submit', function(e) {
        var customername = $('#customername').val().trim();
        var customerphone = $('#customerphone').val().trim();
        var printername = $('#printername').val().trim();
        var reason = $('#reason').val().trim();

        if(customername == '' || customerphone == '' || printername == '' || reason == '') {
            alert('Please fill all required fields.');
            e.preventDefault();
            return false;
        }
        return true;
    });
});
</script>
