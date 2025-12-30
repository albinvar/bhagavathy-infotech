<html>
<title></title>
<head> 
<style>
body {
    display: block;
    margin: 0px;
	text-align:center;
}
table td
{
	height: 28mm;
    width: auto;
	font-size:9px;
	padding:6mm;
	border:1mm solid #fff;
}
@page
   {
    /*size: 79mm 112mm;*/
       width: 79mm;
   margin: 0;
  }
@media print{
	@page
   {
    /*size: 80mm 112mm;*/
       width: 83mm;
   margin: 0;
       padding-left: 8mm;
       padding-right: 8mm;
  }
	body {
		
    margin: 0;
}
.printButtonClass{display:none;}
table{width:100%;
    border-collapse: collapse;
}
table td
{
	height: 25mm;
    width: 38mm;
	font-size:8px;
	padding:3mm;
	border:1mm solid #fff;}
    
#barprint{
        position:fixed;
     bottom:0;
    padding-left: 7mm;
    padding-right: 6mm;
    }
    .bararea{
        margin-top: 4mm;
    }
}
    
</style></head>
<body onLoad="window.print()">

<?php 
$arr=0;
$k=1;
?>
<div id="barprint">
<table style="table-layout: fixed;">
<?php
if($productstockid)
{
	foreach($productstockid as $pid)
	{
		$prdctdet = $this->prdstck->getproductstockdetailbyid($pid);
	if(isset($productcount[$arr]))
  {
    
        if($prdctdet->pt_barcodevalue == "")
        {
          $data=[];
          $code = rand(10000, 99999).'-'.$pid;
          //load library
          $this->load->library('zend');
          //load in folder Zend
          $this->zend->load('Zend/Barcode');
          //generate barcode
          $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$code), array())->draw();
          imagepng($imageResource, 'uploads/barcodes/'.$code.'.png');

          $updacc = array(
              'pt_barcode'   => $code.'.png',
              'pt_barcodevalue' => $code
          );
          $insert_data = $this->prdstck->update($pid, $updacc, TRUE);

          $barcodeimg = $code.'.png';
        }else{
          $barcodeimg = $prdctdet->pt_barcode;
        }
        
	for($c=1;$c<=$productcount[$arr];$c++)
	{
	?>
	<td style="text-align:center;">
        <div class="bararea">
        <b style="font-size: 10px;"><?php echo $this->global_bu_name; ?></b><br><b>ITEM :<?php echo $prdctdet->pd_productname; ?></b><br><b  style="font-size: 10px;">PRICE :<?php echo $prdctdet->pd_retailprice; ?></b><br>

        
        <img width="85%" src="../uploads/barcodes/<?= $barcodeimg ?>" alt="Barcode" /><br>

        <b>CODE :<?php echo $prdctdet->pd_productcode; ?></b>&nbsp;&nbsp;<b>MRP :<?php echo $prdctdet->pd_mrp; ?></b>
        </div>
    </td>
		
	<?php if($k%2==0){echo "<tr>";} $k++; 
	
	}
	}
  $arr++;
}
}

?>
</table>
    </div>

</body>
</html>