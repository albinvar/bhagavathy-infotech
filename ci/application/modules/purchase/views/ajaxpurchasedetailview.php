<div class="row col-md-12">
    <div class="col-md-6">
        <table class="table w-100 " >
            <tr>
                <td>Bill No</td>
                <td><b>: <?= $details->pm_purchaseno ?></b></td>
            </tr>
            <tr>
                <td>Supplier</td>
                <td><b>: <?= $details->sp_name ?></b></td>
            </tr>
            <tr>
                <td>Invoice No</td>
                <td><b>: <?= $details->pm_invoiceno ?></b></td>
            </tr>
            <tr>
                <td>Discount </td>
                <td><b>: <?= $details->pm_discount ?></b></td>
            </tr>
            <tr>
                <td>Freight</td>
                <td><b>: <?= $details->pm_freight ?></b></td>
            </tr>

            <tr>
                <td>Old Balance</td>
                <td><b>: <?= $details->pm_oldbalance ?></b></td>
            </tr>
            <tr>
                <td>Paid Amount</td>
                <td><b>: <?= $details->pm_paidamount ?></b></td>
            </tr>
        
        </table>
    </div>
    <div class="col-md-6">
        <table class="table w-100 " >
            <tr>
                <td>Purchase Date</td>
                <td><b>: <?= date('d-M-Y', strtotime($details->pm_date)) ?> <?= date('H:i', strtotime($details->pm_time)) ?></b></td>
            </tr>
            <tr>
                <td>Vehicle No</td>
                <td><b>: <?= $details->pm_vehicleno ?></b></td>
            </tr>
            <tr>
                <td>Total Amount</td>
                <td><b>: <?= $details->pm_totalamount ?></b></td>
            </tr>
            <tr>
                <td>Grand Total</td>
                <td><b>: <?= $details->pm_grandtotal ?></b></td>
            </tr>
            
            <tr>
                <td>Total <?= $this->isvatgstname ?> Amount</td>
                <td><b>: <?= $details->pm_totalgstamount ?></b></td>
            </tr>

            <tr>
                <td>Balance Amount</td>
                <td><b>: <?= $details->pm_balanceamount ?></b></td>
            </tr>
            <tr>
                <td>Payment Method</td>
                <td><b>: <?php 
                if($details->pm_paymentmethod ==4){echo "Cash";} 
                else if($details->pm_paymentmethod ==3){echo "Bank";}
                ?></b></td>
                
            </tr>
            
        </table>
    </div>

    <div>
        <table class="table w-100 " >
            <tr>
                <td>Purchase Note</td>
                <td><b>: <?= $details->pm_purchasenote ?></b></td>
            </tr>
        </table>
    </div>

    <?php
    if($details->pm_type == 2 || $details->pm_partialreturn == 1)
    {
        if($details->pm_type == 2 && $details->pm_partialreturn == 0)
        {
            echo "<h4>Full Return</h4>";
        }else{
            echo "<h4>Partial Return</h4>";
        }
        ?>
        <table class="table w-100 " >
            
            <tr>
                <td>Returned On</td>
                <td><b>: <?= date('d-M-Y H:i', strtotime($details->pm_returnedon)) ?></b></td>
            </tr>
            <tr>
                <td>Return Comment</td>
                <td><b>: <?= $details->pm_returncomments ?></b></td>
            </tr>
            <tr>
                <td>Return Amount</td>
                <td><b>: <?= $details->pm_returnamount ?></b></td>
            </tr>
        
        </table>
        <?php
    }
    ?>
</div>
