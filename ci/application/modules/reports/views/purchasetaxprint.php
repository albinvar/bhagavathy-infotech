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
                        <td>Purchase Tax Report<br/>
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
            <th width="20px" rowspan="2">#</th>
            <th rowspan="2">BillNo</th>
            <th rowspan="2">Bill Date</th>
            <th <?php if($this->isvatgst == 0){ ?> colspan="3" <?php } ?> class="text-center">Purchase</th>
            <th <?php if($this->isvatgst == 0){ ?> colspan="3" <?php } ?> class="text-center">Return</th>
        </tr>
        <tr>
            <?php if($this->isvatgst == 0){ ?>
                <th>CGST</th>
                <th>SGST</th>
                <th>IGST</th>
                <th>CGST</th>
                <th>SGST</th>
                <th>IGST</th>
            <?php }else{
                ?>
                <th style="text-align: center;">VAT</th>
                <th style="text-align: center;">VAT</th>
                <?php
            } ?>
        </tr>
    </thead>

    <tbody>
        <?php 
        $totalpcgst =0;
        $totalpsgst = 0;
        $totalpigst = 0;

        $totalrtcgst =0;
        $totalrtsgst = 0;
        $totalrtigst = 0;

        if($purchaselist)
        {
            $k=1;
            foreach($purchaselist as $stvl)
            {

                if(($stvl->sp_state == $businessdet->bu_state || $stvl->sp_state == '') || $businessdet->bu_country != '101')
                {
                    $pucgst = $stvl->pm_totalgstamount/2;
                    $pusgst = $stvl->pm_totalgstamount/2;
                    $puigst = 0;
                }else{
                    $pucgst = 0;
                    $pusgst = 0;
                    $puigst = $stvl->pm_totalgstamount;
                }
                $totalpcgst = $totalpcgst + $pucgst;
                $totalpsgst = $totalpsgst + $pusgst;
                $totalpigst = $totalpigst + $puigst;

                $rtcgst = 0;
                $rtsgst = 0;
                $rtigst = 0;
                if($stvl->pm_type == 2)
                {
                    if(($stvl->sp_state == $businessdet->bu_state || $stvl->sp_state == '') || $businessdet->bu_country != '101')
                    {
                        $rtcgst = $stvl->pm_totalgstamount/2;
                        $rtsgst = $stvl->pm_totalgstamount/2;
                        $rtigst = 0;
                    }else{
                        $rtcgst = 0;
                        $rtsgst = 0;
                        $rtigst = $stvl->pm_totalgstamount;
                    }
                }else{
                    if($stvl->pm_partialreturn == 1)
                    {
                        $retrndet = $this->purmstr->getpurchasereturndetails($stvl->pm_purchaseid);
                        if($retrndet)
                        {
                            if(($stvl->sp_state == $businessdet->bu_state || $stvl->sp_state == '') || $businessdet->bu_country != '101')
                            {
                                $rtcgst = $retrndet->pm_totalgstamount/2;
                                $rtsgst = $retrndet->pm_totalgstamount/2;
                                $rtigst = 0;
                            }else{
                                $rtcgst = 0;
                                $rtsgst = 0;
                                $rtigst = $retrndet->pm_totalgstamount;
                            }
                    
                        }
                    }
                    
                }

                $totalrtcgst = $totalrtcgst + $rtcgst;
                $totalrtsgst = $totalrtsgst + $rtsgst;
                $totalrtigst = $totalrtigst + $rtigst;
                ?>
                <tr>
                    <td><?= $k ?></td>
                    <td><?= $stvl->pm_purchaseprefix ?><?= $stvl->pm_purchaseno ?></td>
                    <td><?= date('d-M-Y', strtotime($stvl->pm_date)) ?> <?= date('H:i', strtotime($stvl->pm_time)) ?></td>

                    <?php if($this->isvatgst == 0){ ?>
                    <td><?= $pucgst ?></td>
                    <td><?= $pusgst ?></td>
                    <td><?= $puigst ?></td>
                    <td><?= $rtcgst ?></td>
                    <td><?= $rtsgst ?></td>
                    <td><?= $rtigst ?></td>
                    <?php 
                    }else{
                        ?>
                        <td align="center"><?= $puigst ?></td>
                        <td align="center"><?= $rtigst ?></td>
                        <?php
                    }
                    ?>
                    
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
            <?php if($this->isvatgst == 0){ ?>
            <th><?= $totalpcgst ?></th>
            <th><?= $totalpsgst ?></th>
            <th><?= $totalpigst ?></th>
            <th><?= $totalrtcgst ?></th>
            <th><?= $totalrtsgst ?></th>
            <th><?= $totalrtigst ?></th>
            <?php 
            }else{
                ?>
                <th style="text-align: center;"><?= $totalpigst ?></th>
                <th style="text-align: center;"><?= $totalrtigst ?></th>
                <?php
            }
            ?>
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