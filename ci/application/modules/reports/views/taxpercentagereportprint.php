<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="icon" href="<?= assets_url() ?>assets/img/favicon.png" type="image/x-icon"/>
 <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>components/css/reportstyle.css">
 <style type="text/css">

  .page-footer-space {
    height: 40px;
    padding: 0px;

    margin-bottom: 0px;
  }
  .page-footer {
    height: 40px;
    position: fixed;
    bottom: 0;
    width: 96%;
    padding-top: 10px;
    margin-bottom: 0px;
    border-top: 1px #808080 solid;
    /*background: yellow; /* for demo */
  }

  @media print {
  .table-blue-fotter {
    
    
  }
}

  .page-header {
    height: 110px;
    width: 97%;
    margin-left: 5px;
    margin-top: 5px;

  }
  .page-header-space{
    height: 110px;
  }
  .billitemstr{
    font-size: 12px;
    min-height: 250px;
  }


  @page {
    margin: 0px;
    padding: 0px;
  }

  @page
   {
    size: A4;
  }
  </style>

</head>

<body style="-webkit-print-color-adjust: exact;">



<div class="page-header">
    <div style="width: 97%">
    <table border="0" width="98%" cellpadding="0" cellspacing="0">
        

        <tr>
            <td width="50%">
                <?php 
                if($this->bulogo != "")
                {
                    ?>
                <img src="<?= base_url() ?>uploads/business/<?= $this->bulogo ?>" height="95px" alt="user-image">
                <?php 
                }
                ?>
            </td>
            
            <td width="50%" align="right" style="font-size: font-size: 13px;">
                <table width="100%">
                    <tr valign="top">
                        <td>
                            <b><?= $businessdet->bu_unitname ?></b><br/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><?= $title ?><br/>
                            (<?= date('d-m-Y', strtotime($fromdate)) ?> - <?= date('d-m-Y', strtotime($todate)) ?>)
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
    </table>

    
    </div>
</div>

<div class="page-footer">
    <div align="center" style="font-size: 12px; ">
        <i><?= $businessdet->bu_address ?>, 
       <?= $this->isvatgstname ?> No: <b><?= $businessdet->bu_gstnumber ?></b></i></div>
</div>


<table width="100%">

    <thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td>
          <!--*** CONTENT GOES HERE ***-->

          <div class="page">



<table border="1" width="100%" style="border-collapse: collapse; font-size: 13px;" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th width="20px">#</th>
            <th>Tax Band</th>
            <th>Tax %</th>
            <!--<th>Total Qty</th>-->
            <th>Taxable Amt </th>
            <th>Tax Amt</th>
            <th>Total Amt</th>
            <?php if($this->isvatgst == 0){ ?>
            <th>CGST</th>
            <th>SGST</th>
            <th>IGST</th>
        <?php } ?>
        </tr>
        
    </thead>

    <tbody>
        <?php 
        $totalqty=0;
        $totaltaxableamt =0;
        $totaltaxamt = 0;
        $totalamount = 0;

        $totalcgst =0;
        $totalsgst = 0;
        $totaligst = 0;

        if($taxbands)
        {
            $k=1;
            foreach($taxbands as $txvl)
            {
                $prdcttot = $this->retlslv->gettaxvaluekeralasalesum($txvl->tb_tax, $type, $fromdate, $todate);
                $prdcttotcgst = $this->retlslv->gettaxvalueoutkeralasalesum($txvl->tb_tax, $type, $fromdate, $todate);
                ?>
                <tr>
                    <td><?= $k ?></td>
                    <td><?= $txvl->tb_taxband ?></td>
                    <td><?= $txvl->tb_tax ?></td>
                    <!--<td>
                        <?php 
                        $totalqty = $totalqty + $prdcttot->totqty + $prdcttotcgst->totqty;
                        echo $prdcttot->totqty + $prdcttotcgst->totqty;
                        ?>
                    </td>-->
                    <td>
                        <?php 
                        $totaltaxableamt = $totaltaxableamt + $prdcttot->totnet + $prdcttotcgst->totnet;
                        echo price_roundof($prdcttot->totnet + $prdcttotcgst->totnet);
                        ?>
                    </td>
                    <td>
                        <?php 
                        $totaltaxamt = $totaltaxamt + $prdcttot->totgst + $prdcttotcgst->totgst;
                        echo price_roundof($prdcttot->totgst + $prdcttotcgst->totgst);
                        ?>
                    </td>
                    <td>
                        <?php 
                        $totalamount = $totalamount + $prdcttot->totamnt + $prdcttotcgst->totamnt;
                        echo price_roundof($prdcttot->totamnt + $prdcttotcgst->totamnt);
                        ?>
                    </td>
                    <?php if($this->isvatgst == 0){ ?>
                    <td>
                        <?php 
                        $totalcgst = $totalcgst + ($prdcttot->totgst/2);
                        echo price_roundof($prdcttot->totgst/2);
                        ?>
                    </td>
                    <td>
                        <?php 
                        $totalsgst = $totalsgst + ($prdcttot->totgst/2);
                        echo price_roundof($prdcttot->totgst/2);
                        ?>
                    </td>
                    <td>
                        <?php 
                        $totaligst = $totaligst + ($prdcttotcgst->totgst);
                        echo price_roundof($prdcttotcgst->totgst);
                        ?>
                    </td>
                <?php } ?>
                </tr>
                <?php
                $k++;
            }
        }
        ?>
        
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" align="right" style="text-align: right;">Total</th>
            <!--<td><?= $totalqty ?></td>-->
            <th><?= price_roundof($totaltaxableamt) ?></th>
            <th><?= price_roundof($totaltaxamt) ?></th>
            
            <th><?= price_roundof($totalamount) ?></th>
            <?php if($this->isvatgst == 0){ ?>
            <th><?= price_roundof($totalcgst) ?></th>
            <th><?= price_roundof($totalsgst) ?></th>
            <th><?= price_roundof($totaligst) ?></th>
        <?php } ?>
        </tr>
    </tfoot>
</table>



</div>
</td>
</tr>
</tbody>

    <tfoot style="margin: 0px;">
      <tr>
        <td>
          <!--place holder for the fixed-position footer-->
          <div class="page-footer-space">
              
          </div>
        </td>
      </tr>
    </tfoot>
</table>

<script>
 window.print();
</script>
</body>

</html>