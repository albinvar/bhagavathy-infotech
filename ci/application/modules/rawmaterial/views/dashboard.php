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
                            
                            <a href="<?= base_url() ?>rawmaterial/addrawmaterial" target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Raw Material</button>
                            </a>

                            <a href="<?= base_url() ?>business/addsupplier" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Supplier</button>
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
                            <form action="<?= base_url() ?>purchase/addingpurchase" method="POST" name="purchaseform" id="purchaseform">
                                <input type="hidden" name="purchaseid" id="purchaseid" value="<?= $purchaseid ?>">
                                <input type="hidden" name="type" id="type" value="<?= $type ?>">

                                <input type="hidden" name="israwmaterial" value="1">

                                <input type="hidden" name="return" id="return" value="<?= $return ?>">
                                <?php 
                                if($return == 2)
                                {
                                    $purchaseorderid = $poid;
                                }else{
                                    $purchaseorderid = "";
                                }
                                ?>
                                <input type="hidden" name="purchaseorderid" id="purchaseorderid" value="<?= $purchaseorderid ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="billprefix" value="<?php  echo $billprefix; ?>">
                                    Bill No: <b><?= $billprefix ?></b><input type="text" name="billno" readonly value="<?php if(isset($editdata)){ if($return==2){ echo $billno; }else{ echo $editdata->pm_purchaseno; } }else{ echo $billno; } ?>" class="inputfieldcss" style="width: 100px;">

                                    <?php 
                                    if($return == 2)
                                    {
                                        ?>
                                        PO No: <b><?php if(isset($editdata)){ echo $editdata->pm_purchaseprefix . "" . $editdata->pm_purchaseno; } ?></b>, &nbsp;
                                        Date: <b><?php if(isset($editdata)){ echo date('d-m-Y', strtotime($editdata->pm_date)); } ?> <?php if(isset($editdata)){ echo date('H:i', strtotime($editdata->pm_time)); } ?></b>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-6" align="right">
                                    <input type="date" name="purchasedate" value="<?php if(isset($editdata)){ if($return == 2){ echo date('Y-m-d'); }else{ echo date('Y-m-d', strtotime($editdata->pm_date)); } }else{ echo date('Y-m-d'); } ?>" class="inputfieldcss" style="width: 150px;">

                                    <input type="time" name="purchasetime" value="<?php if(isset($editdata)){ if($return == 2){ echo date('H:i'); }else{ echo date('H:i', strtotime($editdata->pm_time)); } }else{ echo date('H:i'); } ?>" class="inputfieldcss" style="width: 130px;">
                                    
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <input type="hidden" name="supplierid" value="<?php if(isset($editdata)){ echo $editdata->pm_supplierid; } ?>" id="supplierid">
                                    <input type="text" name="supplier" required id="suppliertextbox" autocomplete="off" onkeyup="searchsupplierfun(this.value)" value="<?php if(isset($editdata)){ echo $editdata->sp_name; } ?>" placeholder="Supplier Name" class="w-100 inputfieldcss">

                                    <div id="resultsressearch" class="secol dropdowndivstyle"><div class="secol" style="padding:5px;" id="serchreslt"></div></div>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="vehicleno" value="<?php if(isset($editdata)){ echo $editdata->pm_vehicleno; } ?>" placeholder="Vehicle Number" class="w-100 inputfieldcss">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="invoiceno" value="<?php if(isset($editdata)){ echo $editdata->pm_invoiceno; } ?>" placeholder="Invoice Number" class="w-100 inputfieldcss">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="invoicedate" value="<?php if(isset($editdata)){ echo $editdata->pm_invoicedate; }else{ echo date('Y-m-d'); } ?>" placeholder="Invoice Date" class="w-100 inputfieldcss">
                                </div>
                                <?php 
                                if($inventorysettings)
                                {
                                    if($inventorysettings->is_godown == 1)
                                    {
                                ?>
                                <div class="col-md-3">
                                    <select name="godownid" class="w-100 inputfieldcss">
                                        <option value="">Select Godown</option>
                                        <?php 
                                        if($godowns)
                                        {
                                            foreach($godowns as $gdvl)
                                            {
                                                ?>
                                                <option <?php if(isset($editdata)){ if($editdata->pm_godownid == $gdvl->gd_godownid){ echo "selected"; } } ?> value="<?= $gdvl->gd_godownid ?>"><?= $gdvl->gd_godownname ?> (<?= $gdvl->gd_godowncode ?>)</option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php 
                                    }
                                }
                                ?>
                            </div>

                            <div class="mt-3 table-responsive dashboarditems" >
                                <table class="table  w-100" cellspacing="0" cellspacing="0">
                                    <thead class="bg-gray-300">
                                        <tr>
                                            <th>#</th>
                                            <th>Material Id</th>
                                            <th>Material Name</th>
                                             <?php 
                                            if($inventorysettings)
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
                                            }
                                            ?>
                                            <th>Purchase Price</th>
                                            
                                            <th>MRP</th>
                                            <th><?= $this->isvatgstname ?>%</th>
                                            <th width="100px">Discount</th>
                                            <th>Purchase Rate</th>
                                            <th>Qty</th>
                                            <th width="100px">Total</th>
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
                                                        <input type="hidden" value="<?= $editvl->ps_productid ?>" name="productid[]" id="productid<?= $itno ?>">
                                                        <input type="text" name="productcode[]" id="productcode<?= $itno ?>" onkeyup="searchproductcodefun(this.value, '<?= $itno ?>')" value="<?= $editvl->pd_productcode ?>" autocomplete="off" style="width: 50px;"><br/>
                                                        <div id="resultproductcode<?= $itno ?>" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productcodeserchreslt<?= $itno ?>"></div></div>

                                                        <div id="productitemdetailsdiv<?= $itno ?>" class="productitemdetailsdivstyle"></div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="productname[]" id="productname<?= $itno ?>" onkeyup="searchproductnamefun(this.value, '<?= $itno ?>')" value="<?= htmlentities($editvl->pd_productname) ?>" autocomplete="off"><br/>
                                                        <div id="resultproduct<?= $itno ?>" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productserchreslt<?= $itno ?>"></div></div>
                                                    </td>
                                                    <?php 
                                                    if($inventorysettings)
                                                    {
                                                        if($inventorysettings->is_batchwise == 1)
                                                        {
                                                    ?>
                                                    <td><input type="text" name="batchno[]" value="<?= $editvl->ps_batchno ?>" id="batchno<?= $itno ?>" style="width: 60px;"></td>
                                                    <?php   
                                                        }
                                                        if($inventorysettings->is_expirydate == 1)
                                                        {
                                                    ?>
                                                    <td><input type="date" name="expirydate[]" value="<?= $editvl->ps_expirydate ?>" id="expirydate<?= $itno ?>" style="width: 100px;"></td>
                                                    <?php 
                                                        }
                                                    }
                                                    ?>
                                                    <td><input type="number" step="any" name="purchaseprice[]" onchange="calculateitemprice('<?= $itno ?>')" value="<?= $editvl->ps_purchaseprice ?>" onkeyup="calculateitemprice('<?= $itno ?>')" id="purchaseprice<?= $itno ?>" style="width: 70px;"></td>
                                                    
                                                    <td><input type="number" step="any" value="<?= $editvl->ps_mrp ?>" name="mrp[]" id="mrp<?= $itno ?>" style="width: 60px;"></td>
                                                    <td><input type="number" step="any" value="<?= $editvl->ps_gstpercent ?>" name="gst[]" id="gst<?= $itno ?>" onchange="calculateitemprice('<?= $itno ?>')" onkeyup="calculateitemprice('<?= $itno ?>')" style="width: 45px;"><br/>
                                                        <input type="hidden" name="itemgstval[]" value="<?= $editvl->ps_gstamnt ?>" id="itemgstval<?= $itno ?>">
                                                        <span style="font-size: 11px;" id="itemgstvalue<?= $itno ?>"><?= $editvl->ps_gstamnt ?></span>
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any" name="discountper[]" id="discountper<?= $itno ?>" onchange="calculatediscount('<?= $itno ?>', '1')" onkeyup="calculatediscount('<?= $itno ?>', '1')" style="width: 50px;" value="<?= $editvl->ps_discountpercent ?>">%<br/>
                                                        <input type="number" step="any" name="discountamnt[]" id="discountamnt<?= $itno ?>" onchange="calculatediscount('<?= $itno ?>', '2')" onkeyup="calculatediscount('<?= $itno ?>', '2')" style="width: 50px;" value="<?= $editvl->ps_discountamnt ?>">Amt
                                                    </td>
                                                    <td><input type="text" readonly step="any" value="<?= $editvl->ps_purchaserate ?>" name="unitprice[]" id="unitprice<?= $itno ?>" style="width: 60px;"></td>
                                                    <td>
                                                        <input type="hidden" name="oldqnty[]" id="oldqnty<?= $itno ?>" value="<?= $editvl->ps_qty ?>">

                                                        <input type="number" name="qty[]" id="qty<?= $itno ?>" onchange="calculateitemprice('<?= $itno ?>')" onkeyup="calculateitemprice('<?= $itno ?>')" style="width: 50px;" value="<?= $editvl->ps_qty ?>"><br/>
                                                        <span style="font-size: 11px; color: #F00;">Stock: <span id="availstock<?= $itno ?>"><?php echo $editvl->pd_stock - $editvl->ps_qty; ?></span></span>
                                                    </td>
                                                    
                                                    
                                                    <td>
                                                        <input type="hidden" name="itemnetamt[]" id="itemnetamt<?= $itno ?>" value="<?= $editvl->ps_netamount ?>">
                                                        <input type="hidden" name="itemgstamt[]" id="itemgstamt<?= $itno ?>" value="<?= $editvl->ps_totalgst ?>">
                                                        <input type="hidden" name="itemtotalamt[]" id="itemtotalamt<?= $itno ?>" value="<?= $editvl->ps_totalamount ?>">

                                                        Net: <span id="netamt<?= $itno ?>"><?= $editvl->ps_netamount ?></span><br/>
                                                        <?= $this->isvatgstname ?>: <span id="gstamt<?= $itno ?>"><?= $editvl->ps_totalgst ?></span><br/>
                                                        Total: <span id="totalamt<?= $itno ?>"><?= $editvl->ps_totalamount ?></span>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" onclick="removeitemrow('<?= $itno ?>')" title="Delete Row"><i class="fa fa-times-circle"></i></a>
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
                                                <input type="text" name="productcode[]" id="productcode1" onkeyup="searchproductcodefun(this.value, '1')" autocomplete="off" style="width: 50px;"><br/>
                                                <div id="resultproductcode1" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productcodeserchreslt1"></div></div>

                                                <div id="productitemdetailsdiv1" class="productitemdetailsdivstyle"></div>
                                            </td>
                                            <td>
                                                <input type="text" name="productname[]" id="productname1" onkeyup="searchproductnamefun(this.value, '1')" autocomplete="off"><br/>
                                                <div id="resultproduct1" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productserchreslt1"></div></div>
                                            </td>
                                            <?php 
                                            if($inventorysettings)
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
                                            }
                                            ?>
                                            <td><input type="number" step="any" name="purchaseprice[]" onchange="calculateitemprice('1')" onkeyup="calculateitemprice('1')" id="purchaseprice1" style="width: 70px;"></td>
                                            
                                            <td><input type="number" step="any" name="mrp[]" id="mrp1" style="width: 60px;"></td>
                                            <td><input type="number" step="any" name="gst[]" id="gst1" onchange="calculateitemprice('1')" onkeyup="calculateitemprice('1')" style="width: 45px;"><br/>
                                                <input type="hidden" name="itemgstval[]" id="itemgstval1">
                                                <span style="font-size: 11px;" id="itemgstvalue1"></span>
                                            </td>
                                            <td>
                                                <input type="number" step="any" name="discountper[]" id="discountper1" onchange="calculatediscount('1', '1')" onkeyup="calculatediscount('1', '1')" style="width: 50px;" value="0">%<br/>
                                                <input type="number" step="any" name="discountamnt[]" id="discountamnt1" onchange="calculatediscount('1', '2')" onkeyup="calculatediscount('1', '2')" style="width: 50px;" value="0">Amt
                                            </td>
                                            <td><input type="text" readonly step="any" name="unitprice[]" id="unitprice1" style="width: 60px;"></td>
                                            <td>

                                                <input type="number" name="qty[]" id="qty1" onchange="calculateitemprice('1')" onkeyup="calculateitemprice('1')" style="width: 50px;"><br/>
                                                <span style="font-size: 11px; color: #F00;">Stock: <span id="availstock1"></span></span>
                                            </td>
                                            
                                            
                                            <td>
                                                <input type="hidden" name="itemnetamt[]" id="itemnetamt1">
                                                <input type="hidden" name="itemgstamt[]" id="itemgstamt1">
                                                <input type="hidden" name="itemtotalamt[]" id="itemtotalamt1">

                                                Net: <span id="netamt1"></span><br/>
                                                <?= $this->isvatgstname ?>: <span id="gstamt1"></span><br/>
                                                Total: <span id="totalamt1"></span>
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

                            <div align="right">
                                <a href="javascript:void(0)" onclick="addmoreitem()">Add more +</a>
                            </div>

                            <input type="hidden" name="totalgstamount" id="totalgstamount" value="<?php if(isset($editdata)){ echo $editdata->pm_totalgstamount; }else{ echo 0; } ?>">

                            <table class="w-100 footrtable" cellspacing="5">
                                
                                <tr>
                                    <?php 
                                    if($type != 1)
                                    {
                                    ?>
                                    <td align="right" width="50%">Packing and Forwarding: </td>
                                    <td><input type="number"  step="any" onchange="calculatetotalamnt()" onkeyup="calculatetotalamnt()" name="freight" id="freight" value="<?php if(isset($editdata)){ echo $editdata->pm_freight; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                    <?php 
                                    }
                                    ?>
                                    
                                    <td align="right">Discount: </td>
                                    <td ><input type="number" readonly step="any" onchange="calculatetotalamnt()" onkeyup="calculatetotalamnt()" name="totaldiscount" id="totaldiscount" value="<?php if(isset($editdata)){ echo $editdata->pm_discount; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>

                                </tr>
                                <?php 
                                if($type != 1)
                                {
                                ?>
                                <tr>
                                    <td align="right">Packing Tax %: </td>
                                    <td><input type="number" step="any" onchange="calculatetotalamnt()" onkeyup="calculatetotalamnt()" name="freighttax" id="freighttax" value="<?php if(isset($editdata)){ echo $editdata->pm_freightgst; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                    <td align="right">Packing Tax Amount: </td>
                                    <td><input type="readonly" step="any"  name="freighttaxamount" id="freighttaxamount" value="<?php if(isset($editdata)){ echo $editdata->pm_freigtgstamnt; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                </tr>
                                <?php 
                                }else{
                                    ?>
                                    <input type="hidden" name="freight" id="freight" value="0">
                                    <input type="hidden" name="totaldiscount" id="totaldiscount" value="0" >
                                    <input type="hidden" name="freighttax" id="freighttax" value="0">
                                    <input type="hidden" name="freighttaxamount" id="freighttaxamount" value="0">
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td align="right" width="50%">Total Amount: </td>
                                    <td><input type="number" step="any" readonly name="totalamount" id="totalamount" value="<?php if(isset($editdata)){ echo $editdata->pm_totalamount; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                    <td align="right" width="20%"> </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td align="right">Round Off: </td>
                                    <td><input type="number" step="any" readonly name="roundoffvalue" id="roundoffvalue" value="<?php if(isset($editdata)){ echo $editdata->pm_roundoffvalue; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                    <?php 
                                    if($type != 1)
                                    {
                                    ?>
                                    <td align="right">Old Balance: </td>
                                    <td><input type="number" step="any" readonly name="oldbalance" id="oldbalance" value="<?php if(isset($editdata)){ if($return==2){ echo $oldbalance; }else{ echo $editdata->pm_oldbalance; } }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                    <?php 
                                    }else{
                                        ?>
                                        <input type="hidden" name="oldbalance" id="oldbalance" value="<?php if(isset($editdata)){ echo $editdata->pm_oldbalance; }else{ echo 0; } ?>">
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <td align="right">Grand Total: </td>
                                    <td><input type="number" step="any" readonly name="grandtotal" id="grandtotal" value="<?php if(isset($editdata)){ echo $editdata->pm_grandtotal; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                    <?php 
                                    if($type != 1)
                                    {
                                    ?>
                                    <td align="right">Paid Amount</td>
                                    <td><input type="number" step="any" name="paidamount" id="paidamount" onkeyup="calculatepaidamount()" onchange="calculatepaidamount()" value="<?php if(isset($editdata)){ echo $editdata->pm_paidamount; }else{ echo 0; } ?>" class="w-100 inputfieldcss">

                                        <input type="hidden" name="oldpaidamount" id="oldpaidamount" value="<?php if(isset($editdata)){ echo $editdata->pm_paidamount; }else{ echo 0; } ?>">
                                    </td>
                                    <?php 
                                    }else{
                                        ?>
                                        <input type="hidden" name="paidamount" id="paidamount"  value="<?php if(isset($editdata)){ echo $editdata->pm_paidamount; }else{ echo 0; } ?>" >

                                        <input type="hidden" name="oldpaidamount" id="oldpaidamount" value="<?php if(isset($editdata)){ echo $editdata->pm_paidamount; }else{ echo 0; } ?>">
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <?php 
                                    if($type != 1)
                                    {
                                    ?>
                                    <td align="right">Payment Method: </td>
                                    <td>
                                    <select class="w-100 inputfieldcss" name="paymethod" id="paymethod">
                                        <option <?php if(isset($editdata)){ if($editdata->pm_paymentmethod == 4){ echo "selected"; } } ?> value="4">Cash</option>
                                        <option <?php if(isset($editdata)){ if($editdata->pm_paymentmethod == 3){ echo "selected"; } } ?> value="3">Bank</option>
                                    </select>
                                    </td>

                                    <td align="right">Balance Amount: </td>
                                    <td>
                                        <?php 
                                        if($return == 2)
                                        {
                                            $balanceamount = $oldbalance + $editdata->pm_grandtotal;
                                        }
                                        ?>
                                        <input type="number" step="any" readonly name="balanceamnt" id="balanceamnt" value="<?php if(isset($editdata)){ if($return==2){  echo $balanceamount; }else{ echo $editdata->pm_balanceamount; } }else{ echo 0; } ?>" class="w-100 inputfieldcss">
                                        <input type="hidden" name="previousbalanceamnt" id="previousbalanceamnt" value="<?php if(isset($editdata)){ if($return==2){  echo $balanceamount; }else{ echo $editdata->pm_balanceamount;} }else{ echo 0; } ?>">
                                    </td>
                                    <?php 
                                    }else{
                                        ?>
                                        <input type="hidden" name="paymethod" id="paymethod" value="4">
                                        <input type="hidden"  name="balanceamnt" id="balanceamnt" value="<?php if(isset($editdata)){ echo $editdata->pm_balanceamount; }else{ echo 0; } ?>" class="w-100 inputfieldcss">
                                        <input type="hidden" name="previousbalanceamnt" id="previousbalanceamnt" value="<?php if(isset($editdata)){ echo $editdata->pm_balanceamount; }else{ echo 0; } ?>">
                                        <?php
                                    }
                                    ?>
                                    
                                </tr>

                                <tr>
                                    <td align="right">Purchase Note: </td>
                                    <td colspan="3"><textarea name="purchasenote" placeholder="Purchase Note" class="w-100"><?php if(isset($editdata)){ echo $editdata->pm_purchasenote; } ?></textarea></td>
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
            if(confirm('Are you sure?'))
            {
                return true;
            }else{
                return false;
            }
        }
    }

    function tofixed_amount(amnt)
    {
        var decml = <?= $this->decimalpoints ?>;
        return amnt.toFixed(decml);
    }

    function searchproductcodefun(val, no)
    {
        $('.tabledropdowndivstyle').hide();
        if(val == "")
        {
            document.getElementById('resultproductcode'+no).style.display='none';
        }
        else{
            $.ajax({
                url : "<?= base_url() ?>rawmaterial/searchproductcode",
                type: "POST",
                data : {key : val, no: no},
                success: function(data, textStatus, jqXHR)
                {
                    $('#productcodeserchreslt'+no).html(data);
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
            $.ajax({
                url : "<?= base_url() ?>rawmaterial/searchproductname",
                type: "POST",
                data : {key : val, no: no},
                success: function(data, textStatus, jqXHR)
                {
                    $('#productserchreslt'+no).html(data);
                },
            });
            document.getElementById('resultproduct'+no).style.display='inline';
        }
    }
    function selectproductdet(prdid, no)
    {

        var exists = 0;
        $('input[name^="productid"]').each(function() {
            if($(this).val() == prdid)
            {
                exists = 1;
            }
        });
        /*if(exists == 1)
        {
            alert('Product already selected.');
        }
        else{*/

            $('.tabledropdowndivstyle').hide();
            $.ajax({
                url : "<?= base_url() ?>purchase/getproductdetails",
                type: 'POST',
                dataType: 'JSON',
                data : {prodid : prdid},
            })
            .done(function(result) {
                  $('#productid'+no).val(result.pd_productid);
                  $("#productcode"+no).val(result.pd_productcode);
                  $("#productname"+no).val(result.pd_productname);

                  $("#gst"+no).val(result.tb_tax);

                  var gstamnt = (parseFloat(result.pd_purchaseprice) * parseFloat(result.tb_tax)/100);
                  var unitprice = parseFloat(result.pd_purchaseprice) + parseFloat(gstamnt);

                  $("#purchaseprice"+no).val(result.pd_purchaseprice);
                  $("#mrp"+no).val(result.pd_mrp);
                  $("#unitprice"+no).val(tofixed_amount(unitprice));
                  $("#qty"+no).val('1');
                  $("#discountper"+no).val('0');
                  $("#discountamnt"+no).val('0');

                  $('#itemgstval'+no).val(tofixed_amount(parseFloat(gstamnt)));
                  $('#itemgstvalue'+no).html(tofixed_amount(parseFloat(gstamnt)));

                  $("#netamt"+no).html(tofixed_amount(parseFloat(result.pd_purchaseprice)));
                  $("#gstamt"+no).html(tofixed_amount(parseFloat(gstamnt)));
                  $("#totalamt"+no).html(tofixed_amount(parseFloat(unitprice)));

                  $("#itemnetamt"+no).val(result.pd_purchaseprice);
                  $("#itemgstamt"+no).val(tofixed_amount(parseFloat(gstamnt)));
                  $("#itemtotalamt"+no).val(tofixed_amount(parseFloat(unitprice)));

                  var prddet = 'Category: <b>' + result.pc_categoryname + '</b>, HSN: <b>' + result.pd_hsnno + '</b>, Unit: <b>' + result.un_unitname + '</b>';

                  $('#productitemdetailsdiv'+no).html(prddet);
                  
                  $("#availstock"+no).html(result.pd_stock);

                  
                  calculatetotalamnt();
                  addmoreitem();
                  
            })
            .fail(function() {
              console.log("error");
            })
            .always(function() {
              console.log("complete");
            });
       // }
    }
    function calculatediscount(no, type)
    {
        var purchaseprice = $('#purchaseprice'+no).val();
        if(type == 1)
        {
            var discountper = $('#discountper'+no).val();
            var discountamnt = parseFloat(purchaseprice)*parseFloat(discountper)/100;
            $('#discountamnt'+no).val(tofixed_amount(discountamnt));
        }else{
            var discountamnt = $('#discountamnt'+no).val();
            var discpercent = parseFloat(discountamnt) * 100/parseFloat(purchaseprice)
            $('#discountper'+no).val(tofixed_amount(discpercent));
        }
        calculateitemprice(no);
    }
    function calculateitemprice(no)
    {
        var purchaseprice = $('#purchaseprice'+no).val();
        //var unitprice = $('#unitprice'+no).val();
        var gst = $('#gst'+no).val();
        var qty = $('#qty'+no).val();
        var discountamnt = $('#discountamnt'+no).val();

        var gstamnt = parseFloat(purchaseprice) * parseFloat(gst)/100;
        $('#itemgstvalue'+no).html(tofixed_amount(gstamnt));
        $('#itemgstval'+no).val(tofixed_amount(gstamnt));

        var unitprice = parseFloat(purchaseprice) + parseFloat(purchaseprice) * parseFloat(gst)/100;
        var netamnt = parseFloat(unitprice) - parseFloat(discountamnt);
        

        $('#unitprice'+no).val(tofixed_amount(netamnt));

        totalamount = parseFloat(purchaseprice) * parseFloat(qty);
        
        //totnetamnt = netamnt + 

        totaltaxamnt = parseFloat(totalamount) * parseFloat(gst)/100;

        itemtotalamt = parseFloat(totalamount) + parseFloat(totaltaxamnt) - (parseFloat(discountamnt)*parseFloat(qty));



        $('#itemnetamt'+no).val(tofixed_amount(totalamount));
        $('#netamt'+no).html(tofixed_amount(totalamount));

        $('#itemgstamt'+no).val(tofixed_amount(totaltaxamnt));
        $('#gstamt'+no).html(tofixed_amount(totaltaxamnt));

        $('#itemtotalamt'+no).val(tofixed_amount(itemtotalamt));
        $('#totalamt'+no).html(tofixed_amount(itemtotalamt));

        calculatetotalamnt();
    }
    function calculatetotalamnt()
    {
        var totamount = 0;
        var totgstamnt = 0;

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

        var purchaseid = $('#purchaseid').val();
        var totaldiscount = $('#totaldiscount').val();

        
        var freight = $('#freight').val();
        var freighttax = $('#freighttax').val();

        if(freighttax != 0)
        {
            var fregstmult = 100 + parseFloat(freighttax);
            var frpriceval = parseFloat(freight) * 100/parseFloat(fregstmult);
            var freightgst = parseFloat(freight) - parseFloat(frpriceval);
        }else{
            var freightgst = 0;
        }
        totgstamnt = parseFloat(totgstamnt) + parseFloat(freightgst);
        $('#freighttaxamount').val(tofixed_amount(parseFloat(freightgst)));

        var oldbalance = $('#oldbalance').val();
        //var grandtotal = $('#grandtotal').val();
        var paidamount = $('#paidamount').val();
        //var balanceamnt = $('#balanceamnt').val();

        var grandtotal = parseFloat(freight) + parseFloat(totamount) - parseFloat(totaldiscount);

        var totgrandtotal = tofixed_amount(parseFloat(grandtotal));

        var rounddecimal = totgrandtotal - Math.floor(parseFloat(totgrandtotal));
        if(parseFloat(rounddecimal) >= 0.50)
        {
            var newgrandtotal = Math.ceil(parseFloat(totgrandtotal));
        }else{
            var newgrandtotal = Math.floor(parseFloat(totgrandtotal));
        }

        <?php 
        if($type == 0)
        {
        ?>
        if(purchaseid != 0)
        {
            var balancamnt = parseFloat(newgrandtotal)+parseFloat(oldbalance)-parseFloat(paidamount);
            $('#balanceamnt').val(tofixed_amount(balancamnt));
        }else{
            var paidamount = 0;
            var balanceamount = parseFloat(newgrandtotal)+parseFloat(oldbalance);
            $('#balanceamnt').val(tofixed_amount(parseFloat(balanceamount)));
        }
        <?php 
        }else{
            ?>
            var paidamount = 0;
            var balanceamount = parseFloat(newgrandtotal)+parseFloat(oldbalance);
            $('#balanceamnt').val(tofixed_amount(parseFloat(balanceamount)));
            <?php
        }
        ?>
        
        $('#roundoffvalue').val(tofixed_amount(rounddecimal));

        $('#totalgstamount').val(tofixed_amount(totgstamnt));

        $('#totalamount').val(tofixed_amount(parseFloat(totamount)));
        $('#grandtotal').val(tofixed_amount(parseFloat(newgrandtotal)));
        $('#paidamount').val(tofixed_amount(parseFloat(paidamount)));
        
    }

    function calculatepaidamount()
    {
        var grandtotal = $('#grandtotal').val();
        var oldbalance = $('#oldbalance').val();
        var paidamount = $('#paidamount').val();

        balanceamnt = parseFloat(grandtotal) + parseFloat(oldbalance) - parseFloat(paidamount);
        $('#balanceamnt').val(tofixed_amount(balanceamnt));
    }
   
    function searchsupplierfun(val)
    {
        
        if(val == "")
        {
            document.getElementById('resultsressearch').style.display='none';
        }
        else{
            $.ajax({
                url : "<?= base_url() ?>purchase/searchsupplier",
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
    function selectsupplierdet(spid)
    {
        $.ajax({
            url : "<?= base_url() ?>purchase/getsupplierdetails",
            type: 'POST',
            dataType: 'JSON',
            data : {supid : spid},
        })
        .done(function(result) {
              $('#supplierid').val(result.sp_supplierid);
              $("#suppliertextbox").val(result.sp_name);
              $("#oldbalance").val(result.sp_balanceamount);

              var balanceamount = parseFloat($('#grandtotal').val()) + parseFloat(result.sp_balanceamount);
              $('#paidamount').val(0);
              $('#balanceamnt').val(tofixed_amount(parseFloat(balanceamount)));
              document.getElementById('resultsressearch').style.display='none';
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
                                        <input type="text" name="productcode[]" id="productcode`+itemno+`" onkeyup="searchproductcodefun(this.value, '`+itemno+`')" autocomplete="off" style="width: 50px;"><br/>
                                        <div id="resultproductcode`+itemno+`" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productcodeserchreslt`+itemno+`"></div></div>
                                        <div id="productitemdetailsdiv`+itemno+`" class="productitemdetailsdivstyle"></div>
                                    </td>
                                    <td>
                                        <input type="text" name="productname[]" id="productname`+itemno+`" onkeyup="searchproductnamefun(this.value, '`+itemno+`')" autocomplete="off"><br/>
                                        <div id="resultproduct`+itemno+`" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productserchreslt`+itemno+`"></div></div>
                                    </td>
                                    <?php 
                                    if($inventorysettings)
                                    {
                                        if($inventorysettings->is_batchwise == 1)
                                        {
                                    ?>
                                    <td><input type="text" name="batchno[]" id="batchno`+itemno+`" style="width: 60px;"></td>
                                    <?php   
                                        }
                                        if($inventorysettings->is_expirydate == 1)
                                        {
                                    ?>
                                    <td><input type="date" name="expirydate[]" id="expirydate`+itemno+`" style="width: 100px;"></td>
                                    <?php 
                                        }
                                    }
                                    ?>
                                    <td><input type="number" step="any" name="purchaseprice[]" onchange="calculateitemprice('`+itemno+`')" onkeyup="calculateitemprice('`+itemno+`')" id="purchaseprice`+itemno+`" style="width: 70px;"></td>
                                    <td><input type="number" step="any" name="mrp[]" id="mrp`+itemno+`" style="width: 60px;"></td>
                                    <td><input type="number" step="any" name="gst[]" id="gst`+itemno+`" onchange="calculateitemprice('`+itemno+`')" onkeyup="calculateitemprice('`+itemno+`')" style="width: 45px;"><br/>
                                    <input type="hidden" name="itemgstval[]" id="itemgstval`+itemno+`">
                                                <span style="font-size: 11px;" id="itemgstvalue`+itemno+`"></span></td>
                                    <td>
                                        <input type="number" step="any" name="discountper[]" id="discountper`+itemno+`" onchange="calculatediscount('`+itemno+`', '1')" onkeyup="calculatediscount('`+itemno+`', '1')" style="width: 50px;" value="0">%<br/>
                                        <input type="number" step="any" name="discountamnt[]" id="discountamnt`+itemno+`" onchange="calculatediscount('`+itemno+`', '2')" onkeyup="calculatediscount('`+itemno+`', '2')" style="width: 50px;" value="0">Amt
                                    </td>
                                    <td><input type="text" readonly step="any" name="unitprice[]" id="unitprice`+itemno+`" style="width: 60px;"></td>
                                    <td>
                                        <input type="number" name="qty[]" id="qty`+itemno+`" onchange="calculateitemprice('`+itemno+`')" onkeyup="calculateitemprice('`+itemno+`')" style="width: 50px;"><br/>
                                        <span style="font-size: 11px; color: #F00;">Stock: <span id="availstock`+itemno+`"></span></span>
                                    </td>
                                    <td>
                                        <input type="hidden" name="itemnetamt[]" id="itemnetamt`+itemno+`">
                                        <input type="hidden" name="itemgstamt[]" id="itemgstamt`+itemno+`">
                                        <input type="hidden" name="itemtotalamt[]" id="itemtotalamt`+itemno+`">

                                        Net: <span id="netamt`+itemno+`"></span><br/>
                                        <?= $this->isvatgstname ?>: <span id="gstamt`+itemno+`"></span><br/>
                                        Total: <span id="totalamt`+itemno+`"></span>
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
    
</script>