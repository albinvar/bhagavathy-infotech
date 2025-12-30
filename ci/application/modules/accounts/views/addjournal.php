
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
                            <a href="<?= base_url() ?>accounts/accountjournals/<?= $buid ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="far fa-arrow-alt-circle-left"></i> Back</button>
                            </a>
                        </div>
                        <h4 class="page-title">Add Journal</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">


                            <form id="businessuserform" class="addformvalidate" name="businessuserform" method="post" action="<?php echo site_url('accounts/addjournalprocess') ?>" enctype="multipart/form-data">
                            <input type="hidden" id="buid" name="buid" value="<?= $buid ?>">
                            <input type="hidden" value="<?= $jrnalno ?>" class="form-control w-10" name="journalno">
                            
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    Journal No: <b><?= $jrnalno ?></b>
                                </div>
                                <div class="col-md-6" align="right">
                                    Date: <b><?= date('d-M-Y') ?></b>
                                </div>
                            </div>
                        
                            
                            <table class="table w-100" >
                                <thead>
                                    <tr>
                                        <th width="20%">Date</th>
                                        <th>Particular</th>
                                        <th>Description</th>
                                        <th width="14%">Debit Amt</th>
                                        <th width="14%">Credit Amt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="datetime" id="jounaldatedate1" required="required" class="form-control datetime-datepicker" value="<?= date('d-M-Y H:i') ?>" name="jounaldatedate[]">
                                        </td>
                                        <td>
                                            <select class="form-control pagesearchselect w-100" required="required" name="ledgerid[]">
                                                <option value="">Please Select</option>
                                                <?php 
                                                if($ledgers)
                                                {
                                                    foreach($ledgers as $ldgvl)
                                                    {
                                                        ?>
                                                        <option value="<?= $ldgvl->al_ledgerid ?>"><?= $ldgvl->al_ledger ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="description[]"></td>
                                        <td><input type="number" step=".01" class="form-control" onkeyup="calculatedebittotal()" name="debitamount[]"></td>
                                        <td><input type="number" step=".01" class="form-control" onkeyup="calculatecredittotal()" name="creditamount[]"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="datetime" id="jounaldatedate2" required="required" class="form-control datetime-datepicker" value="<?= date('d-M-Y H:i') ?>" name="jounaldatedate[]">
                                        </td>
                                        <td>
                                            <select class="form-control pagesearchselect w-100" required="required" name="ledgerid[]">
                                                <option value="">Please Select</option>
                                                <?php 
                                                if($ledgers)
                                                {
                                                    foreach($ledgers as $ldgvl)
                                                    {
                                                        ?>
                                                        <option value="<?= $ldgvl->al_ledgerid ?>"><?= $ldgvl->al_ledger ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="description[]"></td>
                                        <td><input type="number" step=".01" class="form-control" onkeyup="calculatedebittotal()" name="debitamount[]"></td>
                                        <td><input type="number" step=".01" class="form-control" onkeyup="calculatecredittotal()" name="creditamount[]"></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th><input type="text" class="form-control" name="totaldebit" id="totaldebit"></th>
                                        <th><input type="text" class="form-control" name="totalcredit" id="totalcredit"></th>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group ">
                                        <label>Notes</label>
                                        <textarea name="notes" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6 grid-margin grid-margin-lg-0">
                                    <div class="form-group ">
                                        <label>Attachment</label>
                                        <input type="file" name="journalfile" class="form-control" id="journalfile">
                                    </div>
                                </div>
                            </div>


                            

                            <div class="row text-right mt-3">
                                <div class="col-md-12 text-center pull-right">
                                    <button type="submit" class="btn btn-primary mr-2 save listbtns" name="submit" value="0" id="submit">Save</button>
                                    <button type="submit" class="btn btn-warning mr-2 save listbtns" name="submit" value="1" id="submit"> Save as Draft</button>
                                    <a href="javascript:history.go(-1);" class="btn btn-secondary listbtns">Cancel</a>
                                </div>
                            </div>

                        </form>

                        </div>
                    </div>
                </div>
            </div>

            
            
        </div> <!-- container -->

    </div> <!-- content -->

    <script type="text/javascript">
        function calculatedebittotal()
        {
            var debtot= 0;

            $("input[name='debitamount[]']").map(function(){
                if($(this).val() != "")
                {
                    debtot = parseInt(debtot) + parseInt($(this).val());
                }
            }).get();

            $('#totaldebit').val(debtot);
        }
        function calculatecredittotal()
        {
            var credtot= 0;

            $("input[name='creditamount[]']").map(function(){
                if($(this).val() != "")
                {
                    credtot = parseInt(credtot) + parseInt($(this).val());
                }
            }).get();

            $('#totalcredit').val(credtot);
        }
    </script>
