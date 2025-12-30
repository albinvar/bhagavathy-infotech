<?php
error_reporting(0);
defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
/**
 * This is authentication for crickm application
 * all done with database
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @license         MIT
 * @link
 */
class Services extends REST_Controller {
    protected $allowedips;

    public function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit']    = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit']   = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->helper('commonfunction_helper');
        date_default_timezone_set('Europe/Dublin');
        //date_default_timezone_set('Asia/Kolkata');
        $this->allowedips = array();
        $this->load->helper('my_image_resize');
    }

    public function androidappversion_get() {
        $this->load->model('admin/appversiondetails', 'app');

        $vesrion = $this->app->get_by(array('app_type' => '1'));

        $vesrionresult = array(
            "app_version"  => $vesrion->app_version,
            "app_required" => $vesrion->app_required,

        );
        if ($vesrion) {
            $this->response(array('status' => 'success', 'message' => 'Android version retrieved', 'dataresult' => $vesrionresult), REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'failed', 'message' => 'No versions available'), REST_Controller::HTTP_OK);
        }
    }

    
    public function loginprocess_post()
    {
        $this->load->model('welcome/userauthentication_model', 'usersigin');
        $this->load->model('admin/businessunit_model', 'busunt');

        $username   = $this->post('username');
        $password   = $this->post('password');
        
        $error = array();
        if (!isset($username) || $username == "") {
            $error['username'] = "required";
        }
        if (!isset($password) || $password == "") {
            $error['password'] = "required";
        }
        
        
        //  if ($hashvalue == $keyvalue) {

        if (!count($error)) {
            $success = $this->usersigin->getuserdetails(array('at_username' => $username, 'at_isactive' => '0'));

            if ($success && $success->at_authid > 0) {
                $checkpassword = md5($password);
                if ($this->usersigin->get_by(array('at_username' => $success->at_username, 'at_password' => $checkpassword))) {
                    if ($success->at_authid > 0) {

                        $session_id            = $success->at_authid;
                        $userrole              = $success->at_usertypeid;
                        

                        if ($userrole == 1) {
                            $this->response(array('status' => 'failed', 'message' => 'This user do not have app login'), REST_Controller::HTTP_OK);
                        } else {

                            if ($userrole == 2) {
                                $bunits = $this->busunt->getactiverows($success->at_businessid);
                                if($bunits)
                                {
                                    $buid = $bunits[0]->bu_businessunitid;
                                }else{
                                    $buid = "";
                                }
                            }else{
                                $buid = $success->at_unitids;
                            }
                            
                            if($buid != "")
                            {
                                 $data  = array(
                                        'authenticationid' => $success->at_authid,
                                        'name'             => $success->at_name,
                                        'mobile'           => $success->at_mobile,
                                        'phone'            => $success->at_phone,
                                        'email'            => $success->at_email,
                                        'usertype'         => $success->at_usertypeid,
                                        'businessid'       => $success->at_businessid,
                                        'buid'             => $buid
                                    );

                                $this->response(array('status' => 'success', 'message' => 'User details retrieved', 'dataresult' => $data), REST_Controller::HTTP_OK);
                            }else{
                                $this->response(array('status' => 'failed', 'message' => 'No business units available.'), REST_Controller::HTTP_OK);
                            }
                        }
                        
                    } else {
                        $this->response(array('status' => 'failed', 'message' => 'User does not exist'), REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response(array('status' => 'failed', 'message' => 'Invalid password'), REST_Controller::HTTP_OK);
                }
            } else {
                $this->response(array('status' => 'failed', 'message' => 'User does not exist'), REST_Controller::HTTP_OK);
            }
        } else {
            $this->response(array('status' => 'failed', 'message' => 'Please fill all mandatory fields'), REST_Controller::HTTP_OK);
        }
    }

    public function dashboardfunc_post()
    {
        $this->load->model('inventory/products_model', 'prdtmdl');
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');

        $authenticationid   = $this->post('authenticationid');
        $buid = $this->post('buid');

        $error = array();
        if (!isset($authenticationid) || $authenticationid == "") {
            $error['authenticationid'] = "required";
        }
        if (!isset($buid) || $buid == "") {
            $error['buid'] = "required";
        }
        
        if (!count($error)) {
            $todaydate  = date('Y-m-d');

            $prdctcnt = $this->prdtmdl->getactiveproductcount($buid);
            $salecount = $this->retlmstr->getsalecountbyuseriddate($buid, $authenticationid, $todaydate);
            $saleamount = $this->retlmstr->getsaleamountbyuseriddate($buid, $authenticationid, $todaydate);

            $details = array('productscount' => $prdctcnt, 'totalsales' => $salecount, 'collectionamount' => $saleamount->totprofit, 'saleamount' => $saleamount->grandtotal);

            $this->response(array('status' => 'success', 'message' => 'Dashboard details retrieved', 'dataresult' => $details), REST_Controller::HTTP_OK);

        }else {
            $this->response(array('status' => 'failed', 'message' => 'Please fill all mandatory fields'), REST_Controller::HTTP_OK);
        }
    }

    public function billsettings_post()
    {
        $this->load->model('business/billprintsettings_model', 'blprnt');
        
        $authenticationid   = $this->post('authenticationid');
        $buid = $this->post('buid');

        $error = array();
        if (!isset($authenticationid) || $authenticationid == "") {
            $error['authenticationid'] = "required";
        }
        if (!isset($buid) || $buid == "") {
            $error['buid'] = "required";
        }
        
        if (!count($error)) {

            $billprintdet = $this->blprnt->getbillprintdetails($buid);
            $details = array();
            if($billprintdet)
            {
                $details = array('retailprefix' => $billprintdet->bp_retailprefix, 'remarkcolumn' => $billprintdet->bp_remarkcolumn, 'hidepurchaseprice' => $billprintdet->bp_hidepurchaseprice, 'showcess' => 1);
            }else{
                $details = array('retailprefix' => "", 'remarkcolumn' => 0, 'hidepurchaseprice' => 0, 'showcess' => 1);
            }

            $this->response(array('status' => 'success', 'message' => 'Settings retrieved', 'dataresult' => $details), REST_Controller::HTTP_OK);

        }else {
            $this->response(array('status' => 'failed', 'message' => 'Please fill all mandatory fields'), REST_Controller::HTTP_OK);
        }
    }

    public function statelist_post()
    {
        $this->load->model('Country_model', 'cuntry');
        $this->load->model('admin/businessunit_model', 'busunt');
        
        $authenticationid   = $this->post('authenticationid');
        $buid = $this->post('buid');

        $error = array();
        if (!isset($authenticationid) || $authenticationid == "") {
            $error['authenticationid'] = "required";
        }
        if (!isset($buid) || $buid == "") {
            $error['buid'] = "required";
        }
        
        if (!count($error)) {
            $businessdet = $this->busunt->getprintbusinessunitdetails($buid);
            $countryid= '101';
            $stateid = '4035';
            if($businessdet)
            {
                if($businessdet->bu_country != "")
                {
                    $countryid = $businessdet->bu_country;
                }
                if($businessdet->bu_state != "")
                {
                    $stateid = $businessdet->bu_state;
                }
                
            }
            $statedet = $this->cuntry->getstatelist($countryid);
            $details = array();
            if($statedet)
            {
                foreach($statedet as $stval)
                {
                    if($stval->id == $stateid)
                    {
                        $default = 1;
                    }else{
                        $default = 0;
                    }
                    $details[] = array('stateid' => $stval->id, 'name' => $stval->name, 'statecode' => $stval->statecode, 'default' => $default);
                }

                $this->response(array('status' => 'success', 'message' => 'States retrieved', 'dataresult' => $details), REST_Controller::HTTP_OK);
            }else{
                $this->response(array('status' => 'failed', 'message' => 'No data available.'), REST_Controller::HTTP_OK);
            }
            
        }else {
            $this->response(array('status' => 'failed', 'message' => 'Please fill all mandatory fields'), REST_Controller::HTTP_OK);
        }
    }


    public function customersearch_post()
    {
        $this->load->model('business/customers_model', 'cstmr');
        
        $authenticationid   = $this->post('authenticationid');
        $searchtag = $this->post('searchtag');
        $buid = $this->post('buid');

        $error = array();
        if (!isset($authenticationid) || $authenticationid == "") {
            $error['authenticationid'] = "required";
        }
        if (!isset($buid) || $buid == "") {
            $error['buid'] = "required";
        }
        if (!isset($searchtag) || $searchtag == "") {
            $error['searchtag'] = "required";
        }
        
        if (!count($error)) {

            $resultdata = $this->cstmr->searchcustomerbytag($searchtag, $buid);
            $details = array();
            if($resultdata)
            {
                foreach($resultdata as $row)
                {
                    if($row->ct_name != "")
                    {
                        $details[] = array('customerid' => $row->ct_cstomerid, 'name' => $row->ct_name, 'type' => $stval->ct_type, 'oldbalance' => $row->ct_balanceamount, 'gstin' => $row->ct_gstin);
                    }
                }

                $this->response(array('status' => 'success', 'message' => 'Customer details retrieved', 'dataresult' => $details), REST_Controller::HTTP_OK);
            }else{
                $this->response(array('status' => 'failed', 'message' => 'No data available.'), REST_Controller::HTTP_OK);
            }
            
        }else {
            $this->response(array('status' => 'failed', 'message' => 'Please fill all mandatory fields'), REST_Controller::HTTP_OK);
        }
    }

    
    public function productsearch_post()
    {
        $this->load->model('inventory/products_model', 'prdtmdl');
        $this->load->model('inventory/inventorysettings_model', 'invset');

        $authenticationid   = $this->post('authenticationid');
        $buid = $this->post('buid');
        $searchtag = $this->post('searchtag');
        $searchby = $this->post('searchby'); // 0-code, 1-name
        
        $error = array();
        if (!isset($authenticationid) || $authenticationid == "") {
            $error['authenticationid'] = "required";
        }
        if (!isset($searchtag) || $searchtag == "") {
            $error['searchtag'] = "required";
        }
        
        if (!count($error)) {

            if($searchby == 0)
            {
                $productdata = $this->prdtmdl->searchproductstockbycode($searchtag, $buid);
            }else{
                $productdata = $this->prdtmdl->searchproductstockbyname($searchtag, $buid);
            }
           
            if(!empty($productdata)){
                $details = array();
                $inventorysettings = $this->invset->getinventorysettings($buid);

                foreach ($productdata as $row){
                    if($row->pd_productcode != "")
                    {
                        $prdctimage = "";
                        if($inventorysettings)
                        {
                            if($inventorysettings->is_image == 1)
                            {
                                if($row->pd_prodimage != "")
                                {
                                    $prdctimage =  base_url() .'uploads/products/'. $row->pd_prodimage;
                                }else{
                                    $prdctimage =  base_url() .'components/images/no-item.png';
                                }
                                
                            }
                        }

                        if($row->pd_profittype == 1)
                        {
                            $retamntval = $row->pt_purchaseprice * $row->pd_retailprofit/100;
                            $netprice = $row->pt_purchaseprice + $retamntval;
                        }else if($row->pd_profittype == 2)
                        {
                            $netprice = $row->pt_purchaseprice + $row->pd_retailprofit;
                        }else{
                            $unitprice = $row->pd_mrp;
                        }

                        if($row->pd_profittype == 3)
                        {
                            $gstmult = 100 + $row->tb_tax;
                            $netprice = $unitprice * 100/$gstmult;
                            $gstamnt = $unitprice - $netprice;
                        }else{
                            $gstamnt = $netprice * $row->tb_tax/100;
                            $unitprice = $netprice + $gstamnt;
                        }

                        $purgstamnt = ($row->pt_purchaseprice * $row->tb_tax)/100;
                        $purchaseamount = $row->pt_purchaseprice + $purgstamnt;

                        $details[] = array('productid' => $row->pd_productid, 'stockid' => $row->pt_stockid, 'productname' => $row->pd_productname, 'productcode' => $row->pd_productcode, 'category' => $row->pc_categoryname, 'productimage' => $prdctimage, 'stock' => $row->pt_stock, 'hsnno' => $row->pd_hsnno, 'purchaseprice' => $purchaseamount, 'netprice' => $netprice, 'defaultnetprice' => $netprice, 'gst' => $row->tb_tax, 'gstamount' => $gstamnt, 'unitprice' => $unitprice, 'pd_mrp' => $row->pd_mrp, 'profittype' => $row->pd_profittype);
                    }
                }

                
                $this->response(array('status' => 'success', 'message' => 'Product details retrieved', 'dataresult' => $details), REST_Controller::HTTP_OK);
            }
            else{
                $this->response(array('status' => 'failed', 'message' => 'No Details available.'), REST_Controller::HTTP_OK);
            }

        }else {
            $this->response(array('status' => 'failed', 'message' => 'Please fill all mandatory fields'), REST_Controller::HTTP_OK);
        }
    }

    public function customerlist_post()
    {
        $this->load->model('business/customers_model', 'cstmr');

        $authenticationid   = $this->post('authenticationid');
        $buid = $this->post('buid');

        $error = array();
        if (!isset($authenticationid) || $authenticationid == "") {
            $error['authenticationid'] = "required";
        }
        if (!isset($buid) || $buid == "") {
            $error['buid'] = "required";
        }
        $customerarr = array();
        if (!count($error)) {
            $customers = $this->cstmr->getactivecustomers($buid);
            $customerarr[] = array('customerid' => 'all', 'name' => 'All');
            $customerarr[] = array('customerid' => '0', 'name' => 'Walk in customers');

            if($customers)
            {
                foreach($customers as $cstvl)
                {
                    $customerarr[] = array('customerid' => $cstvl->ct_cstomerid, 'name' => $cstvl->ct_name);
                }
            }
            $this->response(array('status' => 'success', 'message' => 'Customer details retrieved', 'dataresult' => $customerarr), REST_Controller::HTTP_OK);
        }
        else {
            $this->response(array('status' => 'failed', 'message' => 'Please fill all mandatory fields'), REST_Controller::HTTP_OK);
        }
    }

    
    public function salehistory_post()
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');

        $authenticationid   = $this->post('authenticationid');
        $buid = $this->post('buid');
        $customerid = $this->post('customerid');
        $fromdate = $this->post('fromdate');
        $todate = $this->post('todate');

        $error = array();
        if (!isset($authenticationid) || $authenticationid == "") {
            $error['authenticationid'] = "required";
        }
        if (!isset($buid) || $buid == "") {
            $error['buid'] = "required";
        }
        
        if (!count($error)) {

            if($customerid == "")
            {
                $customerid = 'all';
            }
            if($fromdate == "")
            {
                $fromdate = date('Y-m-d');
                $todate = date('Y-m-d');
            }else{
                $fromdate = date('Y-m-d', strtotime($fromdate));
                $todate = date('Y-m-d', strtotime($todate));
            }

            $salehistory = $this->retlmstr->getsalebillhistoryfilterforapi($buid, $authenticationid, $customerid, $fromdate, $todate);

            if($salehistory)
            {
                foreach($salehistory as $stvl)
                {
                    $billno = $stvl->rb_billprefix ." ". $stvl->rb_billno;
                    $billdate = date('d-M-Y', strtotime($stvl->rb_date)) . " " . date('H:i', strtotime($stvl->rb_time));

                    if($stvl->rb_existcustomer == 1)
                    {
                        $custdet = $this->cstmr->getcustomerdetailsbyid($stvl->rb_customerid);
                        $customername = $custdet->ct_name;
                        $phone = $custdet->ct_phone;
                    }else{
                        $customername = $stvl->rb_customername;
                        $phone = $stvl->rb_phone;
                    }

                    $itemdetails = $this->retlslv->getsaleproducts($stvl->rb_retailbillid);
                    $itemsarray= array();
                    if($itemdetails)
                    {
                        foreach ($itemdetails as $ldgvl) {
                            
                            $itemsarray[] = array('productcode' => $ldgvl->pd_productcode, 'productname' => $ldgvl->pd_productname, 'unitprice' => $ldgvl->rbs_unitprice, 'itemgstamount' => $ldgvl->rbs_gstamnt, 'itemdiscount' => $ldgvl->rbs_totaldiscount, 'qty' => $ldgvl->rbs_qty, 'totalamount' => $ldgvl->rbs_totalamount);
                        }
                    }

                    $salearr[] = array('billid' => $stvl->rb_retailbillid,'billno' => $billno, 'billdate' => $billdate, 'customer' => $customername, 'phone' => $phone, 'grandtotal' => price_roundof($stvl->rb_grandtotal), 'discount' => price_roundof($stvl->rb_discount), 'gstamount' => price_roundof($stvl->rb_totalgstamnt), 'items' => $itemsarray);
                }

                $this->response(array('status' => 'success', 'message' => 'Sale details retrieved', 'dataresult' => $salearr), REST_Controller::HTTP_OK);
            }else{
                $this->response(array('status' => 'failed', 'message' => 'No history available.'), REST_Controller::HTTP_OK);
            }

        }else {
            $this->response(array('status' => 'failed', 'message' => 'Please fill all mandatory fields'), REST_Controller::HTTP_OK);
        }
    }

    public function addingsale_post()
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');
        $this->load->model('inventory/products_model', 'prdtmdl');
        $this->load->model('purchase/Productstock_model', 'prdstck');

        $authenticationid   = $this->post('authenticationid');
        $buid = $this->post('buid');

        $customercheck = $this->post('customercheck');
        if($customercheck != '1')
        {
            $customername = $this->post('customername');
            $customerphone = $this->post('customerphone');
            $customeraddress = $this->post('customeraddress');
            $customergstin = $this->post('customergstin');
            $customerid = 0;
        }
        else{
            $customername = "";
            $customerphone = "";
            $customeraddress = "";
            $customergstin = "";
            $customerid = $this->post('customerid');
        }

        $shippingaddress = $this->post('shippingaddress');
        $stateid = $this->post('stateid');

        $product1 = $this->post('product1');
        $product2 = $this->post('product2');
        
        $totaldiscount = $this->post('totaldiscount');
        $freight = $this->post('freight');
        $totalamount = $this->post('totalamount');
        $oldbalance = $this->post('oldbalance');
        $roundoffvalue = $this->post('roundoffvalue');
        $grandtotal = $this->post('grandtotal');
        $paidamount = $this->post('paidamount');
        $paymethod = $this->post('paymethod');
        $balanceamnt = $this->post('balanceamnt');
        $totalgstamount = $this->post('totalgstamount');
        $salenote = $this->post('salenote');

        $finyearid = "";
        $this->load->model('business/financialyears_model', 'fnyr');
        $finyeardetails = $this->fnyr->getcurrentfinancialyear($buid);
        if($finyeardetails)
        {
            $finyearid = $finyeardetails->ay_financialyearid;
        }

        $billprefix = "";
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $billprintdet = $this->blprnt->getbillprintdetails($buid);
        if($billprintdet)
        {
            $billprefix = $billprintdet->bp_retailprefix;
        }

        $billno = $this->retlmstr->getnextretailbillno($buid, 0);

        $saledate = date('Y-m-d');
        $saletime = date('H:i:s');

        $curdate = date('Y-m-d H:i:s');

        $saleid = $this->retlmstr->insert(array(
            'rb_buid'       => $buid,
            'rb_finyearid'  => $finyearid,
            'rb_billingtype'=> 0,
            'rb_billprefix' => $billprefix,
            'rb_billno'     => $billno,
            'rb_date'       => $saledate,
            'rb_time'       => $saletime,
            'rb_existcustomer'=> $customercheck,
            'rb_customerid' => $customerid,
            'rb_customername' => $customername,
            'rb_phone'      => $customerphone,
            'rb_address'    => $customeraddress,
            'rb_gstno'      => $customergstin,
            /*'rb_vehicleno'  => $vehicleno,
            'rb_godownid' => $godownid,*/
            'rb_salesperson' => $authenticationid,
            'rb_shippingaddress' => $shippingaddress,
            'rb_state'      => $stateid,
            'rb_billtype'   => 1,
            'rb_totalamount'=> $totalamount,
            'rb_discount'   => $totaldiscount,
            'rb_freight'    => $freight,
            'rb_grandtotal' => $grandtotal,
            'rb_roundoffvalue' => $roundoffvalue,
            'rb_totalgstamnt' => $totalgstamount,
            'rb_oldbalance' => $oldbalance,
            'rb_paidamount' => $paidamount,
            'rb_balanceamount' => $balanceamnt,
            /*'rb_totprofit' => $totalprofitamnt,*/
            'rb_paymentmethod' => $paymethod,
            /*'rb_advance100'  => $fulladvance,*/
            'rb_pagesize' => 1,
            'rb_addedon'  => $authenticationid,
            'rb_addedby'  => $authenticationid,
            'rb_updatedby' => $authenticationid,
            'rb_updatedon' => $curdate,
            'rb_notes' => $salenote
        ), TRUE);

        if($saleid)
        {
            $product1array  = explode(',', $product1);
            $product2array  = explode(',', $product2);
            $n=0;
            $totalprofit = 0;
            foreach($product1array as $prvl)
            {
                $prdarray = explode('#', $prvl);
                $prd2array = explode('#', $product2array[$n]);
                if($prdarray)
                {
                    
                    $productid = $prdarray[0];
                    $stockid = $prdarray[1];
                    $purchaseprice = $prdarray[2];
                    $mrp = $prdarray[3];
                    $unitprice = $prdarray[4];
                    $gst = $prdarray[5];
                    $discountper = $prdarray[6];
                    $netprice = $prdarray[7];
                    $qty = $prdarray[8];
                    $defaultnetprice = $prdarray[9];

                    $gstamount = $prd2array[0];
                    $discountamnt = $prd2array[1];
                    $itemtotalamt = $prd2array[2];
                    $itemnetamt = $prd2array[3];
                    $itemgstamt = $prd2array[4];
                    $itemdiscountamt = $prd2array[5];

                    $batch = 0;
                    $expiry = "";

                    $profitamt = ($purchaseprice*$qty) - ($itemtotalamt*$qty);
                    $totalprofit = $totalprofit + $profitamt;
                    $insert_batch_data[] = array(
                        'rbs_buid'   => $buid,
                        'rbs_finyearid'  => $finyearid,
                        'rbs_retailbillid' => $saleid,
                        'rbs_productid'  => $productid,
                        'rbs_stockid'   => $stockid,
                        'rbs_batchno'   => $batch,
                        'rbs_expirydate' => $expiry,
                        'rbs_purchaseprice' => $purchaseprice,
                        'rbs_mrp'        => $mrp,
                        'rbs_netamount'  => $netprice,
                        'rbs_unitprice'  => $unitprice,
                        'rbs_discountedprice' => $netprice,
                        'rbs_gstpercent' => $gst,
                        'rbs_gstamnt'    => $gstamount,
                        'rbs_cesspercent' => 0,
                        'rbs_cessamount' => 0,
                        'rbs_discountpercent' => $discountper,
                        'rbs_discountamnt'  => $discountamnt,
                        'rbs_qty'        => $qty,
                        'rbs_totalamount' => $itemtotalamt,
                        'rbs_nettotal'   => $itemnetamt,
                        'rbs_totalgst'   => $itemgstamt,
                        'rbs_totalcess'  => 0,
                        'rbs_totaldiscount' => $itemdiscountamt,
                        'rbs_profit' => $profitamt,
                        'rbs_updatedon'  => $curdate,
                        'rbs_updatedby'  => $authenticationid,
                        'rbs_type'     => 0,
                        'rbs_itemunitprice' => $defaultnetprice
                    );
                    
                    $adprdctstck = $this->prdtmdl->reduceproductstock($productid, $qty);
                    $updtestck = $this->prdstck->reduceproductstockbyid($stockid, $qty);
                        
                    
                }
                $n++;
            }

            $insertdrg = $this->retlslv->insert_batch($insert_batch_data);

            $updfince = array(
                'rb_totprofit' => $totalprofit
            );
            $insrt1 = $this->retlmstr->update($saleid, $updfince, TRUE);

/**************** Account module connect start *********************/
            
            // Sale account cr
            $saleamnt = $grandtotal-$totalgstamount-$freight;
            $lastledgr = $this->ldgrentr->getlastledgerentry($buid, 1);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosing = $closamnt+$saleamnt;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $buid,
                'le_finyearid' => $finyearid,
                'le_ledgerid' => 1,
                'le_amount' => $saleamnt,
                'le_isdebit' => 1,
                'le_date' => $curdate,
                'le_closingamount' => $lastclosing,
                'le_issale' => 1,
                'le_salepurchaseid' => $saleid,
                'le_updatedby' => $authenticationid,
                'le_updatedon' => $curdate
            ], TRUE);

            //freight charges cr
            $lastledgr = $this->ldgrentr->getlastledgerentry($buid, 7);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosing = $closamnt-$freight;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $buid,
                'le_finyearid' => $finyearid,
                'le_ledgerid' => 7,
                'le_amount' => $freight,
                'le_isdebit' => 1,
                'le_date' => $curdate,
                'le_closingamount' => $lastclosing,
                'le_issale' => 1,
                'le_salepurchaseid' => $saleid,
                'le_updatedby' => $authenticationid,
                'le_updatedon' => $curdate
            ], TRUE);

            // Outward gst account cr
            $lastledgr = $this->ldgrentr->getlastledgerentry($buid, 2);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosingst = $closamnt+$totalgstamount;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $buid,
                'le_finyearid' => $finyearid,
                'le_ledgerid' => 2,
                'le_amount' => $totalgstamount,
                'le_isdebit' => 1,
                'le_date' => $curdate,
                'le_closingamount' => $lastclosingst,
                'le_issale' => 1,
                'le_salepurchaseid' => $saleid,
                'le_updatedby' => $authenticationid,
                'le_updatedon' => $curdate
            ], TRUE);


            // Cash/Bank account dr
            if($paidamount > 0)
            {
                $lastledgr = $this->ldgrentr->getlastledgerentry($buid, $paymethod);
                if($lastledgr)
                {
                    $closamnt = $lastledgr->le_closingamount;
                }else{
                    $closamnt = 0;
                }
                $lastclosing = $closamnt+$paidamount;
                
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $buid,
                    'le_finyearid' => $finyearid,
                    'le_ledgerid' => $paymethod,
                    'le_amount' => $paidamount,
                    'le_isdebit' => 0,
                    'le_date' => $curdate,
                    'le_closingamount' => $lastclosing,
                    'le_issale' => 1,
                    'le_salepurchaseid' => $saleid,
                    'le_updatedby' => $authenticationid,
                    'le_updatedon' => $curdate
                ], TRUE);
            }

            if($customercheck == '1')
            {
                $updateoldbalance = $this->cstmr->update_status_by([
                    'ct_cstomerid' => $customerid
                ], [
                    'ct_balanceamount' => $balanceamnt
                ]);
                
                $getcustomerledgr = $this->accldgr->getcustomerledgerid($buid, $customerid);
                if($getcustomerledgr)
                {
                    $custledgrid=$getcustomerledgr->al_ledgerid;
                }else{
                    $custledgrid = 0;
                }

                if($oldbalance > 0)
                {
                    // Sundry debitor Oldbalance paid cr
                    if($oldbalance > $balanceamnt)
                    {
                        $debitamnt = $oldbalance - $balanceamnt;

                        $lastledgr = $this->ldgrentr->getlastledgerentry($buid, $custledgrid);
                        if($lastledgr)
                        {
                            $closamnt = $lastledgr->le_closingamount;
                        }else{
                            $closamnt = 0;
                        }
                        $lastclosing = $closamnt+$debitamnt;
                        
                        $insrt = $this->ldgrentr->insert([
                            'le_buid' => $buid,
                            'le_finyearid' => $finyearid,
                            'le_ledgerid' => $custledgrid,
                            'le_amount' => $debitamnt,
                            'le_isdebit' => 1,
                            'le_date' => $curdate,
                            'le_closingamount' => $lastclosing,
                            'le_issale' => 1,
                            'le_salepurchaseid' => $saleid,
                            'le_updatedby' => $authenticationid,
                            'le_updatedon' => $curdate
                        ], TRUE);
                    }
                }

                // Sundry debitor new balance dr
                if($oldbalance < $balanceamnt)
                {
                    $creditamnt = $balanceamnt - $oldbalance;

                    $lastledgr = $this->ldgrentr->getlastledgerentry($buid, $custledgrid);
                    if($lastledgr)
                    {
                        $closamnt = $lastledgr->le_closingamount;
                    }else{
                        $closamnt = 0;
                    }
                    $lastclosing = $closamnt-$creditamnt;
                    
                    $insrt = $this->ldgrentr->insert([
                        'le_buid' => $buid,
                        'le_finyearid' => $finyearid,
                        'le_ledgerid' => $custledgrid,
                        'le_amount' => $creditamnt,
                        'le_isdebit' => 0,
                        'le_date' => $curdate,
                        'le_closingamount' => $lastclosing,
                        'le_issale' => 1,
                        'le_salepurchaseid' => $saleid,
                        'le_updatedby' => $authenticationid,
                        'le_updatedon' => $curdate
                    ], TRUE);
                }
            }

/**************** Account module connect end *********************/

            $this->response(array('status' => 'success', 'message' => 'Sale added successfully'), REST_Controller::HTTP_OK);
        }
        else{
            $this->response(array('status' => 'failed', 'message' => 'Error occured, please try again.'), REST_Controller::HTTP_OK);
        }
        
    }
    
/***************** old functions ********************/
    public function addexpenses_post()
    {
        $this->load->model('admin/expenses_model', 'exptypmdl');

        $authenticationid   = $this->post('authenticationid');
        $expensetypeid   = $this->post('expensetypeid');
        $amount   = $this->post('amount');
        $notes   = $this->post('notes');
        
        $error = array();
        if (!isset($authenticationid) || $authenticationid == "") {
            $error['authenticationid'] = "required";
        }
        if (!isset($expensetypeid) || $expensetypeid == "") {
            $error['expensetypeid'] = "required";
        }
        if (!isset($amount) || $amount == "") {
            $error['amount'] = "required";
        }
        $curdate = date('Y-m-d H:i:s');
        
        if (!count($error)) {

            $insrtexp = $this->exptypmdl->insert([
                'ex_expensetype'  => $expensetypeid,
                'ex_amount'   => $amount,
                'ex_notes' => $notes,
                'ex_addedby' => $authenticationid,
                'ex_addedon' => $curdate,
                'ex_issettle' => 0,
            ], TRUE);

            if($insrtexp)
            {
                $this->response(array('status' => 'success', 'message' => 'Expense added successfully.'), REST_Controller::HTTP_OK);
            }
            else{
                $this->response(array('status' => 'failed', 'message' => 'Error occured, please try again.'), REST_Controller::HTTP_OK);
            }

        }else {
            $this->response(array('status' => 'failed', 'message' => 'Please fill all mandatory fields'), REST_Controller::HTTP_OK);
        }
    }

    public function chitcollection_post()
    {
        $this->load->model('chits/chitcustomers_model', 'chtcustmdl');
        $this->load->model('chits/chitterms_model', 'chtrmdl');

        $authenticationid   = $this->post('authenticationid');
        $chitid   = $this->post('chitid');
        $chitcustomerid   = $this->post('chitcustomerid');

        $collectionamount   = $this->post('collectionamount');
        $termamount   = $this->post('termamount');
        $collectionote   = $this->post('collectionote');

        $startdate   = $this->post('startdate');
        $lastcollectiondate   = $this->post('lastcollectiondate');

        $dayscnt = $collectionamount/$termamount;

       $curdate = date('Y-m-d H:i:s');
        
        $error = array();
        if (!isset($authenticationid) || $authenticationid == "") {
            $error['authenticationid'] = "required";
        }
        if (!isset($chitid) || $chitid == "") {
            $error['chitid'] = "required";
        }
        if (!isset($collectionamount) || $collectionamount == "") {
            $error['collectionamount'] = "required";
        }
        if (!isset($termamount) || $termamount == "") {
            $error['termamount'] = "required";
        }
        
        if (!count($error)) {

            if($lastcollectiondate == "")
            {
                $termstart = date('Y-m-d', strtotime($startdate . ' -1 days'));
            }else{
                $termstart = $lastcollectiondate;
            }

            if($dayscnt > 1)
            {
                $moreterm = 1;
            }else{
                $moreterm = 0;
            }

            $chicustdet = $this->chtcustmdl->getcustomerdetailbyid($chitcustomerid);
            if($chicustdet)
            {
                for($i=1; $i<=$dayscnt; $i++)
                {
                    $termdate = date('Y-m-d', strtotime($termstart .' +'.$i.' days'));

                    if($i== 1)
                    {
                        $collctnamnt = $collectionamount;
                        $mrterm = $moreterm;
                    }else{
                        $collctnamnt = 0;
                        $mrterm = 0;
                    }

                    $insrt = $this->chtrmdl->insert([
                        'ct_chitid'  => $chitid,
                        'ct_chitcustomerid'   => $chitcustomerid,
                        'ct_date' => $termdate,
                        'ct_amount' => $termamount,
                        'ct_ismoreterms' => $mrterm,
                        'ct_totalamount' => $collectionamount,
                        'ct_notes' => $collectionote,
                        'ct_updatedby' => $authenticationid,
                        'ct_updatedon' => $curdate,
                        'ct_issettle'  => 0
                    ], TRUE);
                }

                if($insrt)
                {
                    $paiddays = $chicustdet->cc_paiddays;
                    $totaldays = $chicustdet->ch_dayscount;

                    $totalpaiddays = $paiddays + $dayscnt;

                    if($totaldays == $totalpaiddays)
                    {
                        $closed = 1;
                    }else{
                        $closed = 0;
                    }

                    $updfince = array(
                        'cc_paiddays' => $totalpaiddays,
                        'cc_isfinished' => $closed
                    );
                    $insrt1 = $this->chtcustmdl->update($chitcustomerid, $updfince, TRUE);


                    $this->response(array('status' => 'success', 'message' => 'Collection updated successfully.'), REST_Controller::HTTP_OK);
                }else{
                    $this->response(array('status' => 'failed', 'message' => 'Error occured, please try again.'), REST_Controller::HTTP_OK);
                }
            }
            else{
                $this->response(array('status' => 'failed', 'message' => 'Chit details not available.'), REST_Controller::HTTP_OK);
            }
            

        }else {
            $this->response(array('status' => 'failed', 'message' => 'Please fill all mandatory fields'), REST_Controller::HTTP_OK);
        }
    }

    
/************WEB API THird PARTY END********/
    public function random_password()
    {
        $alphabet = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $password = array();
        $alpha_length = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alpha_length);
            $password[] = $alphabet[$n];
        }
        return implode($password);
    }
    public function checksumgen($val)
    {
        $checksum = sha1(HASHCODE . $val);
        return $checksum;
    }

}
