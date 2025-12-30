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
                        <td><?= $title ?> Report<br/>
                          <?php 
                          if($salesperson != 'all')
                          {
                            echo "Sales Person: " . $salespersondet->at_name . '<br/>';
                          }
                          if($customer != 'all')
                          {
                            if($customer == '0')
                            {
                              echo "Walk in Customers <br/>";
                            }else{
                              echo "Customer: " . $customerdet->ct_name . '<br/>';
                            }
                          }
                          ?>
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
            <th rowspan="2">Customer</th>
            <th >Phone</th>
             <th >Item</th>
          
            <th rowspan="2">total</th>
            <th rowspan="2">Discount</th>

        </tr>
    </thead>

  <tbody>
              <?php 
              $alltotalamount =0;
              $alldiscount = 0;
              if($retaillist)
              {
                  $k=1;
                  foreach($retaillist as $stvl)
                  {
                      $billid=$stvl->rb_retailbillid;

                      $alltotalamount+= $stvl->rb_grandtotal;
                      $alldiscount+= $stvl->rb_discount;
                      ?>
                      <tr>
                          <td><?= $k ?></td>
                          <td><?= $stvl->rb_billprefix ?><?= $stvl->rb_billno ?></td>
                          <td><?= date('d-M-Y', strtotime($stvl->rb_date)) ?> <?= date('H:i', strtotime($stvl->rb_time)) ?></td>
                          <td>
                              <?php 
                          if($stvl->rb_existcustomer == 1)
                          {
                              $custdet = $this->cstmr->getcustomerdetailsbyid($stvl->rb_customerid);
                              // print_r($custdet);exit;
                              echo $custdet->ct_name;
                              $phone = $custdet->ct_phone;
                          }else{
                          echo $stvl->rb_customername;
                          $phone = $stvl->rb_phone;
                          
                          }
                          ?>
                          </td>
                         <td><?= $phone ?></td>
                          <td>
                              <?php
                               $itemdetails = $this->retlslv->getsaleproducts($billid);
                               if ($itemdetails) 
                                  {
                                   $n= 1;
                               foreach ($itemdetails as $product) 
                                  {
                                // print_r($itemdetails);exit;
                                  // echo $item_name=$product->pd_productname."<br>";
                                      echo $n . ". " .$product->pd_productname . ", <b>Unit Price:</b> " . price_roundof($product->rbs_unitprice) . ", <b>".$this->isvatgstname.":</b> " . price_roundof($product->rbs_gstamnt). ", <b> Discount:</b> " . price_roundof($product->rbs_totaldiscount).", <b>Qty:</b> " .price_roundof($product->rbs_qty). ", <b>Total:</b> " . price_roundof($product->rbs_totalamount) . "<br/>";
                                  $n++;
                              }
                          }
                               ?>
                          </td>

                  
                          <td><?= price_roundof($stvl->rb_grandtotal) ?></td>
                          
                          <td><?= price_roundof($stvl->rb_discount) ?></td>
                          
                        
                      </tr>
                      <?php
                      $k++;
                  }
              }
              ?>
              
          </tbody>
          <tfoot>
              <tr>
                  <th colspan="6" align="right" style="text-align: right;">Total</th>
                  <th style="text-align: right;"><?= price_roundof($alltotalamount) ?></th>
                  <?php 
                  if($type != 3){
                  ?>
                  <th><?= price_roundof($alldiscount) ?></th>
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