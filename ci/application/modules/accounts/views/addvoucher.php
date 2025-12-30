
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style type="text/css">
    .inputfieldcss {
    height: 33px;
    border: 1px solid var(--ct-input-border-color);
    padding: 0.45rem 0.9rem;
    border-radius: 0.2rem;
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
                            <a href="<?= base_url() ?>accounts/vouchers/<?= $vouchertype ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="far fa-arrow-alt-circle-left"></i> Back</button>
                            </a>
                        </div>
                        <h4 class="page-title"><?= $vouchername ?></h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">


                            <form id="businessuserform" class="addformvalidate" name="businessuserform" method="post" action="<?php echo site_url('accounts/addvoucherprocess') ?>" enctype="multipart/form-data">
                            <input type="hidden" id="buid" name="buid" value="<?= $buid ?>">
                            <input type="hidden" value="<?= $vouchrno ?>" class="form-control w-10" name="voucherno">
                            <input type="hidden" value="<?= $vouchertype ?>" class="form-control w-10" name="vouchertype">
                            
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    Voucher No: <b><?= $vouchrno ?></b>
                                </div>
                                <div class="col-md-6" align="right">
                                    Date: 
                                    <input type="date" name="voucherdate" value="<?php if(isset($editdata)){ if($pretype!=0){ echo date('Y-m-d'); }else{ echo date('Y-m-d', strtotime($editdata->rb_date)); } }else{ echo date('Y-m-d'); } ?>" class="inputfieldcss" style="width: 150px;">

                                    <input type="time" name="vouchertime" value="<?php if(isset($editdata)){ if($pretype!=0){ echo date('H:i'); }else{ echo date('H:i', strtotime($editdata->rb_time)); } }else{ echo date('H:i'); } ?>" class="inputfieldcss" style="width: 130px;">

                                </div>
                            </div>
                        
                            
                            <table class="table w-100" >
                                <thead>
                                    <tr>
                                        <th width="10%">Pament</th>
                                        <th width="35%">Particular</th>
                                        <th>Description</th>
                                        <th width="18%">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php 
                                            if($vouchertype == 3)
                                            {
                                                ?>
                                                Cr<br/>
                                                <i>(credit)</i>
                                                <input type="hidden" name="isdebit[]" value="1">
                                                <?php
                                            }else{
                                                ?>
                                                Dr<br/>
                                                <i>(debit)</i>
                                                <input type="hidden" name="isdebit[]" value="0">
                                                <?php
                                            }
                                            ?>
                                            
                                        </td>
                                        <td>
                                            <select class="form-control pagesearchselect w-100" style="width: 100%" required="required" name="ledgerid[]">
                                                <option value="">Please Select</option>
                                                <?php 
                                                if($drledgers)
                                                {
                                                    foreach($drledgers as $ldgvl)
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
                                        <td><input type="number" step=".01" class="form-control" onkeyup="calculatecredittotal(); <?php if($vouchertype == 3){ ?> calculatecredit(this.value); <?php }else{ ?>calculatedebit(this.value); <?php } ?>" name="amount[]"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php 
                                            if($vouchertype == 3)
                                            {
                                                ?>
                                                Dr<br/>
                                                <i>(debit)</i>
                                                <input type="hidden" name="isdebit[]" value="0">
                                                <?php
                                            }else{
                                                ?>
                                                Cr<br/>
                                                <i>(credit)</i>
                                                <input type="hidden" name="isdebit[]" value="1">
                                                
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <select class="form-control pagesearchselect w-100" style="width: 100%" required="required" name="ledgerid[]">
                                                <option value="">Please Select</option>
                                                <?php 
                                                if($crledgers)
                                                {
                                                    foreach($crledgers as $ldgvl)
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
                                        <td><input type="number" step=".01" class="form-control" onkeyup="calculatecredittotal();<?php if($vouchertype == 3){ ?> calculatedebit(this.value); <?php }else{ ?>calculatecredit(this.value); <?php } ?>" name="amount[]"></td>
                                    </tr>
                                </tbody>
                                <!--<tfoot>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th><input type="text" class="form-control" name="totaldebit" id="totaldebit"></th>
                                        <th><input type="text" class="form-control" name="totalcredit" id="totalcredit"></th>
                                    </tr>
                                </tfoot>-->
                            </table>
                            <input type="hidden" class="form-control" name="totaldebit" id="totaldebit">
                            <input type="hidden" class="form-control" name="totalcredit" id="totalcredit">

                            <input type="hidden" class="form-control" name="totalamount" id="totalamount">

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

            $("input[name='amount[]']").map(function(){
                if($(this).val() != "")
                {
                    credtot = parseInt(credtot) + parseInt($(this).val());
                }
            }).get();

            $('#totalamount').val(credtot);
        }

        function calculatedebit(val)
        {
            $('#totaldebit').val(val);
        }
        function calculatecredit(val)
        {
            $('#totalcredit').val(val);
        }
    </script>
