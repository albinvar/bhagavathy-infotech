<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            
                            <!--<a href="<?= base_url() ?>purchase/dashboard" class="ms-1 finyearaddbutton">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Puchase</button>
                            </a>-->

                            <a href="<?= base_url() ?>reports/creditdebitb2breportcsv/<?= $fromdate ?>/<?= $todate ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-file-excel"></i> Export to CSV</button>
                            </a>

                            <a href="<?= base_url() ?>reports/creditdebitb2breportcsv/<?= $fromdate ?>/<?= $todate ?>/1"  target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-file"></i> Export to Json</button>
                            </a>

                            <a href="<?= base_url() ?>reports/creditdebitb2breport/<?= $fromdate ?>/<?= $todate ?>/1"  target="_blank" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fa fa-print"></i> Print</button>
                            </a>

                        </div>
                        <h4 class="page-title">Credit Note and Debit Note Report -B2B</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
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
                                    <button type="button" onclick="filterstockfun()" class="btn btn-blue" style="margin-top: 20px;">Filter</button>
                                </div>
                            </div>

                            <script type="text/javascript">
                                function filterstockfun()
                                {
                                    var fromdate = $('#fromdate').val();
                                    var todate = $('#todate').val();
                                    window.location.href= '<?= base_url() ?>reports/creditdebitb2breport/'+fromdate+'/'+todate;
                                }
                            </script>

                            <?php 
                            $totalgstamt =0;
                            $totaltaxableamnt = 0;
                            $totalamount = 0;
                            $invoices = array();
                            $invoicewithdate = array();
                            if($salelist)
                            {
                                foreach($salelist as $prvl)
                                {
                                    if($prvl->rbs_gstpercent != 0)
                                    {
                                    if(!in_array($prvl->rb_retailbillid, $invoices))
                                    {
                                        $invoices[] = $prvl->rb_retailbillid;
                                        ${"taxvalues".$prvl->rb_retailbillid} = array();

                                        $invoicewithdate[] = array('invoiceid' => $prvl->rb_retailbillid, 'date' => $prvl->rb_date);
                                    }

                                    if($prvl->rb_customerid == 0)
                                    {
                                        $customr = $prvl->rb_customername;
                                        $custmrgst = $prvl->rb_gstno;
                                    }else{
                                        $customr = $prvl->ct_name;
                                        $custmrgst = $prvl->ct_gstin;
                                    }
                                    //$billno = $prvl->rb_billprefix . $prvl->rb_billno;
                                    $billno = $prvl->rb_billno;
                                    $totaltaxableamnt = $totaltaxableamnt + $prvl->rbs_nettotal;
                                    $totalgstamt = $totalgstamt + $prvl->rbs_totalgst;
                                    $totalamount = $totalamount + $prvl->rbs_totalamount;
                                    $statecode = $prvl->name . "-".$prvl->statecode;

                                    if(!in_array($prvl->rbs_gstpercent, ${"taxvalues".$prvl->rb_retailbillid}))
                                    {
                                        ${"taxvalues".$prvl->rb_retailbillid}[] = $prvl->rbs_gstpercent;

                                        ${"taxableamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_nettotal;
                                        ${"totalamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_totalamount;
                                        ${"totalgst".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_totalgst;
                                        ${"cessamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_totalcess;

                                    }else{
                                        ${"taxableamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_nettotal + ${"taxableamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent};
                                        ${"totalamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_totalamount + ${"totalamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent};

                                        ${"totalgst".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_totalgst + ${"totalgst".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent};

                                        ${"cessamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rbs_totalcess + ${"cessamnt".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent};
                                    }

                                    ${"notetype".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = 'Debit';
                                    ${"statecode".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $statecode;
                                    ${"customername".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $customr;
                                    ${"customergst".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $custmrgst;
                                    ${"billno".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $billno;
                                    ${"billdate".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rb_date;
                                    }
                                }
                            }

                            if($purchaselist)
                            {
                                foreach($purchaselist as $purvl)
                                {
                                    if($purvl->ps_gstpercent != 0)
                                    {
                                    if(!in_array('p'.$purvl->pm_purchaseid, $invoices))
                                    {
                                        $invoices[] = 'p'.$purvl->pm_purchaseid;
                                        ${"taxvaluesp".$purvl->pm_purchaseid} = array();

                                        $invoicewithdate[] = array('invoiceid' => 'p'.$purvl->pm_purchaseid, 'date' => $purvl->pm_date);
                                    }

                                    
                                    //$billno = $prvl->rb_billprefix . $prvl->rb_billno;
                                    $billno = $purvl->pm_purchaseno;
                                    $totaltaxableamnt = $totaltaxableamnt + $purvl->ps_netamount;
                                    $totalgstamt = $totalgstamt + $purvl->ps_totalgst;
                                    $totalamount = $totalamount + $purvl->ps_totalamount;
                                    $statecode = $purvl->name . "-".$purvl->statecode;

                                    if(!in_array($purvl->ps_gstpercent, ${"taxvaluesp".$purvl->pm_purchaseid}))
                                    {
                                        ${"taxvaluesp".$purvl->pm_purchaseid}[] = $purvl->ps_gstpercent;

                                        ${"taxableamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->ps_netamount;
                                        ${"totalamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->ps_totalamount;
                                        ${"totalgstp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->ps_totalgst;
                                        ${"cessamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = 0;

                                    }else{
                                        ${"taxableamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->ps_netamount + ${"taxableamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent};
                                        ${"totalamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->ps_totalamount + ${"totalamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent};

                                        ${"totalgstp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->ps_totalgst + ${"totalgstp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent};

                                        ${"cessamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = 0 + ${"cessamntp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent};
                                    }

                                    ${"notetypep".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = 'Credit';
                                    ${"statecodep".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $statecode;
                                    ${"customernamep".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->sp_name;
                                    ${"customergstp".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->sp_gstno;
                                    ${"billnop".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $billno;
                                    ${"billdatep".$purvl->pm_purchaseid."-" . $purvl->ps_gstpercent} = $purvl->pm_date;
                                    }
                                }
                            }


                            ?>
                            <div align="right" style="padding: 10px; font-size: 15px; font-weight: bold;">
                                <table width="100%">
                                    <tr>
                                        <td>Total Taxable Value: <?= price_roundof($totaltaxableamnt) ?></td>
                                        <td>Total Tax: <?= price_roundof($totalgstamt) ?></td>
                                        <td>Total Amount: <?= price_roundof($totalamount) ?></td>
                                    </tr>
                                </table>
                            </div>
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>

                                    <tr>
                                        <th width="20px">#</th>
                                        <th>GSTIN</th>
                                        <th>Name of Recipient</th>
                                        <th>Note Number</th>
                                        <th>Note Date</th>
                                        <th>Note Type</th>
                                        <th>Place of Supply</th>
                                        <th>Note value</th>
                                        <th>Tax Percentage</th>
                                        <th>Taxable Value</th>
                                        <th>Cess Amt</th>
                                    </tr>
                                    
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    
                                    if($invoicewithdate)
                                    {
                                        usort($invoicewithdate, function($a, $b) { 
                                          return strtotime($a['date']) - strtotime($b['date']); 
                                        });
                                        $k=1;
                                        foreach($invoicewithdate as $indatevl)
                                        {
                                            $invl = $indatevl['invoiceid'];
                                            if(${"taxvalues".$invl})
                                            {
                                                foreach(${"taxvalues".$invl} as $taxvl)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?= $k ?></td>
                                                        <td><?= ${"customergst".$invl."-" . $taxvl} ?></td>
                                                        <td><?= ${"customername".$invl."-" . $taxvl} ?></td>
                                                        <td><?= ${"billno".$invl."-" . $taxvl} ?></td>
                                                        <td><?= date('d-m-Y', strtotime(${"billdate".$invl."-" . $taxvl})) ?></td>
                                                        
                                                        
                                                        <td><?= ${"notetype".$invl."-" . $taxvl} ?></td>
                                                        <td><?= ${"statecode".$invl."-" . $taxvl} ?></td>
                                                        <td><?= price_roundof(${"totalamnt".$invl."-" . $taxvl}) ?></td>
                                                        <td><?= $taxvl ?></td>
                                                        <td><?= price_roundof(${"taxableamnt".$invl."-" . $taxvl}) ?></td>
                                                        <!--<td><?= price_roundof(${"totalgst".$invl."-" . $taxvl}) ?></td>-->
                                                        <td><?= price_roundof(${"cessamnt".$invl."-" . $taxvl}) ?></td>
                                                        
                                                    </tr>
                                                    <?php
                                                    $k++;
                                                }
                                            }
                                            
                                        }
                                    }
                                    ?>
                                    
                                </tbody>
                                
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container -->

    </div> <!-- content -->
