<!-- ============================================================== -->
<!-- Start Page Content here -->
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
                            
                            <!--<a href="<?= base_url() ?>inventory/addproduct" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Products</button>
                            </a>

                            <a href="<?= base_url() ?>business/addcustomer" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Customer</button>
                            </a>-->

                            <a href="<?= base_url() ?>production/productionhistory" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-backward"></i> Back</button>
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
                        <div class="card-body p-2 dashoboardform">
                            <form action="<?= base_url() ?>production/addingdeliverynote" method="POST" name="purchaseform" id="purchaseform">
                                <input type="hidden" name="type" value="<?= $type ?>">
                                <input type="hidden" name="productionid" id="productionid" value="<?= $productionid ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="billprefix" value="<?php  echo $billprefix; ?>">
                                    Bill No: <b><?php  echo $billprefix; ?></b><input type="text" name="billno" readonly value="<?php if(isset($editdata)){ if($pretype!=0){ echo $billno; }else{ echo $editdata->rb_billno;} }else{ echo $billno; } ?>" class="inputfieldcss" style="width: 100px;">

                                    
                                </div>
                                <div class="col-md-6" align="right">
                                    <input type="date" name="saledate" value="<?php if(isset($editdata)){ if($pretype!=0){ echo date('Y-m-d'); }else{ echo date('Y-m-d', strtotime($editdata->rb_date)); } }else{ echo date('Y-m-d'); } ?>" class="inputfieldcss" style="width: 150px;">

                                    <input type="time" name="saletime" value="<?php if(isset($editdata)){ if($pretype!=0){ echo date('H:i'); }else{ echo date('H:i', strtotime($editdata->rb_time)); } }else{ echo date('H:i'); } ?>" class="inputfieldcss" style="width: 130px;">
                                    
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="customercheck"> <b>Already existing customer?</b>
                                <input type="checkbox" value="1" <?php if(isset($editdata)){ if($editdata->rb_existcustomer == 1){ echo "checked"; } } ?>  name="customercheck" id="customercheck"></label>

                                <div id="walkincustdiv" <?php if(isset($editdata)){ if($editdata->rb_existcustomer == 1){ ?> style="display: none;" <?php } } ?>>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label>Customer Name</label>
                                        <input type="text" name="customername" placeholder="Customer Name" value="<?php if(isset($editdata)){ echo $editdata->rb_customername; } ?>" class="w-100 inputfieldcss">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Customer Phone</label>
                                        <input type="text" name="customerphone" placeholder="Customer Phone" value="<?php if(isset($editdata)){ echo $editdata->rb_phone; } ?>" class="w-100 inputfieldcss">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Customer Address</label>
                                        <input type="text" name="customeraddress" placeholder="Customer Address" value="<?php if(isset($editdata)){ echo $editdata->rb_address; } ?>" class="w-100 inputfieldcss">
                                    </div>

                                    <div class="col-md-3">
                                        <label><?= $this->isvatgstname ?> No</label>
                                        <input type="text" name="customergstin" placeholder="Customer <?= $this->isvatgstname ?>" value="<?php if(isset($editdata)){ echo $editdata->rb_gstno; } ?>" class="w-100 inputfieldcss">
                                    </div>
                                         
                                </div>    
                                </div>
                                <div id="existcustdiv" <?php if(isset($editdata)){ if($editdata->rb_existcustomer == 0){ ?> style="display: none;" <?php } }else{ ?> style="display: none;" <?php } ?>>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label>Select Customer</label>
                                        <input type="hidden" name="customerid" id="customerid" value="<?php if(isset($editdata)){ echo $editdata->rb_customerid; }else{ echo '0'; } ?>">
                                        <input type="text" name="supplier" id="suppliertextbox" autocomplete="off" onkeyup="searchcustomerfun(this.value)" placeholder="Cuctomer Name" value="<?php if(isset($editdata)){ echo $editdata->ct_name; } ?>" class="w-100 inputfieldcss">

                                        <div id="resultsressearch" class="secol dropdowndivstyle"><div class="secol" style="padding:5px;" id="serchreslt"></div></div>
                                    </div>
                                </div>
                                </div>
                                
                                
                                <div class="col-md-3 mt-2">
                                    <label>Vehicle Number</label>
                                    <input type="text" name="vehicleno" placeholder="Vehicle Number" value="<?php if(isset($editdata)){ echo $editdata->rb_vehicleno; } ?>" class="w-100 inputfieldcss">
                                </div>
                                
                                <div class="col-md-3 mt-2">
                                    <label>Sales Person</label>

                                    <select class="w-100 inputfieldcss pagesearchselect" data-toggle="select2" name="salesperson">
                                        <?php 
                                        if($this->userrole == 2)
                                        {
                                            ?>
                                            <option selected="selected" value="<?= $this->loggeduserid ?>"><?= $this->session->userdata('name') ?></option>
                                            <?php
                                        }
                                        if($userlist)
                                        {
                                            foreach($userlist as $usrvl)
                                            {
                                                ?>
                                                <option <?php if($this->loggeduserid == $usrvl->at_authid){ echo "selected"; } ?> value="<?= $usrvl->at_authid ?>"><?= $usrvl->at_name ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <!--<input type="text" name="salesperson" placeholder="Sales Person" value="<?php if(isset($editdata)){ echo $editdata->rb_salesperson; } ?>" class="w-100 inputfieldcss">-->
                                </div>
                                <div class="col-md-3 mt-2">
                                    <label>Shipping Address</label>
                                    <input type="text" name="shippingaddress" id="shippingaddress" placeholder="Shipping Address" value="<?php if(isset($editdata)){ echo $editdata->rb_shippingaddress; } ?>" class="w-100 inputfieldcss">
                                </div>
                                

                                <div class="col-md-3 mt-2">
                                    <label>Select Place of Supply</label>
                                    <select name="stateid" id="stateid" class="w-100 inputfieldcss pagesearchselect">
                                        <option value="">Select State</option>
                                            <?php
                                            if($states)
                                            {
                                                foreach($states as $stval)
                                                {
                                                    ?>
                                                    <option <?php if(isset($editdata)){ if($editdata->rb_state==$stval->id){ echo "selected"; } }else{ if($stval->id == $businessdet->bu_state){ echo "selected"; }} ?> value="<?= $stval->id ?>"><?= $stval->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>

                                <!------------- New fields added -------------->
                                
                                <div class="col-md-3 mt-2">
                                    <label>Delivery Date</label>
                                    <input type="date" name="deliverydate" id="deliverydate"  value="<?php if(isset($editdata)){ echo $editdata->rb_deliverydate; }else{ echo date('Y-m-d'); } ?>" class="w-100 inputfieldcss">
                                </div>
                                

                            </div>

                            <div class="mt-3 table-responsive dashboarditems" >
                                <table class="table  w-100" cellspacing="0" cellspacing="0">
                                    <thead class="bg-gray-300">
                                        <tr>
                                            <th>#</th>
                                            <th>Product Id</th>
                                            <th>Product Name</th>
                                             <?php 
                                            /*if($inventorysettings)
                                            {
                                                if($inventorysettings->is_batchwise == 1)
                                                {
                                            ?>
                                            <th>Batch No</th>
                                            <?php 
                                                }
                                                if($inventorysettings->is_expirydate == 1)
                                                {
                                            ?>
                                            <th>Expiry Date</th>
                                            <?php 
                                                }
                                            }*/
                                            
                                            ?>
                                            <th>MRP</th>
                                            <th>Qty</th>
                                            <th width="120px">Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemlistbody">
                                        <?php 
                                        $pretotalamount = 0;
                                        $itno = 1;
                                        if(isset($prdctdet))
                                        {
                                            if($prdctdet)
                                            {
                                                
                                                    ?>

                                        <tr id="prdrow<?= $itno ?>">
                                            <td><span id="slno<?= $itno ?>"><?= $itno ?></span></td>
                                            <td>
                                                <input type="hidden" name="productid[]" value="<?= $prdctdet->pd_productid ?>" id="productid<?= $itno ?>">
                                                <input type="hidden" name="stockid[]" value="" id="stockid<?= $itno ?>">
                                                <input type="hidden" name="batchno[]" value="" id="batchno<?= $itno ?>">
                                                <input type="hidden" name="expirydate[]" value="" id="expirydate<?= $itno ?>">
                                                <input type="text" name="productcode[]" id="productcode<?= $itno ?>" onkeyup="searchproductcodefun(this.value, '<?= $itno ?>')" class="productcodes" value="<?= $prdctdet->pd_productcode ?>" title="<?= $itno ?>" autocomplete="off" style="width: 100px;"><br/>
                                                <div id="resultproductcode<?= $itno ?>" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productcodeserchreslt<?= $itno ?>"></div></div>

                                                <div id="productitemdetailsdiv<?= $itno ?>" class="productitemdetailsdivstyle"></div>
                                            </td>
                                            <td>
                                                <input type="text" name="productname[]" id="productname<?= $itno ?>" onkeyup="searchproductnamefun(this.value, '<?= $itno ?>')" value="<?= $prdctdet->pd_productname ?>" autocomplete="off"><br/>
                                                <div id="resultproduct<?= $itno ?>" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productserchreslt<?= $itno ?>"></div></div>
                                            </td>
                                            <?php 
                                            /*if($inventorysettings)
                                            {
                                                if($inventorysettings->is_batchwise == 1)
                                                {
                                            ?>
                                            <td><input type="text" name="batchno[]" id="batchno1" style="width: 60px;"></td>
                                            <?php   
                                                }
                                                if($inventorysettings->is_expirydate == 1)
                                                {
                                            ?>
                                            <td><input type="date" name="expirydate[]" id="expirydate1" style="width: 100px;"></td>
                                            <?php 
                                                }
                                            }*/
                                            
                                            ?>
                                            
                                            <td><input type="number" step="any" name="mrp[]" value="<?= $prdctdet->pd_mrp ?>" id="mrp<?= $itno ?>" onchange="calculateitemprice('<?= $itno ?>')" onkeyup="calculateitemprice('<?= $itno ?>')" style="width: 60px;"></td>

                                            
                                            
                                             
                                            <td>
                                                <input type="number" name="qty[]" id="qty<?= $itno ?>" value="<?= $qty ?>" onchange="calculateitemprice('<?= $itno ?>')" onkeyup="calculateitemprice('<?= $itno ?>')" style="width: 50px;"><span id="itemunitval<?= $itno ?>"></span>
                                                
                                            </td>
                                            
                                            
                                            <td>
                                                <?php 
                                                $ittotalamount = $prdctdet->pd_mrp * $qty;
                                                $pretotalamount = $pretotalamount + $ittotalamount;
                                                ?>
                                                
                                                <input type="hidden" name="itemtotalamt[]" value="<?= $ittotalamount ?>" id="itemtotalamt<?= $itno ?>">

                                                
                                                
                                                Total: <b><span id="totalamt<?= $itno ?>"><?= $ittotalamount ?></span></b>
                                            </td>
                                            <td>
                                                <?php 
                                                /*if($pretype != 2 && $pretype != 4)
                                                {
                                                    ?>
                                                <a href="javascript:void(0)" onclick="removeitemrow('<?= $itno ?>')" title="Delete Row"><i class="fa fa-times-circle"></i></a>
                                                <?php 
                                                }*/
                                                ?>
                                            </td>
                                        </tr>
                                        <?php 
                                        $itno++;
                                        
                                    }
                                }else{
                                    $itno++;
                                    ?>
                                    <tr id="prdrow1">
                                            <td><span id="slno1">1</span></td>
                                            <td>
                                                <input type="hidden" name="productid[]" id="productid1">
                                                <input type="hidden" name="stockid[]" id="stockid1">
                                                <input type="hidden" name="batchno[]" id="batchno1">
                                                <input type="hidden" name="expirydate[]" id="expirydate1">
                                                <input type="text" name="productcode[]" id="productcode1" onkeyup="searchproductcodefun(this.value, '1')" title="1" class="productcodes" autocomplete="off" style="width: 100px;"><br/>
                                                <div id="resultproductcode1" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productcodeserchreslt1"></div></div>

                                                <div id="productitemdetailsdiv1" class="productitemdetailsdivstyle"></div>
                                            </td>
                                            <td>
                                                <input type="text" name="productname[]" id="productname1" onkeyup="searchproductnamefun(this.value, '1')" autocomplete="off"><br/>
                                                <div id="resultproduct1" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productserchreslt1"></div></div>
                                            </td>
                                            <?php 
                                            /*if($inventorysettings)
                                            {
                                                if($inventorysettings->is_batchwise == 1)
                                                {
                                            ?>
                                            <td><input type="text" name="batchno[]" id="batchno1" style="width: 60px;"></td>
                                            <?php   
                                                }
                                                if($inventorysettings->is_expirydate == 1)
                                                {
                                            ?>
                                            <td><input type="date" name="expirydate[]" id="expirydate1" style="width: 100px;"></td>
                                            <?php 
                                                }
                                            }*/
                                            
                                            
                                            ?>
                                            
                                            <td><input type="number" step="any" name="mrp[]" id="mrp1" style="width: 60px;" onchange="calculateitemprice('1')" onkeyup="calculateitemprice('1')"></td>

                                            
                                            <td>
                                                <input type="number" name="qty[]" id="qty1" onchange="calculateitemprice('1')" onkeyup="calculateitemprice('1')" style="width: 50px;"><span id="itemunitval1"></span>
                                                <br/><br/>
                                                
                                            </td>
                                            
                                            
                                            <td>
                                                <input type="hidden" name="itemnetamt[]" id="itemnetamt1">
                                                <input type="hidden" name="itemgstamt[]" id="itemgstamt1">
                                                <input type="hidden" name="itemcessamt[]" id="itemcessamt1">
                                                <input type="hidden" name="itemdiscountamt[]" id="itemdiscountamt1">
                                                <input type="hidden" name="itemtotalamt[]" id="itemtotalamt1">

                                                <input type="hidden" name="itemtotalprofit[]" id="itemtotalprofit1">

                                                
                                                Total: <b><span id="totalamt1"></span></b>
                                            </td>
                                            <td>
                                                
                                                <a href="javascript:void(0)" onclick="removeitemrow('1')" title="Delete Row"><i class="fa fa-times-circle"></i></a>
                                                
                                            </td>
                                        </tr>
                                    <?php
                                }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php 
                           /* if($pretype != 2 && $pretype != 4)
                            {*/
                                ?>
                            <div align="right">
                                <a href="javascript:void(0)" onclick="addmoreitem()">Add more +</a>
                            </div>
                            <?php 
                            /*}*/
                            ?>

                           

                            <table class="w-100 footrtable" cellspacing="5">
                                <tr>
                                    <td align="right" width="20%"></td>
                                    <td></td>
                                    
                                    <td align="right">Freight: </td>
                                    <td width="150px"><input type="number" step="any" required="required" onchange="calculatetotalamnt()" onkeyup="calculatetotalamnt()" name="freight" id="freight" value="<?php if(isset($editdata)){ echo $editdata->rb_freight; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                    <td align="right"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td align="right"></td>
                                    <td></td>
                                    <td align="right">Total Amount: </td>
                                    <td><input type="number" step="any" readonly name="totalamount" id="totalamount" value="<?php if(isset($editdata)){ echo $editdata->rb_totalamount; }else{ echo price_roundof($pretotalamount); } ?>" class="w-100 inputfieldcss"></td>
                                    <td align="right"></td>
                                    <td></td>
                                </tr>
                                
                                <tr>
                                    <td align="right"></td>
                                    <td></td>
                                    <td align="right">Grand Total: </td>
                                    <td><input type="number" step="any" readonly name="grandtotal" id="grandtotal" value="<?php if(isset($editdata)){ echo $editdata->rb_grandtotal; }else{ echo price_roundof($pretotalamount); } ?>" class="w-100 inputfieldcss"></td>
                                    
                                </tr>
                               

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td align="right">Page Size</td>
                                    <td>
                                        <select class="w-100 inputfieldcss" name="pagesize" id="pagesize">
                                            <option <?php if($defaultpagesize==1){ echo "selected"; } ?> value="1">A4</option>
                                            <option <?php if($defaultpagesize==2){ echo "selected"; } ?> value="2">A5</option>
                                            <option <?php if($defaultpagesize==3){ echo "selected"; } ?> value="3">Thermal</option>
                                        </select>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td align="right">Delivery Note</td>
                                    <td colspan="3">
                                        <textarea name="salenote" id="salenote" class=""><?php if(isset($editdata)){ echo $editdata->rb_notes; } ?></textarea>
                                    </td>
                                </tr>
                            </table>


                            <div class="row text-right mt-3">
                                <div class="col-md-12" align="right">
                                    <button type="submit" class="btn btn-primary mr-2 addfacilitySubmit listbtns"
                                        id="addfacilitySubmit" onclick="return validatedashboard()">Submit</button>
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

    function validatedashboard()
    {
        var prdctadd = 0;
        $('input[name^="productid"]').each(function() {
            if($(this).val() != "")
            {
                prdctadd = 1;
            }
        });
        if(prdctadd == 0)
        {
            alert('Please enter atleast one item..');
            return false;
        }else{
            <?php 
            if($type == 0 || $type== 1)
            {
                ?>
                var prdnegativestock = 0;
                $('input[name^="balancestockval"]').each(function() {
                    if($(this).val() < 0)
                    {
                        prdnegativestock = 1;
                    }
                });
                if(prdnegativestock == 1)
                {
                    alert('Not enough stock, please check quantity..');
                    return false;
                }else{
                    if(confirm('Are you sure?'))
                    {
                        return true;
                    }else{
                        return false;
                    }
                }
                <?php
            }else{
            ?>
            if(confirm('Are you sure?'))
            {
                return true;
            }else{
                return false;
            }
            <?php 
            }
            ?>
        }
    }
    var chech = document.getElementById('customercheck');
    chech.onchange=function()
    {
        if(this.checked)
        {
            $("#paidamount").prop("readonly", false);
            $('#suppliertextbox').val("");
            $("#suppliertextbox").prop('required',true);
            $('#customerid').val(0);
            $('#walkincustdiv').hide();
            $('#existcustdiv').show();
        }
        else
        {
            $("#suppliertextbox").prop('required',false);
            var paidamount = $('#paidamount').val();
            var balanceamnt = $('#balanceamnt').val();
            var oldbalance = $('#oldbalance').val();

            $("#paidamount").prop("readonly", true);

            var newpaidamnt = parseFloat(paidamount) - parseFloat(oldbalance)

            $('#oldbalance').val(0);
            $('#shippingaddress').val("");
            $('#paidamount').val(newpaidamnt);

            $('#walkincustdiv').show();
            $('#existcustdiv').hide();
        }
    }

    function tofixed_amount(amnt)
    {
        var decml = <?= $this->decimalpoints ?>;
        return amnt.toFixed(decml);
    }

    function searchproductcodefun(val, no, entr=0)
    {
        $('.tabledropdowndivstyle').hide();
        if(val == "")
        {
            document.getElementById('resultproductcode'+no).style.display='none';
        }
        else{
            var godownid = $('#godownid').val();
            $.ajax({
                url : "<?= base_url() ?>sale/searchproductcode",
                type: "POST",
                data : {key : val, no: no, type:<?= $type ?>, godownid: godownid},
                success: function(data, textStatus, jqXHR)
                {
                    $('#productcodeserchreslt'+no).html(data);
                    if(entr == 1)
                    {
                        $('.searchdropdown').focus();
                    }
                    
                },
            });
            document.getElementById('resultproductcode'+no).style.display='inline';
        }
    }
    function searchproductnamefun(val, no)
    {
        $('.tabledropdowndivstyle').hide();
        if(val == "")
        {
            document.getElementById('resultproduct'+no).style.display='none';
        }
        else{
            var godownid = $('#godownid').val();
            $.ajax({
                url : "<?= base_url() ?>sale/searchproductname",
                type: "POST",
                data : {key : val, no: no, type:<?= $type ?>, godownid: godownid},
                success: function(data, textStatus, jqXHR)
                {
                    $('#productserchreslt'+no).html(data);
                },
            });
            document.getElementById('resultproduct'+no).style.display='inline';
        }
    }
    function selectproductdet(prdid, stockid, no)
    {
        var exists = 0;
        $('input[name^="stockid"]').each(function() {
            if($(this).val() == stockid)
            {
                exists = 1;
            }
        });
        if(exists == 1)
        {
            alert('Product batch already selected.');
        }
        else{

            $('.tabledropdowndivstyle').hide();
            $.ajax({
                url : "<?= base_url() ?>sale/getproductdetails",
                type: 'POST',
                dataType: 'JSON',
                data : {prodid : prdid, stockid: stockid},
            })
            .done(function(result) {
                  $('#productid'+no).val(result.pd_productid);
                  $('#stockid'+no).val(stockid);
                  $("#productcode"+no).val(result.pd_productcode);
                  $("#productname"+no).val(result.pd_productname + ' ' + result.pd_size+ ' ' + result.pd_brand);

                  $('#batchno'+no).val(result.pt_batchno);
                  $('#expirydate'+no).val(result.pt_expirydate);

                  $("#gst"+no).val(result.tb_tax);
                 
                  if(result.pd_profittype == 1)
                  {
                    <?php 
                    if($type == 1 || $type == 4 || $type == 5)
                    {
                        ?>
                    var retamntval = (parseFloat(result.pt_purchaseprice) * parseFloat(result.pd_wholesaleprofit)/100);
                    var retailpriceval = parseFloat(result.pt_purchaseprice) + parseFloat(retamntval);
                    <?php 
                    }else{
                    ?>
                    var retamntval = (parseFloat(result.pt_purchaseprice) * parseFloat(result.pd_retailprofit)/100);
                    var retailpriceval = parseFloat(result.pt_purchaseprice) + parseFloat(retamntval);
                    <?php 
                    }
                    ?>
                  }
                  else if(result.pd_profittype == 2)
                  {
                    <?php 
                    if($type == 1 || $type == 4 || $type == 5)
                    {
                        ?>
                        var retailpriceval = parseFloat(result.pt_purchaseprice) + parseFloat(result.pd_wholesaleprofit);
                        <?php
                    }else{
                    ?>
                    var retailpriceval = parseFloat(result.pt_purchaseprice) + parseFloat(result.pd_retailprofit);
                    <?php 
                    }
                    ?>
                  }else{
                    if(result.pt_mrp != "" && result.pt_mrp != null)
                    {
                        var retailpriceval = parseFloat(result.pt_mrp);
                    }else{
                        var retailpriceval = parseFloat(result.pd_mrp);
                    }
                  }

                  if(result.pd_profittype == 3)
                  {
                      var retailitemprice = retailpriceval;
                      var gstmult = 100 + parseFloat(result.tb_tax);
                      var retailpriceval = parseFloat(retailitemprice) * 100/parseFloat(gstmult);
                      var retailgst = parseFloat(retailitemprice) - parseFloat(retailpriceval);

                  }else{
                      var retailgst = (parseFloat(retailpriceval) * parseFloat(result.tb_tax)/100);
                      var retailitemprice = parseFloat(retailpriceval) + parseFloat(retailgst);
                  }

                  var gstamnt = (parseFloat(result.pt_purchaseprice) * parseFloat(result.tb_tax)/100);
                  var purchaseval = parseFloat(result.pt_purchaseprice) + parseFloat(gstamnt);

                  $("#purchaseprice"+no).val(tofixed_amount(purchaseval));

                  if(result.pt_mrp != "" && result.pt_mrp != null && result.pt_mrp != 0)
                  {
                    var mrpitemprice = result.pt_mrp;
                    $("#mrp"+no).val(result.pt_mrp);
                  }else{
                    var mrpitemprice = result.pd_mrp;
                    $("#mrp"+no).val(result.pd_mrp);
                  }

                  $("#unitprice"+no).val(tofixed_amount(retailitemprice));
                  
                  $("#qty"+no).val('1');
                  
                  $("#totalamt"+no).html(mrpitemprice);
                  $("#itemtotalamt"+no).val(mrpitemprice);
                 
                 /* var prddet = 'Category: <b>' + result.pc_categoryname + '</b>, HSN: <b>' + result.pd_hsnno + '</b>, Batch: <b>' + result.pt_batchno + '</b>, Expiry: <b>' + result.pt_expirydate + '</b>';

                  $('#productitemdetailsdiv'+no).html(prddet);*/
                  
                 
                  //$("#qty"+no).focus();

                  calculatetotalamnt();
                  addmoreitem();
            })
            .fail(function() {
              console.log("error");
            })
            .always(function() {
              console.log("complete");
            });
        }
    }
    
    
    function calculateitemprice(no)
    {
        var mrp = $('#mrp'+no).val();
        var qty = $('#qty'+no).val();

       
         if(parseInt(qty)<1){
            $("#qty"+no).val(1);
            alert('Invalid qty.');
        }else{
            var totalitemamount = parseFloat(mrp) * parseFloat(qty);

            
            $('#itemtotalamt'+no).val(tofixed_amount(totalitemamount));
            $('#totalamt'+no).html(tofixed_amount(totalitemamount));

            calculatetotalamnt();
        }
    }
    function calculatetotalamnt()
    {
        var totamount = 0;
        var totgstamnt = 0;
        var totprofit = 0;
        var totdiscountval = 0;

        $('input[name^="itemtotalamt"]').each(function() {
            if($(this).val() != "")
            {
                totamount = parseFloat(totamount) + parseFloat($(this).val());
            }
        });

       
        var freight = $('#freight').val();

        var grandtotal = parseFloat(freight) + parseFloat(totamount);
        var totgrandtotal = tofixed_amount(parseFloat(grandtotal));

        
        $('#totalamount').val(tofixed_amount(totamount));
        $('#grandtotal').val(tofixed_amount(parseFloat(totgrandtotal)));
    }

    
   
    function searchcustomerfun(val)
    {
        
        if(val == "")
        {
            document.getElementById('resultsressearch').style.display='none';
        }
        else{
            $.ajax({
                url : "<?= base_url() ?>sale/searchcustomer",
                type: "POST",
                data : {key : val},
                success: function(data, textStatus, jqXHR)
                {
                    $('#serchreslt').html(data);
                },
            });
            document.getElementById('resultsressearch').style.display='inline';
        }
    }
    function selectcustomerdet(spid)
    {
        $.ajax({
            url : "<?= base_url() ?>sale/getcustomerdetails",
            type: 'POST',
            dataType: 'JSON',
            data : {supid : spid},
        })
        .done(function(result) {
              $('#customerid').val(result.ct_cstomerid);
              $("#suppliertextbox").val(result.ct_name);
              $("#oldbalance").val(result.ct_balanceamount);

              $("#shippingaddress").val(result.ct_address);
              $("#stateid").val(result.ct_state);
              //$('#stateid').selectpicker();

              var paidamount = parseFloat($('#grandtotal').val()) + parseFloat(result.ct_balanceamount);
              $('#paidamount').val(paidamount);
              $('#balanceamnt').val(0);
              document.getElementById('resultsressearch').style.display='none';

              $('#stateid').select2();
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    }

    var sln = <?= $itno ?>;
    var itemno = <?= $itno ?>;
    

    function addmoreitem()
    {
        $('#itemlistbody').append(`<tr id="prdrow`+itemno+`">
                                            <td><span id="slno`+sln+`">`+sln+`</span></td>
                                            <td>
                                                <input type="hidden" name="productid[]" id="productid`+itemno+`">
                                                <input type="hidden" name="stockid[]" id="stockid`+itemno+`">
                                                <input type="hidden" name="batchno[]" id="batchno`+itemno+`">
                                                <input type="hidden" name="expirydate[]" id="expirydate`+itemno+`">
                                                <input type="text" name="productcode[]" id="productcode`+itemno+`" onkeyup="searchproductcodefun(this.value, '`+itemno+`')" class="productcodes" autocomplete="off" title="`+itemno+`" style="width: 100px;"><br/>
                                                <div id="resultproductcode`+itemno+`" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productcodeserchreslt`+itemno+`"></div></div>

                                                <div id="productitemdetailsdiv`+itemno+`" class="productitemdetailsdivstyle"></div>
                                            </td>
                                            <td>
                                                <input type="text" name="productname[]" id="productname`+itemno+`" onkeyup="searchproductnamefun(this.value, '`+itemno+`')" autocomplete="off"><br/>
                                                <div id="resultproduct`+itemno+`" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productserchreslt`+itemno+`"></div></div>
                                            </td>
                                            <?php 
                                            /*if($inventorysettings)
                                            {
                                                if($inventorysettings->is_batchwise == 1)
                                                {
                                            ?>
                                            <td><input type="text" name="batchno[]" id="batchno1" style="width: 60px;"></td>
                                            <?php   
                                                }
                                                if($inventorysettings->is_expirydate == 1)
                                                {
                                            ?>
                                            <td><input type="date" name="expirydate[]" id="expirydate1" style="width: 100px;"></td>
                                            <?php 
                                                }
                                            }*/
                                            
                                            
                                            ?>
                                            <td><input type="number" step="any" name="mrp[]" id="mrp`+itemno+`" style="width: 60px;" onchange="calculateitemprice('`+itemno+`')" onkeyup="calculateitemprice('`+itemno+`')"></td>
                                            <td>
                                                <input type="number" name="qty[]" id="qty`+itemno+`" onchange="calculateitemprice('`+itemno+`')" onkeyup="calculateitemprice('`+itemno+`')" style="width: 50px;"><span id="itemunitval`+itemno+`"></span>
                                                <br/><br/>
                                                
                                            </td>
                                            
                                            
                                            <td>
                                                <input type="hidden" name="itemnetamt[]" id="itemnetamt`+itemno+`">
                                                <input type="hidden" name="itemgstamt[]" id="itemgstamt`+itemno+`">
                                                <input type="hidden" name="itemcessamt[]" id="itemcessamt`+itemno+`">
                                                <input type="hidden" name="itemdiscountamt[]" id="itemdiscountamt`+itemno+`">
                                                <input type="hidden" name="itemtotalamt[]" id="itemtotalamt`+itemno+`">
                                                <input type="hidden" name="itemtotalprofit[]" id="itemtotalprofit`+itemno+`">
                                                Total: <b><span id="totalamt`+itemno+`"></span></b>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" onclick="removeitemrow('`+itemno+`')" title="Delete Row"><i class="fa fa-times-circle"></i></a>
                                            </td>
                                        </tr>`);

            itemno = itemno+1;
            sln = sln +1;
    }
    function removeitemrow(no)
    {
        $('#prdrow'+no).remove();
        var j=1;
        for(i=1;i<=itemno;i++)
        {
            if($("#slno"+i).length){
                $("#slno"+i).html(j);
                $("#slno"+i).attr("id","slno"+j)
                j++;
            }
            
        } sln = j;
        calculatetotalamnt();
    }



    /*$('#purchaseform').on('keypress', function(e) {
        alert('test');
    var keyCode = e.keyCode;
      if (keyCode === 13) {
        e.preventDefault();
        console.log("You pressed Enter..!!");
       }
    });*/
    
</script>