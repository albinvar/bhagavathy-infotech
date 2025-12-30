
<table class="table w-100 " >
    <thead>
        <tr>
            <th>#</th>
            <th>Product Code</th>
            <th>Product</th>
            <th>Unit Price</th>
            
            <th><?= $this->isvatgstname ?></th>
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
                    <td><?= $ldgvl->pd_productname ?>
                        <?php 
                        if($remarkfield == 1 && $ldgvl->rbs_remarks != "")
                        {
                           echo '- ' . $ldgvl->rbs_remarks;
                        }
                        ?>
                    </td>
                    <td><?= $ldgvl->rbs_unitprice ?></td>
                    
                    <td><?= $ldgvl->rbs_gstamnt ?></td>
                    <td><?= $ldgvl->rbs_totaldiscount ?></td>
                    

                    <td><?= $ldgvl->rbs_qty ?></td>
                    <td><?= $ldgvl->rbs_totalamount ?></td>
                </tr>
                <?php
                $k++;
            }
        }
        ?>
        
        
    </tbody>
    
</table>

