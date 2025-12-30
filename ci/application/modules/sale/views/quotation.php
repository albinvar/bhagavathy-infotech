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
                            </a>-->

                            <a href="<?= base_url() ?>business/addcustomer" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Customer</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Quotation</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-2 dashoboardform">
                            <form action="<?= base_url() ?>sale/addingquotation" method="POST" name="purchaseform" id="purchaseform">
                                <input type="hidden" name="type" value="<?= $type ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    Bill No: <input type="text" name="billno" readonly value="<?= $billno ?>" class="inputfieldcss" style="width: 100px;">
                                </div>
                                <div class="col-md-6" align="right">
                                    <input type="date" name="saledate" value="<?= date('Y-m-d') ?>" class="inputfieldcss" style="width: 150px;">

                                    <input type="time" name="saletime" value="<?= date('H:i') ?>" class="inputfieldcss" style="width: 130px;">
                                    
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="customercheck"> <b>Already existing customer?</b>
                                <input type="checkbox" value="1"  name="customercheck" id="customercheck"></label>

                                <div id="walkincustdiv">
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label>Customer Name</label>
                                        <input type="text" name="customername" placeholder="Customer Name" class="w-100 inputfieldcss">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Customer Phone</label>
                                        <input type="text" name="customerphone" placeholder="Customer Phone" class="w-100 inputfieldcss">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Customer Address</label>
                                        <input type="text" name="customeraddress" placeholder="Customer Address" class="w-100 inputfieldcss">
                                    </div>

                                    <div class="col-md-3">
                                        <label>GSTIN</label>
                                        <input type="text" name="customergstin" placeholder="Customer GSTIN" class="w-100 inputfieldcss">
                                    </div>
                                         
                                </div>    
                                </div>
                                <div id="existcustdiv" style="display: none;">
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label>Select Customer</label>
                                        <input type="hidden" name="customerid" id="customerid">
                                        <input type="text" name="supplier" id="suppliertextbox" autocomplete="off" onkeyup="searchcustomerfun(this.value)" placeholder="Cuctomer Name" class="w-100 inputfieldcss">

                                        <div id="resultsressearch" class="secol dropdowndivstyle"><div class="secol" style="padding:5px;" id="serchreslt"></div></div>
                                    </div>
                                </div>
                                </div>

                                
                                <div class="col-md-3 mt-2">
                                    <label>Vehicle Number</label>
                                    <input type="text" name="vehicleno" placeholder="Vehicle Number" class="w-100 inputfieldcss">
                                </div>
                                <div class="col-md-3 mt-2">
                                    <label>Sales Person</label>
                                    <input type="text" name="salesperson" placeholder="Sales Person" class="w-100 inputfieldcss">
                                </div>
                                <div class="col-md-3 mt-2">
                                    <label>Shipping Address</label>
                                    <input type="text" name="shippingaddress" placeholder="Shipping Address" class="w-100 inputfieldcss">
                                </div>
                                <?php 
                                if($inventorysettings)
                                {
                                    if($inventorysettings->is_godown == 1)
                                    {
                                ?>
                                <div class="col-md-3 mt-2">
                                    <label>Godown</label>
                                    <select name="godownid" class="w-100 inputfieldcss">
                                        <option value="">Select Godown</option>
                                        <?php 
                                        if($godowns)
                                        {
                                            foreach($godowns as $gdvl)
                                            {
                                                ?>
                                                <option value="<?= $gdvl->gd_godownid ?>"><?= $gdvl->gd_godownname ?> (<?= $gdvl->gd_godowncode ?>)</option>
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

                                <div class="col-md-3 mt-2">
                                    <label>Select Place of Supply</label>
                                    <select name="stateid" id="stateid" class="w-100 inputfieldcss">
                                        <option value="">Select State</option>
                                            <?php
                                            if($states)
                                            {
                                                foreach($states as $stval)
                                                {
                                                    ?>
                                                    <option <?php if($stval->id == '4028'){ echo "selected"; } ?> value="<?= $stval->id ?>"><?= $stval->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3 table-responsive dashboarditems" >
                                <table class="table  w-100" cellspacing="0" cellspacing="0">
                                    <thead class="bg-gray-300">
                                        <tr>
                                            <th>#</th>
                                            <th>Product Id</th>
                                            <th>Product Name</th>
                                             
                                            <th>Unit Price</th>
                                           
                                            <th>Qty</th>
                                            <th width="150px">Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemlistbody">
                                        <tr id="prdrow1">
                                            <td><span id="slno1">1</span></td>
                                            <td>
                                                <input type="hidden" name="productid[]" id="productid1">
                                                <input type="hidden" name="stockid[]" id="stockid1">
                                                <input type="hidden" name="batchno[]" id="batchno1">
                                                <input type="hidden" name="expirydate[]" id="expirydate1">
                                                <input type="text" name="productcode[]" id="productcode1" onkeyup="searchproductcodefun(this.value, '1')" autocomplete="off" style="width: 150px;"><br/>
                                                <div id="resultproductcode1" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productcodeserchreslt1"></div></div>

                                                <div id="productitemdetailsdiv1" class="productitemdetailsdivstyle"></div>
                                            </td>
                                            <td>
                                                <input type="text" name="productname[]" id="productname1" onkeyup="searchproductnamefun(this.value, '1')" autocomplete="off"><br/>
                                                <div id="resultproduct1" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productserchreslt1"></div></div>
                                            </td>
                                            
                                            <td>
                                                <input type="hidden" step="any" name="purchaseprice[]" id="purchaseprice1" >
                                                <input type="hidden" step="any" name="mrp[]" id="mrp1">

                                                <input type="number" step="any" name="unitprice[]" id="unitprice1" onchange="calculateitemprice('1')" onkeyup="calculateitemprice('1')" style="width: 70px;"></td>
                                            <td>
                                                <input type="hidden" step="any" name="netprice[]" id="netprice1">
                                                <input type="hidden" step="any" name="gst[]" id="gst1" >
                                                <input type="hidden" name="itemgstval[]" id="itemgstval1">

                                                <input type="number" name="qty[]" id="qty1" onchange="calculateitemprice('1')" onkeyup="calculateitemprice('1')" style="width: 100px;"><span id="itemunitval1"></span>
                                                <br/>
                                                <input type="hidden" name="availablestck[]" id="availablestck1">
                                                <span style="font-size: 11px; color: #F00;">Stock: <span id="availstock1"></span></span><br/>
                                                <span style="font-size: 11px; color: #F00;">Blnce: <span id="balancestock1"></span></span>
                                            </td>
                                            
                                            <td>
                                                <input type="hidden" name="itemnetamt[]" id="itemnetamt1">
                                                <input type="hidden" name="itemgstamt[]" id="itemgstamt1">
                                                <input type="hidden" name="itemcessamt[]" id="itemcessamt1" value="0">
                                                <input type="hidden" name="itemdiscountamt[]" id="itemdiscountamt1" value="0">
                                                <input type="hidden" name="itemtotalamt[]" id="itemtotalamt1">

                                                
                                                Total: <b><span id="totalamt1"></span></b>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" onclick="removeitemrow('1')" title="Delete Row"><i class="fa fa-times-circle"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div align="right">
                                <a href="javascript:void(0)" onclick="addmoreitem()">Add more +</a>
                            </div>

                            <table class="w-100 footrtable" cellspacing="5">
                                
                                <tr>
                                    <td align="right" width="40%"></td>
                                    <td></td>
                                    <td align="right">Total Amount: </td>
                                    <td><input type="number" step="any" readonly name="totalamount" id="totalamount" value="0" class="w-100 inputfieldcss"></td>
                                    
                                </tr>
                                
                                

                                <tr>
                                    <td align="right"></td>
                                    <td></td>
                                    <td align="right">Page Size</td>
                                    <td>
                                        <select class="w-100 inputfieldcss" name="pagesize" id="pagesize">
                                            <option value="1">A4</option>
                                            <option value="2">A5</option>
                                            <option value="2">Thermal</option>
                                        </select>
                                    </td>
                                    
                                </tr>
                            </table>


                            <div class="row text-right mt-3">
                                <div class="col-md-12" align="right">
                                    <button type="submit" class="btn btn-primary mr-2 addfacilitySubmit listbtns"
                                        id="addfacilitySubmit" onclick="return confirm('Are you sure?')">Submit</button>
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
    var chech = document.getElementById('customercheck');
    chech.onchange=function()
    {
        if(this.checked)
        {
            $('#walkincustdiv').hide();
            $('#existcustdiv').show();
        }
        else
        {
            $('#walkincustdiv').show();
            $('#existcustdiv').hide();
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
                url : "<?= base_url() ?>sale/searchproductcode",
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
                url : "<?= base_url() ?>sale/searchproductname",
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
                  $("#productname"+no).val(result.pd_productname);

                  $('#batchno'+no).val(result.pt_batchno);
                  $('#expirydate'+no).val(result.pt_expirydate);

                  $("#gst"+no).val(result.tb_tax);
                 
                  if(result.pd_profittype == 1)
                  {
                    <?php 
                    if($type == 1)
                    {
                        ?>
                    var retamntval = (parseFloat(result.pd_purchaseprice) * parseFloat(result.pd_wholesaleprofit)/100);
                    var retailpriceval = parseFloat(result.pd_purchaseprice) + parseFloat(retamntval);
                    <?php 
                    }else{
                    ?>
                    var retamntval = (parseFloat(result.pd_purchaseprice) * parseFloat(result.pd_retailprofit)/100);
                    var retailpriceval = parseFloat(result.pd_purchaseprice) + parseFloat(retamntval);
                    <?php 
                    }
                    ?>
                  }
                  else{
                    <?php 
                    if($type == 1)
                    {
                        ?>
                        var retailpriceval = parseFloat(result.pd_purchaseprice) + parseFloat(result.pd_wholesaleprofit);
                        <?php
                    }else{
                    ?>
                    var retailpriceval = parseFloat(result.pd_purchaseprice) + parseFloat(result.pd_retailprofit);
                    <?php 
                    }
                    ?>
                  }

                  var gstamnt = (parseFloat(result.pd_purchaseprice) * parseFloat(result.tb_tax)/100);
                  var purchaseval = parseFloat(result.pd_purchaseprice) + parseFloat(gstamnt);

                  var retailgst = (parseFloat(retailpriceval) * parseFloat(result.tb_tax)/100);
                  var retailitemprice = parseFloat(retailpriceval) + parseFloat(retailgst);

                  $("#purchaseprice"+no).val(tofixed_amount(purchaseval));
                  $("#mrp"+no).val(result.pd_mrp);
                  $("#unitprice"+no).val(tofixed_amount(retailitemprice));
                  $("#qty"+no).val('1');
                  $("#discountper"+no).val('0');
                  $("#discountamnt"+no).val('0');

                  $('#itemgstval'+no).val(tofixed_amount(retailgst));
                  $('#itemgstvalue'+no).html(tofixed_amount(retailgst));

                  $('#netprice'+no).val(tofixed_amount(retailpriceval));

                  $("#netamt"+no).html(tofixed_amount(retailpriceval));
                  $("#gstamt"+no).html(tofixed_amount(retailgst));
                  $("#totalamt"+no).html(tofixed_amount(retailitemprice));

                  $("#itemnetamt"+no).val(tofixed_amount(retailpriceval));
                  $("#itemgstamt"+no).val(tofixed_amount(retailgst));
                  $("#itemtotalamt"+no).val(tofixed_amount(retailitemprice));

                  $('#itemunitval'+no).html(result.un_unitname);


                  var prddet = 'Category: <b>' + result.pc_categoryname + '</b>, HSN: <b>' + result.pd_hsnno + '</b>, Batch: <b>' + result.pt_batchno + '</b>, Expiry: <b>' + result.pt_expirydate + '</b>';

                  $('#productitemdetailsdiv'+no).html(prddet);
                  
                  $("#availstock"+no).html(result.pt_stock);
                  $("#availablestck"+no).val(result.pt_stock);

                  var blancestck = parseFloat(result.pt_stock) - 1;
                  $("#balancestock"+no).html(blancestck);
                                      
                  $("#qty"+no).focus();

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
        var unitprice = $('#unitprice'+no).val();
        var netprice = $('#netprice'+no).val();

        var gst = $('#gst'+no).val();
        
        var qty = $('#qty'+no).val();

        //alert(qty);
        

        var availstock = $("#availablestck"+no).val();

        if(parseInt(qty) > parseInt(availstock))
        {
            $("#qty"+no).val(availstock);
            alert('Not enough stock, Please add stock.');

        }else if(parseInt(qty)<1){
            $("#qty"+no).val(1);
            alert('Invalid qty.');
        }else{

            var blancestck = parseFloat(availstock) - parseFloat(qty);
            $("#balancestock"+no).html(blancestck);

            var gstmult = 100 + parseFloat(gst);
            var gstamnt = parseFloat(unitprice)-(parseFloat(unitprice)*(100/parseFloat(gstmult)));

            
            
            
            var netamount = parseFloat(unitprice) - parseFloat(gstamnt);
            $('#netprice'+no).val(tofixed_amount(netamount));
            $('#itemgstval'+no).val(tofixed_amount(gstamnt));

            totalnetamount = parseFloat(netamount) * parseFloat(qty);

            totaltaxamnt = parseFloat(gstamnt) * parseFloat(qty);
            

            totalitemamount = parseFloat(unitprice) * parseFloat(qty);

            $('#itemnetamt'+no).val(tofixed_amount(totalnetamount));

            $('#itemgstamt'+no).val(tofixed_amount(totaltaxamnt));

            $('#itemtotalamt'+no).val(tofixed_amount(totalitemamount));
            $('#totalamt'+no).html(tofixed_amount(totalitemamount));
            
            calculatetotalamnt();
        }
    }
    function calculatetotalamnt()
    {
        var totamount = 0;

        $('input[name^="itemtotalamt"]').each(function() {
            if($(this).val() != "")
            {
                totamount = parseFloat(totamount) + parseFloat($(this).val());
            }
        });
        //var grandtotal = $('#grandtotal').val();
        //var paidamount = $('#paidamount').val();
        //var balanceamnt = $('#balanceamnt').val();

        var grandtotal = parseFloat(totamount);
        
        $('#totalamount').val(tofixed_amount(totamount));
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
              var paidamount = parseFloat($('#grandtotal').val()) + parseFloat(result.ct_balanceamount);
              $('#paidamount').val(paidamount);
              $('#balanceamnt').val(0);
              document.getElementById('resultsressearch').style.display='none';
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    }
    var sln = 2;
    var itemno = 2;

    function addmoreitem()
    {
        $('#itemlistbody').append(`<tr id="prdrow`+itemno+`">
                                            <td><span id="slno`+sln+`">`+sln+`</span></td>
                                            <td>
                                                <input type="hidden" name="productid[]" id="productid`+itemno+`">
                                                <input type="hidden" name="stockid[]" id="stockid`+itemno+`">
                                                <input type="hidden" name="batchno[]" id="batchno`+itemno+`">
                                                <input type="hidden" name="expirydate[]" id="expirydate`+itemno+`">
                                                <input type="text" name="productcode[]" id="productcode`+itemno+`" onkeyup="searchproductcodefun(this.value, '`+itemno+`')" autocomplete="off" style="width: 150px;"><br/>
                                                <div id="resultproductcode`+itemno+`" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productcodeserchreslt`+itemno+`"></div></div>

                                                <div id="productitemdetailsdiv`+itemno+`" class="productitemdetailsdivstyle"></div>
                                            </td>
                                            <td>
                                                <input type="text" name="productname[]" id="productname`+itemno+`" onkeyup="searchproductnamefun(this.value, '`+itemno+`')" autocomplete="off"><br/>
                                                <div id="resultproduct`+itemno+`" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productserchreslt`+itemno+`"></div></div>
                                            </td>
                                            
                                            <td>
                                                <input type="hidden" step="any" name="purchaseprice[]" id="purchaseprice`+itemno+`" >
                                                <input type="hidden" step="any" name="mrp[]" id="mrp`+itemno+`">

                                                <input type="number" step="any" name="unitprice[]" id="unitprice`+itemno+`" onchange="calculateitemprice('`+itemno+`')" onkeyup="calculateitemprice('`+itemno+`')" style="width: 70px;"></td>
                                            <td>
                                                <input type="hidden" step="any" name="netprice[]" id="netprice`+itemno+`">
                                                <input type="hidden" step="any" name="gst[]" id="gst`+itemno+`" >
                                                <input type="hidden" name="itemgstval[]" id="itemgstval`+itemno+`">

                                                <input type="number" name="qty[]" id="qty`+itemno+`" onchange="calculateitemprice('`+itemno+`')" onkeyup="calculateitemprice('`+itemno+`')" style="width: 100px;"><span id="itemunitval`+itemno+`"></span>
                                                <br/>
                                                <input type="hidden" name="availablestck[]" id="availablestck`+itemno+`">
                                                <span style="font-size: 11px; color: #F00;">Stock: <span id="availstock`+itemno+`"></span></span><br/>
                                                <span style="font-size: 11px; color: #F00;">Blnce: <span id="balancestock`+itemno+`"></span></span>
                                            </td>
                                            
                                            <td>
                                                <input type="hidden" name="itemnetamt[]" id="itemnetamt`+itemno+`">
                                                <input type="hidden" name="itemgstamt[]" id="itemgstamt`+itemno+`">
                                                <input type="hidden" name="itemcessamt[]" id="itemcessamt`+itemno+`" value="0">
                                                <input type="hidden" name="itemdiscountamt[]" id="itemdiscountamt`+itemno+`" value="0">
                                                <input type="hidden" name="itemtotalamt[]" id="itemtotalamt`+itemno+`">

                                                
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
    
</script>