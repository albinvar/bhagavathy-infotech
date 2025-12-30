
<table class="table w-100 " >
    <thead>
        <tr>
            <th>#</th>
            <th>Material Code</th>
            <th>Material</th>
            
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
            $totamount =0;
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
                    <td><?= $ldgvl->pd_productname ?> <?= $ldgvl->pd_size ?> <?= $ldgvl->pd_brand ?></td>
                    
                    <td><?= $ldgvl->pms_unitprice ?></td>
                    <td><?= $ldgvl->pms_mrp ?></td>
                    <td><?= $ldgvl->pms_qty ?></td>
                    
                    <td><?php 
                    $totamount = $totamount + $ldgvl->pms_itemtotalamount;
                    echo $ldgvl->pms_itemtotalamount; ?></td>
                    
                </tr>
                <?php
                $k++;
            }
            ?>
            <tr>
                <th style="text-align: right;" colspan="6">Total Material Cost</th>
                <th><?= $totamount ?></th>
            </tr>
            <?php
        }
        ?>
        
        
    </tbody>
    
</table>

