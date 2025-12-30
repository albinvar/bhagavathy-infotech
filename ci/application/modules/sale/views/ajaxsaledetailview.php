<div class="row col-md-12">
    <div class="col-md-6">
        <table class="table w-100 " >
            <tr>
                <td>Bill No</td>
                <td><b>: <?= $details->rb_billprefix ?><?= $details->rb_billno ?></b></td>
            </tr>
            <tr>
                <td>Customer Name</td>
                <td>
                    <?php 
                    if($details->rb_existcustomer == 1)
                    {
                        
                        $cusname = $details->ct_name;
                        $phone = $details->ct_phone;
                    }else{
                    $cusname = $details->rb_customername;
                    $phone = $details->rb_phone;
                    
                    }
                    ?>
                    <b>: <?= $cusname ?></b></td>
            </tr>
            <tr>
                <td>Eway Bill No</td>
                <td><b>: <?= $details->rb_ewaybillno ?></b></td>
            </tr>
            <tr>
                <td>PO Details</td>
                <td><b>: <?= $details->rb_ponumber ?></b></td>
            </tr>
            <tr>
                <td>Discount </td>
                <td><b>: <?= $details->rb_discount ?></b></td>
            </tr>
            <tr>
                <td>Freight</td>
                <td><b>: <?= $details->rb_freight ?></b></td>
            </tr>

            <tr>
                <td>Old Balance</td>
                <td><b>: <?= $details->rb_oldbalance ?></b></td>
            </tr>
            <tr>
                <td>Paid Amount</td>
                <td><b>: <?= $details->rb_paidamount ?></b></td>
            </tr>
        
        </table>
    </div>
    <div class="col-md-6">
        <table class="table w-100 " >
            <tr>
                <td>Sale Date</td>
                <td><b>: <?= date('d-M-Y', strtotime($details->rb_date)) ?> <?= date('H:i', strtotime($details->rb_time)) ?></b></td>
            </tr>
            <tr>
                <td>Customer Phone</td>
                <td><b>: <?= $phone ?></b></td>
            </tr>
            <tr>
                <td>Vehicle No</td>
                <td><b>: <?= $details->rb_vehicleno ?></b></td>
            </tr>
            <tr>
                <td>Total Amount</td>
                <td><b>: <?= $details->rb_totalamount ?></b></td>
            </tr>
            <tr>
                <td>Grand Total</td>
                <td><b>: <?= $details->rb_grandtotal ?></b></td>
            </tr>
            
            <tr>
                <td>Total <?= $this->isvatgstname ?> Amount</td>
                <td><b>: <?= $details->rb_totalgstamnt ?></b></td>
            </tr>

            <tr>
                <td>Balance Amount</td>
                <td><b>: <?= $details->rb_balanceamount ?></b></td>
            </tr>
            <tr>
                <td>Payment Method</td>
                <td><b>: <?php 
                if($details->rb_paymentmethod ==4){echo "Cash";} 
                else if($details->rb_paymentmethod ==3){echo "Bank";}
                ?></b></td>
                
            </tr>
            
        </table>
    </div>

  <table class="table w-100 " >
            
        <tr>
            <td>Sale Note</td>
            <td><b>: <?= $details->rb_notes ?></b></td>
        </tr>
    </table>

    <?php
    if($details->rb_partialreturn == 1)
    {
        
            echo "<h4>Return</h4>";
        
        ?>
        <table class="table w-100 " >
            
            <tr>
                <td>Returned On</td>
                <td><b>: <?= date('d-M-Y H:i', strtotime($details->rb_returnedon)) ?></b></td>
            </tr>
            <tr>
                <td>Return Comment</td>
                <td><b>: <?= $details->rb_returncomment ?></b></td>
            </tr>
            <tr>
                <td>Return Amount</td>
                <td><b>: <?= $details->rb_returnamount ?></b></td>
            </tr>
        
        </table>
        <?php
    }
    ?>
</div>
