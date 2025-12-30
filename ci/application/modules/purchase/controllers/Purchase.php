<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Purchase extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('welcome/userauthentication_model', 'usersigin');
        $this->load->model('admin/business_model', 'bus');
        $this->load->model('admin/businessunit_model', 'busunt');
        $this->load->model('inventory/products_model', 'prdtmdl');
        $this->load->model('inventory/inventorysettings_model', 'invset');
        $this->load->model('inventory/productcategories_model', 'prdcat');

        $this->load->model('purchase/Purchasemaster_model', 'purmstr');
        $this->load->model('purchase/Purchaseslave_model', 'purslv');
        $this->load->model('purchase/Productstock_model', 'prdstck');

        ini_set('max_execution_time', 35000);
    }
    public function purchasehistory($type=0, $supplierid=0, $fromdate=0, $todate=0)
    {
        $this->load->model('business/suppliers_model', 'splr');

        if($type == 0)
        {
            $this->data['title'] = "Purchase History";
        }
        else{
            $this->data['title'] = "Purchase Orders";
        }

        $this->data['type'] = $type;
        $this->data['supplierid'] = $supplierid;
        $this->data['suppliers'] = $this->splr->getallsuppliers($this->buid);
        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-7 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['purchaselist'] = $this->purmstr->getpurchaselist($this->buid, $supplierid, $fromdate, $todate, $type);
        $this->load->template('purchasehistory', $this->data, FALSE);
    }
    public function purchaseorderhistory($fromdate=0, $todate=0)
    {
        $this->data['title'] = "Purchase Order History";
        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-7 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['purchaselist'] = $this->purmstr->getpurchaseorderlist($this->buid, $fromdate, $todate);
        $this->load->template('purchaseorderhistory', $this->data, FALSE);
    }
    public function purchasereturns($supplierid=0, $fromdate=0, $todate=0)
    {
        $this->load->model('business/suppliers_model', 'splr');

        $this->data['title'] = "Purchase Return History";

        $this->data['supplierid'] = $supplierid;
        $this->data['suppliers'] = $this->splr->getallsuppliers($this->buid);
        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-7 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['purchaselist'] = $this->purmstr->getpurchasereturnlist($this->buid, $supplierid, $fromdate, $todate);
        $this->load->template('purchasereturnhistory', $this->data, FALSE);
    }
    public function getbillitemdetails($type=0)
    {
        $billid = $this->input->post('billid');
        $this->data['type'] = $type;
        $this->data['itemdetails'] = $this->purslv->getpurchaseproducts($billid);
        $this->load->view('ajaxpurchaseitemview', $this->data);
    }
    public function getpurchasedetails($type=0)
    {
        $billid = $this->input->post('billid');
        $this->data['type'] = $type;
        $this->data['details'] = $this->purmstr->getpurchasedetailsbyid($billid);
        $this->load->view('ajaxpurchasedetailview', $this->data);
    }
    public function dashboard($type=0, $purchaseid = 0, $return=0)
    {
        $this->load->model('business/suppliers_model', 'splr');
        $this->load->model('inventory/godowns_model', 'gdwn');
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $this->data['billprintdet'] = $billprintdet = $this->blprnt->getbillprintdetails($this->buid);
        $this->data['type'] = $type;
        $this->data['godowns'] = $this->gdwn->getactiverows($this->buid);
        $this->data['return'] = $return;
        $this->data['purchaseid'] = $purchaseid;
        $this->data['billprefix'] = "";
        if($purchaseid != 0)
        {
            if($return == 0)
            {
                if($type == 1)
                {
                    $this->data['title'] = "Edit Purchase Order";
                    if($billprintdet)
                    {
                        $this->data['billprefix'] = $billprintdet->bp_purchaseorderprefix;
                    }
                }
                else{
                    $this->data['title'] = "Edit Purchase";
                    if($billprintdet)
                    {
                        $this->data['billprefix'] = $billprintdet->bp_purchasebillprefix;
                    }
                }
            }
            else{

                $this->data['title'] = "Purchase Return";  
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_purchasebillprefix;
                }
            }
            $this->data['editdata'] = $this->purmstr->getpurchasedetailsbyid($purchaseid);
            $this->data['edititems'] = $this->purslv->getpurchaseproducts($purchaseid);
        }else{
            if($type == 1)
            {
                $this->data['title'] = "Purchase Order";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_purchaseorderprefix;
                }
            }else{
                $this->data['title'] = "Purchase Billing";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_purchasebillprefix;
                }
            }
            
        }
        $this->data['billno'] = $this->purmstr->getnextpurchasebillno($this->buid, $type);

        $this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['maincategories'] = $this->prdcat->getmaincategories($this->buid);
        $this->data['productlist'] = $this->prdtmdl->getallrows($this->buid);

        if($type == 1)
        {
            $this->load->template('dashboard', $this->data, FALSE);
        }
        else{
            if($return == 0)
            {
                $this->load->template('dashboard', $this->data, FALSE);
            }else{
                $this->data['billprefix'] = $billprintdet->bp_purchasereturnprefix;
                $this->load->template('dashboardreturn', $this->data, FALSE);
            }
        }
    }
    public function confirmdashboard($type, $purchaseid)
    {
        $this->load->model('business/suppliers_model', 'splr');
        $this->load->model('inventory/godowns_model', 'gdwn');
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $this->data['billprintdet'] = $billprintdet = $this->blprnt->getbillprintdetails($this->buid);
        $this->data['type'] = $type;
        $this->data['godowns'] = $this->gdwn->getactiverows($this->buid);
        $this->data['return'] = 2;
        $this->data['poid'] = $purchaseid;
        $this->data['purchaseid'] = 0;
        $this->data['billprefix'] = "";

        $this->data['title'] = "Purchase Order Confirm";
        if($billprintdet)
        {
            $this->data['billprefix'] = $billprintdet->bp_purchasebillprefix;
        }
        $this->data['billno'] = $this->purmstr->getnextpurchasebillno($this->buid, $type);

        $this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['maincategories'] = $this->prdcat->getmaincategories($this->buid);
        $this->data['productlist'] = $this->prdtmdl->getallrows($this->buid);

        $this->data['oldbalance'] = 0;
        $this->data['editdata'] = $purchdet = $this->purmstr->getpurchasedetailsbyid($purchaseid);
        if($purchdet)
        {
            $suppblance = $this->splr->getsupplierbalance($purchdet->pm_supplierid);
            if($suppblance)
            {
                $this->data['oldbalance'] = $suppblance->sp_balanceamount;
            }
        }
        $this->data['edititems'] = $this->purslv->getpurchaseproducts($purchaseid);

        $this->load->template('dashboard', $this->data, FALSE);
    }
    /*public function addingpurchaseorder()
    {
        $billno = $this->input->post('billno');
        $purchasedate = date('Y-m-d', strtotime($this->input->post('purchasedate')));
        $purchasetime = date('H:i:s', strtotime($this->input->post('purchasetime')));
        $supplierid = $this->input->post('supplierid');
        $vehicleno = $this->input->post('vehicleno');
        $invoiceno = $this->input->post('invoiceno');
        $expecteddelivery = date('Y-m-d', strtotime($this->input->post('expecteddelivery')));

        $productid = $this->input->post('productid');
        $qty = $this->input->post('qty');

        $purchasenote = $this->input->post('purchasenote');

        $purchseid = $this->purmstr->insert(array(
            'pm_buid'       => $this->buid,
            'pm_finyearid'  => $this->finyearid,
            'pm_type'       => 1,
            'pm_purchaseno' => $billno,
            'pm_date'       => $purchasedate,
            'pm_time'       => $purchasetime,
            'pm_supplierid' => $supplierid,
            'pm_vehicleno'  => $vehicleno,
            'pm_invoiceno'  => $invoiceno,
            'pm_expecteddelivery' => $expecteddelivery,
            'pm_purchasenote' => $purchasenote,
            'pm_updatedon'  => $this->updatedon,
            'pm_updatedby'  => $this->loggeduserid,
        ), TRUE);

        if($purchseid)
        {
            $k=0;
            foreach($productid as $prvl)
            {
                if($prvl != "")
                {
                    $insrtslv = $this->purslv->insert(array(
                        'ps_buid'   => $this->buid,
                        'ps_finyearid'  => $this->finyearid,
                        'ps_type'       => 1,
                        'ps_purchaseid' => $purchseid,
                        'ps_productid'  => $prvl,
                        'ps_qty'        => $qty[$k],
                        'ps_updatedon'  => $this->updatedon,
                        'ps_updatedby'  => $this->loggeduserid
                    ), TRUE);
                }
                $k++;
            }

        $this->session->set_flashdata('messageS', 'Purchase Order Added Successfully.');
            redirect('purchase/purchaseorderprint/'.$purchseid.'/1');
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
            redirect('purchase/dashboard/1');
        }
    }*/
    public function addingpurchase()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');
        $this->load->model('business/suppliers_model', 'splr');

        $billprefix = $this->input->post('billprefix');
        $purchaseid = $this->input->post('purchaseid');
        $israwmaterial = $this->input->post('israwmaterial');
        $type = $this->input->post('type');
        $return = $this->input->post('return');
        $billno = $this->input->post('billno');
        $purchasedate = date('Y-m-d', strtotime($this->input->post('purchasedate')));
        $purchasetime = date('H:i:s', strtotime($this->input->post('purchasetime')));
        $daybookdate = $purchasedate . " " . $purchasetime;
        $supplierid = $this->input->post('supplierid');
        $vehicleno = $this->input->post('vehicleno');
        $invoiceno = $this->input->post('invoiceno');
        $invoicedate = date('Y-m-d', strtotime($this->input->post('invoicedate')));
        $godownid = $this->input->post('godownid');

        $productid = $this->input->post('productid');
        $batchno = $this->input->post('batchno');
        $expirydate = $this->input->post('expirydate');
        $purchaseprice = $this->input->post('purchaseprice');
        $mrp = $this->input->post('mrp');
        $gst = $this->input->post('gst');
        $itemgstval = $this->input->post('itemgstval');
        $discountper = $this->input->post('discountper');
        $discountamnt = $this->input->post('discountamnt');
        $unitprice = $this->input->post('unitprice');
        $qty = $this->input->post('qty');
        $itemnetamt = $this->input->post('itemnetamt');
        $itemgstamt = $this->input->post('itemgstamt');
        $itemtotalamt = $this->input->post('itemtotalamt');

        $totaldiscount = $this->input->post('totaldiscount');
        $freight = $this->input->post('freight');
        $freighttax = $this->input->post('freighttax');
        $freighttaxamount = $this->input->post('freighttaxamount');
        $roundoffvalue = $this->input->post('roundoffvalue');

        $totalamount = $this->input->post('totalamount');
        $oldbalance = $this->input->post('oldbalance');
        $grandtotal = $this->input->post('grandtotal');
        $paidamount = $this->input->post('paidamount');
        $paymethod = $this->input->post('paymethod');
        $balanceamnt = $this->input->post('balanceamnt');
        $purchasenote = $this->input->post('purchasenote');

        $totalgstamount = $this->input->post('totalgstamount');

        $oldqnty = $this->input->post('oldqnty');

        if($purchaseid == 0 || $purchaseid == "")
        {
            $editdet = 0;
            $purchseid = $this->purmstr->insert(array(
                'pm_buid'       => $this->buid,
                'pm_finyearid'  => $this->finyearid,
                'pm_type'       => $type,
                'pm_godownid'   => $godownid,
                'pm_purchaseprefix' => $billprefix,
                'pm_purchaseno' => $billno,
                'pm_date'       => $purchasedate,
                'pm_time'       => $purchasetime,
                'pm_supplierid' => $supplierid,
                'pm_vehicleno'  => $vehicleno,
                'pm_invoiceno'  => $invoiceno,
                'pm_invoicedate' => $invoicedate,
                'pm_discount'   => $totaldiscount,
                'pm_freight'    => $freight,
                'pm_freightgst' => $freighttax,
                'pm_freigtgstamnt' => $freighttaxamount,
                'pm_roundoffvalue' => $roundoffvalue,
                'pm_totalgstamount' => $totalgstamount,
                'pm_totalamount'=> $totalamount,
                'pm_grandtotal' => $grandtotal,
                'pm_oldbalance' => $oldbalance,
                'pm_paidamount' => $paidamount,
                'pm_balanceamount' => $balanceamnt,
                'pm_paymentmethod' => $paymethod,
                'pm_purchasenote' => $purchasenote,
                'pm_updatedon'  => $this->updatedon,
                'pm_updatedby'  => $this->loggeduserid,
                'pm_israwmaterial' => $israwmaterial
            ), TRUE);

            if($type == 1)
            {
                $flshmsg = "Purchase order added successfully.";
            }else{
                $flshmsg = "Purchase added successfully.";
            }
            

            $purchaseid = $purchseid;
        }
        else{
            $editdet = 1;
            $updacc = array(
                'pm_godownid'   => $godownid,
                'pm_purchaseprefix' => $billprefix,
                'pm_purchaseno' => $billno,
                'pm_type'       => $type,
                'pm_date'       => $purchasedate,
                'pm_time'       => $purchasetime,
                'pm_supplierid' => $supplierid,
                'pm_vehicleno'  => $vehicleno,
                'pm_invoiceno'  => $invoiceno,
                'pm_invoicedate' => $invoicedate,
                'pm_discount'   => $totaldiscount,
                'pm_freight'    => $freight,
                'pm_freightgst' => $freighttax,
                'pm_freigtgstamnt' => $freighttaxamount,
                'pm_roundoffvalue' => $roundoffvalue,
                'pm_totalgstamount' => $totalgstamount,
                'pm_totalamount'=> $totalamount,
                'pm_grandtotal' => $grandtotal,
                'pm_oldbalance' => $oldbalance,
                'pm_paidamount' => $paidamount,
                'pm_balanceamount' => $balanceamnt,
                'pm_paymentmethod' => $paymethod,
                'pm_purchasenote' => $purchasenote,
                'pm_updatedon'  => $this->updatedon,
                'pm_updatedby'  => $this->loggeduserid,
                'pm_israwmaterial' => $israwmaterial
            );
            $purchseid = $this->purmstr->update($purchaseid, $updacc, TRUE);

            if($type == 1)
            {
                $flshmsg = "Purchase order updated successfully.";
            }else{
                $flshmsg = "Purchase updated successfully.";
            }

            $oldpaidamount = $this->input->post('oldpaidamount');

            if($type != 1)
            {
                $purchaseprdcts = $this->purslv->getpurchaseproducts($purchaseid);
                if($purchaseprdcts)
                {
                    $updatestockdet = array();
                    $updateprdstockarr = array();
                    foreach($purchaseprdcts as $oldprdvl)
                    {
                        $oldprdid = $oldprdvl->ps_productid;
                        $oldqty = $oldprdvl->ps_qty;
                        $oldbatchno = $oldprdvl->ps_batchno;

                        $adprdctstck = $this->prdtmdl->reduceproductstock($oldprdid, $oldqty);
                        $updtestck = $this->prdstck->reduceproductstockbyid($oldprdvl->ps_productstockid, $oldqty);
                        
                    }
                }
                $deleteledgrentries = $this->ldgrentr->deleteoldpurchaseledgers($purchaseid);
            }
           
            $deleteitems = $this->purslv->deleteoldpurchaseitems($purchaseid);
            
        }


        if($purchseid)
        {
            // Confirm Purchase order
            if($return == 2)
            {
                $poid = $this->input->post('purchaseorderid');
                $updpoold = array(
                    'pm_postatus'   => 1,
                    'pm_confirmid' => $purchaseid
                );
                $purchseorderupdate = $this->purmstr->update($poid, $updpoold, TRUE);
            }

            if($type != 1)
            {
                if($editdet == 0)
                {
                    $updateoldbalance = $this->splr->update_status_by([
                        'sp_supplierid' => $supplierid
                    ], [
                        'sp_balanceamount' => $balanceamnt
                    ]);
                }else{
                    $previousbalanceamnt = $this->input->post('previousbalanceamnt');
                    
                    $supbalancedet = $this->splr->getsupplierbalance($supplierid);

                    if($balanceamnt > $previousbalanceamnt)
                    {
                        $newblanceamnt = $balanceamnt - $previousbalanceamnt;
                        $supplierbalance = $supbalancedet->sp_balanceamount + $newblanceamnt;
                    }
                    else{
                        $newblanceamnt = $previousbalanceamnt - $balanceamnt;
                        $supplierbalance = $supbalancedet->sp_balanceamount - $newblanceamnt;
                    }
                    

                    $updateoldbalance = $this->splr->update_status_by([
                        'sp_supplierid' => $supplierid
                    ], [
                        'sp_balanceamount' => $supplierbalance
                    ]);
                }
            }
            

            $k=0;
            foreach($productid as $prvl)
            {
                if($prvl != "")
                {
                    $batch = 0;
                    if(isset($batchno[$k]))
                    {
                        $batch = $batchno[$k];
                    }
                    $expiry = "";
                    if(isset($expirydate[$k]))
                    {
                        $expiry = date('Y-m-d', strtotime($expirydate[$k]));
                    }

                    $addedqty = $qty[$k];

                    if($type != 1)
                    {

                        $adprdctstck = $this->prdtmdl->addproductstock($prvl, $addedqty);
                        $prsstockdet = $this->prdstck->getproductstockdetails($this->buid, $prvl, $batch, $godownid);

                        $insert_prdctstockbatch = array();
                        if($prsstockdet)
                        {
                            $prdctstockid = $prsstockdet->pt_stockid;

                            $newstock = $prsstockdet->pt_stock + $addedqty;

                            $updtestck = $this->prdstck->update_status_by([
                                'pt_stockid' => $prdctstockid
                            ], [
                                'pt_purchaseprice' => $purchaseprice[$k],
                                'pt_mrp' => $mrp[$k],
                                'pt_expirydate' => $expiry,
                                'pt_stock' => $newstock
                            ]);

                            //$updtestck = $this->prdstck->addproductstockbyid($prdctstockid, $addedqty);
                        }else{
                            $prdctstockid = $this->prdstck->insert(array(
                                'pt_buid' => $this->buid,
                                'pt_productid' => $prvl,
                                'pt_batchno'  => $batch,
                                'pt_godownid' => $godownid,
                                'pt_supplierid' => $supplierid,
                                'pt_expirydate' => $expiry,
                                'pt_purchaseprice' => $purchaseprice[$k],
                                'pt_mrp' => $mrp[$k],
                                'pt_stock' => $addedqty
                            ), TRUE);
                        }
                    }

                    $insert_batch_data[] = array(
                        'ps_buid'   => $this->buid,
                        'ps_finyearid'  => $this->finyearid,
                        'ps_type'       => $type,
                        'ps_purchaseid' => $purchaseid,
                        'ps_productid'  => $prvl,
                        'ps_batchno'    => $batch,
                        'ps_expirydate' => $expiry,
                        'ps_purchaseprice' => $purchaseprice[$k],
                        'ps_mrp'        => $mrp[$k],
                        'ps_gstpercent' => $gst[$k],
                        'ps_gstamnt'    => $itemgstval[$k],
                        'ps_discountpercent' => $discountper[$k],
                        'ps_productstockid' => $prdctstockid,
                        'ps_discountamnt'  => $discountamnt[$k],
                        'ps_purchaserate' => $unitprice[$k],
                        'ps_qty'        => $qty[$k],
                        'ps_netamount'  => $itemnetamt[$k],
                        'ps_totalgst'   => $itemgstamt[$k],
                        'ps_totalamount' => $itemtotalamt[$k],
                        'ps_updatedon'  => $this->updatedon,
                        'ps_updatedby'  => $this->loggeduserid,
                        'ps_israwmaterial' => $israwmaterial
                    );

                    if($type != 1)
                    {
                        // Update product purchase price
                        $updateprdctprice = $this->prdtmdl->update_status_by([
                            'pd_productid' => $prvl
                        ], [
                            'pd_purchaseprice' => $purchaseprice[$k],
                            'pd_mrp' => $mrp[$k]
                        ]);
                    }

                }
                
                $k++;
            }

            $insertdrg = $this->purslv->insert_batch($insert_batch_data);
            
            

/**************** Account module connect start *********************/
        if($type != 1)
        {
            $freightamnt = $freight-$freighttaxamount;
            // Purchase account dr
            $purchaseamnt = $grandtotal-$totalgstamount-$freightamnt;
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, 5);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosing = $closamnt+$purchaseamnt;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $this->buid,
                'le_finyearid' => $this->finyearid,
                'le_ledgerid' => 5,
                'le_amount' => $purchaseamnt,
                'le_isdebit' => 0,
                'le_date' => $daybookdate,
                'le_closingamount' => $lastclosing,
                'le_issale' => 2,
                'le_salepurchaseid' => $purchaseid,
                'le_updatedby' => $this->loggeduserid,
                'le_updatedon' => $this->updatedon
            ], TRUE);

            //freight charges dr
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, 7);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosing = $closamnt+$freightamnt;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $this->buid,
                'le_finyearid' => $this->finyearid,
                'le_ledgerid' => 7,
                'le_amount' => $freightamnt,
                'le_isdebit' => 0,
                'le_date' => $daybookdate,
                'le_closingamount' => $lastclosing,
                'le_issale' => 2,
                'le_salepurchaseid' => $purchaseid,
                'le_updatedby' => $this->loggeduserid,
                'le_updatedon' => $this->updatedon
            ], TRUE);

            // Inward gst account dr
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, 6);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosingst = $closamnt+$totalgstamount;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $this->buid,
                'le_finyearid' => $this->finyearid,
                'le_ledgerid' => 6,
                'le_amount' => $totalgstamount,
                'le_isdebit' => 0,
                'le_date' => $daybookdate,
                'le_closingamount' => $lastclosingst,
                'le_issale' => 2,
                'le_salepurchaseid' => $purchaseid,
                'le_updatedby' => $this->loggeduserid,
                'le_updatedon' => $this->updatedon
            ], TRUE);

            // Cash/Bank account cr
            if($paidamount > 0)
            {
                $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $paymethod);
                if($lastledgr)
                {
                    $closamnt = $lastledgr->le_closingamount;
                }else{
                    $closamnt = 0;
                }
                $lastclosing = $closamnt-$paidamount;
                
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $this->buid,
                    'le_finyearid' => $this->finyearid,
                    'le_ledgerid' => $paymethod,
                    'le_amount' => $paidamount,
                    'le_isdebit' => 1,
                    'le_date' => $daybookdate,
                    'le_closingamount' => $lastclosing,
                    'le_issale' => 2,
                    'le_salepurchaseid' => $purchaseid,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon
                ], TRUE);
            }
            
            $getsuplierledgr = $this->accldgr->getsupplierledgerid($this->buid, $supplierid);
            if($getsuplierledgr)
            {
                $supledgrid=$getsuplierledgr->al_ledgerid;
            }else{
                $supledgrid = 0;
            }

            if($oldbalance > 0)
            {   
                // Sundry creditor Oldbalance paid dr
                if($oldbalance > $balanceamnt)
                {
                    $debitamnt = $oldbalance - $balanceamnt;

                    $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $supledgrid);
                    if($lastledgr)
                    {
                        $closamnt = $lastledgr->le_closingamount;
                    }else{
                        $closamnt = 0;
                    }
                    $lastclosing = $closamnt-$debitamnt;
                    
                    $insrt = $this->ldgrentr->insert([
                        'le_buid' => $this->buid,
                        'le_finyearid' => $this->finyearid,
                        'le_ledgerid' => $supledgrid,
                        'le_amount' => $debitamnt,
                        'le_isdebit' => 0,
                        'le_date' => $daybookdate,
                        'le_closingamount' => $lastclosing,
                        'le_issale' => 2,
                        'le_salepurchaseid' => $purchaseid,
                        'le_updatedby' => $this->loggeduserid,
                        'le_updatedon' => $this->updatedon
                    ], TRUE);
                }
            }

            // Sundry creditor new balance cr
            if($oldbalance < $balanceamnt)
            {
                $creditamnt = $balanceamnt - $oldbalance;

                $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $supledgrid);
                if($lastledgr)
                {
                    $closamnt = $lastledgr->le_closingamount;
                }else{
                    $closamnt = 0;
                }
                $lastclosing = $closamnt+$creditamnt;
                
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $this->buid,
                    'le_finyearid' => $this->finyearid,
                    'le_ledgerid' => $supledgrid,
                    'le_amount' => $creditamnt,
                    'le_isdebit' => 1,
                    'le_date' => $daybookdate,
                    'le_closingamount' => $lastclosing,
                    'le_issale' => 2,
                    'le_salepurchaseid' => $purchaseid,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon
                ], TRUE);
            }
        }
/****************** Account end ******************/

            $this->session->set_flashdata('messageS', $flshmsg);
            
            if($this->input->post('savesale') == 1)
            {
                if($israwmaterial == 1)
                {
                    redirect('rawmaterial/dashboard');
                }else{
                    redirect('purchase/dashboard');
                }
            }else{
                if($israwmaterial == 1)
                {
                    redirect('rawmaterial/purchaseprint/'.$purchaseid.'/'.$type.'/1');
                }else{
                    redirect('purchase/purchaseprint/'.$purchaseid.'/'.$type.'/1');
                }
            }
            
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
            if($israwmaterial == 1)
            {
                redirect('rawmaterial/dashboard');
            }else{
                redirect('purchase/dashboard');
            }
            
        }
    }

    public function addingpurchasereturn()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');
        $this->load->model('business/suppliers_model', 'splr');

        $purchaseid = $this->input->post('purchaseid');
        $billno = $this->input->post('billno');
        $purchasedate = date('Y-m-d', strtotime($this->input->post('purchasedate')));
        $purchasetime = date('H:i:s', strtotime($this->input->post('purchasetime')));

        $oldpurchasedate = date('Y-m-d H:i:s', strtotime($this->input->post('oldpurchasedate')));

        $supplierid = $this->input->post('supplierid');
        $vehicleno = $this->input->post('vehicleno');
        $invoiceno = $this->input->post('invoiceno');
        $invoicedate = date('Y-m-d', strtotime($this->input->post('invoicedate')));
        $godownid = $this->input->post('godownid');

        $productid = $this->input->post('productid');
        $batchno = $this->input->post('batchno');
        $expirydate = $this->input->post('expirydate');
        $purchaseprice = $this->input->post('purchaseprice');
        $mrp = $this->input->post('mrp');
        $gst = $this->input->post('gst');
        $itemgstval = $this->input->post('itemgstval');
        $discountper = $this->input->post('discountper');
        $discountamnt = $this->input->post('discountamnt');
        $unitprice = $this->input->post('unitprice');
        $qty = $this->input->post('qty');
        $itemnetamt = $this->input->post('itemnetamt');
        $itemgstamt = $this->input->post('itemgstamt');
        $itemtotalamt = $this->input->post('itemtotalamt');

        $totaldiscount = $this->input->post('totaldiscount');
        $freight = $this->input->post('freight');
        $totalamount = $this->input->post('totalamount');
        $oldbalance = $this->input->post('oldbalance');
        $grandtotal = $this->input->post('grandtotal');
        $paidamount = $this->input->post('paidamount');
        $paymethod = $this->input->post('paymethod');
        $balanceamnt = $this->input->post('balanceamnt');
        $purchasenote = $this->input->post('purchasenote');

        $totalgstamount = $this->input->post('totalgstamount');

        $oldqnty = $this->input->post('oldqnty');

        $israwmaterial = $this->input->post('israwmaterial');

        
        $editdet = 0;
        $nwpurchseid = $this->purmstr->insert(array(
            'pm_buid'       => $this->buid,
            'pm_finyearid'  => $this->finyearid,
            'pm_godownid'   => $godownid,
            'pm_purchaseno' => $billno,
            'pm_type'       => 2,
            'pm_date'       => $purchasedate,
            'pm_time'       => $purchasetime,
            'pm_supplierid' => $supplierid,
            'pm_vehicleno'  => $vehicleno,
            'pm_invoiceno'  => $invoiceno,
            'pm_invoicedate' => $invoicedate,
            'pm_discount'   => $totaldiscount,
            'pm_freight'    => $freight,
            'pm_totalgstamount' => $totalgstamount,
            'pm_totalamount'=> $totalamount,
            'pm_grandtotal' => $grandtotal,
            'pm_oldbalance' => $oldbalance,
            'pm_paidamount' => $paidamount,
            'pm_balanceamount' => $balanceamnt,
            'pm_paymentmethod' => $paymethod,
            'pm_returncomments' => $purchasenote,
            'pm_returnamount' => $paidamount,
            'pm_updatedon'  => $this->updatedon,
            'pm_updatedby'  => $this->loggeduserid,
            'pm_returnedon'  => $this->updatedon,
            'pm_returnedby'  => $this->loggeduserid,
            'pm_partialreturn' => 1,
            'pm_returnid' => $purchaseid,
            'pm_israwmaterial' => $israwmaterial
        ), TRUE);

        // Update old purchase 
        $updacc = array(
            'pm_partialreturn'   => 1,
            'pm_returncomments' => $purchasenote,
            'pm_returnamount'       => $paidamount,
            'pm_returnedon'  => $this->updatedon,
            'pm_returnedby'  => $this->loggeduserid,
        );
        $purchseid = $this->purmstr->update($purchaseid, $updacc, TRUE);

        $flshmsg = "Purchase returned successfully.";

        $purchaseid = $nwpurchseid;
        
        

        if($nwpurchseid)
        {
            $updateoldbalance = $this->splr->update_status_by([
                'sp_supplierid' => $supplierid
            ], [
                'sp_balanceamount' => $balanceamnt
            ]);
            

            $k=0;
            foreach($productid as $prvl)
            {
                if($prvl != "")
                {
                    $batch = 0;
                    if(isset($batchno[$k]))
                    {
                        $batch = $batchno[$k];
                    }
                    $expiry = "";
                    if(isset($expirydate[$k]))
                    {
                        $expiry = date('Y-m-d', strtotime($expirydate[$k]));
                    }

                    $addedqty = $qty[$k];

                    $adprdctstck = $this->prdtmdl->reduceproductstock($prvl, $addedqty);
                    $prsstockdet = $this->prdstck->getproductstockdetails($this->buid, $prvl, $batch, $godownid);

                    $insert_prdctstockbatch = array();
                    if($prsstockdet)
                    {
                        $prdctstockid = $prsstockdet->pt_stockid;
                        $updtestck = $this->prdstck->reduceproductstockbyid($prdctstockid, $addedqty);
                    }


                    $insert_batch_data[] = array(
                        'ps_buid'   => $this->buid,
                        'ps_finyearid'  => $this->finyearid,
                        'ps_purchaseid' => $purchaseid,
                        'ps_productid'  => $prvl,
                        'ps_batchno'    => $batch,
                        'ps_expirydate' => $expiry,
                        'ps_purchaseprice' => $purchaseprice[$k],
                        'ps_mrp'        => $mrp[$k],
                        'ps_gstpercent' => $gst[$k],
                        'ps_gstamnt'    => $itemgstval[$k],
                        'ps_discountpercent' => $discountper[$k],
                        'ps_productstockid' => $prdctstockid,
                        'ps_discountamnt'  => $discountamnt[$k],
                        'ps_purchaserate' => $unitprice[$k],
                        'ps_qty'        => $qty[$k],
                        'ps_netamount'  => $itemnetamt[$k],
                        'ps_totalgst'   => $itemgstamt[$k],
                        'ps_totalamount' => $itemtotalamt[$k],
                        'ps_updatedon'  => $this->updatedon,
                        'ps_updatedby'  => $this->loggeduserid,
                        'ps_israwmaterial' => $israwmaterial
                    );

                    
                    // Update product purchase price
                    /*$updateprdctprice = $this->prdtmdl->update_status_by([
                        'pd_productid' => $prvl
                    ], [
                        'pd_purchaseprice' => $purchaseprice[$k],
                        'pd_mrp' => $mrp[$k]
                    ]);*/

                }
                
                $k++;
            }

            $insertdrg = $this->purslv->insert_batch($insert_batch_data);
            
            
/**************** Account module connect start *********************/
            // Purchase account cr
            $purchaseamnt = $grandtotal-$totalgstamount;
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, 5);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosing = $closamnt+$purchaseamnt;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $this->buid,
                'le_finyearid' => $this->finyearid,
                'le_ledgerid' => 5,
                'le_amount' => $purchaseamnt,
                'le_isdebit' => 1,
                'le_date' => $this->updatedon,
                'le_closingamount' => $lastclosing,
                'le_issale' => 2,
                'le_salepurchaseid' => $purchaseid,
                'le_updatedby' => $this->loggeduserid,
                'le_updatedon' => $this->updatedon
            ], TRUE);

            // Inward gst account cr
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, 6);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosingst = $closamnt+$totalgstamount;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $this->buid,
                'le_finyearid' => $this->finyearid,
                'le_ledgerid' => 6,
                'le_amount' => $totalgstamount,
                'le_isdebit' => 1,
                'le_date' => $this->updatedon,
                'le_closingamount' => $lastclosingst,
                'le_issale' => 2,
                'le_salepurchaseid' => $purchaseid,
                'le_updatedby' => $this->loggeduserid,
                'le_updatedon' => $this->updatedon
            ], TRUE);

            // Cash/Bank account dr
            if($paidamount > 0)
            {
                $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $paymethod);
                if($lastledgr)
                {
                    $closamnt = $lastledgr->le_closingamount;
                }else{
                    $closamnt = 0;
                }
                $lastclosing = $closamnt-$paidamount;
                
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $this->buid,
                    'le_finyearid' => $this->finyearid,
                    'le_ledgerid' => $paymethod,
                    'le_amount' => $paidamount,
                    'le_isdebit' => 0,
                    'le_date' => $this->updatedon,
                    'le_closingamount' => $lastclosing,
                    'le_issale' => 2,
                    'le_salepurchaseid' => $purchaseid,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon
                ], TRUE);
            }
            
            $getsuplierledgr = $this->accldgr->getsupplierledgerid($this->buid, $supplierid);
            if($getsuplierledgr)
            {
                $supledgrid=$getsuplierledgr->al_ledgerid;
            }else{
                $supledgrid = 0;
            }

            

            if($oldbalance > 0)
            { 
                // Sundry creditor Oldbalance paid dr
                if($oldbalance > $balanceamnt)
                {
                    if($balanceamnt < 0)
                    {
                        $balanceamnt = abs($balanceamnt);
                        $debitamnt = $oldbalance + $balanceamnt;
                    }else{
                        $debitamnt = $oldbalance - $balanceamnt;
                    }
                    

                    $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $supledgrid);
                    if($lastledgr)
                    {
                        $closamnt = $lastledgr->le_closingamount;
                    }else{
                        $closamnt = 0;
                    }
                    $lastclosing = $closamnt-$debitamnt;
                    
                    $insrt = $this->ldgrentr->insert([
                        'le_buid' => $this->buid,
                        'le_finyearid' => $this->finyearid,
                        'le_ledgerid' => $supledgrid,
                        'le_amount' => $debitamnt,
                        'le_isdebit' => 0,
                        'le_date' => $this->updatedon,
                        'le_closingamount' => $lastclosing,
                        'le_issale' => 2,
                        'le_salepurchaseid' => $purchaseid,
                        'le_updatedby' => $this->loggeduserid,
                        'le_updatedon' => $this->updatedon
                    ], TRUE);
                }
            }

            // Sundry creditor new balance cr
            if($oldbalance < $balanceamnt)
            {
                $creditamnt = $balanceamnt - $oldbalance;

                $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $supledgrid);
                if($lastledgr)
                {
                    $closamnt = $lastledgr->le_closingamount;
                }else{
                    $closamnt = 0;
                }
                $lastclosing = $closamnt+$creditamnt;
                
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $this->buid,
                    'le_finyearid' => $this->finyearid,
                    'le_ledgerid' => $supledgrid,
                    'le_amount' => $creditamnt,
                    'le_isdebit' => 1,
                    'le_date' => $this->updatedon,
                    'le_closingamount' => $lastclosing,
                    'le_issale' => 2,
                    'le_salepurchaseid' => $purchaseid,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon
                ], TRUE);
            }

/****************** Account end ******************/

            $this->session->set_flashdata('messageS', $flshmsg);

            if($israwmaterial == 1)
            {
                redirect('rawmaterial/purchasereturnprint/'.$purchaseid.'/'.$type.'/1');
            }else{
                redirect('purchase/purchasereturnprint/'.$purchaseid.'/'.$type.'/1');
            }

            //redirect('purchase/purchasereturnprint/'.$purchaseid.'/1');
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));

            if($israwmaterial == '1')
            {
                redirect('rawmaterial/purchasehistory');
            }else{
                redirect('purchase/purchasereturns');
            }
            
        }
    }

    public function returnpurchase()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');
        $this->load->model('business/suppliers_model', 'splr');

        $returnbillid = $this->input->post('returnbillid');
        $returndate = date('Y-m-d', strtotime($this->input->post('returndate')));
        $returntime = date('H:i:s', strtotime($this->input->post('returntime')));
        $returndatetime = $returndate . " " . $returntime;
        $returncomments = $this->input->post('returncomments');

        $returnpaidamount = $this->input->post('returnpaidamount');
        $paymethod = $this->input->post('paymethod');

        $purchdet = $this->purmstr->getpurchasedetailsbyid($returnbillid);

        $updacc = array(
            'pm_type' => 2,
            'pm_returncomments' => $returncomments,
            'pm_returnedon'  => $returndatetime,
            'pm_returnedby'  => $this->loggeduserid,
            'pm_returnamount' => $returnpaidamount
        );
        $purchseid = $this->purmstr->update($returnbillid, $updacc, TRUE);

        $flshmsg = "Purchase returned successfully.";

        // Stock reduced
        $purchaseprdcts = $this->purslv->getpurchaseproducts($returnbillid);
        if($purchaseprdcts)
        {
            $updatestockdet = array();
            $updateprdstockarr = array();
            foreach($purchaseprdcts as $oldprdvl)
            {
                $oldprdid = $oldprdvl->ps_productid;
                $oldqty = $oldprdvl->ps_qty;
                $oldbatchno = $oldprdvl->ps_batchno;

                $updateprchslavearr[] = array(
                    'ps_purchaseslaveid' => $oldprdvl->ps_purchaseslaveid,
                    'ps_type' => 2
                );

                $updateprdstockarr[] = array(
                    'pd_productid' => $oldprdid,
                    'pd_stock' => 'pd_stock-'. $oldqty
                );

                $updatestockdet[] = array(
                    'pt_stockid' => $oldprdvl->ps_productstockid,
                    'pt_stock' => 'pt_stock-'.$oldqty
                );
            }
            $oldpurchslve = $this->purslv->update_batch($updateprchslavearr);
            $oldredprdctstck = $this->prdtmdl->update_batch($updateprdstockarr);
            $oldredprsstockdet = $this->prdstck->update_batch($updatestockdet);
        }

        //supplier balance update 
        $grandtotal = $purchdet->pm_grandtotal;
        $paidamount = $purchdet->pm_paidamount;
        $supplierid = $purchdet->pm_supplierid;

        $totalgstamount = $purchdet->pm_totalgstamount;

        $supbalancedet = $this->splr->getsupplierbalance($supplierid);
        $supplierbalance = $supbalancedet->sp_balanceamount - $grndtotal + $returnpaidamount;

        $updateoldbalance = $this->splr->update_status_by([
            'sp_supplierid' => $supplierid
        ], [
            'sp_balanceamount' => $supplierbalance
        ]);


/**************** Account module connect start *********************/
            // Purchase account cr (opposite)
            $purchaseamnt = $grandtotal-$totalgstamount;
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, 5);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosing = $closamnt-$purchaseamnt;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $this->buid,
                'le_finyearid' => $this->finyearid,
                'le_ledgerid' => 5,
                'le_amount' => $purchaseamnt,
                'le_isdebit' => 1,
                'le_date' => $this->updatedon,
                'le_closingamount' => $lastclosing,
                'le_note' => 'Purchase Return',
                'le_issale' => 2,
                'le_salepurchaseid' => $returnbillid,
                'le_updatedby' => $this->loggeduserid,
                'le_updatedon' => $this->updatedon
            ], TRUE);

            // Inward gst account dr
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, 6);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosingst = $closamnt-$totalgstamount;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $this->buid,
                'le_finyearid' => $this->finyearid,
                'le_ledgerid' => 6,
                'le_amount' => $totalgstamount,
                'le_isdebit' => 1,
                'le_note' => 'Purchase Return',
                'le_date' => $this->updatedon,
                'le_closingamount' => $lastclosingst,
                'le_issale' => 2,
                'le_salepurchaseid' => $returnbillid,
                'le_updatedby' => $this->loggeduserid,
                'le_updatedon' => $this->updatedon
            ], TRUE);

            
            // Cash/Bank account cr
            if($returnpaidamount > 0)
            {
                $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $paymethod);
                if($lastledgr)
                {
                    $closamnt = $lastledgr->le_closingamount;
                }else{
                    $closamnt = 0;
                }
                $lastclosing = $closamnt+$returnpaidamount;
                
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $this->buid,
                    'le_finyearid' => $this->finyearid,
                    'le_ledgerid' => $paymethod,
                    'le_amount' => $returnpaidamount,
                    'le_isdebit' => 0,
                    'le_date' => $this->updatedon,
                    'le_closingamount' => $lastclosing,
                    'le_note' => 'Purchase Return',
                    'le_issale' => 2,
                    'le_salepurchaseid' => $returnbillid,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon
                ], TRUE);
            }
            
            $getsuplierledgr = $this->accldgr->getsupplierledgerid($this->buid, $supplierid);
            if($getsuplierledgr)
            {
                $supledgrid=$getsuplierledgr->al_ledgerid;
            }else{
                $supledgrid = 0;
            }

           // $newbalance = $grandtotal - $returnpaidamount;

             
            // Sundry creditor update
            if($grandtotal > $returnpaidamount)
            {
                $debitamnt = $grandtotal - $returnpaidamount;

                $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $supledgrid);
                if($lastledgr)
                {
                    $closamnt = $lastledgr->le_closingamount;
                }else{
                    $closamnt = 0;
                }
                $lastclosing = $closamnt-$debitamnt;
                
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $this->buid,
                    'le_finyearid' => $this->finyearid,
                    'le_ledgerid' => $supledgrid,
                    'le_amount' => $debitamnt,
                    'le_isdebit' => 0,
                    'le_date' => $this->updatedon,
                    'le_closingamount' => $lastclosing,
                    'le_issale' => 2,
                    'le_note' => 'Purchase Return',
                    'le_salepurchaseid' => $returnbillid,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon
                ], TRUE);
            }
            

            // Sundry creditor new balance cr
            if($grandtotal < $returnpaidamount)
            {
                $creditamnt = $returnpaidamount - $grandtotal;

                $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $supledgrid);
                if($lastledgr)
                {
                    $closamnt = $lastledgr->le_closingamount;
                }else{
                    $closamnt = 0;
                }
                $lastclosing = $closamnt+$creditamnt;
                
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $this->buid,
                    'le_finyearid' => $this->finyearid,
                    'le_ledgerid' => $supledgrid,
                    'le_amount' => $creditamnt,
                    'le_isdebit' => 1,
                    'le_date' => $this->updatedon,
                    'le_closingamount' => $lastclosing,
                    'le_issale' => 2,
                    'le_note' => 'Purchase Return',
                    'le_salepurchaseid' => $returnbillid,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon
                ], TRUE);
            }
                
            
/****************** Account end ******************/
        $this->session->set_flashdata('messageS', 'Purchase returned successfully.');
        redirect('purchase/purchasereturns');
    }

    public function purchaseprint($purchseid, $type, $newprint=0)
    {
        
        if($type == 1)
        {
            $this->data['title'] = "Purchase Order";
        }else{
            $this->data['title'] = "Purchase Bill";
        }
        $this->data['type'] = $type;
        $this->data['newprint'] = $newprint;
        $this->data['businessdet'] = $this->busunt->getbusinessunitdetailbyid($this->buid);

        $this->data['purchasedet'] = $this->purmstr->getpurchasedetailsbyid($purchseid);
        $this->data['purchaseprodcts'] = $this->purslv->getpurchaseproducts($purchseid);
        
        $this->load->view('purchaseprint', $this->data, FALSE);
    }
    public function purchasereturnprint($purchseid, $newprint=0)
    {
        $this->data['title'] = "Purchase Return";
        $this->data['newprint'] = $newprint;
        $this->data['businessdet'] = $this->busunt->getbusinessunitdetailbyid($this->buid);

        $this->data['purchasedet'] = $this->purmstr->getpurchasedetailsbyid($purchseid);
        $this->data['purchaseprodcts'] = $this->purslv->getpurchaseproducts($purchseid);
        
        $this->load->view('purchasereturnprint', $this->data, FALSE);
    }
    public function purchaseorderprint($purchseid, $newprint=0)
    {
        $this->data['title'] = "Purchase Order Print";
        $this->data['newprint'] = $newprint;
        $this->data['businessdet'] = $this->busunt->getbusinessunitdetailbyid($this->buid);

        $this->data['purchasedet'] = $this->purmstr->getpurchasedetailsbyid($purchseid);
        $this->data['purchaseprodcts'] = $this->purslv->getpurchaseproducts($purchseid);
        
        $this->load->view('purchaseorderprint', $this->data, FALSE);
    }
    public function searchproductcode()
    {
        $searchtag = $this->input->post('key');
        $no = $this->input->post('no');
        $productdata = $this->prdtmdl->searchproductsbycode($searchtag, $this->buid);
        
        // Generate array
        if(!empty($productdata)){
            foreach ($productdata as $row){
                if($row->pd_productcode != "")
                {
                    echo '<a href="javascript:void(0)" onclick="selectproductdet('.$row->pd_productid.', '.$no.')" class="searchdropdown">' . $row->pd_productcode  . '- '.$row->pd_productname.' '.$row->pd_size.' '.$row->pd_brand.' ('.$row->pc_categoryname.')</a>';
                }
                
            }
        }else {
            echo "<span class='text-primary'>No results</span>";
        }
    }
    public function searchproductname()
    {
        $this->load->model('inventory/inventorysettings_model', 'invset');
        $inventorysettings = $this->invset->getinventorysettings($this->buid);
        $searchtag = $this->input->post('key');
        $no = $this->input->post('no');
        $productdata = $this->prdtmdl->searchproductsbyname($searchtag, $this->buid);
        
        // Generate array
        if(!empty($productdata)){
            foreach ($productdata as $row){
                if($row->pd_productcode != "")
                {
                    $prdctimage = "";
                    if($inventorysettings)
                    {
                        if($inventorysettings->is_image == 1)
                        {
                            $prdctimage = '<img src="'. base_url() .'uploads/products/'. $row->pd_prodimage .'" onerror="this.onerror=null;this.src=\''. base_url().'components/images/no-item.png\';" class="dashboardprdimg"> ';
                        }
                    }

                    echo '<a href="javascript:void(0)" onclick="selectproductdet('.$row->pd_productid.', '.$no.')" class="searchdropdown">' . $prdctimage . $row->pd_productname.' '.$row->pd_size.' '.$row->pd_brand.' ('.$row->pc_categoryname.')</a>';
                }
                
            }
        }else {
            echo "<span class='text-primary'>No results</span>";
        }
    }
    public function getproductdetails()
    {
        $prodid = $this->input->post('prodid');
        $proddet = $this->prdtmdl->getproductdetailsbyid($prodid);
        
        $this->output->set_content_type('application/json')->set_output(json_encode($proddet));
    }
    public function searchsupplier()
    {
        $this->load->model('business/suppliers_model', 'splr');
        
        $searchtag = $this->input->post('key');
        $supplierdata = $this->splr->searchsupplierbytag($searchtag, $this->buid);

        //echo $this->db->last_query();
        
        // Generate array
        if(!empty($supplierdata)){
            foreach ($supplierdata as $row){
                if($row->sp_name != "")
                {
                    echo '<a href="javascript:void(0)" onclick="selectsupplierdet('.$row->sp_supplierid.')" class="searchdropdown">' . $row->sp_name  . ' ('.$row->sp_gstno.')</a>';
                }
                
            }
        }else {
            echo "<span class='text-primary'>No results</span>";
        }
    }
    public function getsupplierdetails()
    {
        $this->load->model('business/suppliers_model', 'splr');
        $supid = $this->input->post('supid');
        $supdet = $this->splr->getsupplierdetailsbyid($supid);
        
        $this->output->set_content_type('application/json')->set_output(json_encode($supdet));
    }
    


}
