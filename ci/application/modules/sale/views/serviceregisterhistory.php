<!-- ============================================================== -->
<!-- Service Register History -->
<!-- ============================================================== -->
<style>
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

.status-card {
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    cursor: pointer;
    transition: transform 0.2s;
}
.status-card:hover {
    transform: translateY(-3px);
}
.status-card h3 {
    margin: 0;
    font-size: 28px;
    font-weight: bold;
}
.status-card p {
    margin: 5px 0 0 0;
    font-size: 13px;
}
.card-pending { background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); }
.card-inprogress { background: linear-gradient(135deg, #cce5ff 0%, #74b9ff 100%); }
.card-completed { background: linear-gradient(135deg, #d4edda 0%, #00b894 100%); }
.card-delivered { background: linear-gradient(135deg, #e2e2e2 0%, #b2bec3 100%); }
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
                            <a href="<?= base_url() ?>sale/serviceregister" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> New Entry</button>
                            </a>
                        </div>
                        <h4 class="page-title"><i class="fas fa-clipboard-list"></i> Service Register</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- Status Cards -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="status-card card-pending" onclick="filterByStatus('0')">
                        <h3><?= $pendingcount ?></h3>
                        <p><i class="fas fa-clock"></i> Pending</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="status-card card-inprogress" onclick="filterByStatus('1')">
                        <h3><?= $inprogresscount ?></h3>
                        <p><i class="fas fa-tools"></i> In Progress</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="status-card card-completed" onclick="filterByStatus('2')">
                        <h3><?= $completedcount ?></h3>
                        <p><i class="fas fa-check-circle"></i> Ready for Pickup</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="status-card card-delivered" onclick="filterByStatus('3')">
                        <h3><?= $deliveredcount ?></h3>
                        <p><i class="fas fa-truck"></i> Delivered</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- Filters -->
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label>From Date</label>
                                    <input type="date" class="form-control" name="fromdate" id="fromdate" value="<?= $fromdate ?>">
                                </div>
                                <div class="col-md-2">
                                    <label>To Date</label>
                                    <input type="date" class="form-control" name="todate" id="todate" value="<?= $todate ?>">
                                </div>
                                <div class="col-md-2">
                                    <label>Status</label>
                                    <select class="form-control" name="statusfilter" id="statusfilter">
                                        <option value="all" <?= ($status == 'all') ? 'selected' : '' ?>>All Status</option>
                                        <option value="0" <?= ($status === '0' || $status === 0) ? 'selected' : '' ?>>Pending</option>
                                        <option value="1" <?= ($status === '1' || $status === 1) ? 'selected' : '' ?>>In Progress</option>
                                        <option value="2" <?= ($status === '2' || $status === 2) ? 'selected' : '' ?>>Completed</option>
                                        <option value="3" <?= ($status === '3' || $status === 3) ? 'selected' : '' ?>>Delivered</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label>&nbsp;</label>
                                    <button type="button" onclick="applyFilter()" class="btn btn-primary form-control"><i class="fas fa-filter"></i></button>
                                </div>
                                <div class="col-md-1">
                                    <label>&nbsp;</label>
                                    <button type="button" onclick="resetFilter()" class="btn btn-secondary form-control"><i class="fas fa-redo"></i></button>
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="button" onclick="printRegister()" class="btn btn-info form-control"><i class="fas fa-print"></i> Print Register</button>
                                </div>
                            </div>

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>In Date</th>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Printer</th>
                                        <th>Status</th>
                                        <th>Out Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    if($registerlist)
                                    {
                                        $k=1;
                                        foreach($registerlist as $item)
                                        {
                                            // Status badge class
                                            $statusclass = '';
                                            $statustext = '';
                                            switch($item->sr_status) {
                                                case 0:
                                                    $statusclass = 'status-pending';
                                                    $statustext = 'Pending';
                                                    break;
                                                case 1:
                                                    $statusclass = 'status-inprogress';
                                                    $statustext = 'In Progress';
                                                    break;
                                                case 2:
                                                    $statusclass = 'status-completed';
                                                    $statustext = 'Completed';
                                                    break;
                                                case 3:
                                                    $statusclass = 'status-delivered';
                                                    $statustext = 'Delivered';
                                                    break;
                                            }

                                            $hash = sha1('UseBiller@#$%^' . $item->sr_id);
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><strong><?= $item->sr_code ?></strong></td>
                                                <td><?= date('d-M-Y', strtotime($item->sr_indate)) ?><br><small class="text-muted"><?= date('h:i A', strtotime($item->sr_intime)) ?></small></td>
                                                <td><?= htmlspecialchars($item->sr_customername) ?></td>
                                                <td><?= htmlspecialchars($item->sr_phone) ?></td>
                                                <td>
                                                    <?= htmlspecialchars($item->sr_printername) ?>
                                                    <?php if($item->sr_printertype): ?>
                                                    <br><small class="text-muted"><?= htmlspecialchars($item->sr_printertype) ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="status-badge <?= $statusclass ?>"><?= $statustext ?></span>
                                                    <?php if($item->sr_status < 3): ?>
                                                    <br>
                                                    <select class="form-control form-control-sm mt-1" style="font-size: 11px; padding: 2px 5px;" onchange="updateStatus(<?= $item->sr_id ?>, this.value)">
                                                        <option value="">Change...</option>
                                                        <?php if($item->sr_status != 0): ?><option value="0">Pending</option><?php endif; ?>
                                                        <?php if($item->sr_status != 1): ?><option value="1">In Progress</option><?php endif; ?>
                                                        <?php if($item->sr_status != 2): ?><option value="2">Completed</option><?php endif; ?>
                                                    </select>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($item->sr_outdate): ?>
                                                        <?= date('d-M-Y', strtotime($item->sr_outdate)) ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="<?= base_url() ?>sale/serviceregisterview/<?= $item->sr_id ?>/<?= $hash ?>" class="btn btn-sm btn-info" title="View/Edit">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?= base_url() ?>sale/serviceregisterprint/<?= $item->sr_id ?>/<?= $hash ?>" target="_blank" class="btn btn-sm btn-secondary" title="Print">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                        <?php if($item->sr_status < 3): ?>
                                                        <a href="<?= base_url() ?>sale/serviceregisterout/<?= $item->sr_id ?>/<?= $hash ?>" class="btn btn-sm btn-success" title="Deliver">
                                                            <i class="fas fa-truck"></i>
                                                        </a>
                                                        <?php endif; ?>
                                                        <a href="<?= base_url() ?>sale/deleteserviceregister/<?= $item->sr_id ?>/<?= $hash ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this entry?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            $k++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <?php if(!$registerlist): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">No records found</h5>
                                <p class="text-muted">Try adjusting your filters or add a new entry.</p>
                                <a href="<?= base_url() ?>sale/serviceregister" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Entry</a>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
function applyFilter() {
    var fromdate = $('#fromdate').val();
    var todate = $('#todate').val();
    var status = $('#statusfilter').val();
    window.location.href = '<?= base_url() ?>sale/serviceregisterhistory/' + status + '/' + fromdate + '/' + todate;
}

function resetFilter() {
    window.location.href = '<?= base_url() ?>sale/serviceregisterhistory';
}

function filterByStatus(status) {
    var fromdate = $('#fromdate').val();
    var todate = $('#todate').val();
    window.location.href = '<?= base_url() ?>sale/serviceregisterhistory/' + status + '/' + fromdate + '/' + todate;
}

function updateStatus(id, status) {
    if(status == '') return;

    $.ajax({
        url: '<?= base_url() ?>sale/updateservicestatus',
        type: 'POST',
        data: { id: id, status: status },
        dataType: 'json',
        success: function(response) {
            if(response.status == 'success') {
                location.reload();
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Error updating status. Please try again.');
        }
    });
}

function printRegister() {
    var fromdate = $('#fromdate').val();
    var todate = $('#todate').val();
    var status = $('#statusfilter').val();
    window.open('<?= base_url() ?>sale/serviceregisterreport/' + status + '/' + fromdate + '/' + todate, '_blank');
}
</script>
