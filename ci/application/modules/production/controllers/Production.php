<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Production extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('welcome/userauthentication_model', 'usersigin');
        $this->load->model('admin/business_model', 'bus');
        $this->load->model('admin/businessunit_model', 'busunt');
        $this->load->model('production/productionoperations_model', 'proprtn');
        $this->load->model('inventory/products_model', 'prdtmdl');

        $this->load->model('production/productionmaster_model', 'prdcn');
        $this->load->model('production/productionmaterialslave_model', 'prdcnslve');
        $this->load->model('production/productionmaterialoperations_model', 'prdcnmatop');
    }

    public function productionhistory($finished=0)
    {
        $this->data['title'] = "Production History";
        if($finished == 1)
        {
            $this->data['subtitle'] = "Finished Productions";
        }else{
            $this->data['subtitle'] = "Active Productions";
        }
        $this->data['finished'] = $finished;
        $this->data['activeproductioncnt'] = $this->prdcn->getproductioncount($this->buid, 0);
        $this->data['finishedproductioncnt'] = $this->prdcn->getproductioncount($this->buid, 1);
        $this->data['productions'] = $this->prdcn->getproductionhistory($this->buid, $finished);
        $this->load->template('productionhistory', $this->data, FALSE);
    }
    public function deliverynote($productid, $qty, $productionid)
    {
        $this->load->model('production/deliverynotemaster_model', 'dlntmstr');
        $this->load->model('Country_model', 'cuntry');
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $this->data['billprintdet'] = $billprintdet = $this->blprnt->getbillprintdetails($this->buid);
        $this->data['businessdet'] = $businessdet = $this->busunt->getprintbusinessunitdetails($this->buid);
        $this->data['prdctdet'] = $this->prdtmdl->getproductdetailsbyid($productid);
        $this->data['qty'] = $qty;
        $this->data['states'] = $this->cuntry->getstatelist($businessdet->bu_country);
        $this->data['billno'] = $this->dlntmstr->getnextretailbillno($this->buid);
        $this->data['productionid'] = $productionid;

        $this->data['defaultpagesize'] = 1;
        if($billprintdet)
        {
            $this->data['defaultpagesize'] = $billprintdet->bp_defaultpagesize;
        }

        $this->data['title'] = "Delivery Note";
        $this->data['billprefix'] = "";
        $this->data['type'] = 0;
        $this->data['pretype'] = 0;

        $this->load->template('dashboard', $this->data, FALSE);
    }
    public function addingdeliverynote()
    {
        $this->load->model('production/deliverynotemaster_model', 'dlntmstr');
        $this->load->model('production/deliverynoteslave_model', 'dlntslv');
        
        $billprefix = $this->input->post('billprefix');
        $billno = $this->input->post('billno');
        $productionid = $this->input->post('productionid');

        $saledate = date('Y-m-d', strtotime($this->input->post('saledate')));
        $saletime = date('H:i:s', strtotime($this->input->post('saletime')));
        $daybookdate = $saledate . " " . $saletime;

        $customercheck = $this->input->post('customercheck');
        if($customercheck != '1')
        {
            $customername = $this->input->post('customername');
            $customerphone = $this->input->post('customerphone');
            $customeraddress = $this->input->post('customeraddress');
            $customergstin = $this->input->post('customergstin');
            $customerid = 0;
        }
        else{
            $customername = "";
            $customerphone = "";
            $customeraddress = "";
            $customergstin = "";
            $customerid = $this->input->post('customerid');
        }

        $vehicleno = $this->input->post('vehicleno');
        $salesperson = $this->input->post('salesperson');
        $shippingaddress = $this->input->post('shippingaddress');
        $stateid = $this->input->post('stateid');
        $deliverydate = date('Y-m-d', strtotime($this->input->post('deliverydate')));

        $productid = $this->input->post('productid');
        $mrp = $this->input->post('mrp');
        $qty = $this->input->post('qty');
        $itemtotalamt = $this->input->post('itemtotalamt');

        $freight = $this->input->post('freight');
        $totalamount = $this->input->post('totalamount');
        $grandtotal = $this->input->post('grandtotal');
        $pagesize = $this->input->post('pagesize');
        $salenote = $this->input->post('salenote');

        $deliverynotid = $this->dlntmstr->insert(array(
            'dn_buid'       => $this->buid,
            'dn_finyearid'  => $this->finyearid,
            'dn_billprefix' => $billprefix,
            'dn_billno'     => $billno,
            'dn_date'       => $saledate,
            'dn_time'       => $saletime,
            'dn_existcustomer'=> $customercheck,
            'dn_customerid' => $customerid,
            'dn_customername' => $customername,
            'dn_phone'      => $customerphone,
            'dn_address'    => $customeraddress,
            'dn_gstno'      => $customergstin,
            'dn_placeofsupply'  => $stateid,
            'dn_vehicleno' => $vehicleno,
            'dn_salesperson' => $salesperson,
            'dn_shippingaddress' => $shippingaddress,
            'dn_state'      => $stateid,
            'dn_totalamount'=> $totalamount,
            'dn_freight'    => $freight,
            'dn_grandtotal' => $grandtotal,
            'dn_pagesize' => $pagesize,
            'dn_notes' => $salenote,
            'dn_addedon'  => $this->updatedon,
            'dn_addedby'  => $this->loggeduserid,
            'dn_updatedby' => $this->loggeduserid,
            'dn_updatedon' => $this->updatedon,
            'dn_deliverydate' => $deliverydate
        ), TRUE);
        
        if($deliverynotid)
        {
            
            $updacc = array(
                'pm_deliverynote'=> 1,
            );
            $updateprdctn = $this->prdcn->update($productionid, $updacc, TRUE);

            $k=0;
            $insert_batch_data = array();
            foreach($productid as $prvl)
            {
                $insert_batch_data[] = array(
                    'dns_buid'   => $this->buid,
                    'dns_finyearid'  => $this->finyearid,
                    'dns_retailbillid' => $deliverynotid,
                    'dns_productid'  => $prvl,
                    'dns_mrp'   => $mrp[$k],
                    'dns_qty'   => $qty[$k],
                    'dns_totalamount'=> $itemtotalamt[$k],
                    'dns_updatedby'  => $this->loggeduserid,
                    'dns_updatedon'  => $this->updatedon
                );
                $k++;
            }

            $insertdrg = $this->dlntslv->insert_batch($insert_batch_data);

            $this->session->set_flashdata('messageS', 'Delivery note added.');

            redirect('production/deliverynoteprint/'.$deliverynotid.'/'.$pagesize);
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
            redirect('production/productionhistory');
        }
    }
    public function deliverynoteprint($deliverynotid, $thermal=0)
    {
        $this->load->model('production/deliverynotemaster_model', 'dlntmstr');
        $this->load->model('production/deliverynoteslave_model', 'dlntslv');
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $this->data['billprintdet'] = $billprintdet = $this->blprnt->getbillprintdetails($this->buid);

        $this->data['businessdet'] = $businessdet = $this->busunt->getprintbusinessunitdetails($this->buid);

        $this->data['showpurchaserate'] = 0;
        $this->data['remarkfield'] = 0;
        if($billprintdet)
        {
            $this->data['showpurchaserate'] = $billprintdet->bp_hidepurchaseprice;
            $this->data['remarkfield'] = $billprintdet->bp_remarkcolumn;
        }

        $this->data['title'] = "Delivery Note";

        $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);

        $this->data['purchasedet'] = $this->dlntmstr->getdeliverynotedetailsbyid($deliverynotid);
        $this->data['purchaseprodcts'] = $this->dlntslv->getdeliverynoteproducts($deliverynotid);
        $this->data['duptext'] = "";
        
        if($thermal == 3)
        {
            $this->load->view('thermalprint', $this->data, FALSE);
        }else{
            //$this->load->view('saleprint2', $this->data, FALSE);
            $this->load->view('deliverynoteprint', $this->data, FALSE);
        }
    }
    public function deliverynotes($complete=0, $fromdate=0, $todate=0)
    {
        $this->load->model('production/deliverynotemaster_model', 'dlntmstr');
        $this->load->model('production/deliverynoteslave_model', 'dlntslv');
        $this->load->model('business/customers_model', 'cstmr');

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }
        $this->data['complete'] = $complete;
        $this->data['title'] = "Delivery Note";
        if($complete == 0)
        {
            $this->data['deliverynotes'] = $this->dlntmstr->getallrows($this->buid);
        }else{
            $this->data['deliverynotes'] = $this->dlntmstr->getdeliverynotelist($this->buid, $complete, $fromdate, $todate);
        }

        $this->load->template('deliverynotes', $this->data, FALSE);
    }
    public function returndeliverynotes()
    {
        $this->load->model('production/deliverynotemaster_model', 'dlntmstr');

        $editid = $this->input->post('editid');
        $retdate = date('Y-m-d', strtotime($this->input->post('retdate')));
        $rettime = date('H:i:s', strtotime($this->input->post('rettime')));
        $returndatetime = $retdate . " " . $rettime;
        $notes = $this->input->post('notes');

        $updacc = array(
            'dn_isreturn'=> 1,
            'dn_returnedon' => $returndatetime,
            'dn_returncomments' => $notes,
            'returnedby' => $this->loggeduserid
        );
        $updateprdctn = $this->dlntmstr->update($editid, $updacc, TRUE);

        if($updateprdctn)
        {
            $this->session->set_flashdata('messageS', 'Delivery note returned.');
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }

        redirect('production/deliverynotes');
    }
    public function getdeliveryitemdetails()
    {
        $this->load->model('production/deliverynoteslave_model', 'dlntslv');
        $billid = $this->input->post('billid');
        $this->data['itemdetails'] = $this->dlntslv->getdeliverynoteproducts($billid);
        $this->load->view('ajaxsaleitemview', $this->data);
    }

    public function viewproductiondetails($productionid)
    {
        $this->load->model('inventory/godowns_model', 'gdwn');
        $this->data['godowns'] = $this->gdwn->getactiverows($this->buid);

        $this->data['productionid'] = $productionid;
        $this->data['operations'] = $this->proprtn->getactiverows($this->buid);
        $this->data['editdata'] = $this->prdcn->getproductionfulldetailbyid($productionid);
        $this->data['itemdetails'] = $this->prdcnslve->getproductionmaterials($productionid);
        $this->data['operationdetails'] = $this->prdcnmatop->getproductionoperations($productionid);

        $this->load->template('viewproductiondetails', $this->data, FALSE);
    }
    public function getproductionitemdetails()
    {
        $billid = $this->input->post('billid');
        $this->data['itemdetails'] = $this->prdcnslve->getproductionmaterials($billid);
        $this->load->view('ajaxproductionmaterialview', $this->data);
    }
    public function productionstart($productid=0, $qty=0, $productionid=0)
    {
        $this->load->model('production/productionsettings_model', 'prdcnset');
        $this->load->model('production/productmaterialdesignslave_model', 'prdsgnslv');
        $this->load->model('crm/crmenquiries_model', 'enqry');
        $this->load->model('inventory/godowns_model', 'gdwn');

        $this->data['godowns'] = $this->gdwn->getactiverows($this->buid);
        $settings = $this->prdcnset->getproductionsettings($this->buid);
        $this->data['productionid'] = $productionid;
        $this->data['productid'] = $productid;
        $this->data['qty'] = $qty;
        $this->data['title'] = "Start Production";
        $this->data['startprdctn'] = 0;
        $this->data['type'] = 0;
        if($productid != 0)
        {
            $this->data['startprdctn'] = 1;
            $this->data['billprefix'] = "";
            if($settings)
            {
                $this->data['billprefix'] = $settings->ps_productionprefix;
            }

            if($productionid != 0)
            {
                $this->data['title'] = "Update Production";
                $this->data['editdata'] = $this->prdcn->getproductiondetailbyid($productionid);
                $this->data['edititems'] = $this->prdcnslve->getproductionmaterials($productionid);
            }
            $this->data['billno'] = $this->prdcn->getnextproductionnumber($this->buid);
            $this->data['enquiries'] = $this->enqry->getallenquiriesbystatus($this->buid, 2);
            $this->data['materials'] = $this->prdsgnslv->selectedproductmaterials($productid);
            //echo $this->db->last_query();
            //exit();
        }
        $this->data['products'] = $this->prdtmdl->getactiverows($this->buid);
        $this->load->template('productionstart', $this->data, FALSE);
    }
    public function startingproduction()
    {
        $this->load->model('purchase/Productstock_model', 'prdstck');
        
        $productionid = $this->input->post('productionid');
        $mainproductid = $this->input->post('mainproductid');
        $quantity = $this->input->post('quantity');
        $billprefix = $this->input->post('billprefix');
        $billno = $this->input->post('billno');

        $saledate = date('Y-m-d', strtotime($this->input->post('saledate')));
        $saletime = date('H:i:s', strtotime($this->input->post('saletime')));
        $startdate = $saledate . " " . $saletime;

        $enquiryid = $this->input->post('enquiryid');
        $godownid = $this->input->post('godownid');

        $productid = $this->input->post('productid');
        $stockid = $this->input->post('stockid');
        $batchno = $this->input->post('batchno');
        $expirydate = $this->input->post('expirydate');

        $purchasepriceval = $this->input->post('purchasepriceval');
        $purchaseprice = $this->input->post('purchaseprice');
        $mrp = $this->input->post('mrp');
        $qty = $this->input->post('qty');
        $itemtotalamt = $this->input->post('itemtotalamt');

        $completiondate = date('Y-m-d', strtotime($this->input->post('completiondate')));
        $completiontime = date('H:i:s', strtotime($this->input->post('saletime')));
        $completiondate = $completiondate . " " . $completiontime;

        $totalamount = $this->input->post('totalamount');
        $averagecost = $this->input->post('averagecost');
        $productioncomments = $this->input->post('productioncomments');
        
        if($productionid ==0 || $productionid == "")
        {
            $editdet = 0;
            $saleid = $this->prdcn->insert(array(
                'pm_buid'       => $this->buid,
                'pm_finyearid'  => $this->finyearid,
                'pm_productionprefix'=> $billprefix,
                'pm_productionno'=> $billno,
                'pm_productid'   => $mainproductid,
                'pm_enquiryid'   => $enquiryid,
                'pm_godownind'   => $godownid,
                'pm_startdate'   => $startdate,
                'pm_qty'         => $quantity,
                'pm_comments'    => $productioncomments,
                'pm_materialcost'=> $totalamount,
                'pm_othercosts'  => $averagecost,
                'pm_totalcost'   => $averagecost,
                'pm_expectedtime'=> $completiondate,
                'pm_updatedby'   => $this->loggeduserid,
                'pm_updatedon'   => $this->updatedon,
                'pm_addedby'     => $this->loggeduserid,
                'pm_addedon'     => $this->updatedon,
            ), TRUE);

            $flshmsg = "Production started successfully.";
        }else{
            $saleid = $productionid;
            $editdet = 1;

            $updacc = array(
                'pm_productionprefix'=> $billprefix,
                'pm_productionno'=> $billno,
                'pm_productid'   => $mainproductid,
                'pm_enquiryid'   => $enquiryid,
                'pm_godownind'   => $godownid,
                'pm_startdate'   => $startdate,
                'pm_qty'         => $quantity,
                'pm_comments'    => $productioncomments,
                'pm_materialcost'=> $totalamount,
                'pm_othercosts'  => $averagecost,
                'pm_totalcost'   => $averagecost,
                'pm_expectedtime'=> $completiondate,
                'pm_updatedby'   => $this->loggeduserid,
                'pm_updatedon'   => $this->updatedon,
            );
            $updatesale = $this->prdcn->update($productionid, $updacc, TRUE);

            $flshmsg = "Production updated successfully.";

            $saleprdcts = $this->prdcnslve->getproductionmaterials($productionid);
            if($saleprdcts)
            {
                $updatestockdet = array();
                $updateprdstockarr = array();
                foreach($saleprdcts as $oldprdvl)
                {
                    $oldprdid = $oldprdvl->pms_materialid;
                    $oldqty = $oldprdvl->pms_qty;
                    $oldstockid = $oldprdvl->pms_stockid;

                    $adprdctstck = $this->prdtmdl->addproductstock($oldprdid, $oldqty);
                    $updtestck = $this->prdstck->addproductstockbyid($oldstockid, $oldqty);
                }
            }

            $deleteitems = $this->prdcnslve->deleteoldproductionitems($productionid);
        }

        if($saleid)
        {
            $k=0;
            $insert_batch_data = array();
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

                    $insert_batch_data[] = array(
                        'pms_buid'   => $this->buid,
                        'pms_finyearid'  => $this->finyearid,
                        'pms_productionid' => $saleid,
                        'pms_materialid'  => $prvl,
                        'pms_stockid'   => $stockid[$k],
                        'pms_qty'   => $qty[$k],
                        'pms_itemrate' => $purchasepriceval[$k],
                        'pms_mrp' => $mrp[$k],
                        'pms_unitprice' => $purchaseprice[$k],
                        'pms_itemtotalamount' => $itemtotalamt[$k],
                        'pms_updatedon'  => $this->updatedon,
                        'pms_updatedby'  => $this->loggeduserid
                    );

                    $adprdctstck = $this->prdtmdl->reduceproductstock($prvl, $qty[$k]);
                    $updtestck = $this->prdstck->reduceproductstockbyid($stockid[$k], $qty[$k]);

                }
                $k++;
            }

            $insertdrg = $this->prdcnslve->insert_batch($insert_batch_data);

            $this->session->set_flashdata('messageS', $flshmsg);
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('production/productionhistory');
    }

    public function startingoperation()
    {
        $productionid = $this->input->post('productionid');
        $operationid = $this->input->post('operationid');

        $opstartdate = date('Y-m-d', strtotime($this->input->post('opstartdate')));
        $opstarttime = date('H:i:s', strtotime($this->input->post('opstarttime')));
        $starttime = $opstartdate . " " . $opstarttime;

        $operationcost = $this->input->post('operationcost');

        $expcompletiondate = date('Y-m-d', strtotime($this->input->post('expcompletiondate')));
        $expcompletiontime = date('H:i:s', strtotime($this->input->post('expcompletiontime')));
        $expendtime = $expcompletiondate . " " . $expcompletiontime;

        $notes = $this->input->post('notes');

        $insertoperation = $this->prdcnmatop->insert(array(
            'pmo_buid' => $this->buid,
            'pmo_productionid' => $productionid,
            'pmo_operationid' => $operationid,
            'pmo_cost' => $operationcost,
            'pmo_comments' => $notes,
            'pmo_operationstarttime' => $starttime,
            'pmo_expectedendtime' => $expendtime,
            'pmo_addedby' => $this->loggeduserid,
            'pm_addedon' => $this->updatedon,
            'pmo_updatedby' => $this->loggeduserid,
            'pmo_updatedon' => $this->updatedon,
        ), TRUE);
        if($insertoperation)
        {
            $updacc = array(
                'pm_status'=> $operationid,
            );
            $updateprdction = $this->prdcn->update($productionid, $updacc, TRUE);

            $this->session->set_flashdata('messageS', 'Operation started successfully.');
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('production/viewproductiondetails/'.$productionid);
    }
    public function finishingoperation()
    {
        $productionid = $this->input->post('productionid');
        $productionoprtnid = $this->input->post('productionoprtnid');

        $finisheddate = date('Y-m-d', strtotime($this->input->post('finisheddate')));
        $finishedtime = date('H:i:s', strtotime($this->input->post('finishedtime')));
        $finishdatetime = $finisheddate . " " . $finishedtime;

        $finaloperationcost = $this->input->post('finaloperationcost');
        $finishednotes = $this->input->post('finishednotes');

        $updacc = array(
            'pmo_operationendtime'=> $finishdatetime,
            'pmo_isfinished' => 1,
            'pmo_finishedcost' => $finaloperationcost,
            'pmo_finishedcomments' => $finishednotes,
            'pmo_updatedby' => $this->loggeduserid,
            'pmo_updatedon' => $this->updatedon,

        );
        $updateprdction = $this->prdcnmatop->update($productionoprtnid, $updacc, TRUE);
        if($updateprdction)
        {
            $this->session->set_flashdata('messageS', 'Operation finished successfully.');
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('production/viewproductiondetails/'.$productionid);
    }

    public function finishedproductiondetail()
    {
        $this->load->model('purchase/Productstock_model', 'prdstck');

        $productionid = $this->input->post('productionid');

        $productid = $this->input->post('productid');
        $productqty = $this->input->post('productqty');
        $godownid = $this->input->post('godownid');
        $batchno = $this->input->post('batchno');
        if($this->input->post('expirydate'))
        {
            $expirydate = date('Y-m-d', strtotime($this->input->post('expirydate')));
        }
        else{
            $expirydate = "";
        }

        $finisheddate = date('Y-m-d', strtotime($this->input->post('finisheddate')));
        $finishedtime = date('H:i:s', strtotime($this->input->post('finishedtime')));
        $finishdatetime = $finisheddate . " " . $finishedtime;

        $finalproductioncost = $this->input->post('finalproductioncost');
        $finishedproductionnotes = $this->input->post('finishedproductionnotes');

        $purchaseprice = $this->input->post('purchaseprice');
        $mrp = $this->input->post('mrp');

        $updacc = array(
            'pm_finished'=> 1,
            'pm_finishedtime' => $finishdatetime,
            'pm_operationcost' => $finalproductioncost,
            'pm_fnishedcomments' => $finishedproductionnotes,
            'pm_finishedgodownid' => $godownid,
            'pm_batchno' => $batchno,
            'pm_expirydate' => $expirydate
        );
        $updateprdction = $this->prdcn->update($productionid, $updacc, TRUE);

        if($updateprdction)
        {
            $adprdctstck = $this->prdtmdl->addproductstock($productid, $productqty);
            $prsstockdet = $this->prdstck->getproductstockdetails($this->buid, $productid, $batchno, $godownid);

            if($prsstockdet)
            {
                $prdctstockid = $prsstockdet->pt_stockid;

                $newstock = $prsstockdet->pt_stock + $productqty;

                $updtestck = $this->prdstck->update_status_by([
                    'pt_stockid' => $prdctstockid
                ], [
                    'pt_expirydate' => $expiry,
                    'pt_stock' => $newstock,
                    'pt_purchaseprice' => $purchaseprice,
                    'pt_mrp' => $mrp,
                ]);

                //$updtestck = $this->prdstck->addproductstockbyid($prdctstockid, $addedqty);
            }else{
                /*$getprdctdet = $this->prdtmdl->getproductdetailsbyid($productid);
                $purchaseprice = $getprdctdet->pd_purchaseprice;
                $mrp = $getprdctdet->pd_mrp;*/

                $prdctstockid = $this->prdstck->insert(array(
                    'pt_buid' => $this->buid,
                    'pt_productid' => $productid,
                    'pt_batchno'  => $batchno,
                    'pt_godownid' => $godownid,
                    'pt_expirydate' => $expiry,
                    'pt_purchaseprice' => $purchaseprice,
                    'pt_mrp' => $mrp,
                    'pt_stock' => $productqty
                ), TRUE);
            }

            $updacc1 = array(
                'pm_stockid'=> $prdctstockid,
            );
            $updateprdctstckid = $this->prdcn->update($productionid, $updacc1, TRUE);

            $this->session->set_flashdata('messageS', 'Production finished details updated successfully.');
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('production/productionhistory/1');
    }

    public function searchmaterialcode()
    {
        $this->load->model('inventory/inventorysettings_model', 'invset');
        $inventorysettings = $this->invset->getinventorysettings($this->buid);

        $searchtag = $this->input->post('key');
        $no = $this->input->post('no');
        $godownid = $this->input->post('godownid');
        if($godownid == "")
        {
            $productdata = $this->prdtmdl->searchproductstockbycode($searchtag, $this->buid, 1);
        }else{
            $productdata = $this->prdtmdl->searchgodownproductstockbycode($searchtag, $this->buid, $godownid, 1);
        }
        
        // Generate array
        if(!empty($productdata)){
            foreach ($productdata as $row){
                if($row->pd_productcode != "")
                {
                    $btchdet = "";
                    if($inventorysettings)
                    {
                        if($inventorysettings->is_batchwise == 1)
                        {
                            $btchdet = 'Batch No:'.$row->pt_batchno;
                        }
                        if($inventorysettings->is_expirydate == 1)
                        {
                            $btchdet.=' Expiry: '.date("d-M-Y", strtotime($row->pt_expirydate));
                        }
                    }
                    echo '<a href="javascript:void(0)" onclick="selectproductdet('.$row->pd_productid.','.$row->pt_stockid.','.$no.')" class="searchdropdown">' . $row->pd_productcode  . '- '.$row->pd_productname.' '.$row->pd_size.' '.$row->pd_brand.' ('.$row->pc_categoryname.') (Avail Stock: '.$row->pt_stock.') <br/><span style="font-size:11px;">'.$btchdet.'</span></a>';
                }
                
            }
        }else {
            echo "<span class='text-primary'>No results</span>";
        }
    }
    public function searchmaterialname()
    {
        $this->load->model('inventory/inventorysettings_model', 'invset');
        $inventorysettings = $this->invset->getinventorysettings($this->buid);
        $searchtag = $this->input->post('key');
        $no = $this->input->post('no');
        $godownid = $this->input->post('godownid');

        if($godownid == "")
        {
            $productdata = $this->prdtmdl->searchproductstockbyname($searchtag, $this->buid, 1);
        }else{
            $productdata = $this->prdtmdl->searchgodownproductstockbyname($searchtag, $this->buid, $godownid, 1);
        }
        
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

                    $btchdet = "";
                    if($inventorysettings)
                    {
                        if($inventorysettings->is_batchwise == 1)
                        {
                            $btchdet = 'Batch No:'.$row->pt_batchno;
                        }
                        if($inventorysettings->is_expirydate == 1)
                        {
                            $btchdet.=' Expiry: '.date("d-M-Y", strtotime($row->pt_expirydate));
                        }
                    }

                    echo '<a href="javascript:void(0)" onclick="selectproductdet('.$row->pd_productid.','.$row->pt_stockid.', '.$no.')" class="searchdropdown">' . $prdctimage . $row->pd_productname.' '.$row->pd_size.' '.$row->pd_brand.' ('.$row->pc_categoryname.') (Avail Stock: '.$row->pt_stock.')<br/><span style="font-size:11px;">'.$btchdet.'</span></a>';
                }
                
            }
        }else {
            echo "<span class='text-primary'>No results</span>";
        }
    }
    public function getmaterialstockdetails()
    {
        $prodid = $this->input->post('prodid');
        $stockid = $this->input->post('stockid');
        
        $proddet = $this->prdtmdl->getproductdetailstockbyid($prodid, $stockid);
        echo $this->db->last_query();
        
        $this->output->set_content_type('application/json')->set_output(json_encode($proddet));
    }

    public function productdesign()
    {
        $this->load->model('production/productmaterialdesign_model', 'prdsgn');
        $this->data['title'] = "Product Design";
        $this->data['operations'] = $this->prdsgn->getallrows($this->buid);
        $this->load->template('productdesign', $this->data, FALSE);
    }
    public function getbillitemdetails()
    {
        $this->load->model('production/productmaterialdesignslave_model', 'prdsgnslv');
        $billid = $this->input->post('billid');
        $this->data['itemdetails'] = $this->prdsgnslv->getproductmaterials($billid);
        $this->load->view('ajaxproductdesignitemview', $this->data);
    }
    public function designproductmaterial($editid=0)
    {
        $this->load->model('production/productmaterialdesign_model', 'prdsgn');
        $this->load->model('production/productmaterialdesignslave_model', 'prdsgnslv');
        
        $this->data['editid'] = $editid;
        $this->data['type'] = 0;

        if($editid != 0)
        {
            $this->data['title'] = "Update Product Design";

            $this->data['editdata'] = $editdata = $this->prdsgn->getproddesigndetailsbyid($editid);
            $this->data['edititems'] = $this->prdsgnslv->getproductmaterials($editid);

            $this->data['products'] = $this->prdtmdl->getnotdesignedproductbyid($this->buid, $editdata->pmd_productid);
        }else{
            $this->data['title'] = "Design New Product";
            $this->data['products'] = $this->prdtmdl->getnotdesignedproducts($this->buid);
        }

        
        $this->load->template('designproductmaterial', $this->data, FALSE);
    }
    public function designingproduct()
    {
        $this->load->model('production/productmaterialdesign_model', 'prdsgn');
        $this->load->model('production/productmaterialdesignslave_model', 'prdsgnslv');
        
        $designid = $this->input->post('designid');
        $mainproductid = $this->input->post('mainproductid');

        $productid = $this->input->post('productid');
        $purchasepriceval = $this->input->post('purchasepriceval');
        $purchaseprice = $this->input->post('purchaseprice');
        $mrp = $this->input->post('mrp');
        $qty = $this->input->post('qty');
        $itemtotalamt = $this->input->post('itemtotalamt');

        $averagetime = $this->input->post('averagetime');
        $totalamount = $this->input->post('totalamount');
        $averagecost = $this->input->post('averagecost');

        if($designid == 0 || $designid == "")
        {
            $editdet = 0;
            $designadedid = $this->prdsgn->insert(array(
                'pmd_buid'       => $this->buid,
                'pmd_productid'  => $mainproductid,
                'pmd_averagaetime'   => $averagetime,
                'pmd_averagecost' => $averagecost,
                'pmd_totalamount' => $totalamount,
                'pmd_updatedon'  => $this->updatedon,
                'pmd_updatedby'  => $this->loggeduserid,
            ), TRUE);

            $flshmsg = "Product design added successfully.";
            
            $designid = $designadedid;
        }else{
            $editdet = 1;

            $updacc = array(
                'pmd_productid'  => $mainproductid,
                'pmd_averagaetime'   => $averagetime,
                'pmd_averagecost' => $averagecost,
                'pmd_totalamount' => $totalamount,
                'pmd_updatedon'  => $this->updatedon,
                'pmd_updatedby'  => $this->loggeduserid,
            );
            $designadedid = $this->prdsgn->update($designid, $updacc, TRUE);

            $flshmsg = "Product design updated successfully.";

            $deleteitems = $this->prdsgnslv->deleteolddesignmaterilas($designid);
        }

        if($designid)
        {
            $k=0;
            foreach($productid as $prvl)
            {
                if($prvl != "")
                {
                    $materialid = $this->prdsgnslv->insert(array(
                        'pdm_buid' => $this->buid,
                        'pdm_productdesignid' => $designid,
                        'pdm_materialid'  => $prvl,
                        'pdm_qty' => $qty[$k],
                        'pdm_rate' => $purchasepriceval[$k],
                        'pdm_unitprice' => $purchaseprice[$k],
                        'pdm_mrp' => $mrp[$k],
                        'pdm_itemtotalamount' => $itemtotalamt[$k],
                        'pdm_updatedby' => $this->loggeduserid,
                        'pdm_updatedon' => $this->updatedon
                    ), TRUE);
                }
                $k++;
            }

            $this->session->set_flashdata('messageS', $flshmsg);
            redirect('production/productdesign');
        }
        else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
            redirect('production/designproductmaterial');
        }

    }
    public function searchproductcode()
    {
        $searchtag = $this->input->post('key');
        $no = $this->input->post('no');
        $productdata = $this->prdtmdl->searchproductsbycode($searchtag, $this->buid, 1);
        
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
        $productdata = $this->prdtmdl->searchproductsbyname($searchtag, $this->buid, 1);
        
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
    
    public function productionoperations()
    {
        $this->data['title'] = "Production Operations";
        $this->data['operations'] = $this->proprtn->getallrows($this->buid);
        $this->load->template('productionoperations', $this->data, FALSE);
    }
    public function addingoperation()
    {
        $editid = $this->input->post('editid');
        $operationname = $this->input->post('operationname');
        $isexternal = $this->input->post('isexternal');
        $operationpriority = $this->input->post('operationpriority');
        $notes = $this->input->post('notes');

        if($editid == "")
        {
            $insertset = $this->proprtn->insert(array(
                'po_buid' => $this->buid,
                'po_operation' => $operationname,
                'po_description' => $notes,
                'po_isexternal' => $isexternal,
                'po_priority' => $operationpriority,
                'po_updatedby' => $this->loggeduserid,
                'po_updatedon' => $this->updatedon
            ), TRUE);
        }else{
            $updacc = array(
                'po_buid' => $this->buid,
                'po_operation' => $operationname,
                'po_description' => $notes,
                'po_isexternal' => $isexternal,
                'po_priority' => $operationpriority,
                'po_updatedby' => $this->loggeduserid,
                'po_updatedon' => $this->updatedon
            );
            $insertset = $this->proprtn->update($editid, $updacc, TRUE);
        }
        if($insertset)
        {
            $this->session->set_flashdata('messageS', lang('record_updated_success'));
        }
        else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('production/productionoperations');
    }
    public function enabledisableoperation($editid, $action = 0)
    {
        
        $dsbledary = $this->proprtn->update($editid, ['po_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('production/productionoperations');
    }
    public function getoperationdetails()
    {
        $operationid = $this->input->post('operationid');
        $editdata = $this->proprtn->getrowbyid($operationid);
        $this->output->set_content_type('application/json')->set_output(json_encode($editdata));
    }

}
