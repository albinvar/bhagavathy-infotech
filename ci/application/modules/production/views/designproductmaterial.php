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
                            
                            <a href="<?= base_url() ?>production/productdesign" class="ms-1">
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
                            <form action="<?= base_url() ?>production/designingproduct" method="POST" name="purchaseform" id="purchaseform">
                                <input type="hidden" name="designid" value="<?= $editid ?>">

                            

                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <label>Select Product*</label>
                                    <select name="mainproductid" id="mainproductid" required="required" class="w-100 inputfieldcss pagesearchselect" onchange="productselectfun()" data-toggle="select2">
                                        <option value="">Select Product</option>
                                        <?php 
                                        if($products)
                                        {
                                            foreach($products as $pdvl)
                                            {
                                                ?>
                                                <option <?php if(isset($editdata)){ if($editdata->pmd_productid == $pdvl->pd_productid){ echo "selected"; } } ?> value="<?= $pdvl->pd_productid ?>"><?= $pdvl->pd_productname ?> (<?= $pdvl->pd_productcode ?>)</option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                
                                <script type="text/javascript">
                                    function productselectfun()
                                    {
                                        var productid = $('#productid').select2();
                                    }
                                </script>


                            </div>

                            

                            <div class="mt-3 table-responsive dashboarditems" >
                                <table class="table  w-100" cellspacing="0" cellspacing="0">
                                    <thead class="bg-gray-300">
                                        <tr>
                                            <th>#</th>
                                            <th>Material Id</th>
                                            <th>Material Name</th>
                                            
                                            <th>Purchase Price</th>
                                            
                                            <th>MRP</th>
                                            
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
                                                <input type="hidden" value="<?= $editvl->pdm_materialid ?>" name="productid[]" id="productid<?= $itno ?>">
                                                <input type="text" value="<?= $editvl->pd_productcode ?>" name="productcode[]" id="productcode<?= $itno ?>" onkeyup="searchproductcodefun(this.value, '<?= $itno ?>')" title="1" class="productcodes" autocomplete="off" style="width: 100px;"><br/>
                                                <div id="resultproductcode<?= $itno ?>" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productcodeserchreslt<?= $itno ?>"></div></div>

                                                <div id="productitemdetailsdiv<?= $itno ?>" class="productitemdetailsdivstyle"></div>
                                            </td>
                                            <td>
                                                <?php
                                                $prdctname = $editvl->pd_productname . " " . $editvl->pd_size . " " . $editvl->pd_brand;
                                                ?>
                                                <input type="text" value="<?= htmlentities($prdctname) ?>" name="productname[]" id="productname<?= $itno ?>" onkeyup="searchproductnamefun(this.value, '<?= $itno ?>')" autocomplete="off"><br/>
                                                <div id="resultproduct<?= $itno ?>" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productserchreslt<?= $itno ?>"></div></div>
                                            </td>
                                            
                                            <td>
                                                <input type="hidden" name="purchasepriceval[]" value="<?= $editvl->pdm_rate ?>" id="purchasepriceval<?= $itno ?>">
                                                <input type="text" readonly step="any" value="<?= $editvl->pdm_unitprice ?>" name="purchaseprice[]" id="purchaseprice<?= $itno ?>" style="width: 100px;"></td>
                                            
                                            <td><input type="text" readonly step="any" value="<?= $editvl->pdm_mrp ?>" name="mrp[]" id="mrp<?= $itno ?>" style="width: 100px;"></td>
                                            
                                            <td>
                                                <input type="number" step="any" name="qty[]" value="<?= $editvl->pdm_qty ?>" id="qty<?= $itno ?>" onchange="calculateitemprice('<?= $itno ?>')" onkeyup="calculateitemprice('<?= $itno ?>')" style="width: 70px;"><span id="itemunitval<?= $itno ?>"></span>
                                                <br/><br/>
                                            </td>
                                            
                                            <td>
                                                <input type="text" readonly step="any" value="<?= $editvl->pdm_itemtotalamount ?>" name="itemtotalamt[]" id="itemtotalamt<?= $itno ?>" style="width: 100px;">
                                                
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
                                                <input type="number" step="any" name="qty[]" id="qty1" onchange="calculateitemprice('1')" onkeyup="calculateitemprice('1')" style="width: 70px;"><span id="itemunitval1"></span>
                                                <br/><br/>
                                            </td>
                                            
                                            
                                            <td>

                                                <input type="text" readonly step="any" name="itemtotalamt[]" id="itemtotalamt1" style="width: 100px;">
                                                
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
                            

                            
                            <table class="w-100 footrtable" cellspacing="5">
                                
                                <tr>
                                    <td align="right" width="20%"></td>
                                    <td align="right">Average Completion Time(In hrs)</td>
                                    <td><input type="number" step="any" name="averagetime" id="averagetime" value="<?php if(isset($editdata)){ echo $editdata->pmd_averagaetime; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                    <td align="right">Material Amount: </td>
                                    <td><input type="number" step="any" readonly name="totalamount" id="totalamount" value="<?php if(isset($editdata)){ echo $editdata->pmd_totalamount; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>

                                    <td align="right">Average Cost: </td>
                                    <td><input type="number" step="any" name="averagecost" id="averagecost" value="<?php if(isset($editdata)){ echo $editdata->pmd_averagecost; }else{ echo 0; } ?>" class="w-100 inputfieldcss"></td>
                                    
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
                url : "<?= base_url() ?>production/searchproductcode",
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
                url : "<?= base_url() ?>production/searchproductname",
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
    function selectproductdet(prdid, no)
    {
        var exists = 0;
        $('input[name^="productid"]').each(function() {
            if($(this).val() == prdid)
            {
                exists = 1;
            }
        });
        if(exists == 1)
        {
            alert('Product already selected.');
        }
        else{

            $('.tabledropdowndivstyle').hide();
            $.ajax({
                url : "<?= base_url() ?>production/getproductdetails",
                type: 'POST',
                dataType: 'JSON',
                data : {prodid : prdid},
            })
            .done(function(result) {
                  $('#productid'+no).val(result.pd_productid);
                  $("#productcode"+no).val(result.pd_productcode);
                  $("#productname"+no).val(result.pd_productname + ' ' + result.pd_size+ ' ' + result.pd_brand);

                  $('#batchno'+no).val(result.pt_batchno);
                  $('#expirydate'+no).val(result.pt_expirydate);
                 
                  $('#purchasepriceval'+no).val(result.pd_purchaseprice);

                  var gstamnt = (parseFloat(result.pd_purchaseprice) * parseFloat(result.tb_tax)/100);
                  var purchaseval = parseFloat(result.pd_purchaseprice) + parseFloat(gstamnt);

                  $("#purchaseprice"+no).val(tofixed_amount(purchaseval));

                  
                    $("#mrp"+no).val(result.pd_mrp);
                  

                  
                  $("#qty"+no).val('1');
                  
                  $("#itemtotalamt"+no).val(tofixed_amount(purchaseval));

                  $('#itemunitval'+no).html(result.un_unitname);

                  
                  var prddet = 'Category: <b>' + result.pc_categoryname + '</b>, HSN: <b>' + result.pd_hsnno + '</b>';

                  $('#productitemdetailsdiv'+no).html(prddet);
                  
                 
                                      
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
                                                <input type="number" step="any" name="qty[]" id="qty`+itemno+`" onchange="calculateitemprice('`+itemno+`')" onkeyup="calculateitemprice('`+itemno+`')" style="width: 70px;"><span id="itemunitval`+itemno+`"></span>
                                                <br/><br/>
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