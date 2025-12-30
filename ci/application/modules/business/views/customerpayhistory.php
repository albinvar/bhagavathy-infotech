
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
                            
                            <!--<a href="<?= base_url() ?>inventory/addproduct" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Product</button>
                            </a>--->

                            <a href="<?= base_url() ?>business/customers" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-backward"></i> Back</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Customer Transaction History</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <table class="table w-100 borderless" style="margin-bottom: 0px;">
                                <tr>
                                    <td>Customer Name </td>
                                    <td><b>: <?= $customerdet->ct_name ?></b></td>
                                
                                    <td>Phone</td>
                                    <td><b>: 
                                        <?php 
                                                $pharr = array();
                                                if($customerdet->ct_phone != "")
                                                {
                                                    $pharr[] = $customerdet->ct_phone;
                                                }
                                                if($customerdet->ct_mobile != "")
                                                {
                                                    $pharr[] = $customerdet->ct_mobile;
                                                }
                                                echo implode(', ', $pharr);
                                                ?>
                                    </b></td>
                                
                                    <td>Type</td>
                                    <td><b>: <?php 
                                                    if($customerdet->ct_type == 0)
                                                    {
                                                        echo 'B2C';
                                                    }else{
                                                        echo 'B2B (' . $customerdet->ct_gstin . ')';
                                                    }
                                                    ?></b></td>
                                
                                    <td>Balance</td>
                                    <td><b>: <?= price_roundof($customerdet->ct_balanceamount) ?></b></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">

                            <div class="row mb-2">
                                <div class="col-md-2">
                                    From Date:
                                    <input type="date" class="form-control" name="fromdate" id="fromdate" value="<?= $fromdate ?>">
                                </div>
                                <div class="col-md-2">
                                    To Date:
                                    <input type="date" class="form-control" name="todate" id="todate" value="<?= $todate ?>">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" onclick="filterproducthistory()" class="btn btn-blue" style="margin-top: 20px;">Filter</button>
                                </div>
                            </div>

                            <script type="text/javascript">
                                function filterproducthistory()
                                {
                                    var fromdate = $('#fromdate').val();
                                    var todate = $('#todate').val();
                                    window.location.href= '<?= base_url() ?>business/customerpayhistory/<?= $customerid ?>/'+fromdate+'/'+todate;
                                }
                            </script>


                            <ul class="nav nav-pills navtab-bg nav-justified">
                                
                                <li class="nav-item">
                                    <a href="#billtab" data-bs-toggle="tab"  class="nav-link active">
                                        Sale Bills
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#ledgrtab" data-bs-toggle="tab"  class="nav-link">
                                        Ledger Entries
                                    </a>
                                </li>
                                <!--<li class="nav-item">
                                    <a href="#paymnttab" data-bs-toggle="tab"  class="nav-link">
                                        Other Payments
                                    </a>
                                </li>-->
                            </ul>

                            <div class="tab-content">
                                

                                <div class="tab-pane active" id="billtab">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Bill No</th>
                                                <th>Total Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Balance Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    
                                        <tbody>
                                            <?php
                                            $totamount = 0;
                                            $totpaid = 0;

                                            if(!empty($salebills))
                                            {
                                                $k=1;
                                                foreach($salebills as $stvl)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?= $k ?></td>
                                                        <td><?= date('d-M-Y', strtotime($stvl->rb_date)) ?> <?= date('H:i', strtotime($stvl->rb_time)) ?></td>
                                                        <td><?= $stvl->rb_billprefix ?><?= $stvl->rb_billno ?></td>
                                                        <td><?php echo $stvl->rb_grandtotal;
                                                        $totamount = $totamount + $stvl->rb_grandtotal;
                                                         ?></td>
                                                        
                                                        <td><?php echo $stvl->rb_paidamount;
                                                        $totpaid = $totpaid + $stvl->rb_paidamount;
                                                         ?></td>
                                                        <td><?= $stvl->rb_balanceamount ?></td>
                                                        <td>
                                                            <a href="<?= base_url() ?>sale/saleprint/<?= $stvl->rb_retailbillid ?>/0/<?= $stvl->rb_billingtype ?>" target="_blank" class="text-primary"><i class="fas fa-print"></i> Print</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $k++;
                                                }
                                            }
                                            ?>
                                            

                                        </tbody>
                                    </table>

                                    <div class="row col-md-12 mt-2">
                                        <div class="col-md-4">
                                            Total Bill Amount: <b><?= $totamount ?></b>
                                        </div>
                                        <div class="col-md-4" align="center">
                                            
                                        </div>
                                        <div class="col-md-4" align="right">
                                            Total Pay Amount: <b><?= $totpaid ?></b>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane show" id="ledgrtab">
                                    
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Notes</th>
                                                <th>Bill No</th>
                                            </tr>
                                        </thead>
                                    
                                        <tbody>
                                            <?php
                                            $totcredit = 0;
                                                $totdebit = 0;
                                                $closingbalance = 0;
                                            if(!empty($custledgrs))
                                            {
                                                $k=1;
                                                foreach($custledgrs as $stvl)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?= $k ?></td>
                                                        <td><?= date('d-M-Y H:i', strtotime($stvl->le_date)) ?></td>
                                                        <td>
                                                            <?php 
                                                            if($stvl->le_isdebit == 1)
                                                            {
                                                                $closingbalance = $closingbalance - $stvl->le_amount;
                                                                $totcredit = $totcredit + $stvl->le_amount;
                                                                ?>
                                                                <span class="badge bg-danger">Cr</span>
                                                                <?php
                                                            }else{
                                                                $closingbalance = $closingbalance + $stvl->le_amount;
                                                                $totdebit = $totdebit + $stvl->le_amount;
                                                                ?>
                                                                <span class="badge bg-success">Dr</span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?= $stvl->le_amount ?></td>
                                                        <td><?= $stvl->le_note ?></td>
                                                        <td><?= $stvl->rb_billprefix ?><?= $stvl->rb_billno ?></td>
                                                    </tr>
                                                    <?php
                                                    $k++;
                                                }
                                            }
                                            ?>
                                            

                                        </tbody>
                                    </table>

                                    <div class="row col-md-12 mt-2">
                                        <div class="col-md-4">
                                            Total Credit: <b><?= $totcredit ?></b>
                                        </div>
                                        <div class="col-md-4" align="center">
                                            Total Debit: <b><?= $totdebit ?></b>
                                        </div>
                                        <div class="col-md-4" align="right">
                                            Closing Balance: <b><?= $closingbalance ?></b>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane" id="paymnttab">
                                </div>
                            </div>

                            

                            

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
                        <h4 class="modal-title" id="standard-modalLabel">Add Category</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?php echo base_url(); ?>inventory/addingcategory" name="addingform" id="addingform" class="addformvalidate" method="post">
                        <input type="hidden" name="editid" id="editid">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-check-label" for="customRadio1"><input type="radio" id="customRadio1" onclick="groupcreateselect('0')" value="0" checked="checked" name="issubgroup" id="maincheck" class="form-check-input"> Create Main Category</label>
                                    &nbsp; &nbsp;
                                    <label class="form-check-label" for="customRadio2"><input type="radio" id="customRadio2" onclick="groupcreateselect('1')" value="1" name="issubgroup" id="subcheck" class="form-check-input"> Create Sub Category</label>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="maingroupdiv" style="display: none;">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-3" class="form-label">Select Main Category</label>
                                    <select class="form-control searchselect" name="maincategoryid" id="maincategoryid" data-toggle="select2" data-width="100%">
                                        <?php 
                                    if($maincategories)
                                    {
                                        $k=1;
                                        foreach($maincategories as $bvl)
                                        {
                                            ?>
                                            <option value="<?= $bvl->pc_productcategoryid ?>"><?= $bvl->pc_categoryname ?></option>
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
                                    <label for="field-3" class="form-label">Category Name</label>
                                    <input type="text" name="categoryname" required class="form-control" id="categoryname" placeholder="Category Name">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="field-7" class="form-label">Description</label>
                                    <textarea class="form-control" id="notes" name="notes" placeholder="Notes"></textarea>
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
    function additemfun()
    {
        $('#standard-modalLabel').html('Add New Category');
        $('#editid').val("");
        $("#categoryname").val("");
        $("#maincheck").prop("checked", true);
        $('#maingroupdiv').hide();
        $("#notes").val("");
        $('#addformmodal').modal('show');
    }

</script>