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
                            
                            <a href="<?= base_url() ?>inventory/addproduct" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Products</button>
                            </a>

                            <a href="<?= base_url() ?>business/addsupplier" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Supplier</button>
                            </a>
                                
                        </div>
                        <h4 class="page-title">Purchase Order</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-2 dashoboardform">
                            <form action="<?= base_url() ?>purchase/addingpurchaseorder" method="POST" name="purchaseform" id="purchaseform">
                            <div class="row">
                                <div class="col-md-6">
                                    Bill No: <input type="text" name="billno" readonly value="<?= $billno ?>" class="inputfieldcss" style="width: 100px;">
                                </div>
                                <div class="col-md-6" align="right">
                                    <input type="date" name="purchasedate" value="<?= date('Y-m-d') ?>" class="inputfieldcss" style="width: 150px;">

                                    <input type="time" name="purchasetime" value="<?= date('H:i') ?>" class="inputfieldcss" style="width: 130px;">
                                    
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    Supplier Name
                                    <input type="hidden" name="supplierid" id="supplierid">
                                    <input type="text" name="supplier" required id="suppliertextbox" autocomplete="off" onkeyup="searchsupplierfun(this.value)" placeholder="Supplier Name" class="w-100 inputfieldcss">

                                    <div id="resultsressearch" class="secol dropdowndivstyle"><div class="secol" style="padding:5px;" id="serchreslt"></div></div>
                                </div>
                                <div class="col-md-3">
                                    Vehicle Number
                                    <input type="text" name="vehicleno" placeholder="Vehicle Number" class="w-100 inputfieldcss">
                                </div>
                                <div class="col-md-3">
                                    Invoice Number
                                    <input type="text" name="invoiceno" placeholder="Invoice Number" class="w-100 inputfieldcss">
                                </div>
                                <div class="col-md-3">
                                     Expected Delivery 
                                    <input type="date" name="expecteddelivery" class="w-100 inputfieldcss">
                                </div>
                            </div>

                            <div class="mt-3 table-responsive dashboarditems" >
                                <table class="table  w-100" cellspacing="0" cellspacing="0">
                                    <thead class="bg-gray-300">
                                        <tr>
                                            <th>#</th>
                                            <th>Product Id</th>
                                            <th>Product Name</th>
                                            <th>Qty</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemlistbody">
                                        <tr id="prdrow1">
                                            <td><span id="slno1">1</span></td>
                                            <td>
                                                <input type="hidden" name="productid[]" id="productid1">
                                                <input type="text" name="productcode[]" id="productcode1" onkeyup="searchproductcodefun(this.value, '1')" autocomplete="off" style="width: 150px;"><br/>
                                                <div id="resultproductcode1" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productcodeserchreslt1"></div></div>

                                                <div id="productitemdetailsdiv1" class="productitemdetailsdivstyle"></div>
                                            </td>
                                            <td>
                                                <input type="text" name="productname[]" id="productname1" onkeyup="searchproductnamefun(this.value, '1')" autocomplete="off"><br/>
                                                <div id="resultproduct1" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productserchreslt1"></div></div>
                                            </td>
                                            
                                            <td>
                                                <input type="number" name="qty[]" id="qty1" onchange="calculateitemprice('1')" onkeyup="calculateitemprice('1')" style="width: 100px;"><br/>
                                                <span style="font-size: 11px; color: #F00;">Stock: <span id="availstock1"></span></span>
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

                            <input type="hidden" name="totalgstamount" id="totalgstamount" value="0">

                            <table class="w-100 footrtable" cellspacing="5">
                                
                                <tr>
                                    <td align="right">Purchase Note: </td>
                                    <td colspan="3"><textarea name="purchasenote" placeholder="Purchase Note" class="w-100"></textarea></td>
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
                url : "<?= base_url() ?>purchase/searchproductcode",
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
                url : "<?= base_url() ?>purchase/searchproductname",
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
        if(exists == 1)
        {
            alert('Product already selected.');
        }
        else{

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

                  
                  $("#qty"+no).val('1');
                  

                  var prddet = 'Category: <b>' + result.pc_categoryname + '</b>, HSN: <b>' + result.pd_hsnno + '</b>, Unit: <b>' + result.un_unitname + '</b>';

                  $('#productitemdetailsdiv'+no).html(prddet);
                  
                  $("#availstock"+no).html(result.pd_stock);

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
                                        <input type="text" name="productcode[]" id="productcode`+itemno+`" onkeyup="searchproductcodefun(this.value, '`+itemno+`')" autocomplete="off" style="width: 150px;"><br/>
                                        <div id="resultproductcode`+itemno+`" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productcodeserchreslt`+itemno+`"></div></div>
                                        <div id="productitemdetailsdiv`+itemno+`" class="productitemdetailsdivstyle"></div>
                                    </td>
                                    <td>
                                        <input type="text" name="productname[]" id="productname`+itemno+`" onkeyup="searchproductnamefun(this.value, '`+itemno+`')" autocomplete="off"><br/>
                                        <div id="resultproduct`+itemno+`" class="secol tabledropdowndivstyle"><div class="secol" style="padding:5px;" id="productserchreslt`+itemno+`"></div></div>
                                    </td>
                                   
                                    <td>
                                        <input type="number" name="qty[]" id="qty`+itemno+`" onchange="calculateitemprice('`+itemno+`')" onkeyup="calculateitemprice('`+itemno+`')" style="width: 100px;"><br/>
                                        <span style="font-size: 11px; color: #F00;">Stock: <span id="availstock`+itemno+`"></span></span>
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