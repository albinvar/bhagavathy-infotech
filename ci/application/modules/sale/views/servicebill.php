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
                            <form action="<?= base_url() ?>sale/addingservicebill" method="POST" name="purchaseform" id="purchaseform">
                               
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
                                

                                
                                <div class="col-md-3 mt-2">
                                    <label>Date</label>
                                    <input type="date" name="billdate" class="w-100 inputfieldcss">
                                </div>
                                
                                

                            </div>

                            <div class="mt-3 table-responsive dashboarditems" >
                                <table class="table  w-100" cellspacing="0" cellspacing="0">
                                    <thead class="bg-gray-300">
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Complaint</th>
                                            
                                            <th width="150px">Price</th>
                                            <th width="50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemlistbody">
                                        <tr id="prdrow1">
                                            <td><span id="slno1">1</span></td>
                                            
                                            <td>
                                                <input type="text" name="productname[]" required="required" id="productname1" autocomplete="off">
                                            </td>
                                            
                                           <td>
                                                <input type="text" name="complaint[]" id="complaint1" autocomplete="off">
                                            </td>

                                            <td><input type="number" step="any" name="itemprice[]" id="itemprice1" onchange="calculateitemprice('1')" onkeyup="calculateitemprice('1')" ></td>
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
                                    <td align="right"></td>
                                    <td></td>
                                    <td align="right">Freight: </td>
                                    <td><input type="number" step="any" onchange="calculatetotalamnt()" onkeyup="calculatetotalamnt()" name="freight" id="freight" value="0" class="w-100 inputfieldcss"></td>
                                    <td align="right"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td align="right"></td>
                                    <td></td>
                                    <td align="right">Total Amount: </td>
                                    <td><input type="number" step="any" readonly name="totalamount" id="totalamount" value="0" class="w-100 inputfieldcss"></td>
                                    
                                </tr>
                                <tr>
                                    <td align="right"></td>
                                    <td></td>
                                    <td align="right">Grand Total: </td>
                                    <td><input type="number" step="any" readonly name="grandtotal" id="grandtotal" value="0" class="w-100 inputfieldcss"></td>
                                    
                                </tr>
                                <tr>
                                    <td align="right"></td>
                                    <td></td>
                                    
                                    
                                </tr>

                                <tr>
                                    <td align="right">Page Size</td>
                                    <td>
                                        <select class="w-100 inputfieldcss" name="pagesize" id="pagesize">
                                            <option value="1">A4</option>
                                            <option value="2">A5</option>
                                        </select>
                                    </td>
                                    <td align="right">Payment Method: </td>
                                    <td>
                                    <select class="w-100 inputfieldcss" name="paymethod" id="paymethod">
                                        <option value="1">Cash</option>
                                        <option value="2">Bank</option>
                                        <option value="3">UPI</option>
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
    

    function tofixed_amount(amnt)
    {
        var decml = <?= $this->decimalpoints ?>;
        return amnt.toFixed(decml);
    }

    
    
    
    function calculateitemprice(no)
    {
        var itemprice = $('#itemprice'+no).val();

        calculatetotalamnt();
        
    }
    function calculatetotalamnt()
    {
        var totamount = 0;

        $('input[name^="itemprice"]').each(function() {
            if($(this).val() != "")
            {
                totamount = parseFloat(totamount) + parseFloat($(this).val());
            }
        });
        var freight = $('#freight').val();
        //var grandtotal = $('#grandtotal').val();
        //var paidamount = $('#paidamount').val();
        //var balanceamnt = $('#balanceamnt').val();

        var grandtotal = parseFloat(freight) + parseFloat(totamount);

        var paidamount = parseFloat(grandtotal);
        
        $('#totalamount').val(tofixed_amount(totamount));
        $('#grandtotal').val(tofixed_amount(grandtotal));
    }

    

    
    var sln = 2;
    var itemno = 2;

    function addmoreitem()
    {
        $('#itemlistbody').append(`<tr id="prdrow`+itemno+`">
                                            <td><span id="slno`+sln+`">`+sln+`</span></td>
                                            <td>
                                                <input type="text" name="productname[]" required="required" id="productname`+itemno+`" autocomplete="off">
                                            </td>
                                           <td>
                                                <input type="text" name="complaint[]" id="complaint`+itemno+`" autocomplete="off">
                                            </td>
                                            <td><input type="number" step="any" name="itemprice[]" id="itemprice`+itemno+`" onchange="calculateitemprice('`+itemno+`')" onkeyup="calculateitemprice('`+itemno+`')" ></td>
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