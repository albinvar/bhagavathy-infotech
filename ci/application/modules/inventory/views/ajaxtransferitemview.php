
<table class="table w-100 " >
    <thead>
        <tr>
            <th>#</th>
            <th>Product Code</th>
            <th>Product</th>
            
            <th>Purchase Price</th>
            <th>MRP</th>
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
                    
                    <td><?= $ldgvl->sts_purchaseprice ?></td>
                    <td><?= $ldgvl->sts_mrp ?></td>
                    <td><?= $ldgvl->sts_qty ?></td>
                    
                    <td><?= $ldgvl->sts_totalprice ?></td>
                    
                </tr>
                <?php
                $k++;
            }
        }
        ?>
        
        
    </tbody>
    
</table>

