
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        

                        <div class="row">
                        <div class="col-12">
                            <div class="card mt-3 mb-0">
                                <div class="card-body">
                                    <div class="row mb-2">
                                    <div class="col-md-2">
                                        From Date:
                                        <input type="date" class="form-control" name="fromdate" id="fromdate" value="<?= $fromdate ?>">
                                    </div>
                                    <div class="col-md-2">
                                        To Date:
                                        <input type="date" class="form-control" name="todate" id="todate" value="<?= $todate ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" onclick="filterdashboardfun()" class="btn btn-blue" style="margin-top: 20px;">Filter</button>
                                    </div>
                                    </div>
                            </div>
                        </div>
                        </div>
                        </div>

                        <script type="text/javascript">
                            function filterdashboardfun()
                            {
                                var fromdate = $('#fromdate').val();
                                var todate = $('#todate').val();
                                window.location.href= '<?= base_url() ?>business/businessalalyticview/'+fromdate+'/'+todate;
                            }
                        </script>

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title"><?= $this->global_bu_name ?>, Business Analytics ( 
                                        <?php 
                                        if($fromdate == $todate){ echo date('d-M-Y', strtotime($fromdate)); }else{
                                            echo date('d-M-Y', strtotime($fromdate)) ." to ".date('d-M-Y', strtotime($todate));
                                        }
                                        ?>)
                                    </h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="card" id="tooltip-container">
                                    <div class="card-body">
                                        <!--<i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info"></i>-->
                                        <h4 class="mt-0 font-16">Total Sales</h4>
                                        <h2 class="text-primary my-3 text-center"><span data-plugin="counterup"><?= $salecnt ?></span></h2>
                                        <p class="text-muted mb-0">Total sale amount: <?= show_currency_amount($saledet->grandtotal) ?> <!--<span class="float-end"><i class="fa fa-caret-up text-success me-1"></i>10.25%</span>--></p>

                                        <?php 

    $txt='മൊത്തം വിൽപ്പന തുക '.$saledet->grandtotal.' രൂപ';
  $txt=htmlspecialchars($txt);
  $txt=rawurlencode($txt);
  $audio=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=ml-IN');
  $speech="<audio id='saleamntaudio' style='height:0px; padding:0px;' controls='controls' autoplay><source src='data:audio/mpeg;base64,".base64_encode($audio)."'></audio>";
  echo $speech;
                                        ?>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-md-6 col-xl-3">
                                <div class="card" id="tooltip-container">
                                    <div class="card-body">
                                        <!--<i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info"></i>-->
                                        <h4 class="mt-0 font-16">Total Profit</h4>
                                        <?php 
                                        $profit = $profitdet->totsale - $profitdet->totpurchase;
                                        ?>
                                        <h2 class="text-primary my-3 text-center"><?= show_currency_amount($profit) ?></h2>
                                        <p class="text-muted mb-0">Total sale amount: <?= show_currency_amount($saledet->grandtotal) ?> </p>
                                        <!--<p class="text-muted mb-0">Sale: <?= show_currency_amount($profitdet->totsale) ?>, Pur: <?= show_currency_amount($profitdet->totpurchase) ?> </p>-->

                                        <?php 

    $txt='മൊത്തം ലാഭ തുക '.$profit.' രൂപ';
  $txt=htmlspecialchars($txt);
  $txt=rawurlencode($txt);
  $audio=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=ml-IN');
  $speech="<audio id='profitamntaudio' style='height:0px; padding:0px;' controls='controls'><source src='data:audio/mpeg;base64,".base64_encode($audio)."'></audio>";
  echo $speech;
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-3">
                                <div class="card" id="tooltip-container">
                                    <div class="card-body">
                                        <!--<i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info"></i>-->
                                        <h4 class="mt-0 font-16">Total Tax Received</h4>
                                        <h2 class="text-primary my-3 text-center"><?= show_currency_amount($saledet->tottalgst) ?></h2>
                                        <p class="text-muted mb-0">Total sale amount: <?= show_currency_amount($saledet->grandtotal) ?> </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-3">
                                <div class="card" id="tooltip-container">
                                    <div class="card-body">
                                        <!--<i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info"></i>-->
                                        <h4 class="mt-0 font-16">Total Purchases</h4>
                                        <h2 class="text-primary my-3 text-center"><span data-plugin="counterup"><?= $purchasecnt ?></span></h2>
                                        <p class="text-muted mb-0">Total purchase: <?= show_currency_amount($purdet->grandtotal) ?> </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-3">
                                <div class="card" id="tooltip-container">
                                    <div class="card-body">
                                        <!--<i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info"></i>-->
                                        <h4 class="mt-0 font-16">Cash Balance</h4>
                                        <h2 class="text-primary my-3 text-center"><?= show_currency_amount($cashdebit-$cashcredit) ?></h2>
                                        <p class="text-muted mb-0">Dr: <?= show_currency_amount($cashdebit) ?><br/> Cr:  <?= show_currency_amount($cashcredit) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-3">
                                <div class="card" id="tooltip-container">
                                    <div class="card-body">
                                        <!--<i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info"></i>-->
                                        <h4 class="mt-0 font-16">Bank Balance</h4>
                                        <h2 class="text-primary my-3 text-center"><?= show_currency_amount($bankdebit-$bankcredit) ?></h2>
                                        <p class="text-muted mb-0">Dr: <?= show_currency_amount($bankdebit) ?><br/> Cr:  <?= show_currency_amount($bankcredit) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-3">
                                <div class="card" id="tooltip-container">
                                    <div class="card-body">
                                        <!--<i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info"></i>-->
                                        <h4 class="mt-0 font-16">Total Tax Paid</h4>
                                        <h2 class="text-primary my-3 text-center"><?= show_currency_amount($purdet->purchtotgst) ?></h2>
                                        <p class="text-muted mb-0">Total purchase: <?= show_currency_amount($purdet->grandtotal) ?> </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <div class="card" id="tooltip-container">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Fast Moving Items</h4>

                                        <div style="height: 490px; overflow-y: auto;">
                                        <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                            <thead>
                                                <th>Product</th>
                                                <th>Qty</th>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $fastitem1 = "Nothing";
                                                if($fastitems)
                                                {
                                                    $f=0;
                                                    foreach($fastitems as $fstvl)
                                                    {
                                                        if($f == 0)
                                                        {
                                                            $fastitem1 = $fstvl->pd_productname;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?= $fstvl->pd_productname ?></td>
                                                            <td><?= $fstvl->totqty ?></td>
                                                        </tr>
                                                        <?php
                                                        $f++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>

                                        <?php 


    $txt='ഫാസ്റ്റ് മൂവിംഗ് ഇനം ആണ് '.$fastitem1;
  $txt=htmlspecialchars($txt);
  $txt=rawurlencode($txt);
  $audio=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=ml-IN');
  $speech="<audio id='fastmovingaudio' style='height:0px; padding:0px;' controls='controls'><source src='data:audio/mpeg;base64,".base64_encode($audio)."'></audio>";
  echo $speech;

                                        ?>

                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6">
                                <div class="card" id="tooltip-container">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Slow Moving Items</h4>

                                        <div style="height: 490px; overflow-y: auto;">
                                        <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                            <thead>
                                                <th>Product</th>
                                                <th>Qty</th>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $slowitem1 = "";
                                                $pn=1;
                                                if($notsaleitems)
                                                {
                                                    foreach ($notsaleitems as $ntval) {
                                                        if($pn==1)
                                                        {
                                                            $slowitem1 = $ntval->pd_productname;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?= $ntval->pd_productname ?></td>
                                                            <td>0</td>
                                                        </tr>
                                                        <?php
                                                        $pn++;
                                                    }
                                                }
                                                if($pn < 10)
                                                {
                                                if($slowitems)
                                                {
                                                    foreach($slowitems as $slwvl)
                                                    {
                                                        if($pn==1)
                                                        {
                                                            $slowitem1 = $slwvl->pd_productname;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?= $slwvl->pd_productname ?></td>
                                                            <td><?= $slwvl->totqty ?></td>
                                                        </tr>
                                                        <?php
                                                        $pn++;
                                                        if($pn == 10)
                                                        {
                                                            break;
                                                        }
                                                    }
                                                }
                                                }
                                                ?>
                                            </tbody>
                                        </table>

                                        <?php 


    $txt='പതുക്കെ മൂവിംഗ് ഇനം ആണ് '.$slowitem1;
  $txt=htmlspecialchars($txt);
  $txt=rawurlencode($txt);
  $audio=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=ml-IN');
  $speech="<audio id='slowmovingaudio' style='height:0px; padding:0px;' controls='controls'><source src='data:audio/mpeg;base64,".base64_encode($audio)."'></audio>";
  echo $speech;

                                        ?>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                    </div> <!-- container -->

                </div> <!-- content -->


<script type="text/javascript">
var audio1 = document.getElementById("saleamntaudio");
audio1.onended = function() {
  //console.log('Playing background audio')
  var audio2 = document.getElementById("profitamntaudio");
  audio2.play();

  audio2.onended = function() {
    var audio3 = document.getElementById("fastmovingaudio");
    audio3.play();

    audio3.onended = function() {
        var audio4 = document.getElementById("slowmovingaudio");
        audio4.play();
      }
  }
};
</script>