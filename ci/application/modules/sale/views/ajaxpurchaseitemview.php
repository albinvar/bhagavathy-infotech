
<table class="table w-100 " >
    <thead>
        <tr>
            <th>#</th>
            <th>Product Code</th>
            <th>Product</th>
            <th>Unit Price</th>
            <th>GST</th>
            <th>Discount</th>
            <th>Qty</th>
            
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php 
       
        if($itemdetails)
        {
            $k=1;
            foreach($itemdetails as $ldgvl)
            {
                ?>
                <tr>
                    <td>
                        <?= $k ?>
                    </td>
                    <td>
                        <?= $ldgvl->pd_productcode ?>
                    </td>
                    <td><?= $ldgvl->pd_productname ?></td>
                    <td><?= $ldgvl->ps_purchaseprice ?></td>
                    <td><?= $ldgvl->ps_gstamnt ?></td>
                    <td><?= $ldgvl->ps_discountamnt ?></td>

                    <td><?= $ldgvl->ps_qty ?></td>
                    <td><?= $ldgvl->ps_totalamount ?></td>
                </tr>
                <?php
                $k++;
            }
        }
        ?>
        
        
    </tbody>
    
</table>

