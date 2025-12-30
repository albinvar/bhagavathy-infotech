
<table class="table w-100 " >
    <thead>
        <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Complaint</th>
        
            <th>Price</th>
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
                    <td><?= $ldgvl->sbs_productname ?></td>
                    <td><?= $ldgvl->sbs_complaint ?></td>
                    <td><?= $ldgvl->sbs_price ?></td>
                    
                </tr>
                <?php
                $k++;
            }
        }
        ?>
        
        
    </tbody>
    
</table>

