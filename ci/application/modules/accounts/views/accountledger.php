
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<style type="text/css">

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
                            <a href="javascript:void(0)" onclick="addaccgroupfun()" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Account Ledger</button>
                            </a>

                            <a href="<?= base_url() ?>accounts/accountprofileview/<?= $buid ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="far fa-arrow-alt-circle-left"></i> Back</button>
                            </a>
                        </div>
                        <h4 class="page-title">Account Ledgers</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ledger Name</th>
                                        <th>Account Group</th>
                                        <th>Type</th>
                                        <th>Main Ledger</th>
                                        <!--<th>Opening Balance</th>-->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($ledgers)
                                    {
                                        $k=1;
                                        foreach($ledgers as $bvl)
                                        {
                                            $isledgerentries = $this->ldgrentr->getlastledgerentry($this->buid, $bvl->al_ledgerid);
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $bvl->al_ledger ?></td>
                                                <td><?= $bvl->ag_group ?></td>
                                                <td>
                                                    <?php 
                                                    if($bvl->al_issub == '0')
                                                    {
                                                        ?>
                                                        <span class="badge bg-primary">Main</span>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <span class="badge bg-success">Sub</span>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php
                                                if($bvl->al_issub == '1')
                                                {
                                                    $mmaingropdet = $this->accldgr->getledgerdetailbyid($this->buid, $bvl->al_mainledgerid);
                                                    if($mmaingropdet)
                                                    {
                                                        echo $mmaingropdet->al_ledger;
                                                    }
                                                }
                                                 ?></td>
                                                 <!--<td><?= $bvl->al_closingbalance ?></td>-->
                                                <td>
                                                    
                                                    <?php 
                                                    if(!$isledgerentries)
                                                    {
                                                        ?>
                                                        <a href="javascript:void(0)" onclick="addopeningbalancefun('<?= $bvl->al_ledgerid ?>')" class="text-primary"><i class="fas fa-plus"></i> Add Opening Balance</a>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <a href="<?= base_url() ?>accounts/ledgerentries/<?= $bvl->al_ledgerid ?>" class="text-primary"><i class="fas fa-eye"></i> View</a>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $k++;
                                        }
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Add modal content -->
        <div id="addformmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Add Ledger</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?php echo base_url(); ?>accounts/addingaccledger" name="renewchiropodiform" id="renewchiropodiform" class="form-horizontal" method="post" onsubmit="return validateForm()">

                        <input type="hidden" name="buid" id="buid" value="<?= $buid ?>">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-check-label" for="customRadio1"><input type="radio" id="customRadio1" onclick="groupcreateselect('0')" value="0" checked="checked" name="issubgroup" class="form-check-input"> Create Main Ledger</label>
                                    &nbsp; &nbsp;
                                    <label class="form-check-label" for="customRadio2"><input type="radio" id="customRadio2" onclick="groupcreateselect('1')" value="1" name="issubgroup" class="form-check-input"> Create Sub Ledger</label>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="maingroupdiv" style="display: none;">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Select Main Ledger</label>
                                    <select class="form-control searchselect" name="mainledgerid" id="mainledgerid" data-toggle="select2" data-width="100%">
                                        <?php 
                                    if($mainledgers)
                                    {
                                        $k=1;
                                        foreach($mainledgers as $bvl)
                                        {
                                            ?>
                                            <option value="<?= $bvl->al_ledgerid ?>"><?= $bvl->al_ledger ?></option>
                                            <?php
                                        }
                                    }
                                            ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="accountgroupdiv">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="field-3" class="form-label">Select Account Group</label>
                                    <select class="form-control searchselect" required="required" name="accgroupid" id="accgroupid" data-toggle="select2" data-width="100%">
                                        <?php 
                                    if($accountgroups)
                                    {
                                        $k=1;
                                        foreach($accountgroups as $agvl)
                                        {
                                            ?>
                                            <option value="<?= $agvl->ag_groupid ?>"><?= $agvl->ag_group ?></option>
                                            <?php
                                        }
                                    }
                                            ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Ledger Name</label>
                                    <input type="text" name="ledgername" required class="form-control" id="ledgername" placeholder="Name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-7" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="field-3" class="form-label">Select Dr/Cr</label>
                                <select class="form-control" name="debicredit" id="debicredit">
                                    <option value="0">Dr</option>
                                    <option value="1">Cr</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <div class="">
                                    <label for="field-3" class="form-label">Opening Balance</label>
                                    <input type="number" name="openingbalance" class="form-control" id="openingbalance" placeholder="Opening Balance">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light listbtns" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-blue listbtns">Submit</button>
                    </div>
                </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <!-- Add modal content -->
        <div id="openingformmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabe2">Add Opening Balance</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?php echo base_url(); ?>accounts/addingledgeropeningbalance" name="renewchiropodiform" id="renewchiropodiform" class="form-horizontal" method="post" onsubmit="return validateForm()">

                        <input type="hidden" name="ledgerid" id="ledgerid" >

                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <label for="field-3" class="form-label">Select Dr/Cr</label>
                                <select class="form-control" name="debicredit" id="debicredit">
                                    <option value="0">Dr</option>
                                    <option value="1">Cr</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <div class="">
                                    <label for="field-3" class="form-label">Opening Balance*</label>
                                    <input type="number" name="openingbalance" required="required" class="form-control" id="openingbalance" placeholder="Opening Balance">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-7" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light listbtns" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-blue listbtns">Submit</button>
                    </div>
                </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    <script type="text/javascript">
        function addopeningbalancefun(ledgrid)
        {
            $('#ledgerid').val(ledgrid);
            $('#openingformmodal').modal('show');
        }
        function addaccgroupfun()
        {
            $('#addformmodal').modal('show');
        }
        function groupcreateselect(val)
        {
            if(val == '1')
            {
                $('#maingroupdiv').show();
                $('#accountgroupdiv').hide();
            }else{
                $('#maingroupdiv').hide();
                $('#accountgroupdiv').show();
            }
        }
    </script>