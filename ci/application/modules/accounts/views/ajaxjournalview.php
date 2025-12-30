<div class="row col-md-12">
    <div class="col-md-6">
        Journal No: <b><?= $journaldet->je_journalnumber ?></b>
    </div>
    <div class="col-md-6" align="right">
        Date: <b><?= date('d-M-Y', strtotime($journaldet->je_date)) ?></b>
    </div>
</div>


<table class="table w-100 " >
    <thead>
        <tr>
            <th width="20%">Date</th>
            <th>Particular</th>
            <th>Description</th>
            <th width="14%">Credit/Debit</th>
            <th width="14%">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $totcredit = 0;
        $totdebit = 0;
        if($ledgerdet)
        {
            foreach($ledgerdet as $ldgvl)
            {
                ?>
                <tr>
                    <td>
                        <?= date('d-M-Y H:i', strtotime($ldgvl->le_date)) ?>
                    </td>
                    <td>
                        <?= $ldgvl->al_ledger ?>
                    </td>
                    <td><?= $ldgvl->le_note ?></td>
                    <td>
                        <?php 
                        if($ldgvl->le_isdebit == 1)
                        {
                            $totcredit = $totcredit + $ldgvl->le_amount;
                            ?>
                            <span class="badge bg-success">Credit</span>
                            <?php
                        }else{
                            $totdebit = $totdebit + $ldgvl->le_amount;
                            ?>
                            <span class="badge bg-danger">Debit</span>
                            <?php
                        }
                        ?>
                        
                    </td>
                    <td><?= $ldgvl->le_amount ?></td>
                </tr>
                <?php
            }
        }
        ?>
        
        
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2">Total</th>
            <th colspan="3" align="right">
                Total Credit: <?= $totcredit ?> &nbsp; &nbsp; &nbsp;
                Total Debit: <?= $totdebit ?>
            </th>
        </tr>
    </tfoot>
</table>

<div class="row col-md-12">
    <div class="col-md-6">
        Notes: <b><?= $journaldet->je_description ?></b>
    </div>
    <div class="col-md-6" align="right">
        Attachment: 
    </div>
</div>