<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sale extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('welcome/userauthentication_model', 'usersigin');
        $this->load->model('admin/business_model', 'bus');
        $this->load->model('admin/businessunit_model', 'busunt');
        $this->load->model('inventory/products_model', 'prdtmdl');
        $this->load->model('inventory/inventorysettings_model', 'invset');
        $this->load->model('inventory/productcategories_model', 'prdcat');

        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('purchase/Productstock_model', 'prdstck');

        ini_set('max_execution_time', 35000);
    }
    public function orderhistory($ordertype=0, $salesperson='all', $customer='all', $fromdate=0, $todate=0)
    {
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('inventory/godowns_model', 'gdwn');
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $this->data['billprintdet'] = $billprintdet = $this->blprnt->getbillprintdetails($this->buid);

        $this->data['dupprint'] = 0;
        $this->data['tripprint'] = 0;
        
        $this->data['godowns'] = $this->gdwn->getactiverows($this->buid);

        $this->data['userlist'] = $this->usersigin->getbusinessunitusers($this->buid);
        $this->data['customers'] = $this->cstmr->getactivecustomers($this->buid);
        $this->data['salesperson'] = $salesperson;
        $this->data['customer'] = $customer;
        $this->data['ordertype'] = $ordertype;
        if($ordertype == 0)
        {
            $this->data['title'] = "New Orders";
        }else if($ordertype == 1){
            $this->data['title'] = "Confirmed Orders";
        }else{
            $this->data['title'] = "Cancelled Orders";
        }
        
        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-7 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['retaillist'] = $this->retlmstr->getneworderlist($this->buid, $ordertype, $salesperson, $customer, $fromdate, $todate);
        $this->load->template('orderhistory', $this->data, FALSE);
    }
    public function cancelorderfun($billid)
    {
        $updeorder = array(
            'rb_orderstatus'=> 2
        );
        $updatepreorder = $this->retlmstr->update($billid, $updeorder, TRUE);
        if($updatepreorder)
        {
            $this->session->set_flashdata('messageS', 'Order Cancelled Successfully.');
            redirect('sale/orderhistory');
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
            redirect('sale/orderhistory');
        }

    }

    public function salehistory($type='0', $godownid='0', $salesperson='all', $customer='all', $fromdate=0, $todate=0)
    {
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('inventory/godowns_model', 'gdwn');
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $this->data['billprintdet'] = $billprintdet = $this->blprnt->getbillprintdetails($this->buid);

        $this->data['dupprint'] = 0;
        $this->data['tripprint'] = 0;
        if($billprintdet)
        {
            if($type == '0' || $type == '1' || $type == '7' || $type == '8')
            {
                $this->data['dupprint'] = $billprintdet->bp_needdupinvoice;
                $this->data['tripprint'] = $billprintdet->bp_needtripinvoice;
            }
        }

        $this->data['godowns'] = $this->gdwn->getactiverows($this->buid);

        $this->data['godownid'] = $godownid;

        $this->data['userlist'] = $this->usersigin->getbusinessunitusers($this->buid);
        $this->data['customers'] = $this->cstmr->getactivecustomers($this->buid);
        $this->data['type'] = $type;
        $this->data['salesperson'] = $salesperson;
        $this->data['customer'] = $customer;
        if($type == '0')
        {
            $this->data['title'] = "Retail";
        }
        else if($type == '1'){
            $this->data['title'] = "Wholesale";
        }else if($type == '2'){
            $this->data['title'] = "Retail Proforma";
        }else if($type == '3'){
            $this->data['title'] = "Retail Quotation";
        }else if($type == '4'){
            $this->data['title'] = "Wholesale Proforma";
        }else if($type == '5'){
            $this->data['title'] = "Wholesale Quotation";
        }else if($type == '7'){
            $this->data['title'] = "C Sale";
        }else if($type == '8'){
            $this->data['title'] = "D Sale";
        }
        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-7 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['retaillist'] = $this->retlmstr->getretailbillhistoryfilter($this->buid, $type, $godownid, $salesperson, $customer, $fromdate, $todate);
        $this->load->template('salehistory', $this->data, FALSE);
    }
    public function csvsalehistory($type, $godownid, $salesperson, $customer, $fromdate, $todate)
    {
        $this->load->model('business/customers_model', 'cstmr');
        if($type == '0')
        {
            $title = "Retail";
        }
        else if($type == '1'){
            $title = "Wholesale";
        }else if($type == '2'){
            $title = "Retail Proforma";
        }else if($type == '3'){
            $title = "Retail Quotation";
        }else if($type == '4'){
            $title = "Wholesale Proforma";
        }else if($type == '5'){
            $title = "Wholesale Quotation";
        }else if($type == '7'){
            $this->data['title'] = "C Sale";
        }else if($type == '8'){
            $this->data['title'] = "D Sale";
        }

        $salesdet = "";
        if($salesperson != 'all')
        {
            $salespersondet = $this->usersigin->getrowbyid($salesperson);
            $salesdet = "Sales Person: " . $salespersondet->at_name;
        }
        if($customer != 'all')
        {
            if($customer == '0')
            {
                $salesdet = $salesdet . " - Walk in Customers";
            }else{
                $customerdet = $this->cstmr->getcustomerdetailsbyid($customer);
                $salesdet =  $salesdet . " - Customer: " . $customerdet->ct_name;
            }
            
        }

        $retaillist = $this->retlmstr->getretailbillhistoryfilter($this->buid, $type, $godownid, $salesperson, $customer, $fromdate, $todate);

        $alltotalamount =0;
        $alldiscount = 0;
        $newArray=[];

        foreach ($retaillist as $list) {
            $rb_billno=$list->rb_billprefix . "" .$list->rb_billno;

            $customer_id = $list->rb_customerid;
            $billid=$list->rb_retailbillid;
            $alltotalamount=$alltotalamount+ $list->rb_grandtotal;
            $alldiscount=$alldiscount+ $list->rb_discount;

            if($list->rb_existcustomer == 1)
            {
                $custdet = $this->cstmr->getcustomerdetailsbyid($customer_id);
                $cname=$custdet->ct_name;
                $phone = $custdet->ct_phone;
             }
             else
             {
                $cname=$list->rb_customername;
                $phone = $list->rb_phone;
             }
            $itemdetails = $this->retlslv->getsaleproducts($billid);
            if ($itemdetails) 
            {
            foreach ($itemdetails as $product) 
            {
                // print_r($itemdetails);exit;
               $item_name=$product->pd_productname;
               $unitprice=$product->rbs_unitprice;
               $gst=$product->rbs_gstamnt;
               $quantity=$product->rbs_qty;
               $item_discount=$product->rbs_totaldiscount;
               $total_item=$product->rbs_totalamount;

                $newArray[]=array(
                "Bill No"=> $rb_billno,
                "date"=> date('d-M-Y H:i', strtotime($list->rb_date)),
                "customer"=> $cname,
                "phone"=> $phone,
                "product"=>$item_name,
                "unitprice"=>price_roundof($unitprice),
                $this->isvatgstname =>price_roundof($gst),
                "Item Discount"=>price_roundof($item_discount),
                "Quantity"=>$quantity,
                "Totals"=>price_roundof($total_item),
                "Total"=> price_roundof($list->rb_grandtotal),
                // "Discount tot"=>$list['rb_discount'],
                "Discont"=>price_roundof($item_discount),

                 );
               }
            } 

        }

        $filename =$title. " Report " .date('d-m-Y').'.csv';
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$filename"); 
         header("Content-Type: application/csv; ");

         // file creation 
         $file = fopen('php://output', 'w');

        $title = array($title." Report ". date('d-m-Y', strtotime($fromdate))."/" . date('d-m-Y', strtotime($todate)) . " " . $salesdet); 
        

        fputcsv($file, $title);
      $header = array("Bill No","Bill date", "Customer","Phone","Product","Unit price",$this->isvatgstname,"Item Discount","Quantity","Item Total","Total","Discounts"); 
     fputcsv($file, $header);

     array_push($newArray, array(
            
           '',
           '',
           '',
           '',
           '',
           '',
           '',
           '',
           '',
           'Total',
            (price_roundof($alltotalamount)) ,
            (price_roundof($alldiscount)),
        ));

        foreach ($newArray as $key => $value) {
            fputcsv($file,$value);
        }
        fclose($file); 
        exit;
    }
    public function printsalehistory($type, $godownid, $salesperson, $customer, $fromdate, $todate)
    {
        $this->load->model('business/customers_model', 'cstmr');
        if($type == '0')
        {
            $this->data['title'] = "Retail";
        }
        else if($type == '1'){
            $this->data['title'] = "Wholesale";
        }else if($type == '2'){
            $this->data['title'] = "Retail Proforma";
        }else if($type == '3'){
            $this->data['title'] = "Retail Quotation";
        }else if($type == '4'){
            $this->data['title'] = "Wholesale Proforma";
        }else if($type == '5'){
            $this->data['title'] = "Wholesale Quotation";
        }
        else if($type == '7'){
            $this->data['title'] = "C Sale";
        }else if($type == '8'){
            $this->data['title'] = "D Sale";
        }
        $this->data['type'] = $type;
        $this->data['salesperson'] = $salesperson;
        $this->data['customer'] = $customer;
        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;
        if($salesperson != 'all')
        {
            $this->data['salespersondet'] = $this->usersigin->getrowbyid($salesperson);
        }
        if($customer != 'all' && $customer != '0')
        {
            $this->data['customerdet'] = $this->cstmr->getcustomerdetailsbyid($customer);
        }
        $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
        $this->data['retaillist'] = $this->retlmstr->getretailbillhistoryfilter($this->buid, $type, $godownid, $salesperson, $customer, $fromdate, $todate);

        $this->load->view('printsalehistory',$this->data, FALSE);
    }
    public function salereturns($type=5, $fromdate=0, $todate=0)
    {
        $this->load->model('business/customers_model', 'cstmr');
        $this->data['type'] = $type;
        if($type == '0')
        {
            $this->data['title'] = "Retail";
        }
        else if($type == '1'){
            $this->data['title'] = "Wholesale";
        }else{
            $this->data['title'] = "Sale";
        }
        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-7 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['retaillist'] = $this->retlmstr->getsalereturnlist($this->buid, $type, $fromdate, $todate);
        $this->load->template('salereturns', $this->data, FALSE);
    }
    public function getbillitemdetails()
    {
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $this->data['billprintdet'] = $billprintdet = $this->blprnt->getbillprintdetails($this->buid);
        $this->data['showpurchaserate'] = 0;
        $this->data['remarkfield'] = 0;
        if($billprintdet)
        {
            $this->data['showpurchaserate'] = $billprintdet->bp_hidepurchaseprice;
            $this->data['remarkfield'] = $billprintdet->bp_remarkcolumn;
        }

        $billid = $this->input->post('billid');
        $this->data['type'] = $type = $this->input->post('type');
        $this->data['itemdetails'] = $this->retlslv->getsaleproducts($billid);
        $this->load->view('ajaxsaleitemview', $this->data);
    }
    public function speedbilling($type=0, $billid=0)
    {
        $this->load->model('Country_model', 'cuntry');
        $this->load->model('inventory/godowns_model', 'gdwn');
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $this->data['billprintdet'] = $billprintdet = $this->blprnt->getbillprintdetails($this->buid);

        $this->data['userlist'] = $this->usersigin->getbusinessunitusers($this->buid);

        $this->data['businessdet'] = $businessdet = $this->busunt->getprintbusinessunitdetails($this->buid);

        $this->data['type'] = $type;
        $this->data['pretype'] = 0;
        $this->data['billid'] = $billid;
        $this->data['billprefix'] = "";
        $this->data['orderid'] = 0;

        $this->data['showpurchaserate'] = 0;
        $this->data['remarkfield'] = 0;
        $this->data['hidevehiclenumber'] = 0;
        $this->data['hideewaybillno'] = 0;
        $this->data['hidedeliverydate'] = 0;
        $this->data['hidepodetails'] = 0;
        $this->data['defaultpagesize'] = 1;
        if($billprintdet)
        {
            $this->data['showpurchaserate'] = $billprintdet->bp_hidepurchaseprice;
            $this->data['remarkfield'] = $billprintdet->bp_remarkcolumn;
            $this->data['hidevehiclenumber'] = $billprintdet->bp_hidevehiclenumber;
            $this->data['hideewaybillno'] = $billprintdet->bp_hideewaybillno;
            $this->data['hidedeliverydate'] = $billprintdet->bp_hidedeliverydate;
            $this->data['hidepodetails'] = $billprintdet->bp_hidepodetails;
            $this->data['defaultpagesize'] = $billprintdet->bp_defaultpagesize;
        }

        if($billid != '0')
        {
            if($type == '0')
            {
                $this->data['title'] = "Update Retail Billing";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_retailprefix;
                }
            }
            else if($type == '1'){
                $this->data['title'] = "Update Wholesale Billing";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_wholesaleprefix;
                }
            }else if($type == '2'){
                $this->data['title'] = "Update Retail Proforma Invoice";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_proformaprefix;
                }
            }else if($type == '3'){
                $this->data['title'] = "Update Retail Quotation";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_quotationprefix;
                }
            }else if($type == '4'){
                $this->data['title'] = "Update Wholesale Proforma Invoice";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_wholesaleproformaprefix;
                }
            }else if($type == '5'){
                $this->data['title'] = "Update Wholesale Quotation";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_wholesalequotationprefix;
                }
            }else if($type == '6'){
                $this->data['title'] = "Update Order";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_orderprefix;
                }
            }else if($type == '7'){
                $this->data['title'] = "Update C Sale";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_csaleprefix;
                }
            }else if($type == '8'){
                $this->data['title'] = "Update D Sale";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_dsaleprefix;
                }
            }


            $this->data['editdata'] = $this->retlmstr->getretailbilldetailsbyid($billid);
            $this->data['edititems'] = $this->retlslv->getsaleproducts($billid);
        }
        else{
            if($type == '0')
            {
                $this->data['title'] = "Retail Billing";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_retailprefix;
                }
            }
            else if($type == '1'){
                $this->data['title'] = "Wholesale Billing";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_wholesaleprefix;
                }
            }else if($type == '2'){
                $this->data['title'] = "Retail Proforma Invoice";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_proformaprefix;
                }
            }else if($type == '3'){
                $this->data['title'] = "Retail Quotation";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_quotationprefix;
                }
            }else if($type == '4'){
                $this->data['title'] = "Wholesale Proforma Invoice";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_wholesaleproformaprefix;
                }
            }else if($type == '5'){
                $this->data['title'] = "Wholesale Quotation";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_wholesalequotationprefix;
                }
            }else if($type == '6'){
                $this->data['title'] = "Order";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_orderprefix;
                }
            }else if($type == '7'){
                $this->data['title'] = "C Sale";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_csaleprefix;
                }
            }else if($type == '8'){
                $this->data['title'] = "D Sale";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_dsaleprefix;
                }
            }
        }
        
        $this->data['godowns'] = $this->gdwn->getactiverows($this->buid);
        $this->data['states'] = $this->cuntry->getstatelist($businessdet->bu_country);

        $this->data['billno'] = $this->retlmstr->getnextretailbillno($this->buid, $type);

        $this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['maincategories'] = $this->prdcat->getmaincategories($this->buid);
        $this->data['productlist'] = $this->prdtmdl->getallrows($this->buid);
        
        $this->load->template('speedbilling', $this->data, FALSE);
    }
    public function dashboard($type=0, $billid=0)
    {
        $this->load->model('Country_model', 'cuntry');
        $this->load->model('inventory/godowns_model', 'gdwn');
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $this->data['billprintdet'] = $billprintdet = $this->blprnt->getbillprintdetails($this->buid);

        $this->data['userlist'] = $this->usersigin->getbusinessunitusers($this->buid);

        $this->data['businessdet'] = $businessdet = $this->busunt->getprintbusinessunitdetails($this->buid);

        $this->data['type'] = $type;
        $this->data['pretype'] = 0;
        $this->data['billid'] = $billid;
        $this->data['billprefix'] = "";
        $this->data['orderid'] = 0;

        $this->data['showpurchaserate'] = 0;
        $this->data['remarkfield'] = 0;
        $this->data['hidevehiclenumber'] = 0;
        $this->data['hideewaybillno'] = 0;
        $this->data['hidedeliverydate'] = 0;
        $this->data['hidepodetails'] = 0;
        $this->data['defaultpagesize'] = 1;
        if($billprintdet)
        {
            $this->data['showpurchaserate'] = $billprintdet->bp_hidepurchaseprice;
            $this->data['remarkfield'] = $billprintdet->bp_remarkcolumn;
            $this->data['hidevehiclenumber'] = $billprintdet->bp_hidevehiclenumber;
            $this->data['hideewaybillno'] = $billprintdet->bp_hideewaybillno;
            $this->data['hidedeliverydate'] = $billprintdet->bp_hidedeliverydate;
            $this->data['hidepodetails'] = $billprintdet->bp_hidepodetails;
            $this->data['defaultpagesize'] = $billprintdet->bp_defaultpagesize;
        }

        if($billid != '0')
        {
            if($type == '0')
            {
                $this->data['title'] = "Update Retail Billing";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_retailprefix;
                }
            }
            else if($type == '1'){
                $this->data['title'] = "Update Wholesale Billing";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_wholesaleprefix;
                }
            }else if($type == '2'){
                $this->data['title'] = "Update Retail Proforma Invoice";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_proformaprefix;
                }
            }else if($type == '3'){
                $this->data['title'] = "Update Retail Quotation";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_quotationprefix;
                }
            }else if($type == '4'){
                $this->data['title'] = "Update Wholesale Proforma Invoice";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_wholesaleproformaprefix;
                }
            }else if($type == '5'){
                $this->data['title'] = "Update Wholesale Quotation";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_wholesalequotationprefix;
                }
            }else if($type == '6'){
                $this->data['title'] = "Update Order";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_orderprefix;
                }
            }else if($type == '7'){
                $this->data['title'] = "Update C Sale";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_csaleprefix;
                }
            }else if($type == '8'){
                $this->data['title'] = "Update D Sale";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_dsaleprefix;
                }
            }


            $this->data['editdata'] = $this->retlmstr->getretailbilldetailsbyid($billid);
            $this->data['edititems'] = $this->retlslv->getsaleproducts($billid);
        }
        else{
            if($type == '0')
            {
                $this->data['title'] = "Retail Billing";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_retailprefix;
                }
            }
            else if($type == '1'){
                $this->data['title'] = "Wholesale Billing";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_wholesaleprefix;
                }
            }else if($type == '2'){
                $this->data['title'] = "Retail Proforma Invoice";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_proformaprefix;
                }
            }else if($type == '3'){
                $this->data['title'] = "Retail Quotation";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_quotationprefix;
                }
            }else if($type == '4'){
                $this->data['title'] = "Wholesale Proforma Invoice";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_wholesaleproformaprefix;
                }
            }else if($type == '5'){
                $this->data['title'] = "Wholesale Quotation";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_wholesalequotationprefix;
                }
            }else if($type == '6'){
                $this->data['title'] = "Order";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_orderprefix;
                }
            }else if($type == '7'){
                $this->data['title'] = "C Sale";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_csaleprefix;
                }
            }else if($type == '8'){
                $this->data['title'] = "D Sale";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_dsaleprefix;
                }
            }
        }
        
        $this->data['godowns'] = $this->gdwn->getactiverows($this->buid);
        $this->data['states'] = $this->cuntry->getstatelist($businessdet->bu_country);

        $this->data['billno'] = $this->retlmstr->getnextretailbillno($this->buid, $type);

        $this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['maincategories'] = $this->prdcat->getmaincategories($this->buid);
        $this->data['productlist'] = $this->prdtmdl->getallrows($this->buid);
        
        $this->load->template('dashboard', $this->data, FALSE);
        
    }
    public function confirmdashboard($pretype=0, $billid=0)
    {
        $this->load->model('Country_model', 'cuntry');
        $this->load->model('inventory/godowns_model', 'gdwn');
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $this->data['billprintdet'] = $billprintdet = $this->blprnt->getbillprintdetails($this->buid);

        $this->data['businessdet'] = $businessdet = $this->busunt->getprintbusinessunitdetails($this->buid);
        $this->data['userlist'] = $this->usersigin->getbusinessunitusers($this->buid);
        
        $this->data['billid'] = 0;
        $this->data['orderid'] = $billid;
        $this->data['billprefix'] = "";
        $this->data['pretype'] = $pretype;

        $this->data['showpurchaserate'] = 0;
        $this->data['remarkfield'] = 0;
        $this->data['hidevehiclenumber'] = 0;
        $this->data['hideewaybillno'] = 0;
        $this->data['hidedeliverydate'] = 0;
        $this->data['hidepodetails'] = 0;
        $this->data['defaultpagesize'] = 1;
        if($billprintdet)
        {
            $this->data['showpurchaserate'] = $billprintdet->bp_hidepurchaseprice;
            $this->data['remarkfield'] = $billprintdet->bp_remarkcolumn;
            $this->data['hidevehiclenumber'] = $billprintdet->bp_hidevehiclenumber;
            $this->data['hideewaybillno'] = $billprintdet->bp_hideewaybillno;
            $this->data['hidedeliverydate'] = $billprintdet->bp_hidedeliverydate;
            $this->data['hidepodetails'] = $billprintdet->bp_hidepodetails;
            $this->data['defaultpagesize'] = $billprintdet->bp_defaultpagesize;
        }

        if($pretype == '2'){
            $this->data['title'] = "Confirm Retail Proforma Invoice";
            $type= 0;
            if($billprintdet)
            {
                $this->data['billprefix'] = $billprintdet->bp_retailprefix;
            }
        }else if($pretype == '3'){
            $this->data['title'] = "Confirm Retail Quotation";
            $type= 0;
            if($billprintdet)
            {
                $this->data['billprefix'] = $billprintdet->bp_retailprefix;
            }
        }else if($pretype == '4'){
            $this->data['title'] = "Confirm Wholesale Proforma Invoice";
            $type= 1;
            if($billprintdet)
            {
                $this->data['billprefix'] = $billprintdet->bp_wholesaleprefix;
            }
        }else if($pretype == '5'){
            $this->data['title'] = "Confirm Wholesale Quotation";
            $type= 1;
            if($billprintdet)
            {
                $this->data['billprefix'] = $billprintdet->bp_wholesaleprefix;
            }
        }else if($pretype == '6'){
            $this->data['title'] = "Confirm Order";
            $type= 0;
            if($billprintdet)
            {
                $this->data['billprefix'] = $billprintdet->bp_retailprefix;
            }
        }

        $this->data['editdata'] = $this->retlmstr->getretailbilldetailsbyid($billid);
        $this->data['edititems'] = $this->retlslv->getsaleproducts($billid);

        $this->data['type'] = $type;

        $this->data['godowns'] = $this->gdwn->getactiverows($this->buid);
        $this->data['states'] = $this->cuntry->getstatelist($businessdet->bu_country);

        $this->data['billno'] = $this->retlmstr->getnextretailbillno($this->buid, $type);

        $this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['maincategories'] = $this->prdcat->getmaincategories($this->buid);
        $this->data['productlist'] = $this->prdtmdl->getallrows($this->buid);
        
        $this->load->template('dashboard', $this->data, FALSE);
    }
    public function dashboardreturn($type=0, $billid=0)
    {
        $this->load->model('Country_model', 'cuntry');
        $this->load->model('inventory/godowns_model', 'gdwn');
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $this->data['billprintdet'] = $billprintdet = $this->blprnt->getbillprintdetails($this->buid);
        $this->data['userlist'] = $this->usersigin->getbusinessunitusers($this->buid);

        $this->data['businessdet'] = $businessdet = $this->busunt->getprintbusinessunitdetails($this->buid);

        $this->data['type'] = $type;
        $this->data['billid'] = $billid;
        $this->data['billprefix'] = "";
        $this->data['prevbillprefix'] = "";

        $this->data['showpurchaserate'] = 0;
        $this->data['remarkfield'] = 0;
        $this->data['defaultpagesize'] = 1;
        if($billprintdet)
        {
            $this->data['showpurchaserate'] = $billprintdet->bp_hidepurchaseprice;
            $this->data['remarkfield'] = $billprintdet->bp_remarkcolumn;
            $this->data['billprefix'] = $billprintdet->bp_salereturnprefix;
            $this->data['defaultpagesize'] = $billprintdet->bp_defaultpagesize;
        }

        if($billid != '0')
        {
            if($type == '0')
            {
                $this->data['title'] = "Retail Return";
                if($billprintdet)
                {
                    $this->data['prevbillprefix'] = $billprintdet->bp_retailprefix;
                }
            }
            else if($type == '1'){
                $this->data['title'] = "Wholesale Return";
                if($billprintdet)
                {
                    $this->data['prevbillprefix'] = $billprintdet->bp_wholesaleprefix;
                }
            }
            else if($type == '7'){
                $this->data['title'] = "Sale Return";
                if($billprintdet)
                {
                    $this->data['prevbillprefix'] = $billprintdet->bp_csaleprefix;
                }
            }
            else if($type == '8'){
                $this->data['title'] = "Sale Return";
                if($billprintdet)
                {
                    $this->data['prevbillprefix'] = $billprintdet->bp_dsaleprefix;
                }
            }

            $this->data['editdata'] = $this->retlmstr->getretailbilldetailsbyid($billid);
            $this->data['edititems'] = $this->retlslv->getsaleproducts($billid);
        }
        
        
        $this->data['godowns'] = $this->gdwn->getactiverows($this->buid);
        $this->data['states'] = $this->cuntry->getstatelist('101');

        $this->data['billno'] = $this->retlmstr->getnextretailbillno($this->buid, $type);

        $this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['maincategories'] = $this->prdcat->getmaincategories($this->buid);
        $this->data['productlist'] = $this->prdtmdl->getallrows($this->buid);

        $this->load->template('dashboardreturn', $this->data, FALSE);
    }

    
    public function addingquotation()
    {
        $this->load->model('business/customers_model', 'cstmr');
        $type = $this->input->post('type');
        $billno = $this->input->post('billno');
        $saledate = date('Y-m-d', strtotime($this->input->post('saledate')));
        $saletime = date('H:i:s', strtotime($this->input->post('saletime')));

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
        $godownid = $this->input->post('godownid');
        $stateid = $this->input->post('stateid');

        $productid = $this->input->post('productid');
        $stockid = $this->input->post('stockid');
        $batchno = $this->input->post('batchno');
        $expirydate = $this->input->post('expirydate');
        $purchaseprice = $this->input->post('purchaseprice');
        $mrp = $this->input->post('mrp');
        $unitprice = $this->input->post('unitprice');
        $discountedprice = $this->input->post('discountedprice');
        $gst = $this->input->post('gst');
        $itemgstval = $this->input->post('itemgstval');
        $cess = $this->input->post('cess');
        $itemcessval = $this->input->post('itemcessval');
        $discountper = $this->input->post('discountper');
        $discountamnt = $this->input->post('discountamnt');
        $netprice = $this->input->post('netprice');
        $qty = $this->input->post('qty');
        $itemnetamt = $this->input->post('itemnetamt');
        $itemgstamt = $this->input->post('itemgstamt');
        $itemcessamt = $this->input->post('itemcessamt');
        $itemdiscountamt = $this->input->post('itemdiscountamt');
        $itemtotalamt = $this->input->post('itemtotalamt');
        $itemnetprice = $this->input->post('itemnetprice');

        $totaldiscount = $this->input->post('totaldiscount');
        $freight = $this->input->post('freight');
        $totalamount = $this->input->post('totalamount');
        $oldbalance = $this->input->post('oldbalance');
        $grandtotal = $this->input->post('grandtotal');
        $paidamount = $this->input->post('paidamount');
        $paymethod = $this->input->post('paymethod');
        $balanceamnt = $this->input->post('balanceamnt');
        $pagesize = $this->input->post('pagesize');
        $fulladvance = $this->input->post('fulladvance');
        $billtype = $this->input->post('billtype');

        $saleid = $this->retlmstr->insert(array(
            'rb_buid'       => $this->buid,
            'rb_finyearid'  => $this->finyearid,
            'rb_billingtype'=> 3,
            'rb_billno'     => $billno,
            'rb_date'       => $saledate,
            'rb_time'       => $saletime,
            'rb_existcustomer'=> $customercheck,
            'rb_customerid' => $customerid,
            'rb_customername' => $customername,
            'rb_phone'      => $customerphone,
            'rb_address'    => $customeraddress,
            'rb_gstno'      => $customergstin,
            'rb_vehicleno'  => $vehicleno,
            'rb_salesperson' => $salesperson,
            'rb_shippingaddress' => $shippingaddress,
            'rb_state'      => $stateid,
            'rb_billtype'   => $billtype,
            'rb_totalamount'=> $totalamount,
            'rb_discount'   => 0,
            'rb_freight'    => 0,
            'rb_grandtotal' => $totalamount,
            'rb_oldbalance' => 0,
            'rb_paidamount' => 0,
            'rb_balanceamount' => 0,
            'rb_pagesize' => $pagesize,
            'rb_addedon'  => $this->updatedon,
            'rb_addedby'  => $this->loggeduserid,
            'rb_updatedby' => $this->loggeduserid,
            'rb_updatedon' => $this->updatedon
        ), TRUE);

        if($saleid)
        {
            
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

                    $insrtslv = $this->retlslv->insert(array(
                        'rbs_buid'   => $this->buid,
                        'rbs_finyearid'  => $this->finyearid,
                        'rbs_retailbillid' => $saleid,
                        'rbs_productid'  => $prvl,
                        'rbs_stockid'   => $stockid[$k],
                        'rbs_batchno'   => $batch,
                        'rbs_expirydate' => $expiry,
                        'rbs_purchaseprice' => $purchaseprice[$k],
                        'rbs_mrp'        => $mrp[$k],
                        'rbs_netamount'  => $netprice[$k],
                        'rbs_unitprice'  => $unitprice[$k],
                        'rbs_discountedprice' => $discountedprice[$k],
                        'rbs_gstpercent' => $gst[$k],
                        'rbs_gstamnt'    => $itemgstval[$k],
                        'rbs_cesspercent' => 0,
                        'rbs_cessamount' => 0,
                        'rbs_discountpercent' => 0,
                        'rbs_discountamnt'  => 0,
                        'rbs_qty'        => $qty[$k],
                        'rbs_totalamount' => $itemtotalamt[$k],
                        'rbs_nettotal'   => $itemnetamt[$k],
                        'rbs_totalgst'   => $itemgstamt[$k],
                        'rbs_totalcess'  => 0,
                        'rbs_totaldiscount' => 0,
                        'rbs_updatedon'  => $this->updatedon,
                        'rbs_updatedby'  => $this->loggeduserid,
                        'rbs_type'     => 3,
                        'rbs_itemunitprice' => $itemnetprice
                    ), TRUE);

                    
                }
                
                $k++;
            }

            $this->session->set_flashdata('messageS', 'Quotation Added Successfully.');
            redirect('sale/saleprint/'.$saleid.'/1/'.$type);
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
            redirect('sale/dashboard');
        }
    }
    public function addingsale()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');
        $this->load->model('business/customers_model', 'cstmr');
        $billprefix = $this->input->post('billprefix');
        $billid = $this->input->post('billid');
        $type = $this->input->post('type');
        $pretype = $this->input->post('pretype');
        //$billno = $this->input->post('billno');
        $billno = $this->retlmstr->getnextretailbillno($this->buid, $type);
        $orderid = $this->input->post('orderid');

        if($type == 6)
        {
            $isorder = 1;
        }else{
            $isorder = 0;
        }

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
        $godownid = $this->input->post('godownid');
        $stateid = $this->input->post('stateid');

        $productid = $this->input->post('productid');
        $stockid = $this->input->post('stockid');
        $batchno = $this->input->post('batchno');
        $expirydate = $this->input->post('expirydate');
        $purchaseprice = $this->input->post('purchaseprice');
        $mrp = $this->input->post('mrp');
        $unitprice = $this->input->post('unitprice');
        $discountedprice = $this->input->post('discountedprice');
        $gst = $this->input->post('gst');
        $itemgstval = $this->input->post('itemgstval');
        $cess = $this->input->post('cess');
        $itemcessval = $this->input->post('itemcessval');
        $discountper = $this->input->post('discountper');
        $discountamnt = $this->input->post('discountamnt');
        $netprice = $this->input->post('netprice');
        $qty = $this->input->post('qty');
        $itemnetamt = $this->input->post('itemnetamt');
        $itemgstamt = $this->input->post('itemgstamt');
        $itemcessamt = $this->input->post('itemcessamt');
        $itemdiscountamt = $this->input->post('itemdiscountamt');
        $itemtotalamt = $this->input->post('itemtotalamt');
        $itemtotalprofit = $this->input->post('itemtotalprofit');
        $remarks = $this->input->post('remarks');
        $itemnetprice = $this->input->post('itemnetprice');

        $totaldiscount = $this->input->post('totaldiscount');
        $freight = $this->input->post('freight');
        $totalamount = $this->input->post('totalamount');
        $oldbalance = $this->input->post('oldbalance');
        $roundoffvalue = $this->input->post('roundoffvalue');
        $grandtotal = $this->input->post('grandtotal');
        $paidamount = $this->input->post('paidamount');
        $paymethod = $this->input->post('paymethod');
        $balanceamnt = $this->input->post('balanceamnt');
        $pagesize = $this->input->post('pagesize');
        $fulladvance = $this->input->post('fulladvance');
        $billtype = $this->input->post('billtype');

        $totalgstamount = $this->input->post('totalgstamount');
        $totalprofitamnt = $this->input->post('totalprofitamnt');


        $ewaybillno = $this->input->post('ewaybillno');
        $deliverydate = date('Y-m-d', strtotime($this->input->post('deliverydate')));
        $ponumber = $this->input->post('ponumber');
        $podate = date('Y-m-d', strtotime($this->input->post('podate')));

        $salenote = $this->input->post('salenote');

        if($billid ==0 || $billid == "")
        {
            $editdet = 0;

            /*$existbilno = $this->retlmstr->checkalreadyexistbillno($this->buid, $billno);
            if(!$existbilno)
            {*/
                $saleid = $this->retlmstr->insert(array(
                    'rb_buid'       => $this->buid,
                    'rb_finyearid'  => $this->finyearid,
                    'rb_billingtype'=> $type,
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
                    'rb_vehicleno'  => $vehicleno,
                    'rb_godownid' => $godownid,
                    'rb_salesperson' => $salesperson,
                    'rb_shippingaddress' => $shippingaddress,
                    'rb_state'      => $stateid,
                    'rb_billtype'   => $billtype,
                    'rb_totalamount'=> $totalamount,
                    'rb_discount'   => $totaldiscount,
                    'rb_freight'    => $freight,
                    'rb_grandtotal' => $grandtotal,
                    'rb_roundoffvalue' => $roundoffvalue,
                    'rb_totalgstamnt' => $totalgstamount,
                    'rb_oldbalance' => $oldbalance,
                    'rb_paidamount' => $paidamount,
                    'rb_balanceamount' => $balanceamnt,
                    'rb_totprofit' => $totalprofitamnt,
                    'rb_paymentmethod' => $paymethod,
                    'rb_advance100'  => $fulladvance,
                    'rb_pagesize' => $pagesize,
                    'rb_addedon'  => $this->updatedon,
                    'rb_addedby'  => $this->loggeduserid,
                    'rb_updatedby' => $this->loggeduserid,
                    'rb_updatedon' => $this->updatedon,
                    'rb_ewaybillno' => $ewaybillno,
                    'rb_deliverydate' => $deliverydate,
                    'rb_ponumber' => $ponumber,
                    'rb_podate' => $podate,
                    'rb_notes' => $salenote,
                    'rb_isorder' => $isorder
                ), TRUE);

                $flshmsg = "Sale added successfully.";
            /*}else{
                $saleid =FALSE;
            }*/
        }else{
            $saleid = $billid;
            $editdet = 1;

            $updacc = array(
                'rb_billingtype'=> $type,
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
                'rb_vehicleno'  => $vehicleno,
                'rb_godownid' => $godownid,
                'rb_salesperson' => $salesperson,
                'rb_shippingaddress' => $shippingaddress,
                'rb_state'      => $stateid,
                'rb_billtype'   => $billtype,
                'rb_totalamount'=> $totalamount,
                'rb_discount'   => $totaldiscount,
                'rb_freight'    => $freight,
                'rb_grandtotal' => $grandtotal,
                'rb_roundoffvalue' => $roundoffvalue,
                'rb_totalgstamnt' => $totalgstamount,
                'rb_oldbalance' => $oldbalance,
                'rb_paidamount' => $paidamount,
                'rb_balanceamount' => $balanceamnt,
                'rb_totprofit' => $totalprofitamnt,
                'rb_paymentmethod' => $paymethod,
                'rb_advance100'  => $fulladvance,
                'rb_pagesize' => $pagesize,
                'rb_updatedby' => $this->loggeduserid,
                'rb_updatedon' => $this->updatedon,
                'rb_ewaybillno' => $ewaybillno,
                'rb_deliverydate' => $deliverydate,
                'rb_ponumber' => $ponumber,
                'rb_podate' => $podate,
                'rb_notes' => $salenote
            );
            $updatesale = $this->retlmstr->update($billid, $updacc, TRUE);

            $flshmsg = "Sale updated successfully.";

            if($type == 0 || $type == 1 || $type == 7 || $type == 8)
            {
                $saleprdcts = $this->retlslv->getsaleproducts($billid);
                if($saleprdcts)
                {
                    $updatestockdet = array();
                    $updateprdstockarr = array();
                    foreach($saleprdcts as $oldprdvl)
                    {
                        $oldprdid = $oldprdvl->rbs_productid;
                        $oldqty = $oldprdvl->rbs_qty;
                        $oldstockid = $oldprdvl->rbs_stockid;

                        $adprdctstck = $this->prdtmdl->addproductstock($oldprdid, $oldqty);
                        $updtestck = $this->prdstck->addproductstockbyid($oldstockid, $oldqty);
                    }
                }
                $deleteledgrentries = $this->ldgrentr->deleteoldsaleledgers($billid);
            }
           
            $deleteitems = $this->retlslv->deleteoldsaleitems($billid);
            

        }
        

        if($saleid)
        {
            if($pretype != 0)
            {
                $updeorder = array(
                    'rb_orderstatus'=> 1,
                    'rb_confirmid'  => $saleid,
                );
                $updatepreorder = $this->retlmstr->update($orderid, $updeorder, TRUE);
            }

            if($type == 0 || $type == 1 || $type == 7 || $type == 8)
            {
                if($customerid != 0)
                {
                    if($editdet == 0)
                    {
                        $updateoldbalance = $this->cstmr->update_status_by([
                            'ct_cstomerid' => $customerid
                        ], [
                            'ct_balanceamount' => $balanceamnt
                        ]);
                    }else{
                        $previousbalanceamnt = $this->input->post('previousbalanceamnt');
                        
                        $custbalancedet = $this->cstmr->getcustomerbalance($customerid);
                        if($balanceamnt > $previousbalanceamnt)
                        {
                            if($previousbalanceamnt == 0)
                            {
                                $customererbalance = $balanceamnt;
                            }else{
                                $newblanceamnt = $balanceamnt - $previousbalanceamnt;
                                $customererbalance = $custbalancedet->ct_balanceamount + $newblanceamnt;
                            }
                            
                        }else{
                            if($previousbalanceamnt == 0)
                            {
                                $customererbalance = $balanceamnt;
                            }else{
                                $newblanceamnt = $previousbalanceamnt - $balanceamnt;
                                $customererbalance = $custbalancedet->ct_balanceamount - $newblanceamnt;
                            }
                            
                        }
                        
                        $updateoldbalance = $this->cstmr->update_status_by([
                            'ct_cstomerid' => $customerid
                        ], [
                            'ct_balanceamount' => $customererbalance
                        ]);
                    }
                }
            }

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
                        'rbs_buid'   => $this->buid,
                        'rbs_finyearid'  => $this->finyearid,
                        'rbs_retailbillid' => $saleid,
                        'rbs_productid'  => $prvl,
                        'rbs_stockid'   => $stockid[$k],
                        'rbs_batchno'   => $batch,
                        'rbs_expirydate' => $expiry,
                        'rbs_purchaseprice' => $purchaseprice[$k],
                        'rbs_mrp'        => $mrp[$k],
                        'rbs_netamount'  => $netprice[$k],
                        'rbs_unitprice'  => $unitprice[$k],
                        'rbs_discountedprice' => $discountedprice[$k],
                        'rbs_gstpercent' => $gst[$k],
                        'rbs_gstamnt'    => $itemgstval[$k],
                        'rbs_cesspercent' => $cess[$k],
                        'rbs_cessamount' => $itemcessval[$k],
                        'rbs_discountpercent' => $discountper[$k],
                        'rbs_discountamnt'  => $discountamnt[$k],
                        'rbs_qty'        => $qty[$k],
                        'rbs_totalamount' => $itemtotalamt[$k],
                        'rbs_nettotal'   => $itemnetamt[$k],
                        'rbs_totalgst'   => $itemgstamt[$k],
                        'rbs_totalcess'  => $itemcessamt[$k],
                        'rbs_totaldiscount' => $itemdiscountamt[$k],
                        'rbs_profit' => $itemtotalprofit[$k],
                        'rbs_updatedon'  => $this->updatedon,
                        'rbs_updatedby'  => $this->loggeduserid,
                        'rbs_type'     => $type,
                        'rbs_remarks' => $remarks[$k],
                        'rbs_itemunitprice' => $itemnetprice[$k]
                    );

                    if($type == 0 || $type == 1 || $type == 7 || $type == 8)
                    {
                        
                        $adprdctstck = $this->prdtmdl->reduceproductstock($prvl, $qty[$k]);
                        $updtestck = $this->prdstck->reduceproductstockbyid($stockid[$k], $qty[$k]);
                        
                    }
                }
                
                $k++;
            }

            $insertdrg = $this->retlslv->insert_batch($insert_batch_data);


/**************** Account module connect start *********************/
        if($type == 0 || $type == 1 || $type == 7 || $type == 8)
        {
            // Sale account cr
            $saleamnt = $grandtotal-$totalgstamount-$freight;
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, 1);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosing = $closamnt+$saleamnt;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $this->buid,
                'le_finyearid' => $this->finyearid,
                'le_ledgerid' => 1,
                'le_amount' => $saleamnt,
                'le_isdebit' => 1,
                'le_date' => $daybookdate,
                'le_closingamount' => $lastclosing,
                'le_issale' => 1,
                'le_salepurchaseid' => $saleid,
                'le_updatedby' => $this->loggeduserid,
                'le_updatedon' => $this->updatedon
            ], TRUE);

            //freight charges cr
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, 7);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosing = $closamnt-$freight;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $this->buid,
                'le_finyearid' => $this->finyearid,
                'le_ledgerid' => 7,
                'le_amount' => $freight,
                'le_isdebit' => 1,
                'le_date' => $daybookdate,
                'le_closingamount' => $lastclosing,
                'le_issale' => 1,
                'le_salepurchaseid' => $saleid,
                'le_updatedby' => $this->loggeduserid,
                'le_updatedon' => $this->updatedon
            ], TRUE);

            // Outward gst account cr
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, 2);
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
                'le_ledgerid' => 2,
                'le_amount' => $totalgstamount,
                'le_isdebit' => 1,
                'le_date' => $daybookdate,
                'le_closingamount' => $lastclosingst,
                'le_issale' => 1,
                'le_salepurchaseid' => $saleid,
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
                $lastclosing = $closamnt+$paidamount;
                
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $this->buid,
                    'le_finyearid' => $this->finyearid,
                    'le_ledgerid' => $paymethod,
                    'le_amount' => $paidamount,
                    'le_isdebit' => 0,
                    'le_date' => $daybookdate,
                    'le_closingamount' => $lastclosing,
                    'le_issale' => 1,
                    'le_salepurchaseid' => $saleid,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon
                ], TRUE);
            }

            if($customercheck == '1')
            {

                $getcustomerledgr = $this->accldgr->getcustomerledgerid($this->buid, $customerid);
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

                        $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $custledgrid);
                        if($lastledgr)
                        {
                            $closamnt = $lastledgr->le_closingamount;
                        }else{
                            $closamnt = 0;
                        }
                        $lastclosing = $closamnt+$debitamnt;
                        
                        $insrt = $this->ldgrentr->insert([
                            'le_buid' => $this->buid,
                            'le_finyearid' => $this->finyearid,
                            'le_ledgerid' => $custledgrid,
                            'le_amount' => $debitamnt,
                            'le_isdebit' => 1,
                            'le_date' => $daybookdate,
                            'le_closingamount' => $lastclosing,
                            'le_issale' => 1,
                            'le_salepurchaseid' => $saleid,
                            'le_updatedby' => $this->loggeduserid,
                            'le_updatedon' => $this->updatedon
                        ], TRUE);
                    }
                }

                // Sundry debitor new balance dr
                if($oldbalance < $balanceamnt)
                {
                    $creditamnt = $balanceamnt - $oldbalance;

                    $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $custledgrid);
                    if($lastledgr)
                    {
                        $closamnt = $lastledgr->le_closingamount;
                    }else{
                        $closamnt = 0;
                    }
                    $lastclosing = $closamnt-$creditamnt;
                    
                    $insrt = $this->ldgrentr->insert([
                        'le_buid' => $this->buid,
                        'le_finyearid' => $this->finyearid,
                        'le_ledgerid' => $custledgrid,
                        'le_amount' => $creditamnt,
                        'le_isdebit' => 0,
                        'le_date' => $daybookdate,
                        'le_closingamount' => $lastclosing,
                        'le_issale' => 1,
                        'le_salepurchaseid' => $saleid,
                        'le_updatedby' => $this->loggeduserid,
                        'le_updatedon' => $this->updatedon
                    ], TRUE);
                }
            }

        }
/**************** Account connection end ********************/

            $this->session->set_flashdata('messageS', $flshmsg);

            if($type == 6)
            {
                redirect('sale/orderhistory');
            }else{
                if($pagesize == 3)
                {
                    redirect('sale/saleprint/'.$saleid.'/1/'.$type.'/3');
                }else{
                    redirect('sale/saleprint/'.$saleid.'/1/'.$type);
                }
            }
            
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
            redirect('sale/dashboard/'.$type);
        }
    }
    public function addingsalereturn()
    {
        $this->load->model('accounts/ledgerentries_model', 'ldgrentr');
        $this->load->model('accounts/accountledgers_model', 'accldgr');
        $this->load->model('business/customers_model', 'cstmr');
        $billprefix = $this->input->post('billprefix');
        $billid = $this->input->post('billid');
        $type = $this->input->post('type');
        $billno = $this->input->post('billno');
        $saledate = date('Y-m-d', strtotime($this->input->post('saledate')));
        $saletime = date('H:i:s', strtotime($this->input->post('saletime')));

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
        $godownid = $this->input->post('godownid');
        $stateid = $this->input->post('stateid');

        $productid = $this->input->post('productid');
        $stockid = $this->input->post('stockid');
        $batchno = $this->input->post('batchno');
        $expirydate = $this->input->post('expirydate');
        $purchaseprice = $this->input->post('purchaseprice');
        $mrp = $this->input->post('mrp');
        $unitprice = $this->input->post('unitprice');
        $discountedprice = $this->input->post('discountedprice');
        $gst = $this->input->post('gst');
        $itemgstval = $this->input->post('itemgstval');
        $cess = $this->input->post('cess');
        $itemcessval = $this->input->post('itemcessval');
        $discountper = $this->input->post('discountper');
        $discountamnt = $this->input->post('discountamnt');
        $netprice = $this->input->post('netprice');
        $qty = $this->input->post('qty');
        $itemnetamt = $this->input->post('itemnetamt');
        $itemgstamt = $this->input->post('itemgstamt');
        $itemcessamt = $this->input->post('itemcessamt');
        $itemdiscountamt = $this->input->post('itemdiscountamt');
        $itemtotalamt = $this->input->post('itemtotalamt');
        $itemtotalprofit = $this->input->post('itemtotalprofit');
        $remarks = $this->input->post('remarks');
        $itemnetprice = $this->input->post('itemnetprice');

        $totaldiscount = $this->input->post('totaldiscount');
        $freight = $this->input->post('freight');
        $totalamount = $this->input->post('totalamount');
        $oldbalance = $this->input->post('oldbalance');
        $roundoffvalue = $this->input->post('roundoffvalue');
        $grandtotal = $this->input->post('grandtotal');
        $paidamount = $this->input->post('paidamount');
        $paymethod = $this->input->post('paymethod');
        $balanceamnt = $this->input->post('balanceamnt');
        $pagesize = $this->input->post('pagesize');
        $fulladvance = $this->input->post('fulladvance');
        $billtype = $this->input->post('billtype');

        $totalgstamount = $this->input->post('totalgstamount');
        $totalprofitamnt = $this->input->post('totalprofitamnt');

        $editdet = 0;

        $saleid = $this->retlmstr->insert(array(
            'rb_buid'       => $this->buid,
            'rb_finyearid'  => $this->finyearid,
            'rb_billingtype'=> $type,
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
            'rb_vehicleno'  => $vehicleno,
            'rb_godownid' => $godownid,
            'rb_salesperson' => $salesperson,
            'rb_shippingaddress' => $shippingaddress,
            'rb_state'      => $stateid,
            'rb_billtype'   => $billtype,
            'rb_totalamount'=> $totalamount,
            'rb_discount'   => $totaldiscount,
            'rb_freight'    => $freight,
            'rb_grandtotal' => $grandtotal,
            'rb_roundoffvalue' => $roundoffvalue,
            'rb_totalgstamnt' => $totalgstamount,
            'rb_oldbalance' => $oldbalance,
            'rb_paidamount' => $paidamount,
            'rb_balanceamount' => $balanceamnt,
            'rb_totprofit' => $totalprofitamnt,
            'rb_paymentmethod' => $paymethod,
            'rb_advance100'  => $fulladvance,
            'rb_pagesize' => $pagesize,
            'rb_addedon'  => $this->updatedon,
            'rb_addedby'  => $this->loggeduserid,
            'rb_updatedby' => $this->loggeduserid,
            'rb_updatedon' => $this->updatedon,
            'rb_isreturn' => 1,
            'rb_returnedon' => $this->updatedon,
            'rb_returnedby' => $this->loggeduserid,
            'rb_partialreturn' => 1,
            'rb_returnid' => $billid
        ), TRUE);

        // Update old purchase 
        $oldprofitamnt = $this->input->post('oldprofitamnt');
        $newprofitamnt = $oldprofitamnt-$totalprofitamnt;
        $updacc = array(
            'rb_totprofit' => $newprofitamnt,
            'rb_returnedon' => $this->updatedon,
            'rb_returnedby' => $this->loggeduserid,
            'rb_partialreturn' => 1,
            'rb_returnamount' => $paidamount,
        );
        $updatesale = $this->retlmstr->update($billid, $updacc, TRUE);

        $flshmsg = "Sale returned successfully.";

               
        

        if($saleid)
        {
            if($customerid != 0)
            {
                $updateoldbalance = $this->cstmr->update_status_by([
                    'ct_cstomerid' => $customerid
                ], [
                    'ct_balanceamount' => $balanceamnt
                ]);
            }
            

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
                        'rbs_buid'   => $this->buid,
                        'rbs_finyearid'  => $this->finyearid,
                        'rbs_retailbillid' => $saleid,
                        'rbs_productid'  => $prvl,
                        'rbs_stockid'   => $stockid[$k],
                        'rbs_batchno'   => $batch,
                        'rbs_expirydate' => $expiry,
                        'rbs_purchaseprice' => $purchaseprice[$k],
                        'rbs_mrp'        => $mrp[$k],
                        'rbs_netamount'  => $netprice[$k],
                        'rbs_unitprice'  => $unitprice[$k],
                        'rbs_discountedprice' => $discountedprice[$k],
                        'rbs_gstpercent' => $gst[$k],
                        'rbs_gstamnt'    => $itemgstval[$k],
                        'rbs_cesspercent' => $cess[$k],
                        'rbs_cessamount' => $itemcessval[$k],
                        'rbs_discountpercent' => $discountper[$k],
                        'rbs_discountamnt'  => $discountamnt[$k],
                        'rbs_qty'        => $qty[$k],
                        'rbs_totalamount' => $itemtotalamt[$k],
                        'rbs_nettotal'   => $itemnetamt[$k],
                        'rbs_totalgst'   => $itemgstamt[$k],
                        'rbs_totalcess'  => $itemcessamt[$k],
                        'rbs_totaldiscount' => $itemdiscountamt[$k],
                        'rbs_profit' => $itemtotalprofit[$k],
                        'rbs_updatedon'  => $this->updatedon,
                        'rbs_updatedby'  => $this->loggeduserid,
                        'rbs_type'     => $type,
                        'rbs_remarks' => $remarks[$k],
                        'rbs_itemunitprice' => $itemnetprice[$k]
                    );

                    $adprdctstck = $this->prdtmdl->addproductstock($prvl, $qty[$k]);
                    $updtestck = $this->prdstck->addproductstockbyid($stockid[$k], $qty[$k]);
                        
                    
                }
                
                $k++;
            }

            $insertdrg = $this->retlslv->insert_batch($insert_batch_data);


/**************** Account module connect start *********************/
        
            // Sale account cr to dr
            $saleamnt = $grandtotal-$totalgstamount;
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, 1);
            if($lastledgr)
            {
                $closamnt = $lastledgr->le_closingamount;
            }else{
                $closamnt = 0;
            }
            $lastclosing = $closamnt-$saleamnt;
            
            $insrt = $this->ldgrentr->insert([
                'le_buid' => $this->buid,
                'le_finyearid' => $this->finyearid,
                'le_ledgerid' => 1,
                'le_amount' => $saleamnt,
                'le_isdebit' => 0,
                'le_date' => $this->updatedon,
                'le_closingamount' => $lastclosing,
                'le_issale' => 1,
                'le_salepurchaseid' => $saleid,
                'le_updatedby' => $this->loggeduserid,
                'le_updatedon' => $this->updatedon
            ], TRUE);

            // Outward gst account cr to dr
            $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, 2);
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
                'le_ledgerid' => 2,
                'le_amount' => $totalgstamount,
                'le_isdebit' => 0,
                'le_date' => $this->updatedon,
                'le_closingamount' => $lastclosingst,
                'le_issale' => 1,
                'le_salepurchaseid' => $saleid,
                'le_updatedby' => $this->loggeduserid,
                'le_updatedon' => $this->updatedon
            ], TRUE);


            // Cash/Bank account dr to cr
            if($paidamount > 0)
            {
                $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $paymethod);
                if($lastledgr)
                {
                    $closamnt = $lastledgr->le_closingamount;
                }else{
                    $closamnt = 0;
                }
                $lastclosing = $closamnt+$paidamount;
                
                $insrt = $this->ldgrentr->insert([
                    'le_buid' => $this->buid,
                    'le_finyearid' => $this->finyearid,
                    'le_ledgerid' => $paymethod,
                    'le_amount' => $paidamount,
                    'le_isdebit' => 1,
                    'le_date' => $this->updatedon,
                    'le_closingamount' => $lastclosing,
                    'le_issale' => 1,
                    'le_salepurchaseid' => $saleid,
                    'le_updatedby' => $this->loggeduserid,
                    'le_updatedon' => $this->updatedon
                ], TRUE);
            }

            if($customercheck == '1')
            {

                $getcustomerledgr = $this->accldgr->getcustomerledgerid($this->buid, $customerid);
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
                        if($balanceamnt < 0)
                        {
                            $balanceamnt = abs($balanceamnt);
                            $debitamnt = $oldbalance + $balanceamnt;
                        }else{
                            $debitamnt = $oldbalance - $balanceamnt;
                        }

                        $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $custledgrid);
                        if($lastledgr)
                        {
                            $closamnt = $lastledgr->le_closingamount;
                        }else{
                            $closamnt = 0;
                        }
                        $lastclosing = $closamnt+$debitamnt;
                        
                        $insrt = $this->ldgrentr->insert([
                            'le_buid' => $this->buid,
                            'le_finyearid' => $this->finyearid,
                            'le_ledgerid' => $custledgrid,
                            'le_amount' => $debitamnt,
                            'le_isdebit' => 1,
                            'le_date' => $this->updatedon,
                            'le_closingamount' => $lastclosing,
                            'le_issale' => 1,
                            'le_salepurchaseid' => $saleid,
                            'le_updatedby' => $this->loggeduserid,
                            'le_updatedon' => $this->updatedon
                        ], TRUE);
                    }
                }

                // Sundry debitor new balance dr
                if($oldbalance < $balanceamnt)
                {
                    $creditamnt = $balanceamnt - $oldbalance;

                    $lastledgr = $this->ldgrentr->getlastledgerentry($this->buid, $custledgrid);
                    if($lastledgr)
                    {
                        $closamnt = $lastledgr->le_closingamount;
                    }else{
                        $closamnt = 0;
                    }
                    $lastclosing = $closamnt-$creditamnt;
                    
                    $insrt = $this->ldgrentr->insert([
                        'le_buid' => $this->buid,
                        'le_finyearid' => $this->finyearid,
                        'le_ledgerid' => $custledgrid,
                        'le_amount' => $creditamnt,
                        'le_isdebit' => 0,
                        'le_date' => $this->updatedon,
                        'le_closingamount' => $lastclosing,
                        'le_issale' => 1,
                        'le_salepurchaseid' => $saleid,
                        'le_updatedby' => $this->loggeduserid,
                        'le_updatedon' => $this->updatedon
                    ], TRUE);
                }
            }

        
/**************** Account connection end ********************/

            $this->session->set_flashdata('messageS', $flshmsg);
            //redirect('sale/saleprint/'.$saleid.'/1/'.$type);

            /*if($pagesize == 3)
            {
                redirect('sale/saleprint/'.$saleid.'/1/'.$type.'/3s');
            }else{
                redirect('sale/saleprint/'.$saleid.'/1/'.$type);
            }*/
            redirect('sale/salereturnprint/'.$saleid.'/1/'.$type);
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
            redirect('sale/dashboardreturn/'.$type.'/'.$billid.'/1');
        }
    }
    public function saleprint($saleid, $newprint=0, $type=0, $thermal=0)
    {
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

        if($type == 0)
        {
            $this->data['title'] = "Retail Bill";
        }else if($type == 1)
        {
            $this->data['title'] = "Wholesale Bill";
        }
        else if($type == 2 || $type == 4){
            $this->data['title'] = "Proforma Invoice";
        }else if($type == 3 || $type == 5){
            $this->data['title'] = "Quotation";
        }
        $this->data['type'] = $type;
        $this->data['newprint'] = $newprint;
        $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);

        $this->data['purchasedet'] = $this->retlmstr->getretailbilldetailsbyid($saleid);
        $this->data['purchaseprodcts'] = $this->retlslv->getsaleproducts($saleid);
        $this->data['duptext'] = "";
        /*if($type == 3)
        {
            $this->load->view('quotationprint', $this->data, FALSE);
        }else{*/
        if($thermal == 3)
        {
            $this->load->view('thermalprint', $this->data, FALSE);
        }else{
            //$this->load->view('saleprint2', $this->data, FALSE);
            $this->load->view('saleprint1', $this->data, FALSE);
        }
        
        //}
        
    }
    public function saleprintdup($saleid, $newprint=0, $type=0, $thermal=0, $dup)
    {
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

        if($dup == 1)
        {
            $this->data['duptext'] = "(Duplicate Copy)";
        }else{
            $this->data['duptext'] = "(Triplicate Copy)";
        }

        if($type == 0)
        {
            $this->data['title'] = "Retail Bill";
        }else if($type == 1)
        {
            $this->data['title'] = "Wholesale Bill";
        }
        else if($type == 2 || $type == 4){
            $this->data['title'] = "Proforma Invoice";
        }else if($type == 3 || $type == 5){
            $this->data['title'] = "Quotation";
        }
        $this->data['type'] = $type;
        $this->data['newprint'] = $newprint;
        $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);

        $this->data['purchasedet'] = $this->retlmstr->getretailbilldetailsbyid($saleid);
        $this->data['purchaseprodcts'] = $this->retlslv->getsaleproducts($saleid);
        
        /*if($type == 3)
        {
            $this->load->view('quotationprint', $this->data, FALSE);
        }else{*/
        if($thermal == 3)
        {
            $this->load->view('thermalprint', $this->data, FALSE);
        }else{
            //$this->load->view('saleprint2', $this->data, FALSE);
            $this->load->view('saleprint1', $this->data, FALSE);
        }
    }
    public function salereturnprint($saleid, $newprint=0, $type)
    {
        $this->load->model('business/customers_model', 'cstmr');
        $this->load->model('business/billprintsettings_model', 'blprnt');
        $this->data['billprintdet'] = $billprintdet = $this->blprnt->getbillprintdetails($this->buid);

        $this->data['showpurchaserate'] = 0;
        $this->data['remarkfield'] = 0;
        if($billprintdet)
        {
            $this->data['showpurchaserate'] = $billprintdet->bp_hidepurchaseprice;
            $this->data['remarkfield'] = $billprintdet->bp_remarkcolumn;
        }

        
        $this->data['title'] = "Sale Return";
        
        $this->data['type'] = $type;
        $this->data['newprint'] = $newprint;
        $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);

        $this->data['purchasedet'] = $this->retlmstr->getretailbilldetailsbyid($saleid);
        $this->data['purchaseprodcts'] = $this->retlslv->getsaleproducts($saleid);
        
        $this->load->view('saleprint', $this->data, FALSE);
    }
    public function searchproductcode()
    {
        $this->load->model('inventory/inventorysettings_model', 'invset');
        $inventorysettings = $this->invset->getinventorysettings($this->buid);

        $searchtag = $this->input->post('key');
        $no = $this->input->post('no');
        $type = $this->input->post('type');
        $godownid = $this->input->post('godownid');
        if($godownid == "")
        {
            $productdata = $this->prdtmdl->searchproductstockbycode($searchtag, $this->buid, 0, $type);
        }
        else{
            $productdata = $this->prdtmdl->searchgodownproductstockbycode($searchtag, $this->buid, $godownid, 0, $type);
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
    public function speedsearchproductcode()
    {
        $this->load->model('inventory/inventorysettings_model', 'invset');
        $inventorysettings = $this->invset->getinventorysettings($this->buid);

        $searchtag = $this->input->post('key');
        $no = $this->input->post('no');
        $type = $this->input->post('type');
        $godownid = $this->input->post('godownid');
        if($godownid == "")
        {
            $productdata = $this->prdtmdl->speedsearchproductstockbycode($searchtag, $this->buid, 0, $type);
        }
        else{
            $productdata = $this->prdtmdl->speedsearchgodownproductstockbycode($searchtag, $this->buid, $godownid, 0, $type);
        }
        
        // Generate array
        $nwar= 0;
        $prdid="";
        $stckid = "";
        if(!empty($productdata)){
            foreach ($productdata as $row){

                if($row->pd_productcode != "")
                {
                    $nwar = $nwar+1;
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
                    $prdid = $row->pd_productid;
                    $stckid = $row->pt_stockid;
                    echo '<a href="javascript:void(0)" onclick="selectproductdet('.$row->pd_productid.','.$row->pt_stockid.','.$no.')" class="searchdropdown">' . $row->pd_productcode  . '- '.$row->pd_productname.' '.$row->pd_size.' '.$row->pd_brand.' ('.$row->pc_categoryname.') (Avail Stock: '.$row->pt_stock.') <br/><span style="font-size:11px;">'.$btchdet.'</span></a>';
                }
                
            }
            if($nwar == 1)
            {
                echo "|".$prdid."-".$stckid; 
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
        $type = $this->input->post('type');
        $godownid = $this->input->post('godownid');

        if($godownid == "")
        {
            $productdata = $this->prdtmdl->searchproductstockbyname($searchtag, $this->buid, 0, $type);
        }else{
            $productdata = $this->prdtmdl->searchgodownproductstockbyname($searchtag, $this->buid, $godownid, 0, $type);
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
    public function getproductdetails()
    {
        $prodid = $this->input->post('prodid');
        $stockid = $this->input->post('stockid');
        
        $proddet = $this->prdtmdl->getproductdetailstockbyid($prodid, $stockid);
        
        $this->output->set_content_type('application/json')->set_output(json_encode($proddet));
    }
    public function searchcustomer()
    {
        $this->load->model('business/customers_model', 'cstmr');
        
        $searchtag = $this->input->post('key');
        $resultdata = $this->cstmr->searchcustomerbytag($searchtag, $this->buid);
        
        // Generate array
        if(!empty($resultdata)){
            foreach ($resultdata as $row){
                if($row->ct_name != "")
                {
                    $gsttxt = "";
                    if($row->ct_type == 1)
                    {
                        $gsttxt = ' (' . $row->ct_gstin . ')';
                    }
                    echo '<a href="javascript:void(0)" onclick="selectcustomerdet('.$row->ct_cstomerid.')" class="searchdropdown">' . $row->ct_name  . $gsttxt . '<br/>'. $row->ct_address .'</a>';
                }
                
            }
        }else {
            echo "<span class='text-primary'>No results</span>";
        }
    }
    public function getcustomerdetails()
    {
        $this->load->model('business/customers_model', 'cstmr');
        $supid = $this->input->post('supid');
        $supdet = $this->cstmr->getcustomerdetailsbyid($supid);
        
        $this->output->set_content_type('application/json')->set_output(json_encode($supdet));
    }

    public function getsalefulldetails($type=0)
    {
        $billid = $this->input->post('billid');
        $this->data['type'] = $type;
        $this->data['details'] = $this->retlmstr->getretailbilldetailsbyid($billid);
        $this->load->view('ajaxsaledetailview', $this->data);
    }
    
    public function servicebill()
    {
        $this->load->model('Country_model', 'cuntry');
        $this->load->model('sale/servicebillmaster_model', 'srvcbl');
        $this->load->model('business/customers_model', 'cstmr');

        $this->data['title'] = "Service Billing";

        $this->data['states'] = $this->cuntry->getstatelist('101');
        $this->data['customerlist'] = $this->cstmr->getactivecustomers($this->buid);

        $this->data['billno'] = $this->srvcbl->getnextservicebillno($this->buid);

        $this->load->template('servicebill', $this->data, FALSE);
    }
    public function addingservicebill()
    {
        $this->load->model('sale/servicebillmaster_model', 'srvcbl');
        $this->load->model('sale/servicebillslave_model', 'srvcblslv');

        $billno = $this->input->post('billno');
        $saledate = date('Y-m-d', strtotime($this->input->post('saledate')));
        $saletime = date('H:i:s', strtotime($this->input->post('saletime')));
        $existcustomer = $this->input->post('existcustomer');
        $customerid = $this->input->post('customerid');
        $customername = $this->input->post('customername');
        $customerphone = $this->input->post('customerphone');
        $customeraddress = $this->input->post('customeraddress');
        $customergstin = $this->input->post('customergstin');
        $billdate = date('Y-m-d', strtotime($this->input->post('billdate')));

        $productname = $this->input->post('productname');
        $complaint = $this->input->post('complaint');
        $itemprice = $this->input->post('itemprice');

        $freight = $this->input->post('freight');
        $totalamount = $this->input->post('totalamount');
        $grandtotal = $this->input->post('grandtotal');
        $pagesize = $this->input->post('pagesize');
        $paymethod = $this->input->post('paymethod');

        $servicebilid = $this->srvcbl->insert(array(
            'sb_buid'       => $this->buid,
            'sb_finyearid'  => $this->finyearid,
            'sb_billno'     => $billno,
            'sb_date'       => $saledate,
            'sb_time'       => $saletime,
            'sb_existcustomer' => $existcustomer,
            'sb_customerid' => $customerid ? $customerid : 0,
            'sb_customername' => $customername,
            'sb_phone'      => $customerphone,
            'sb_place'      => $customeraddress,
            'sb_customergst' => $customergstin,
            'sb_billdate'   => $billdate,
            'sb_freight'    => $freight,
            'sb_totalamount'=> $totalamount,
            'sb_grandtotal' => $grandtotal,
            'sb_paymethod' => $paymethod,
            'sb_pagesize'  => $pagesize,
            'sb_updatedon'  => $this->updatedon,
            'sb_updatedby'  => $this->loggeduserid,
        ), TRUE);

        $k=0;
        if($servicebilid)
        {
            foreach($productname as $prvl)
            {
                if($prvl != "")
                {
                    $insrtslv = $this->srvcblslv->insert(array(
                        'sbs_buid'   => $this->buid,
                        'sbs_finyearid'  => $this->finyearid,
                        'sbs_servicebillid' => $servicebilid,
                        'sbs_productname' => $prvl,
                        'sbs_complaint'  => $complaint[$k],
                        'sbs_price'      => $itemprice[$k],
                        'sbs_updatedon'  => $this->updatedon,
                        'sbs_updatedby'  => $this->loggeduserid
                    ), TRUE);
                }
                $k++;
            }

            $this->session->set_flashdata('messageS', 'Service Bill Added Successfully.');
            redirect('sale/servicebillprint/'.$servicebilid.'/1');
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
            redirect('sale/servicebill');
        }
    }

    public function servicebillprint($servcbilid, $newprint=0)
    {
        $this->load->model('sale/servicebillmaster_model', 'srvcbl');
        $this->load->model('sale/servicebillslave_model', 'srvcblslv');

        $this->data['title'] = "Service Bill Print";
        $this->data['newprint'] = $newprint;
        $this->data['businessdet'] = $this->busunt->getbusinessunitdetailbyid($this->buid);

        $this->data['billedet'] = $this->srvcbl->getbilldetailsbyid($servcbilid);
        $this->data['billprodcts'] = $this->srvcblslv->getbillproducts($servcbilid);
        
        $this->load->view('servicebillprint', $this->data, FALSE);
    }
    public function servicebillhistory($fromdate=0, $todate=0, $customerid=0)
    {
        $this->load->model('sale/servicebillmaster_model', 'srvcbl');
        $this->load->model('business/customers_model', 'cstmr');
        $this->data['title'] = "Service Bill";
        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-7 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['customerid'] = $customerid;
        $this->data['customerlist'] = $this->cstmr->getactivecustomers($this->buid);

        // Get customer details for matching old records by name/phone
        $customername = '';
        $customerphone = '';
        if($customerid > 0)
        {
            $customerdetails = $this->cstmr->getcustomerdetailsbyid($customerid);
            if($customerdetails)
            {
                $customername = $customerdetails->ct_name;
                $customerphone = $customerdetails->ct_phone;
            }
        }

        $this->data['retaillist'] = $this->srvcbl->getretailbilllist($this->buid, $fromdate, $todate, $customerid, $customername, $customerphone);
        $this->load->template('servicebillhistory', $this->data, FALSE);
    }

    public function getservicebillitemdetails()
    {
        $this->load->model('sale/servicebillslave_model', 'srvcblslv');
        $billid = $this->input->post('billid');
        $this->data['itemdetails'] = $this->srvcblslv->getbillproducts($billid);
        $this->load->view('ajaxserviceitemview', $this->data);
    }

    public function servicebillprintall($fromdate=0, $todate=0, $customerid=0)
    {
        $this->load->model('sale/servicebillmaster_model', 'srvcbl');
        $this->load->model('sale/servicebillslave_model', 'srvcblslv');
        $this->load->model('business/customers_model', 'cstmr');

        if($fromdate == 0)
        {
            $fromdate = date('Y-m-d', strtotime('-7 days'));
            $todate = date('Y-m-d');
        }else{
            $fromdate = date('Y-m-d', strtotime($fromdate));
            $todate = date('Y-m-d', strtotime($todate));
        }

        // Get customer details for matching old records
        $customername = '';
        $customerphone = '';
        if($customerid > 0)
        {
            $customerdetails = $this->cstmr->getcustomerdetailsbyid($customerid);
            if($customerdetails)
            {
                $customername = $customerdetails->ct_name;
                $customerphone = $customerdetails->ct_phone;
            }
        }

        $this->data['businessdet'] = $this->busunt->getbusinessunitdetailbyid($this->buid);
        $this->data['billlist'] = $this->srvcbl->getretailbilllist($this->buid, $fromdate, $todate, $customerid, $customername, $customerphone);

        // Fetch products for each bill
        $billproducts = array();
        if($this->data['billlist'])
        {
            foreach($this->data['billlist'] as $bill)
            {
                $billproducts[$bill->sb_servicebillid] = $this->srvcblslv->getbillproducts($bill->sb_servicebillid);
            }
        }
        $this->data['billproducts'] = $billproducts;
        $this->data['customername'] = $customername;
        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;

        $this->load->view('servicebillprintall', $this->data, FALSE);
    }

    // ============================================
    // SERVICE REGISTER METHODS
    // ============================================

    /**
     * Service Register - IN Form (New Entry)
     */
    public function serviceregister()
    {
        $this->load->model('sale/Serviceregister_model', 'srvreg');
        $this->load->model('business/customers_model', 'cstmr');

        $this->data['title'] = 'Service Register - New Entry';
        $this->data['servicecode'] = $this->srvreg->getnextservicecode($this->buid);
        $this->data['customerlist'] = $this->cstmr->getactivecustomers($this->buid);
        $this->data['todaydate'] = date('Y-m-d');
        $this->data['currenttime'] = date('H:i');

        $this->load->template('serviceregister', $this->data, FALSE);
    }

    /**
     * Service Register - Save IN Entry
     */
    public function addserviceregister()
    {
        $this->load->model('sale/Serviceregister_model', 'srvreg');

        $servicecode = $this->input->post('servicecode');
        $existcustomer = $this->input->post('existcustomer');
        $customerid = $this->input->post('customerid');
        $customername = $this->input->post('customername');
        $customerphone = $this->input->post('customerphone');
        $customeraddress = $this->input->post('customeraddress');
        $printername = $this->input->post('printername');
        $printertype = $this->input->post('printertype');
        $serialno = $this->input->post('serialno');
        $reason = $this->input->post('reason');
        $indate = $this->input->post('indate');
        $intime = $this->input->post('intime');

        $insertdata = array(
            'sr_buid'         => $this->buid,
            'sr_finyearid'    => $this->finyearid,
            'sr_code'         => $servicecode,
            'sr_indate'       => $indate,
            'sr_intime'       => $intime,
            'sr_existcustomer'=> $existcustomer,
            'sr_customerid'   => ($existcustomer == 1) ? $customerid : 0,
            'sr_customername' => $customername,
            'sr_phone'        => $customerphone,
            'sr_address'      => $customeraddress,
            'sr_printername'  => $printername,
            'sr_printertype'  => $printertype,
            'sr_serialno'     => $serialno,
            'sr_reason'       => $reason,
            'sr_status'       => 0, // Pending
            'sr_updatedby'    => $this->loggeduserid,
            'sr_updatedon'    => $this->updatedon,
            'sr_isactive'     => 0
        );

        $insertid = $this->srvreg->insert($insertdata, TRUE);

        if ($insertid) {
            $this->session->set_flashdata('messageS', 'Service entry added successfully. Code: ' . $servicecode);
            redirect('sale/serviceregisterhistory');
        } else {
            $this->session->set_flashdata('messageE', 'Failed to add service entry. Please try again.');
            redirect('sale/serviceregister');
        }
    }

    /**
     * Service Register - History/List View
     */
    public function serviceregisterhistory($status = 'all', $fromdate = 0, $todate = 0)
    {
        $this->load->model('sale/Serviceregister_model', 'srvreg');
        $this->load->model('business/customers_model', 'cstmr');

        $this->data['title'] = 'Service Register History';

        if ($fromdate == 0) {
            $fromdate = date('Y-m-d', strtotime('-30 days'));
            $todate = date('Y-m-d');
        } else {
            $fromdate = date('Y-m-d', strtotime($fromdate));
            $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;
        $this->data['status'] = $status;
        $this->data['customerlist'] = $this->cstmr->getactivecustomers($this->buid);

        $this->data['registerlist'] = $this->srvreg->getserviceregisterlist($this->buid, $fromdate, $todate, $status);

        // Get counts for status badges
        $this->data['pendingcount'] = $this->srvreg->getcountbystatus($this->buid, 0);
        $this->data['inprogresscount'] = $this->srvreg->getcountbystatus($this->buid, 1);
        $this->data['completedcount'] = $this->srvreg->getcountbystatus($this->buid, 2);
        $this->data['deliveredcount'] = $this->srvreg->getcountbystatus($this->buid, 3);

        $this->load->template('serviceregisterhistory', $this->data, FALSE);
    }

    /**
     * Service Register - View/Edit Entry
     */
    public function serviceregisterview($id, $hash)
    {
        if (!$this->validchecksumcheck($id, $hash)) {
            $this->session->set_flashdata('messageE', 'Invalid request.');
            redirect('sale/serviceregisterhistory');
        }

        $this->load->model('sale/Serviceregister_model', 'srvreg');
        $this->load->model('business/customers_model', 'cstmr');

        $this->data['title'] = 'Service Register - View Entry';
        $this->data['entry'] = $this->srvreg->getdetailsbyid($id);
        $this->data['customerlist'] = $this->cstmr->getactivecustomers($this->buid);

        if (!$this->data['entry']) {
            $this->session->set_flashdata('messageE', 'Entry not found.');
            redirect('sale/serviceregisterhistory');
        }

        $this->load->template('serviceregisterview', $this->data, FALSE);
    }

    /**
     * Service Register - Update Status
     */
    public function updateservicestatus()
    {
        $this->load->model('sale/Serviceregister_model', 'srvreg');

        $id = $this->input->post('id');
        $status = $this->input->post('status');

        $result = $this->srvreg->updatestatus($id, $status, $this->loggeduserid);

        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'Status updated successfully.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to update status.'));
        }
    }

    /**
     * Service Register - Delivery/OUT Form
     */
    public function serviceregisterout($id, $hash)
    {
        if (!$this->validchecksumcheck($id, $hash)) {
            $this->session->set_flashdata('messageE', 'Invalid request.');
            redirect('sale/serviceregisterhistory');
        }

        $this->load->model('sale/Serviceregister_model', 'srvreg');

        $this->data['title'] = 'Service Register - Deliver Item';
        $this->data['entry'] = $this->srvreg->getdetailsbyid($id);
        $this->data['hash'] = $hash;

        if (!$this->data['entry']) {
            $this->session->set_flashdata('messageE', 'Entry not found.');
            redirect('sale/serviceregisterhistory');
        }

        if ($this->data['entry']->sr_status == 3) {
            $this->session->set_flashdata('messageE', 'This item has already been delivered.');
            redirect('sale/serviceregisterhistory');
        }

        $this->load->template('serviceregisterout', $this->data, FALSE);
    }

    /**
     * Service Register - Process Delivery
     */
    public function processservicedelivery()
    {
        $this->load->model('sale/Serviceregister_model', 'srvreg');

        $id = $this->input->post('id');
        $hash = $this->input->post('hash');

        if (!$this->validchecksumcheck($id, $hash)) {
            $this->session->set_flashdata('messageE', 'Invalid request.');
            redirect('sale/serviceregisterhistory');
        }

        $remarks = $this->input->post('remarks');
        $servicecost = $this->input->post('servicecost');

        $updatedata = array(
            'sr_remarks'     => $remarks,
            'sr_servicecost' => $servicecost,
            'sr_updatedby'   => $this->loggeduserid,
            'sr_updatedon'   => $this->updatedon
        );

        $result = $this->srvreg->markdelivered($id, $updatedata);

        if ($result) {
            $this->session->set_flashdata('messageS', 'Item marked as delivered successfully.');
        } else {
            $this->session->set_flashdata('messageE', 'Failed to update. Please try again.');
        }

        redirect('sale/serviceregisterhistory');
    }

    /**
     * Service Register - Update Entry
     */
    public function updateserviceregister()
    {
        $this->load->model('sale/Serviceregister_model', 'srvreg');

        $id = $this->input->post('id');
        $hash = $this->input->post('hash');

        if (!$this->validchecksumcheck($id, $hash)) {
            $this->session->set_flashdata('messageE', 'Invalid request.');
            redirect('sale/serviceregisterhistory');
        }

        $existcustomer = $this->input->post('existcustomer');
        $customerid = $this->input->post('customerid');

        $updatedata = array(
            'sr_existcustomer'=> $existcustomer,
            'sr_customerid'   => ($existcustomer == 1) ? $customerid : 0,
            'sr_customername' => $this->input->post('customername'),
            'sr_phone'        => $this->input->post('customerphone'),
            'sr_address'      => $this->input->post('customeraddress'),
            'sr_printername'  => $this->input->post('printername'),
            'sr_printertype'  => $this->input->post('printertype'),
            'sr_serialno'     => $this->input->post('serialno'),
            'sr_reason'       => $this->input->post('reason'),
            'sr_status'       => $this->input->post('status'),
            'sr_remarks'      => $this->input->post('remarks'),
            'sr_servicecost'  => $this->input->post('servicecost'),
            'sr_updatedby'    => $this->loggeduserid,
            'sr_updatedon'    => $this->updatedon
        );

        $result = $this->srvreg->update($id, $updatedata, TRUE);

        if ($result) {
            $this->session->set_flashdata('messageS', 'Entry updated successfully.');
        } else {
            $this->session->set_flashdata('messageE', 'Failed to update. Please try again.');
        }

        redirect('sale/serviceregisterhistory');
    }

    /**
     * Service Register - Delete Entry (Soft Delete)
     */
    public function deleteserviceregister($id, $hash)
    {
        if (!$this->validchecksumcheck($id, $hash)) {
            $this->session->set_flashdata('messageE', 'Invalid request.');
            redirect('sale/serviceregisterhistory');
        }

        $this->load->model('sale/Serviceregister_model', 'srvreg');

        $updatedata = array(
            'sr_isactive'  => 1,
            'sr_updatedby' => $this->loggeduserid,
            'sr_updatedon' => $this->updatedon
        );

        $result = $this->srvreg->update($id, $updatedata, TRUE);

        if ($result) {
            $this->session->set_flashdata('messageS', 'Entry deleted successfully.');
        } else {
            $this->session->set_flashdata('messageE', 'Failed to delete. Please try again.');
        }

        redirect('sale/serviceregisterhistory');
    }

    /**
     * Service Register - Print Receipt
     */
    public function serviceregisterprint($id, $hash)
    {
        if (!$this->validchecksumcheck($id, $hash)) {
            $this->session->set_flashdata('messageE', 'Invalid request.');
            redirect('sale/serviceregisterhistory');
        }

        $this->load->model('sale/Serviceregister_model', 'srvreg');

        $this->data['entry'] = $this->srvreg->getdetailsbyid($id);
        $this->data['businessdet'] = $this->busunt->getbusinessunitdetailbyid($this->buid);

        if (!$this->data['entry']) {
            $this->session->set_flashdata('messageE', 'Entry not found.');
            redirect('sale/serviceregisterhistory');
        }

        $this->load->view('serviceregisterprint', $this->data, FALSE);
    }

    /**
     * Service Register - Print Register Report for Date Range
     */
    public function serviceregisterreport($status = 'all', $fromdate = 0, $todate = 0)
    {
        $this->load->model('sale/Serviceregister_model', 'srvreg');

        if ($fromdate == 0) {
            $fromdate = date('Y-m-d', strtotime('-30 days'));
            $todate = date('Y-m-d');
        } else {
            $fromdate = date('Y-m-d', strtotime($fromdate));
            $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['fromdate'] = $fromdate;
        $this->data['todate'] = $todate;
        $this->data['status'] = $status;
        $this->data['registerlist'] = $this->srvreg->getserviceregisterlist($this->buid, $fromdate, $todate, $status);
        $this->data['businessdet'] = $this->busunt->getbusinessunitdetailbyid($this->buid);

        $this->load->view('serviceregisterreport', $this->data, FALSE);
    }

}
