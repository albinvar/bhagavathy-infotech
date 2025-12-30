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
                            
                            <a href="<?= base_url() ?>inventory/stocktransferlist" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-history"></i> Transfer History</button>
                            </a>
                           
                        </div>
                        <h4 class="page-title">Stock Transfer</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-2 dashoboardform">
                            <form action="<?= base_url() ?>inventory/transferingstock" method="POST" name="purchaseform" id="purchaseform">
                                <input type="hidden" name="billid" value="">

                            

                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <label>Tranfer From*</label>
                                    <select name="fromgodownid" id="fromgodownid" required="required" class="w-100 inputfieldcss" onchange="godownselectfun()">
                                        <option <?php if($fromid==0){ echo "selected"; }  ?> value="0">Select Godown</option>
                                        <?php 
                                        if($fromgodowns)
                                        {
                                            foreach($fromgodowns as $gdvl)
                                            {
                                                ?>
                                                <option <?php if($fromid==$gdvl->gd_godownid){ echo "selected"; }  ?> value="<?= $gdvl->gd_godownid ?>"><?= $gdvl->gd_godownname ?> (<?= $gdvl->gd_godowncode ?>)</option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Tranfer To*</label>
                                    <select name="togodownid" id="togodownid" required="required" class="w-100 inputfieldcss" onchange="godownselectfun()">
                                        <option <?php if($toid==0){ echo "selected"; }  ?> value="0">Select Godown</option>
                                        <?php 
                                        if($togodowns)
                                        {
                                            foreach($togodowns as $gdvl)
                                            {
                                                ?>
                                                <option <?php if($toid==$gdvl->gd_godownid){ echo "selected"; }?> value="<?= $gdvl->gd_godownid ?>"><?= $gdvl->gd_godownname ?> (<?= $gdvl->gd_godowncode ?>)</option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Tranfer Date</label><br/>
                                    <input type="date" name="transferdate" value="<?php echo date('Y-m-d'); ?>" class="inputfieldcss" style="width: 150px;">

                                    <input type="time" name="transfertime" value="<?php echo date('H:i'); ?>" class="inputfieldcss" style="width: 130px;">
                                </div>

                                <script type="text/javascript">
                                    function godownselectfun()
                                    {
                                        var fromgodownid = $('#fromgodownid').val();
                                        var togodownid = $('#togodownid').val();

                                        window.location.href= '<?= base_url() ?>inventory/stocktransfer/'+fromgodownid+'/'+togodownid;
                                    }
                                </script>


                            </div>

                            <?php 
                            if($transferform == 1)
                            {
                            ?>

                            <div class="mt-3 table-responsive dashboarditems" >
                                <table class="table  w-100" cellspacing="0" cellspacing="0">
                                    <thead class="bg-gray-300">
                                        <tr>
                                            <th>#</th>
                                            <th>Product Id</th>
                                            <th>Product Name</th>
                                            
                                            <th>Purchase Price</th>
                                            
                                            <th>MRP</th>
                                            
                                            <th>Qty</th>
                                            <th width="120px">Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemlistbody">
                                        <?php 
                                        $itno = 2;
                                        
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
                                            
                                            <td>
                                                <input type="hidden" name="purchasepriceval[]" id="purchasepriceval1">
                                                <input type="text" readonly step="any" name="purchaseprice[]" id="purchaseprice1" style="width: 100px;"></td>
                                            
                                            
                                            <td><input type="text" readonly step="any" name="mrp[]" id="mrp1" style="width: 100px;"></td>
                                            
                                            <td>
                                                <input type="number" name="qty[]" id="qty1" onchange="calculateitemprice('1')" onkeyup="calculateitemprice('1')" style="width: 70px;"><span id="itemunitval1"></span>
                                                <br/>
                                                <input type="hidden" name="availablestck[]" id="availablestck1">
                                                <span style="font-size: 11px; color: #F00;">Stock: <span id="availstock1"></span></span><br/>

                                                <input type="hidden" name="balancestockval[]" id="balancestockval1">
                                                <span style="font-size: 11px; color: #F00;">Blnce: <span id="balancestock1"></span></span>
                                            </td>
                                            
                                            
                                            <td>

                                                <input type="text" readonly step="any" name="itemtotalamt[]" id="itemtotalamt1" style="width: 100px;">
                                                
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
                                    <td align="right" width="50%"></td>
                                    <td></td>
                                    <td align="right">Total Amount: </td>
                                    <td><input type="number" step="any" readonly name="totalamount" id="totalamount" value="<?php if(isset($editdata)){ echo $editdata->rb_totalamount; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                    
                                </tr>
                                
                            </table>


                            <div class="row text-right mt-3">
                                <div class="col-md-12" align="right">
                                    <button type="submit" class="btn btn-primary mr-2 addfacilitySubmit listbtns"
                                        id="addfacilitySubmit" onclick="return validatedashboard()">Submit</button>
                                    <a href="javascript:history.go(-1);" class="btn btn-secondary listbtns">Cancel</a>
                                </div>
                            </div>

                            <?php 
                            }else{
                                ?>
                                <div class="mt-3 mb-3">
                                    Please select transfer godowns..
                                </div>
                                <?php
                            }
                            ?>

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
            var godownid = $('#fromgodownid').val();
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
            var godownid = $('#fromgodownid').val();
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
                 
                  $('#purchasepriceval'+no).val(result.pt_purchaseprice);

                  var gstamnt = (parseFloat(result.pt_purchaseprice) * parseFloat(result.tb_tax)/100);
                  var purchaseval = parseFloat(result.pt_purchaseprice) + parseFloat(gstamnt);

                  $("#purchaseprice"+no).val(tofixed_amount(purchaseval));

                  if(result.pt_mrp != "" && result.pt_mrp != null && result.pt_mrp != 0)
                  {
                    $("#mrp"+no).val(result.pt_mrp);
                  }else{
                    $("#mrp"+no).val(result.pd_mrp);
                  }

                  
                  $("#qty"+no).val('1');
                  
                  $("#itemtotalamt"+no).val(tofixed_amount(purchaseval));

                  
                  var prddet = 'Category: <b>' + result.pc_categoryname + '</b>, HSN: <b>' + result.pd_hsnno + '</b>, Batch: <b>' + result.pt_batchno + '</b>, Expiry: <b>' + result.pt_expirydate + '</b>';

                  $('#productitemdetailsdiv'+no).html(prddet);
                  
                  $("#availstock"+no).html(result.pt_stock);
                  $("#availablestck"+no).val(result.pt_stock);

                  var blancestck = parseFloat(result.pt_stock) - 1;
                  $("#balancestock"+no).html(blancestck);
                  $('#balancestockval'+no).html(blancestck);
                                      
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
        var purchaseprice = $('#purchaseprice'+no).val();
        var qty = $('#qty'+no).val();
        var availstock = $("#availablestck"+no).val();
        
        if(parseInt(qty) > parseInt(availstock))
        {
            $("#qty"+no).val(availstock);
            alert('Not enough stock, Please add stock.');

        }else
       
         if(parseInt(qty)<1){
            $("#qty"+no).val(1);
            alert('Invalid qty.');
        }else{

            var blancestck = parseFloat(availstock) - parseFloat(qty);
            $("#balancestock"+no).html(blancestck);
            $("#balancestockval"+no).html(blancestck);


            totalitemamount = parseFloat(purchaseprice) * parseFloat(qty);

            $('#itemtotalamt'+no).val(tofixed_amount(totalitemamount));
            
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

        
        $('#totalamount').val(tofixed_amount(totamount));
        
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
                                            
                                            <td>
                                            <input type="hidden" name="purchasepriceval[]" id="purchasepriceval`+itemno+`">
                                            <input type="text" readonly step="any" name="purchaseprice[]" id="purchaseprice`+itemno+`" style="width: 100px;"></td>
                                            
                                            <td><input type="text" readonly step="any" name="mrp[]" id="mrp`+itemno+`" style="width: 100px;"></td>

                                            
                                            
                                            <td>
                                                <input type="number" name="qty[]" id="qty`+itemno+`" onchange="calculateitemprice('`+itemno+`')" onkeyup="calculateitemprice('`+itemno+`')" style="width: 70px;"><span id="itemunitval`+itemno+`"></span>
                                                <br/>
                                                <input type="hidden" name="availablestck[]" id="availablestck`+itemno+`">
                                                <span style="font-size: 11px; color: #F00;">Stock: <span id="availstock`+itemno+`"></span><br/>
                                                <input type="hidden" name="balancestockval[]" id="balancestockval`+itemno+`">
                                                <span style="font-size: 11px; color: #F00;">Blnce: <span id="balancestock`+itemno+`"></span></span>
                                            </td>
                                            
                                            
                                            <td>
                                            <input type="text" readonly step="any" name="itemtotalamt[]" id="itemtotalamt`+itemno+`" style="width: 100px;">

                                               
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