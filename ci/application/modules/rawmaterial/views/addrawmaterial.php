
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style type="text/css">
    .proditemform{
        margin-top: 5px;
        border: 1px #cdbdbd solid;
        border-radius: 5px;
        padding: 5px 10px 15px 10px;
    }
    .frmcode{
        margin-top: 5px;
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
                            <a href="<?= base_url() ?>rawmaterial/rawmateriallist" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="far fa-arrow-alt-circle-left"></i> Back</button>
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
                        <div class="card-body">

                            <h4 class="formmainheading"><?php if($editid == 0){ echo "Add New Material"; }else{ echo "Edit Details"; } ?></h4>

                            <form id="businessuserform" class="addformvalidate" name="businessuserform" method="post" action="<?php echo site_url('rawmaterial/addingmaterialsprocess') ?>" enctype="multipart/form-data">
                            <input type="hidden" id="editid" name="editid" value="<?= $editid ?>">
                            
                            <div class="row">
                                <div class="col-md-12" id="productadddiv">

                                <div class="proditemform" id="productitem1">
                                    

                                    <div class="row">
                                        <div class="col-md-2 frmcode">
                                            <label>Material Code</label>
                                            <input type="text" class="form-control" value="<?=(isset($editdata)) ? $editdata->pd_productcode : ''?>" required name="productcode[]" data-parsley-trigger="focusout" data-parsley-checkproductcode data-parsley-checkproductcode-message="Code already Exists">
                                        </div>
                                        <div class="col-md-4 frmcode">
                                            <label>Material name</label>
                                            <input type="text" class="form-control" required value='<?php if(isset($editdata)){ echo $editdata->pd_productname; } ?>' name="productname[]">
                                        </div>

                                        <div class="col-md-3 frmcode">
                                            <label>Size</label>
                                            <input type="text" class="form-control" value='<?php if(isset($editdata)){ echo $editdata->pd_size; } ?>' name="productsize[]">
                                        </div>

                                        <div class="col-md-3 frmcode">
                                            <label>Brand</label>
                                            <input type="text" class="form-control" value='<?php if(isset($editdata)){ echo $editdata->pd_brand; } ?>' name="productbrand[]">
                                        </div>

                                        <div class="col-md-3 frmcode">
                                            <label>Company</label>
                                            <input type="text" class="form-control" value='<?php if(isset($editdata)){ echo $editdata->pd_company; } ?>' name="productcompany[]">
                                        </div>

                                        <?php 
                                        if($inventorysettings)
                                        {
                                            if($inventorysettings->is_categorywise == 1)
                                            {
                                            ?>
                                        <div class="col-md-3 frmcode">
                                            <label>Category</label>
                                            <select class="form-select" name="categoryid[]" required>
                                                <?php
                                                if($categories)
                                                {
                                                    foreach($categories as $ctval)
                                                    {
                                                        ?>
                                                        <option <?php if(isset($editdata)){ if($editdata->pd_categoryid == $ctval->pc_productcategoryid){ echo "selected"; } } ?> value="<?= $ctval->pc_productcategoryid ?>"><?= $ctval->pc_categoryname ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                            <?php 
                                            }
                                            if($inventorysettings->is_hsn == 1)
                                            {
                                            ?>
                                        <div class="col-md-2 frmcode">
                                            <label>HSN No</label>
                                            <input type="text" class="form-control" required value="<?=(isset($editdata)) ? $editdata->pd_hsnno : ''?>" name="hsnno[]">
                                        </div>
                                        <?php 
                                            }
                                        }
                                        ?>
                                        <div class="col-md-2 frmcode">
                                            <label>Unit</label>
                                            <select class="form-select" name="unitid[]" required>
                                                <?php
                                                if($units)
                                                {
                                                    foreach($units as $utval)
                                                    {
                                                        ?>
                                                        <option <?php if(isset($editdata)){ if($editdata->pd_unitid == $utval->un_unitid){ echo "selected"; } } ?> value="<?= $utval->un_unitid ?>"><?= $utval->un_unitname ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-2 frmcode">
                                            <label>Taxband</label>
                                            <select class="form-select" name="taxbandid[]" required>
                                                <?php
                                                if($taxbands)
                                                {
                                                    foreach($taxbands as $txval)
                                                    {
                                                        ?>
                                                        <option <?php if(isset($editdata)){ if($editdata->pd_taxbandid == $txval->tb_taxbandid){ echo "selected"; } } ?> value="<?= $txval->tb_taxbandid ?>"><?= $txval->tb_taxband ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-2 frmcode">
                                            <label>CESS</label>
                                            <input type="number" step="any" class="form-control" value="<?=(isset($editdata)) ? $editdata->pd_cess : ''?>" name="cess[]">
                                        </div>

                                        <div class="col-md-2 frmcode">
                                            <label>Purchase Price</label>
                                            <input type="number" step="any" id="pruchaseprice1" value="<?=(isset($editdata)) ? $editdata->pd_purchaseprice : ''?>" onkeyup="retailamntcalculation('1');wholesaleamntcalculation('1')" onchange="retailamntcalculation('1');wholesaleamntcalculation('1')" class="form-control" name="purprice[]">
                                        </div>

                                        <div class="col-md-2 frmcode">
                                            <label>MRP</label>
                                            <input type="number" step="any" class="form-control" onkeyup="retailamntcalculation('1');wholesaleamntcalculation('1')" onchange="retailamntcalculation('1');wholesaleamntcalculation('1')" value="<?=(isset($editdata)) ? $editdata->pd_mrp : ''?>" id="mrp1" name="mrp[]">
                                        </div>

                                        <?php 
                                        /*
                                        $profttpeaded = 0;
                                        $profittyp = 3;
                                        $retailprofit = "";
                                        $retailamnt = "";
                                        $wholeprofit = "";
                                        $wholesaleamnt = "";

                                        if(isset($editdata)){
                                            if($editdata->pd_profittype != "")
                                            {
                                                $profttpeaded = 1;
                                                $profittyp = $editdata->pd_profittype;
                                                $retailprofit = $editdata->pd_retailprofit;
                                                if($editdata->pd_retailprice != 0)
                                                {
                                                    if($profittyp == 2)
                                                    {
                                                        $retailamnt = $editdata->pd_purchaseprice + $retailprofit;
                                                    }else if($profittyp == 1){
                                                        $retailamnt = $editdata->pd_purchaseprice + ($editdata->pd_purchaseprice*$retailprofit/100);
                                                    }else{
                                                        $retailamnt = $editdata->pd_mrp;
                                                    }
                                                }

                                                if($editdata->pd_wholesaleprice != 0)
                                                {
                                                    $wholeprofit = $editdata->pd_wholesaleprofit;
                                                    if($profittyp == 2)
                                                    {
                                                        $wholesaleamnt = $editdata->pd_purchaseprice + $wholeprofit;
                                                    }else if($profittyp == 1){
                                                        $wholesaleamnt = $editdata->pd_purchaseprice + ($editdata->pd_purchaseprice*$wholeprofit/100);
                                                    }else{
                                                        $wholesaleamnt = $editdata->pd_mrp;
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="col-md-2 frmcode">
                                            <label>Profit Type</label><br/>
                                            <label><input type="radio"  value="1" <?php if($profittyp == 1){ echo "checked"; } else{ ?> checked="checked" <?php } ?> onclick="protypechangefun('1', this.value);retailamntcalculation('1');wholesaleamntcalculation('1')" name="profittype1"> %</label> &nbsp;
                                            <label><input type="radio"  value="2" <?php if($profittyp == 2){ echo "checked"; }  ?> onclick="protypechangefun('1', this.value);retailamntcalculation('1');wholesaleamntcalculation('1')" name="profittype1"> Amount</label>

                                            <label><input type="radio"  value="3" <?php if($profittyp == 3){ echo "checked"; }  ?> onclick="protypechangefun('1', this.value);retailamntcalculation('1');wholesaleamntcalculation('1')" name="profittype1"> Use MRP</label>

                                            

                                            <input type="hidden" name="protype[]" value="<?= $profittyp ?>" id="protype1">
                                        </div>

                                        <div class="col-md-2 frmcode retproftdet1" <?php if($profittyp == 3){ ?> style="display: none;" <?php } ?>>
                                            <label>Retail Profit</label>
                                            <input type="number" step="any" id="retailprofit1" value="<?= $retailprofit ?>" onkeyup="retailamntcalculation('1')" onchange="retailamntcalculation('1')" class="form-control" name="retailprofit[]">

                                        </div>
                                       <div class="col-md-2 frmcode">
                                            <label>Retail Amount</label>
                                            <input type="number" readonly="readonly" step="any" id="retailamount1" value="<?= $retailamnt ?>" class="form-control" name="retailamount[]">
                                        </div>
                                        <div class="col-md-2 frmcode retproftdet1" <?php if($profittyp == 3){ ?> style="display: none;" <?php } ?>>
                                            <label>Wholesale Profit</label>
                                            <input type="number" step="any" id="wholesaleprofit1" onkeyup="wholesaleamntcalculation('1')" onchange="wholesaleamntcalculation('1')" class="form-control" value="<?= $wholeprofit ?>" name="wholesaleprofit[]">

                                        </div>
                                        <div class="col-md-2 frmcode">
                                            <label>Wholesale Amount</label>
                                            <input type="number" readonly="readonly" step="any" id="wholesaleamount1" value="<?= $wholesaleamnt ?>" class="form-control" name="wholesaleamount[]">
                                        </div>

                                        <?php
                                        */
                                        if($inventorysettings)
                                        {
                                            if($inventorysettings->is_image == 1)
                                            {
                                            ?>
                                        <div class="col-md-4 frmcode">
                                            <label>Material Image</label>
                                            <input type="file" id="prodimg1" class="form-control" name="prodimage[]">
                                        </div>
                                            <?php 
                                            }
                                        }
                                        ?>

                                        <div class="col-md-2 frmcode">
                                            <label>Stock Threshold</label>
                                            <input type="number" step="any" id="thresholdstock1" value="<?=(isset($editdata)) ? $editdata->pd_stockthreshold : '0'?>" class="form-control" name="thresholdstock[]">
                                        </div>
                            
                                    </div>
                                </div>

                                </div>
                            </div>
                            <?php 
                            if($editid == 0)
                            {
                            ?>
                            <div align="right">
                                <a href="javascript:void(0)" onclick="addmoreitem()">Add more +</a>
                            </div>
                            <?php 
                            }
                            ?>

                            <div class="row text-right mt-3">
                                <div class="col-md-12 text-center pull-right">
                                    <button type="submit" class="btn btn-primary mr-2 addfacilitySubmit listbtns"
                                        id="addfacilitySubmit">Submit</button>
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
    function tofixed_amount(amnt)
    {
        var decml = <?= $this->decimalpoints ?>;
        return amnt.toFixed(decml);
    }
        function protypechangefun(no, val)
        {
           // alert(val);
            $('#protype'+no).val(val);
            if(val == 3)
            {
                $('.retproftdet'+no).hide();
            }else{
                $('.retproftdet'+no).show();
            }
        }
        function retailamntcalculation(val)
        {
            var type = $('#protype'+val).val();
            let purprice = parseFloat($('#pruchaseprice'+val).val());
            let retailprofit = parseFloat($('#retailprofit'+val).val());
            let mrp = parseFloat($('#mrp'+val).val());

            if(type == 2)
            {
                var retprice = purprice + retailprofit;
            }else if(type == 1){
                var retprice = purprice + (purprice*retailprofit/100);
            }else{
                var retprice = mrp;
            }
            $('#retailamount'+val).val(tofixed_amount(retprice));
        }
        function wholesaleamntcalculation(val)
        {
            var type = $('#protype'+val).val();
            let purprice = parseFloat($('#pruchaseprice'+val).val());
            let wholesaleprofit = parseFloat($('#wholesaleprofit'+val).val());
            let mrp = parseFloat($('#mrp'+val).val());

            if(type == 2)
            {
                var wholeprice = purprice + wholesaleprofit;
            }else if(type == 1){
                var wholeprice = purprice + (purprice*wholesaleprofit/100);
            }else{
                var wholeprice = mrp;
            }
            $('#wholesaleamount'+val).val(tofixed_amount(wholeprice));
        }

        function removeitemrow(no)
        {
            $('#productitem'+no).remove();
        }

        var itmno = 2;
        function addmoreitem()
        {
            $('#productadddiv').append(`<div class="proditemform" id="productitem`+itmno+`">
                        <div align="right"><a href="javascript:void(0)" onclick="removeitemrow('`+itmno+`')" title="Delete Row"><i class="fa fa-times-circle"></i></a></div>
                        <div class="row">
                            <div class="col-md-2 frmcode">
                                <label>Material Code</label>
                                <input type="text" class="form-control" required name="productcode[]">
                            </div>
                            <div class="col-md-4 frmcode">
                                <label>Material name</label>
                                <input type="text" class="form-control" required name="productname[]">
                            </div>
                            <div class="col-md-3 frmcode">
                                <label>Size</label>
                                <input type="text" class="form-control" name="productsize[]">
                            </div>

                            <div class="col-md-3 frmcode">
                                <label>Brand</label>
                                <input type="text" class="form-control" name="productbrand[]">
                            </div>

                            <div class="col-md-3 frmcode">
                                <label>Company</label>
                                <input type="text" class="form-control" name="productcompany[]">
                            </div>

                            <?php 
                            if($inventorysettings)
                            {
                                if($inventorysettings->is_categorywise == 1)
                                {
                                ?>
                            <div class="col-md-3 frmcode">
                                <label>Category</label>
                                <select class="form-select" name="categoryid[]" required>
                                    <?php
                                    if($categories)
                                    {
                                        foreach($categories as $ctval)
                                        {
                                            ?>
                                            <option value="<?= $ctval->pc_productcategoryid ?>"><?= $ctval->pc_categoryname ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                                <?php 
                                }
                                if($inventorysettings->is_hsn == 1)
                                {
                                ?>
                            <div class="col-md-2 frmcode">
                                <label>HSN No</label>
                                <input type="text" class="form-control" required name="hsnno[]">
                            </div>
                            <?php 
                                }
                            }
                            ?>
                            <div class="col-md-2 frmcode">
                                <label>Unit</label>
                                <select class="form-select" name="unitid[]" required>
                                    <?php
                                    if($units)
                                    {
                                        foreach($units as $utval)
                                        {
                                            ?>
                                            <option value="<?= $utval->un_unitid ?>"><?= $utval->un_unitname ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 frmcode">
                                <label>Taxband</label>
                                <select class="form-select" name="taxbandid[]" required>
                                    <?php
                                    if($taxbands)
                                    {
                                        foreach($taxbands as $txval)
                                        {
                                            ?>
                                            <option value="<?= $txval->tb_taxbandid ?>"><?= $txval->tb_taxband ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 frmcode">
                                <label>CESS</label>
                                <input type="number" step="any" class="form-control" name="cess[]">
                            </div>
                            <div class="col-md-2 frmcode">
                                <label>Purchase Price</label>
                                <input type="number" step="any" id="pruchaseprice`+itmno+`" onkeyup="retailamntcalculation('`+itmno+`');wholesaleamntcalculation('`+itmno+`')" class="form-control" name="purprice[]">
                            </div>
                            <div class="col-md-2 frmcode">
                                <label>MRP</label>
                                <input type="number" step="any" onkeyup="retailamntcalculation('`+itmno+`');wholesaleamntcalculation('`+itmno+`')" onchange="retailamntcalculation('`+itmno+`');wholesaleamntcalculation('`+itmno+`')" class="form-control" id="mrp`+itmno+`" name="mrp[]">
                            </div>
                            <?php 
                            /*
                            ?>
                            <div class="col-md-2 frmcode">
                                <label>Profit Type</label><br/>
                                <label><input type="radio"  value="1" onclick="protypechangefun('`+itmno+`', this.value);retailamntcalculation('`+itmno+`');wholesaleamntcalculation('`+itmno+`')" name="profittype`+itmno+`"> %</label> &nbsp;
                                <label><input type="radio"  value="2" onclick="protypechangefun('`+itmno+`', this.value);retailamntcalculation('`+itmno+`');wholesaleamntcalculation('`+itmno+`')" name="profittype`+itmno+`"> Amount</label>
                                <label><input type="radio"  value="3" checked="checked" onclick="protypechangefun('`+itmno+`', this.value);retailamntcalculation('`+itmno+`');wholesaleamntcalculation('`+itmno+`')" name="profittype`+itmno+`"> Use MRP</label>
                                <input type="hidden" name="protype[]" id="protype`+itmno+`" value="3">
                            </div>

                            <div class="col-md-2 frmcode retproftdet`+itmno+`" style="display:none;">
                                <label>Retail Profit</label>
                                <input type="number" step="any" id="retailprofit`+itmno+`" onkeyup="retailamntcalculation('`+itmno+`')" class="form-control" name="retailprofit[]">
                            </div>
                            <div class="col-md-2 frmcode">
                                <label>Retail Amount</label>
                                <input type="number" step="any" id="retailamount`+itmno+`" class="form-control" name="retailamount[]">
                            </div>
                            <div class="col-md-2 frmcode retproftdet`+itmno+`" style="display:none;">
                                <label>Wholesale Profit</label>
                                <input type="number" step="any" id="wholesaleprofit`+itmno+`" onkeyup="wholesaleamntcalculation('`+itmno+`')" class="form-control" name="wholesaleprofit[]">
                            </div>
                            <div class="col-md-2 frmcode">
                                <label>Wholesale Amount</label>
                                <input type="number" step="any" id="wholesaleamount`+itmno+`" class="form-control" name="wholesaleamount[]">
                            </div>
                            <?php
                            */
                            if($inventorysettings)
                            {
                                if($inventorysettings->is_image == 1)
                                {
                                ?>
                            <div class="col-md-4 frmcode">
                                <label>Material Image</label>
                                <input type="file" id="prodimg`+itmno+`" class="form-control" name="prodimage[]">
                            </div>
                                <?php 
                                }
                            }
                            ?>
                            <div class="col-md-2 frmcode">
                                <label>Stock Threshold</label>
                                <input type="number" step="any" id="thresholdstock`+itmno+`" value="0" class="form-control" name="thresholdstock[]">
                            </div>
                        </div>
                    </div>`);
            itmno=itmno+1;
        }
    </script>