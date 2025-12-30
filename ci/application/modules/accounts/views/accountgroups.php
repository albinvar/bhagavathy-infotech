
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
                            <a href="javascript:void(0)" onclick="addaccgroupfun()" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Account Group</button>
                            </a>

                            <a href="<?= base_url() ?>accounts/accountprofileview/<?= $this->buid ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="far fa-arrow-alt-circle-left"></i> Back</button>
                            </a>
                        </div>
                        <h4 class="page-title">Account Groups</h4>
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
                                        <th>Group Name</th>
                                        <th>Sub Groups</th>
                                        <th>Under</th>
                                        <!--<th>Action</th>-->
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($accountgroups)
                                    {
                                        $k=1;
                                        foreach($accountgroups as $bvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= $bvl->ag_group ?> &nbsp;&nbsp;
                                                    <?php 
                                                    if($bvl->ag_isdefault != 1)
                                                    {
                                                    ?>
                                                <a href="#" onclick="return confirm('Are you sure?')" class="ml-2 text-primary" title="Edit"><i class="fas fa-edit"></i></a> &nbsp;
                                                <a href="#" onclick="return confirm('Are you sure?')" class="ml-2 text-danger" title="Disable"><i class="fas fa-times"></i></a>
                                                <?php 
                                                    }
                                                ?>
                                                </td>
                                                <td><?php
                                                    $accsubgrop = $this->accgrp->getaccsubgroups($bvl->ag_groupid, $this->buid);
                                                    if($accsubgrop)
                                                    {
                                                        foreach($accsubgrop as $sbvl)
                                                        {
                                                            echo $sbvl->ag_group;
                                                            ?>
                                                            &nbsp;
                                                            <?php 
                                                            if($sbvl->ag_isdefault != 1)
                                                            {
                                                            ?>
                                                            <a href="#" onclick="return confirm('Are you sure?')" class="ml-2 text-primary" title="Edit"><i class="fas fa-edit"></i></a> &nbsp;
                                                            <a href="#" onclick="return confirm('Are you sure?')" class="ml-2 text-danger" title="Disable"><i class="fas fa-times"></i></a>
                                                            <?php 
                                                            }
                                                            ?>
                                                            <br/>
                                                            <?php
                                                        }
                                                    }
                                                 ?></td>

                                                 <td><?= $bvl->am_maingroup ?></td>
                                                
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
                        <h4 class="modal-title" id="standard-modalLabel">Add Account Group</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?php echo base_url(); ?>accounts/addingaccgroup" name="renewchiropodiform" id="renewchiropodiform" class="form-horizontal" method="post" onsubmit="return validateForm()">

                        <input type="hidden" name="buid" id="buid" value="<?= $buid ?>">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-check-label" for="customRadio1"><input type="radio" id="customRadio1" onclick="groupcreateselect('0')" value="0" checked="checked" name="issubgroup" class="form-check-input"> Create Main Group</label>
                                    &nbsp; &nbsp;
                                    <label class="form-check-label" for="customRadio2"><input type="radio" id="customRadio2" onclick="groupcreateselect('1')" value="1" name="issubgroup" class="form-check-input"> Create Sub Group</label>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="primarygroupdiv">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Select Primary Group</label>
                                    <select class="form-control" name="primarygroupid" id="primarygroupid" >
                                        <?php 
                                    if($accprimarygroups)
                                    {
                                        $k=1;
                                        foreach($accprimarygroups as $pbvl)
                                        {
                                            ?>
                                            <option value="<?= $pbvl->am_maingroupid ?>"><?= $pbvl->am_maingroup ?></option>
                                            <?php
                                        }
                                    }
                                            ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        

                        <div class="row" id="maingroupdiv" style="display: none;">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Select Main Group</label>
                                    <select class="form-control" name="maingroupid" id="maingroupid" data-toggle="select2" data-width="100%">
                                        <?php 
                                    if($accountgroups)
                                    {
                                        $k=1;
                                        foreach($accountgroups as $bvl)
                                        {
                                            ?>
                                            <option value="<?= $bvl->ag_groupid ?>"><?= $bvl->ag_group ?></option>
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
                                    <label for="field-3" class="form-label">Group Name</label>
                                    <input type="text" name="groupname" required class="form-control" id="butype" placeholder="Name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
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
        function addaccgroupfun()
        {
            $('#addformmodal').modal('show');
        }
        function groupcreateselect(val)
        {
            if(val == '1')
            {
                $('#maingroupdiv').show();
                $('#primarygroupdiv').hide();
            }else{
                $('#maingroupdiv').hide();
                $('#primarygroupdiv').show();
            }
        }
    </script>