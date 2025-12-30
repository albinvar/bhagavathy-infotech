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
                            
                            <a href="<?= base_url() ?>sale/dashboard/<?= $type ?>" target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> New Bill</button>
                            </a>

                            <a href="<?= base_url() ?>business/addcustomer" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Customer</button>
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
                            <form action="<?= base_url() ?>sale/addingsale" method="POST" name="purchaseform" id="purchaseform">
                                <input type="hidden" name="type" value="<?= $type ?>">
                                <input type="hidden" name="pretype" value="<?= $pretype ?>">
                                <input type="hidden" name="billid" value="<?= $billid ?>">

                                <input type="hidden" name="orderid" value="<?= $orderid ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="billprefix" value="<?php  echo $billprefix; ?>">
                                    Bill No: <b><?php  echo $billprefix; ?></b><input type="text" name="billno" readonly value="<?php if(isset($editdata)){ if($pretype!=0){ echo $billno; }else{ echo $editdata->rb_billno;} }else{ echo $billno; } ?>" class="inputfieldcss" style="width: 100px;">

                                    <?php 
                                    if($pretype != 0)
                                    {
                                        ?>
                                        Order No: <b><?php if(isset($editdata)){ echo $editdata->rb_billprefix . "" . $editdata->rb_billno; } ?></b>, &nbsp;
                                        Date: <b><?php if(isset($editdata)){ echo date('d-m-Y', strtotime($editdata->rb_date)); } ?> <?php if(isset($editdata)){ echo date('H:i', strtotime($editdata->rb_time)); } ?></b>
                                        <?php
                                    }
                                    ?>
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
                                
                                <?php 
                                if($hidevehiclenumber == 0)
                                {
                                ?>
                                <div class="col-md-3 mt-2">
                                    <label>Vehicle Number</label>
                                    <input type="text" name="vehicleno" placeholder="Vehicle Number" value="<?php if(isset($editdata)){ echo $editdata->rb_vehicleno; } ?>" class="w-100 inputfieldcss">
                                </div>
                                <?php 
                                }
                                ?>
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
                                <?php 
                                $isgodown=0;
                                if($inventorysettings)
                                {
                                    if($inventorysettings->is_godown == 1)
                                    {
                                        $isgodown=1;
                                ?>
                                <div class="col-md-3 mt-2">
                                    <label>Godown</label>
                                    <select name="godownid" id="godownid" class="w-100 inputfieldcss">
                                        <option value="">Select Godown</option>
                                        <?php 
                                        if($godowns)
                                        {
                                            foreach($godowns as $gdvl)
                                            {
                                                ?>
                                                <option <?php if(isset($editdata)){ if($editdata->rb_godownid==$gdvl->gd_godownid){ echo "selected"; } }else if($this->godownid == $gdvl->gd_godownid){ echo "selected"; } ?> value="<?= $gdvl->gd_godownid ?>"><?= $gdvl->gd_godownname ?> (<?= $gdvl->gd_godowncode ?>)</option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php 
                                    }
                                }
                                if($isgodown == 0)
                                {
                                    ?>
                                    <input type="hidden" name="godownid" id="godownid" value="">
                                    <?php
                                }
                                ?>

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
                                <?php 
                                if($hideewaybillno == 0)
                                {
                                ?>
                                <div class="col-md-3 mt-2">
                                    <label>E way Bill No</label>
                                    <input type="text" name="ewaybillno" id="ewaybillno" placeholder="E way Bill Number" value="<?php if(isset($editdata)){ echo $editdata->rb_ewaybillno; } ?>" class="w-100 inputfieldcss">
                                </div>
                                <?php 
                                }

                                if($hidedeliverydate == 0)
                                {
                                ?>
                                <div class="col-md-3 mt-2">
                                    <label>Delivery Date</label>
                                    <input type="date" name="deliverydate" id="deliverydate"  value="<?php if(isset($editdata)){ echo $editdata->rb_deliverydate; }else{ echo date('Y-m-d'); } ?>" class="w-100 inputfieldcss">
                                </div>
                                <?php 
                                }
                                
                                if($hidepodetails == 0)
                                {
                                ?>
                                <div class="col-md-3 mt-2">
                                    <label>PO Number</label>
                                    <input type="text" name="ponumber" id="ponumber" placeholder="PO Number" value="<?php if(isset($editdata)){ echo $editdata->rb_ponumber; } ?>" class="w-100 inputfieldcss">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label>PO Date</label>
                                    <input type="date" name="podate" id="podate" value="<?php if(isset($editdata)){ echo $editdata->rb_podate; }else{ echo date('Y-m-d'); } ?>" class="w-100 inputfieldcss">
                                </div>
                                <?php 
                                }
                                ?>

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
                                            if($remarkfield == 1)
                                            {
                                                ?>
                                                <th>Remarks</th>
                                                <?php
                                            }
                                            if($showpurchaserate == 0)
                                            {
                                            ?>
                                            <th>Purchase Price</th>
                                            <?php 
                                            }
                                            ?>
                                            <th>MRP</th>
                                            <th>Unit Price</th>
                                            <th><?= $this->isvatgstname ?>%</th>
                                            <th>CESS%</th>
                                            <th width="100px">Discount</th>
                                            <th>Net Rate</th>
                                            <th>Qty</th>
                                            <th width="120px">Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemlistbody">
                                        <?php 
                                        $itno = 1;
                                        if(isset($editdata))
                                        {
                                            if($edititems)
                                            {
                                                foreach($edititems as $editvl)
                                                {
                                                    ?>

                                        <tr id="prdrow<?= $itno ?>">
                                            <td><span id="slno<?= $itno ?>"><?= $itno ?></span></td>
                                            <td>
                                                <input type="hidden" name="productid[]" value="<?= $editvl->rbs_productid ?>" id="productid<?= $itno ?>">
                                                <input type="hidden" name="stockid[]" value="<?= $editvl->rbs_stockid ?>" id="stockid<?= $itno ?>">
                                                <input type="hidden" name="batchno[]" value="<?= $editvl->rbs_batchno ?>" id="batchno<?= $itno ?>">
                                                <input type="hidden" name="expirydate[]" value="<?= $editvl->rbs_expirydate ?>" id="expirydate<?= $itno ?>">
                                                <input type="text" name="productcode[]" id="productcode<?= $itno ?>" onkeyup="searchproductcodefun(this.value, '<?= $itno ?>')" class="productcodes" value="<?= $editvl->pd_productcode ?>" title="<?= $itno ?>" autocomplete="off" style="width: 50px;"><br/>
                                                <div id="resultproductcode<?= $itno ?>" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productcodeserchreslt<?= $itno ?>"></div></div>

                                                <div id="productitemdetailsdiv<?= $itno ?>" class="productitemdetailsdivstyle"></div>
                                            </td>
                                            <td>
                                                <input type="text" name="productname[]" id="productname<?= $itno ?>" onkeyup="searchproductnamefun(this.value, '<?= $itno ?>')" value="<?= $editvl->pd_productname ?>" autocomplete="off"><br/>
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
                                            if($remarkfield == 1)
                                            {
                                                ?>
                                                <td><input type="text" name="remarks[]" id="remarks<?= $itno ?>" value="<?= $editvl->rbs_remarks ?>" ></td>
                                                <?php
                                            }
                                            if($showpurchaserate == 0)
                                            {
                                            ?>
                                            <td><input type="text" readonly step="any" name="purchaseprice[]" value="<?= $editvl->rbs_purchaseprice ?>" id="purchaseprice<?= $itno ?>" style="width: 60px;"></td>
                                            <?php 
                                            }else{
                                                ?>
                                                <input type="hidden" name="purchaseprice[]" value="<?= $editvl->rbs_purchaseprice ?>" id="purchaseprice<?= $itno ?>" >
                                                <?php
                                            }
                                            ?>
                                            
                                            <td><input type="text" readonly step="any" name="mrp[]" value="<?= $editvl->rbs_mrp ?>" id="mrp<?= $itno ?>" style="width: 60px;"></td>

                                            <td><input type="number" step="any" name="unitprice[]" value="<?= $editvl->rbs_unitprice ?>" id="unitprice<?= $itno ?>" onchange="calculateunitnetprice('<?= $itno ?>')" onkeyup="calculateunitnetprice('<?= $itno ?>')" style="width: 70px;">
                                                
                                            </td>

                                            <td><input type="text" readonly step="any" name="gst[]" value="<?= $editvl->rbs_gstpercent ?>" id="gst<?= $itno ?>"  style="width: 45px;"><br/>
                                                <input type="hidden" name="itemgstval[]" value="<?= $editvl->rbs_gstamnt ?>" id="itemgstval<?= $itno ?>">
                                                <span style="font-size: 10px;">Amt:</span> <span style="font-size: 11px;" id="itemgstvalue<?= $itno ?>"><?= $editvl->rbs_gstamnt ?></span>
                                            </td>
                                             <td><input type="number" step="any" name="cess[]" value="<?= $editvl->rbs_cesspercent ?>" id="cess<?= $itno ?>" onchange="calculateitemprice('<?= $itno ?>')" onkeyup="calculateitemprice('<?= $itno ?>')" style="width: 45px;"><br/>
                                                <input type="hidden" name="itemcessval[]" value="<?= $editvl->rbs_cessamount ?>" id="itemcessval<?= $itno ?>">
                                                <span style="font-size: 10px;">Amt:</span> <span style="font-size: 11px;" id="itemcessvalue<?= $itno ?>"><?= $editvl->rbs_cessamount ?></span>
                                            </td>
                                            <td>
                                                <input type="number" step="any" name="discountper[]" id="discountper<?= $itno ?>" onchange="calculatediscount('<?= $itno ?>', '1')" value="<?= $editvl->rbs_discountpercent ?>" onkeyup="calculatediscount('<?= $itno ?>', '1')" style="width: 50px;">%<br/>
                                                <input type="number" step="any" name="discountamnt[]" value="<?= $editvl->rbs_discountamnt ?>" id="discountamnt<?= $itno ?>" onchange="calculatediscount('<?= $itno ?>', '2')" onkeyup="calculatediscount('<?= $itno ?>', '2')" style="width: 50px;">Amt
                                            </td>
                                            <td><input type="text" readonly step="any" name="netprice[]" value="<?= $editvl->rbs_netamount ?>" id="netprice<?= $itno ?>" style="width: 60px;">

                                                <input type="hidden" name="itemnetprice[]" value="<?= $editvl->rbs_itemunitprice ?>" id="itemnetprice<?= $itno ?>">
                                                <input type="hidden" value="<?= $editvl->rbs_discountedprice ?>" name="discountedprice[]" id="discountedprice<?= $itno ?>">
                                            </td>
                                            <td>
                                                <input type="number" name="qty[]" id="qty<?= $itno ?>" value="<?= $editvl->rbs_qty ?>" onchange="calculateitemprice('<?= $itno ?>')" onkeyup="calculateitemprice('<?= $itno ?>')" style="width: 50px;"><span id="itemunitval<?= $itno ?>"></span>
                                                <br/>
                                                <input type="hidden" name="availablestck[]" value="<?php if(($type==0||$type==1||$type==7||$type==8)&&$pretype==0){ echo $editvl->pt_stock + $editvl->rbs_qty;}else{ echo $editvl->pt_stock; } ?>" id="availablestck<?= $itno ?>">
                                                <span style="font-size: 11px; color: #F00;">Stock: <span id="availstock<?= $itno ?>"><?php if(($type==0||$type==1||$type==7||$type==8)&&$pretype==0){ echo $editvl->pt_stock + $editvl->rbs_qty;}else{ echo $editvl->pt_stock; } ?></span></span><br/>

                                                <input type="hidden" name="balancestockval[]" value="<?php if(($type==0||$type==1||$type==7||$type==8)&&$pretype==0){ echo $editvl->pt_stock;}else{ echo $editvl->pt_stock-$editvl->rbs_qty; } ?>" id="balancestockval<?= $itno ?>">

                                                <span style="font-size: 11px; color: #F00;">Blnce: <span id="balancestock<?= $itno ?>"><?php if(($type==0||$type==1||$type==7||$type==8)&&$pretype==0){ echo $editvl->pt_stock;}else{ echo $editvl->pt_stock-$editvl->rbs_qty; } ?></span></span>
                                            </td>
                                            
                                            
                                            <td>
                                                <input type="hidden" name="itemnetamt[]" value="<?= $editvl->rbs_nettotal ?>" id="itemnetamt<?= $itno ?>">
                                                <input type="hidden" name="itemgstamt[]" value="<?= $editvl->rbs_totalgst ?>" id="itemgstamt<?= $itno ?>">
                                                <input type="hidden" name="itemcessamt[]" value="<?= $editvl->rbs_totalcess ?>" id="itemcessamt<?= $itno ?>">
                                                <input type="hidden" name="itemdiscountamt[]" value="<?= $editvl->rbs_totaldiscount ?>" id="itemdiscountamt<?= $itno ?>">
                                                <input type="hidden" name="itemtotalamt[]" value="<?= $editvl->rbs_totalamount ?>" id="itemtotalamt<?= $itno ?>">

                                                <input type="hidden" name="itemtotalprofit[]" value="<?= $editvl->rbs_profit ?>" id="itemtotalprofit<?= $itno ?>">

                                                Net: <b><span id="netamt<?= $itno ?>"><?= $editvl->rbs_nettotal ?></span></b><br/>
                                                <?= $this->isvatgstname ?>: <b><span id="gstamt<?= $itno ?>"><?= $editvl->rbs_totalgst ?></span></b><br/>
                                                CESS: <b><span id="cessamt<?= $itno ?>"><?= $editvl->rbs_totalcess ?></span></b><br/>
                                                Discount: <b><span id="discountamt<?= $itno ?>"><?= $editvl->rbs_totaldiscount ?></span></b><br/>
                                                Total: <b><span id="totalamt<?= $itno ?>"><?= $editvl->rbs_totalamount ?></span></b>
                                            </td>
                                            <td>
                                                <?php 
                                                if($pretype != 2 && $pretype != 4)
                                                {
                                                    ?>
                                                <a href="javascript:void(0)" onclick="removeitemrow('<?= $itno ?>')" title="Delete Row"><i class="fa fa-times-circle"></i></a>
                                                <?php 
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php 
                                        $itno++;
                                        }
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
                                                <input type="text" name="productcode[]" id="productcode1" onkeyup="searchproductcodefun(this.value, '1')" title="1" class="productcodes" autocomplete="off" style="width: 50px;"><br/>
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
                                            if($remarkfield == 1)
                                            {
                                                ?>
                                                <td><input type="text" name="remarks[]" id="remarks1" ></td>
                                                <?php
                                            }
                                            if($showpurchaserate == 0)
                                            {
                                            ?>
                                            <td><input type="text" readonly step="any" name="purchaseprice[]" id="purchaseprice1" style="width: 60px;"></td>
                                            <?php 
                                            }else{
                                                ?>
                                                <input type="hidden" name="purchaseprice[]" id="purchaseprice1">
                                                <?php
                                            }
                                            ?>
                                            
                                            <td><input type="text" readonly step="any" name="mrp[]" id="mrp1" style="width: 60px;"></td>

                                            <td><input type="number" step="any" name="unitprice[]" id="unitprice1" onchange="calculateunitnetprice('1')" onkeyup="calculateunitnetprice('1')" style="width: 70px;">

                                                
                                            </td>

                                            <td><input type="text" readonly step="any" name="gst[]" id="gst1"  style="width: 45px;"><br/>
                                                <input type="hidden" name="itemgstval[]" id="itemgstval1">
                                                <span style="font-size: 10px;">Amt:</span> <span style="font-size: 11px;" id="itemgstvalue1">0</span>
                                            </td>
                                             <td><input type="number" step="any" value="0" name="cess[]" id="cess1" onchange="calculateitemprice('1')" onkeyup="calculateitemprice('1')" style="width: 45px;"><br/>
                                                <input type="hidden" name="itemcessval[]" id="itemcessval1" value="0">
                                                <span style="font-size: 10px;">Amt:</span> <span style="font-size: 11px;" id="itemcessvalue1">0</span>
                                            </td>
                                            <td>
                                                <input type="number" step="any" name="discountper[]" id="discountper1" onchange="calculatediscount('1', '1')" onkeyup="calculatediscount('1', '1')" style="width: 50px;" value="0">%<br/>
                                                <input type="number" step="any" name="discountamnt[]" id="discountamnt1" onchange="calculatediscount('1', '2')" onkeyup="calculatediscount('1', '2')" style="width: 50px;" value="0">Amt
                                            </td>
                                            <td><input type="text" readonly step="any" name="netprice[]" id="netprice1" style="width: 60px;">

                                                <input type="hidden" name="itemnetprice[]" id="itemnetprice1">
                                                <input type="hidden" name="discountedprice[]" id="discountedprice1">
                                            </td>
                                            <td>
                                                <input type="number" name="qty[]" id="qty1" onchange="calculateitemprice('1')" onkeyup="calculateitemprice('1')" style="width: 50px;"><span id="itemunitval1"></span>
                                                <br/>
                                                <input type="hidden" name="availablestck[]" id="availablestck1">
                                                <span style="font-size: 11px; color: #F00;">Stock: <span id="availstock1"></span></span><br/>

                                                <input type="hidden" name="balancestockval[]" id="balancestockval1">
                                                <span style="font-size: 11px; color: #F00;">Blnce: <span id="balancestock1"></span></span>
                                            </td>
                                            
                                            
                                            <td>
                                                <input type="hidden" name="itemnetamt[]" id="itemnetamt1">
                                                <input type="hidden" name="itemgstamt[]" id="itemgstamt1">
                                                <input type="hidden" name="itemcessamt[]" id="itemcessamt1">
                                                <input type="hidden" name="itemdiscountamt[]" id="itemdiscountamt1">
                                                <input type="hidden" name="itemtotalamt[]" id="itemtotalamt1">

                                                <input type="hidden" name="itemtotalprofit[]" id="itemtotalprofit1">

                                                Net: <b><span id="netamt1"></span></b><br/>
                                                <?= $this->isvatgstname ?>: <b><span id="gstamt1"></span></b><br/>
                                                CESS: <b><span id="cessamt1"></span></b><br/>
                                                Discount: <b><span id="discountamt1"></span></b><br/>
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
                            if($pretype != 2 && $pretype != 4)
                            {
                                ?>
                            <div align="right">
                                <a href="javascript:void(0)" onclick="addmoreitem()">Add more +</a>
                            </div>
                            <?php 
                            }
                            ?>

                            <input type="hidden" name="totalgstamount" id="totalgstamount" value="<?php if(isset($editdata)){ echo $editdata->rb_totalgstamnt; }else{ echo 0; } ?>">

                            <input type="hidden" name="totalprofitamnt" id="totalprofitamnt" value="<?php if(isset($editdata)){ echo $editdata->rb_totprofit; }else{ echo 0; } ?>">

                            <table class="w-100 footrtable" cellspacing="5">
                                <tr>
                                    <td align="right" width="20%"></td>
                                    <td></td>
                                    <td align="right" width="20%">Discount: </td>
                                    <td><input type="number" readonly="readonly" step="any" onchange="calculatetotalamnt()" onkeyup="calculatetotalamnt()" name="totaldiscount" id="totaldiscount" value="<?php if(isset($editdata)){ echo $editdata->rb_discount; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                    <td align="right">Freight: </td>
                                    <td width="150px"><input type="number" step="any" required="required" onchange="calculatetotalamnt()" onkeyup="calculatetotalamnt()" name="freight" id="freight" value="<?php if(isset($editdata)){ echo $editdata->rb_freight; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                    <td align="right"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td align="right"></td>
                                    <td></td>
                                    <td align="right">Total Amount: </td>
                                    <td><input type="number" step="any" readonly name="totalamount" id="totalamount" value="<?php if(isset($editdata)){ echo $editdata->rb_totalamount; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                    <td align="right"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td align="right"></td>
                                    <td></td>
                                    <td align="right">Round Off: </td>
                                    <td>
                                        
                                        <input type="number" step="any" readonly name="roundoffvalue" id="roundoffvalue" value="<?php if(isset($editdata)){ echo $editdata->rb_roundoffvalue; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>

                                    <td align="right">Old Balance: </td>
                                    <?php 
                                    if(isset($editdata)){
                                        if($pretype != 0)
                                        {
                                            $custbalanceamount = $editdata->ct_balanceamount;

                                            $newblnce =  $custbalanceamount - $editdata->rb_oldbalance;
                                            $totbalanceaamount = $editdata->rb_balanceamount - $custbalanceamount;
                                        }else{
                                            if($type == 0 || $type == 1 || $type == 7 || $type == 8)
                                            {
                                                $custbalanceamount = $editdata->rb_oldbalance;
                                                $totbalanceaamount = $editdata->rb_balanceamount;
                                            }
                                            else{
                                                $custbalanceamount = $editdata->ct_balanceamount;

                                                $newblnce =  $custbalanceamount - $editdata->rb_oldbalance;
                                                $totbalanceaamount = $editdata->rb_balanceamount - $custbalanceamount;
                                            }
                                        }
                                        $oldblnce = $editdata->ct_balanceamount;
                                        $newbalance = $editdata->ct_balanceamount;
                                    }
                                    ?>
                                    <td><input type="number" step="any" readonly name="oldbalance" id="oldbalance" value="<?php if(isset($editdata)){ echo $custbalanceamount; }else{ echo $custbalanceamount = 0; } ?>" class="w-100 inputfieldcss"></td>
                                </tr>
                                <tr>
                                    <td align="right"></td>
                                    <td></td>
                                    <td align="right">Grand Total: </td>
                                    <td><input type="number" step="any" readonly name="grandtotal" id="grandtotal" value="<?php if(isset($editdata)){ echo $grndttl = $editdata->rb_grandtotal; }else{ echo $grndttl = 0; } ?>" class="w-100 inputfieldcss"></td>
                                    <td align="right">Paid Amount</td>
                                    <td><input type="number" step="any" <?php if(isset($editdata)){ if($editdata->rb_existcustomer == 0){ ?> readonly <?php } }else{ ?> readonly <?php } ?>  name="paidamount" id="paidamount" onkeyup="calculatepaidamount()" onchange="calculatepaidamount()" value="<?php if(isset($editdata)){ echo $paidamnt = $editdata->rb_paidamount; }else{ echo $paidamnt = 0; } ?>" class="w-100 inputfieldcss">

                                        <input type="hidden" name="previouspaidamnt" value="<?php if(isset($editdata)){ echo $editdata->rb_paidamount; }else{ echo 0; } ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right"></td>
                                    <td></td>
                                    <td align="right">Payment Method: </td>
                                    <td>
                                    <select class="w-100 inputfieldcss" name="paymethod" id="paymethod">
                                        <option <?php if(isset($editdata)){ if($editdata->rb_paymentmethod==4){ echo "selected"; } } ?> value="4">Cash</option>
                                        <option <?php if(isset($editdata)){ if($editdata->rb_paymentmethod==3){ echo "selected"; } } ?> value="3">Bank</option>
                                        <!--<option value="3">UPI</option>-->
                                    </select>
                                    </td>
                                    <td align="right">Balance Amount: </td>
                                    <td>
                                        <?php 
                                        if($paidamnt == 0 && $pretype != 0)
                                        {
                                            if(isset($editdata)){
                                                $totbalanceaamount = ($custbalanceamount + $grndttl)-$paidamnt;
                                            }
                                        }
                                        ?>
                                        <input type="number" step="any" readonly name="balanceamnt" value="<?php if(isset($editdata)){ echo $totbalanceaamount; }else{ echo 0; } ?>" id="balanceamnt" value="0" class="w-100 inputfieldcss">
                                        <input type="hidden" name="previousbalanceamnt" value="<?php if(isset($editdata)){ echo $totbalanceaamount; }else{ echo 0; } ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <?php 
                                    if($type == 6){
                                        ?>
                                        <td></td>
                                        <td></td>
                                        <?php
                                    }else{
                                    ?>
                                    <td align="right">Page Size</td>
                                    <td>
                                        <select class="w-100 inputfieldcss" name="pagesize" id="pagesize">
                                            <option <?php if($defaultpagesize==1){ echo "selected"; } ?> value="1">A4</option>
                                            <option <?php if($defaultpagesize==2){ echo "selected"; } ?> value="2">A5</option>
                                            <option <?php if($defaultpagesize==3){ echo "selected"; } ?> value="3">Thermal</option>
                                        </select>
                                    </td>
                                    <?php 
                                    }
                                    ?>
                                    <td align="right">100% Advance</td>
                                    <td>
                                        <select class="w-100 inputfieldcss" name="fulladvance" id="fulladvance">
                                            <option <?php if(isset($editdata)){ if($editdata->rb_advance100==1){ echo "selected"; } } ?> value="1">Yes</option>
                                            <option <?php if(isset($editdata)){ if($editdata->rb_advance100==0){ echo "selected"; } } ?> value="0">No</option>
                                        </select>
                                    </td>
                                    <td align="right">Bill Type</td>
                                    <td>
                                        <select class="w-100 inputfieldcss" name="billtype" id="billtype">
                                            <option <?php if(isset($editdata)){ if($editdata->rb_billtype==1){ echo "selected"; } } ?> value="1">Tax Invoice</option>
                                            <option <?php if(isset($editdata)){ if($editdata->rb_billtype==2){ echo "selected"; } } ?> value="2">Customer Invoice</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td align="right">
                                        <?php 
                                        if($type == 6){ echo "Order Note"; }else{ echo "Sale Note"; }
                                        ?>
                                    </td>
                                    <td colspan="3">
                                        <textarea name="salenote" id="salenote" class=""><?php if(isset($editdata)){ echo $editdata->rb_notes; } ?></textarea>
                                    </td>
                                </tr>
                            </table>


                            <div class="row text-right mt-3">
                                <div class="col-md-12" align="right">
                                    <button type="button" class="btn btn-primary mr-2 addfacilitySubmit listbtns"
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
            if($type == 0 || $type== 1 || $type == 7 || $type == 8)
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
                        $("#purchaseform").submit();
                        $('#addfacilitySubmit').prop('disabled', true);
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
                $("#purchaseform").submit();
                $('#addfacilitySubmit').prop('disabled', true);
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
                    }else if($type == 7)
                    {
                        ?>
                        var retamntval = (parseFloat(result.pt_purchaseprice) * parseFloat(result.pd_csaleprofit)/100);
                        var retailpriceval = parseFloat(result.pt_purchaseprice) + parseFloat(retamntval);
                        <?php
                    }else if($type == 8)
                    {
                        ?>
                        var retamntval = (parseFloat(result.pt_purchaseprice) * parseFloat(result.pd_dsaleprofit)/100);
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
                    }else if($type == 7)
                    {
                        ?>
                        var retailpriceval = parseFloat(result.pt_purchaseprice) + parseFloat(result.pd_csaleprofit);
                        <?php
                    }else if($type == 8)
                    {
                        ?>
                        var retailpriceval = parseFloat(result.pt_purchaseprice) + parseFloat(result.pd_dsaleprofit);
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
                    $("#mrp"+no).val(result.pt_mrp);
                  }else{
                    $("#mrp"+no).val(result.pd_mrp);
                  }

                  $("#unitprice"+no).val(tofixed_amount(retailitemprice));
                  
                  $("#qty"+no).val('1');
                  $("#discountper"+no).val('0');
                  $("#discountamnt"+no).val('0');

                  $('#itemgstval'+no).val(tofixed_amount(retailgst));
                  $('#itemgstvalue'+no).html(tofixed_amount(retailgst));

                  $('#netprice'+no).val(tofixed_amount(retailpriceval));
                  $('#itemnetprice'+no).val(tofixed_amount(retailpriceval));
                  $("#discountedprice"+no).val(tofixed_amount(retailpriceval));

                  $("#netamt"+no).html(tofixed_amount(retailpriceval));
                  $("#gstamt"+no).html(tofixed_amount(retailgst));
                  $("#totalamt"+no).html(tofixed_amount(retailitemprice));

                  $("#itemnetamt"+no).val(tofixed_amount(retailpriceval));
                  $("#itemgstamt"+no).val(tofixed_amount(retailgst));
                  $("#itemtotalamt"+no).val(tofixed_amount(retailitemprice));

                  var itemprofit = parseFloat(retailitemprice) - parseFloat(purchaseval);
                 
                  $('#itemtotalprofit'+no).val(tofixed_amount(itemprofit));

                  $('#itemunitval'+no).html(result.un_unitname);


                  $('#itemcessamt'+no).val(0);
                  $('#cessamt'+no).html(0);
                  $('#itemdiscountamt'+no).val(0);
                  $('#discountamt'+no).html(0);

                  var prddet = 'Category: <b>' + result.pc_categoryname + '</b>, HSN: <b>' + result.pd_hsnno + '</b>, Batch: <b>' + result.pt_batchno + '</b>, Expiry: <b>' + result.pt_expirydate + '</b>';

                  $('#productitemdetailsdiv'+no).html(prddet);
                  
                  $("#availstock"+no).html(result.pt_stock);
                  $("#availablestck"+no).val(result.pt_stock);

                  var blancestck = parseFloat(result.pt_stock) - 1;
                  $("#balancestock"+no).html(blancestck);
                  $('#balancestockval'+no).val(blancestck);
                                      
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
    function calculateunitnetprice(no)
    {
        var unitprice = $('#unitprice'+no).val();
        var gst = $('#gst'+no).val();
        //var discountamnt = $('#discountamnt'+no).val();

        var gstmult = 100 + parseFloat(gst);
        var retailpriceval = parseFloat(unitprice) * 100/parseFloat(gstmult);
        var retailgst = parseFloat(unitprice) - parseFloat(retailpriceval);

        var discountper = $('#discountper'+no).val();
        var discountamnt = parseFloat(retailpriceval)*parseFloat(discountper)/100;
        $('#discountamnt'+no).val(tofixed_amount(discountamnt));

        var discountedprice = parseFloat(retailpriceval) - parseFloat(discountamnt);
        $('#discountedprice'+no).val(tofixed_amount(discountedprice));

        $('#itemnetprice'+no).val(tofixed_amount(retailpriceval));

        calculateitemprice(no);
    }
    function calculatediscount(no, type)
    {
        var itemnetprice = $('#itemnetprice'+no).val();
        //var itemnetprice = $('#unitprice'+no).val();
        if(type == 1)
        {
            var discountper = $('#discountper'+no).val();
            var discountamnt = parseFloat(itemnetprice)*parseFloat(discountper)/100;
            $('#discountamnt'+no).val(tofixed_amount(discountamnt));
        }else{
            var discountamnt = $('#discountamnt'+no).val();
            var discpercent = parseFloat(discountamnt) * 100/parseFloat(itemnetprice)
            $('#discountper'+no).val(tofixed_amount(discpercent));
        }
        var discountedprice = parseFloat(itemnetprice) - parseFloat(discountamnt);
        $('#discountedprice'+no).val(tofixed_amount(discountedprice));
        calculateitemprice(no);
    }
    function calculateitemprice(no)
    {
        var unitprice = $('#unitprice'+no).val();
        var gst = $('#gst'+no).val();

        
        //var retailgst = parseFloat(retailitemprice) - parseFloat(retailpriceval);

        var netprice = $('#netprice'+no).val();
        var discountedprice = $('#discountedprice'+no).val();
       
        var purchaseprice = $('#purchaseprice'+no).val();

        
        var cess = $('#cess'+no).val();
        var qty = $('#qty'+no).val();
        var discountamnt = $('#discountamnt'+no).val();

        var availstock = $("#availablestck"+no).val();

        <?php 
        if($type == 0 || $type == 1 || $type == 7 || $type == 8)
        {
        ?>
        if(parseInt(qty) > parseInt(availstock))
        {
            $("#qty"+no).val(availstock);
            alert('Not enough stock, Please add stock.');

        }else
        <?php 
        }
        ?>
         if(parseInt(qty)<1){
            $("#qty"+no).val(1);
            alert('Invalid qty.');
        }else{

            var blancestck = parseFloat(availstock) - parseFloat(qty);
            $("#balancestock"+no).html(blancestck);
            $("#balancestockval"+no).val(blancestck);

            var gstmult = 100 + parseFloat(gst);
            var gstamnt = (parseFloat(discountedprice)*parseFloat(gst)/100);

            if(cess != 0)
            {
                var cessmult = 100 + parseFloat(cess);

                var cessamnt = (parseFloat(discountedprice)*parseFloat(cess)/100);

                $('#itemcessval'+no).val(tofixed_amount(cessamnt));
                $('#itemcessvalue'+no).html(tofixed_amount(cessamnt));
                
            }else{
                var cessamnt = 0;
                $('#itemcessval'+no).val(0);
                $('#itemcessvalue'+no).html(0);
            }
            
            
            var netamount = parseFloat(unitprice) - parseFloat(gstamnt) - parseFloat(cessamnt) - parseFloat(discountamnt);
            $('#netprice'+no).val(discountedprice);
            $('#itemgstvalue'+no).html(tofixed_amount(gstamnt));
            $('#itemgstval'+no).val(tofixed_amount(gstamnt));

            totalnetamount = parseFloat(discountedprice) * parseFloat(qty);

            totaltaxamnt = parseFloat(gstamnt) * parseFloat(qty);

            totalcessamnt = parseFloat(cessamnt) * parseFloat(qty);
            
            totaldiscountamnt = parseFloat(discountamnt) * parseFloat(qty);

            totalitemamount = parseFloat(discountedprice) * parseFloat(qty);
            totallastamount = parseFloat(totalitemamount) + parseFloat(totaltaxamnt) + parseFloat(totalcessamnt);

            $('#itemnetamt'+no).val(tofixed_amount(totalnetamount));
            $('#netamt'+no).html(tofixed_amount(totalnetamount));

            $('#itemgstamt'+no).val(tofixed_amount(totaltaxamnt));
            $('#gstamt'+no).html(tofixed_amount(totaltaxamnt));

            $('#itemcessamt'+no).val(tofixed_amount(totalcessamnt));
            $('#cessamt'+no).html(tofixed_amount(totalcessamnt));

            $('#itemdiscountamt'+no).val(tofixed_amount(totaldiscountamnt));
            $('#discountamt'+no).html(tofixed_amount(totaldiscountamnt));

            $('#itemtotalamt'+no).val(tofixed_amount(totallastamount));
            $('#totalamt'+no).html(tofixed_amount(totallastamount));

            var purchaseval = parseFloat(purchaseprice) * parseFloat(qty);

            var itemprofit = parseFloat(totallastamount) - parseFloat(purchaseval);
            $('#itemtotalprofit'+no).val(tofixed_amount(itemprofit));
            
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

        $('input[name^="itemgstamt"]').each(function() {
            if($(this).val() != "")
            {
                totgstamnt = parseFloat(totgstamnt) + parseFloat($(this).val());
            }
        });

        $('input[name^="itemtotalprofit"]').each(function() {
            if($(this).val() != "")
            {
                totprofit = parseFloat(totprofit) + parseFloat($(this).val());
            }
        });

        $('input[name^="itemdiscountamt"]').each(function() {
            if($(this).val() != "")
            {
                totdiscountval = parseFloat(totdiscountval) + parseFloat($(this).val());
            }
        });

        

        $('#totaldiscount').val(tofixed_amount(totdiscountval));
        var freight = $('#freight').val();
        var oldbalance = $('#oldbalance').val();
        //var grandtotal = $('#grandtotal').val();
        //var paidamount = $('#paidamount').val();
        //var balanceamnt = $('#balanceamnt').val();

        var grandtotal = parseFloat(freight) + parseFloat(totamount);
        var totgrandtotal = tofixed_amount(parseFloat(grandtotal));

        var rounddecimal = totgrandtotal - Math.floor(parseFloat(totgrandtotal));
        if(parseFloat(rounddecimal) >= 0.50)
        {
            var rounddecimalvalue = 1-parseFloat(rounddecimal);
            var newgrandtotal = Math.ceil(parseFloat(totgrandtotal));
        }else{
            var rounddecimalvalue = rounddecimal;
            var newgrandtotal = Math.floor(parseFloat(totgrandtotal));
        }

        <?php 
        if($type == 0 || $type == 1 || $type == 7 || $type == 8)
        {
            ?>
        var paidamount = parseFloat(newgrandtotal)+parseFloat(oldbalance);
        var balanceamnt = 0;
        <?php 
        }else{
            ?>
            var paidamount = 0;
            var balanceamnt = parseFloat(newgrandtotal)+parseFloat(oldbalance);
            <?php
        }
        ?>

        //var totalprofitamount = parseFloat(totprofit)-parseFloat(totaldiscount);
        $('#roundoffvalue').val(tofixed_amount(rounddecimalvalue));
        $('#totalgstamount').val(tofixed_amount(totgstamnt));
        $('#totalprofitamnt').val(tofixed_amount(totprofit));
        
        $('#totalamount').val(tofixed_amount(totamount));
        $('#grandtotal').val(tofixed_amount(parseFloat(newgrandtotal)));
        $('#paidamount').val(tofixed_amount(paidamount));
        $('#balanceamnt').val(tofixed_amount(balanceamnt));
    }

    function calculatepaidamount()
    {
        var grandtotal = $('#grandtotal').val();
        var oldbalance = $('#oldbalance').val();
        var paidamount = $('#paidamount').val();

        balanceamnt = parseFloat(grandtotal) + parseFloat(oldbalance) - parseFloat(paidamount);
        $('#balanceamnt').val(tofixed_amount(balanceamnt));
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
                                                <input type="text" name="productcode[]" id="productcode`+itemno+`" onkeyup="searchproductcodefun(this.value, '`+itemno+`')" class="productcodes" autocomplete="off" title="`+itemno+`" style="width: 50px;"><br/>
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
                                            if($remarkfield == 1)
                                            {
                                                ?>
                                                <td><input type="text" name="remarks[]" id="remarks`+itemno+`" ></td>
                                                <?php
                                            }
                                            if($showpurchaserate == 0)
                                            {
                                            ?>
                                            <td><input type="text" readonly step="any" name="purchaseprice[]" id="purchaseprice`+itemno+`" style="width: 60px;"></td>
                                            <?php 
                                            }else{
                                                ?>
                                                <input type="hidden" name="purchaseprice[]" id="purchaseprice`+itemno+`">
                                                <?php
                                            }
                                            ?>
                                            <td><input type="text" readonly step="any" name="mrp[]" id="mrp`+itemno+`" style="width: 60px;"></td>

                                            <td><input type="number" step="any" name="unitprice[]" id="unitprice`+itemno+`" onchange="calculateunitnetprice('`+itemno+`')" onkeyup="calculateunitnetprice('`+itemno+`')" style="width: 70px;">
                                            
                                            </td>

                                            <td><input type="text" readonly step="any" name="gst[]" id="gst`+itemno+`"  style="width: 45px;"><br/>
                                                <input type="hidden" name="itemgstval[]" id="itemgstval`+itemno+`">
                                                <span style="font-size: 10px;">Amt:</span> <span style="font-size: 11px;" id="itemgstvalue`+itemno+`">0</span>
                                            </td>
                                             <td><input type="number" step="any" value="0" name="cess[]" id="cess`+itemno+`" onchange="calculateitemprice('`+itemno+`')" onkeyup="calculateitemprice('`+itemno+`')" style="width: 45px;"><br/>
                                                <input type="hidden" name="itemcessval[]" id="itemcessval`+itemno+`" value="0">
                                                <span style="font-size: 11px;" id="itemcessvalue`+itemno+`">0</span>
                                            </td>
                                            <td>
                                                <input type="number" step="any" name="discountper[]" id="discountper`+itemno+`" onchange="calculatediscount('`+itemno+`', '1')" onkeyup="calculatediscount('`+itemno+`', '1')" style="width: 50px;" value="0">%<br/>
                                                <input type="number" step="any" name="discountamnt[]" id="discountamnt`+itemno+`" onchange="calculatediscount('`+itemno+`', '2')" onkeyup="calculatediscount('`+itemno+`', '2')" style="width: 50px;" value="0">Amt
                                            </td>
                                            <td>
                                            <input type="text" readonly step="any" name="netprice[]" id="netprice`+itemno+`" style="width: 60px;">

                                            <input type="hidden" name="itemnetprice[]" id="itemnetprice`+itemno+`">
                                            <input type="hidden" name="discountedprice[]" id="discountedprice`+itemno+`">
                                            </td>
                                            <td>
                                                <input type="number" name="qty[]" id="qty`+itemno+`" onchange="calculateitemprice('`+itemno+`')" onkeyup="calculateitemprice('`+itemno+`')" style="width: 50px;"><span id="itemunitval`+itemno+`"></span>
                                                <br/>
                                                <input type="hidden" name="availablestck[]" id="availablestck`+itemno+`">
                                                <span style="font-size: 11px; color: #F00;">Stock: <span id="availstock`+itemno+`"></span><br/>
                                                <input type="hidden" name="balancestockval[]" id="balancestockval`+itemno+`">
                                                <span style="font-size: 11px; color: #F00;">Blnce: <span id="balancestock`+itemno+`"></span></span>
                                            </td>
                                            
                                            
                                            <td>
                                                <input type="hidden" name="itemnetamt[]" id="itemnetamt`+itemno+`">
                                                <input type="hidden" name="itemgstamt[]" id="itemgstamt`+itemno+`">
                                                <input type="hidden" name="itemcessamt[]" id="itemcessamt`+itemno+`">
                                                <input type="hidden" name="itemdiscountamt[]" id="itemdiscountamt`+itemno+`">
                                                <input type="hidden" name="itemtotalamt[]" id="itemtotalamt`+itemno+`">
                                                <input type="hidden" name="itemtotalprofit[]" id="itemtotalprofit`+itemno+`">

                                                Net: <b><span id="netamt`+itemno+`"></span></b><br/>
                                                <?= $this->isvatgstname ?>: <b><span id="gstamt`+itemno+`"></span></b><br/>
                                                CESS: <b><span id="cessamt`+itemno+`"></span></b><br/>
                                                Discount: <b><span id="discountamt`+itemno+`"></span></b><br/>
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