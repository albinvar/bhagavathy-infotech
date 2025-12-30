<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rawmaterial extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('welcome/userauthentication_model', 'usersigin');
        $this->load->model('admin/business_model', 'bus');
        $this->load->model('admin/businessunit_model', 'busunt');
        $this->load->model('inventory/products_model', 'prdtmdl');
        $this->load->model('inventory/productcategories_model', 'prdcat');

        $this->load->model('purchase/Purchasemaster_model', 'purmstr');
        $this->load->model('purchase/Purchaseslave_model', 'purslv');
        $this->load->model('purchase/Productstock_model', 'prdstck');
    }

    public function purchasehistory($type=0, $supplierid=0, $fromdate=0, $todate=0)
    {
        $this->load->model('business/suppliers_model', 'splr');

        if($type == 0)
        {
            $this->data['title'] = "Material Purchase History";
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

        $this->data['purchaselist'] = $this->purmstr->getpurchaselist($this->buid, $supplierid, $fromdate, $todate, $type, 1);
        $this->load->template('purchasehistory', $this->data, FALSE);
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

        $this->data['purchaselist'] = $this->purmstr->getpurchasereturnlist($this->buid, $supplierid, $fromdate, $todate, 1);
        $this->load->template('purchasereturnhistory', $this->data, FALSE);
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
                $this->data['title'] = "Material Purchase Billing";
                if($billprintdet)
                {
                    $this->data['billprefix'] = $billprintdet->bp_purchasebillprefix;
                }
            }
            
        }
        $this->data['billno'] = $this->purmstr->getnextpurchasebillno($this->buid, $type);

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

    public function rawmateriallist($active=0)
    {
        $this->data['active'] = $active;
        $this->data['categories'] = $this->prdcat->getmaterialrows($this->buid);
        $this->data['maincategories'] = $this->prdcat->getmaterialmaincategories($this->buid);
        if($active == 0)
        {
            $this->data['title'] = "Active Raw Materials";
            $this->data['productlist'] = $this->prdtmdl->getactiverows($this->buid, 1);
        }else{
            $this->data['title'] = "Deleted Raw Materials";
            $this->data['productlist'] = $this->prdtmdl->getdeletedrows($this->buid, 1);
        }
        
        $this->load->template('rawmaterials', $this->data, FALSE);
    }
    public function addrawmaterial($editid=0)
    {
        $this->load->model('units_model', 'unmdl');
        $this->load->model('business/taxbands_model', 'txbnds');
        $this->data['editid'] = $editid;
        if($editid == 0)
        {
            $this->data['title'] = "Add Raw Material";
        }
        else{
            $this->data['title'] = "Edit Raw Material";
            $this->data['editdata'] = $this->prdtmdl->getproductdetailsbyid($editid);
        }
        $this->data['units'] = $this->unmdl->getactiverows($this->buid);
        $this->data['taxbands'] = $this->txbnds->getactiverows($this->buid);
        $this->data['categories'] = $this->prdcat->getactivematerialrows($this->buid);
        $this->load->template('addrawmaterial', $this->data, FALSE);
    }
    public function addingmaterialsprocess()
    {
        $editid = $this->input->post('editid');

        $productcode = $this->input->post('productcode');
        $productname = $this->input->post('productname');
        $categoryid = $this->input->post('categoryid');
        $hsnno = $this->input->post('hsnno');
        $unitid = $this->input->post('unitid');
        $taxbandid = $this->input->post('taxbandid');
        $cess = $this->input->post('cess');
        $purprice = $this->input->post('purprice');
        $mrp = $this->input->post('mrp');
        $thresholdstock = $this->input->post('thresholdstock');

        /*$protype = $this->input->post('protype');
        $retailprofit = $this->input->post('retailprofit');
        $retailamount = $this->input->post('retailamount');
        $wholesaleprofit = $this->input->post('wholesaleprofit');
        $wholesaleamount = $this->input->post('wholesaleamount');*/
        //$prodimage = $this->input->post('prodimage');

        $productsize = $this->input->post('productsize');
        $productbrand = $this->input->post('productbrand');
        $productcompany = $this->input->post('productcompany');

        $k=0;
        foreach($productname as $prdname)
        {
            if(isset($categoryid[$k]))
            {
                $catgry = $categoryid[$k];
            }else{
                $catgry = "";
            }
            if(isset($hsnno[$k]))
            {
                $hsnnumber = $hsnno[$k];
            }else{
                $hsnnumber = "";
            }

            $prodimage = "";


            
           if($editid == 0)
           {
                $prdinsrt = $this->prdtmdl->insert(array(
                    'pd_buid' => $this->buid,
                    'pd_productcode' => $productcode[$k],
                    'pd_productname' => $prdname,
                    'pd_categoryid' => $catgry,
                    'pd_hsnno' => $hsnnumber,
                    'pd_taxbandid' => $taxbandid[$k],
                    'pd_cess' => $cess[$k],
                    'pd_unitid' => $unitid[$k],
                    'pd_purchaseprice' => $purprice[$k],
                    'pd_mrp' => $mrp[$k],
                    'pd_stock' => 0,
                    'pd_stockthreshold' => $thresholdstock[$k],
                    'pd_addedby' => $this->loggeduserid,
                    'pd_addedon' => $this->updatedon,
                    'pd_size' => $productsize[$k],
                    'pd_brand' => $productbrand[$k],
                    'pd_company' => $productcompany[$k],
                    'pd_israwmaterial' => 1
                ), TRUE);

                $prodctid = $prdinsrt;

                $flshmsg = "Material added successfully.";
           }else{
                $prodctid = $editid;

                $updacc = array(
                    'pd_productcode' => $productcode[$k],
                    'pd_productname' => $prdname,
                    'pd_categoryid' => $catgry,
                    'pd_hsnno' => $hsnnumber,
                    'pd_taxbandid' => $taxbandid[$k],
                    'pd_cess' => $cess[$k],
                    'pd_unitid' => $unitid[$k],
                    'pd_purchaseprice' => $purprice[$k],
                    'pd_mrp' => $mrp[$k],
                    'pd_stockthreshold' => $thresholdstock[$k],
                    'pd_addedby' => $this->loggeduserid,
                    'pd_addedon' => $this->updatedon,
                    'pd_size' => $productsize[$k],
                    'pd_brand' => $productbrand[$k],
                    'pd_company' => $productcompany[$k],
                    'pd_israwmaterial' => 1
                );

                $insert_data = $this->prdtmdl->update($prodctid, $updacc, TRUE);

                $flshmsg = "Material updated successfully.";
           }

            if(isset($_FILES["prodimage"]["name"][$k]))
            {
                $target_dir1  = "uploads/products/";
                $temp1        = explode(".", $_FILES["prodimage"]["name"][$k]);
                $filenameup   = @round(microtime(true)) . '.' . end($temp1);
                $target_file1 = $target_dir1 . $filenameup;
                if (move_uploaded_file($_FILES["prodimage"]["tmp_name"][$k], $target_file1)) {
                    $prodimage = $filenameup;

                    $updacc = array(
                        'pd_prodimage'   => $prodimage,
                    );
                    $insert_data = $this->prdtmdl->update($prodctid, $updacc, TRUE);
                }
            }

            $k= $k+1;
        }

        $this->session->set_flashdata('messageS', $flshmsg);
        redirect('rawmaterial/rawmateriallist');
    }
    public function enabledisablematerial($editid, $action = 0)
    {
        $dsbledary = $this->prdtmdl->update($editid, ['pd_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('rawmaterial/rawmateriallist');
    }

    public function materialcategory($status=0)
    {
        $this->data['title'] = "Material Categories";
        $this->data['categories'] = $this->prdcat->getmaterialrows($this->buid);
        $this->data['maincategories'] = $this->prdcat->getmaterialmaincategories($this->buid);
        $this->load->template('materialcategory', $this->data, FALSE);
    }
    public function addingcategory()
    {
        $editid = $this->input->post('editid');
        $issubgroup = $this->input->post('issubgroup');
        if($issubgroup == 1)
        {
            $maincategoryid = $this->input->post('maincategoryid');
        }
        else{
            $maincategoryid = 0;
        }
        $categoryname = $this->input->post('categoryname');
        $notes = $this->input->post('notes');

        if($editid == "")
        {
            $insertset = $this->prdcat->insert(array(
                'pc_buid' => $this->buid,
                'pc_categoryname' => $categoryname,
                'pc_description' => $notes,
                'pc_issub' => $issubgroup,
                'pc_maincategoryid' => $maincategoryid,
                'pc_updatedby' => $this->loggeduserid,
                'pc_updatedon' => $this->updatedon,
                'pc_israwmaterial' => 1
            ), TRUE);
        }else{
            $updacc = array(
                'pc_buid' => $this->buid,
                'pc_categoryname' => $categoryname,
                'pc_description' => $notes,
                'pc_issub' => $issubgroup,
                'pc_maincategoryid' => $maincategoryid,
                'pc_updatedby' => $this->loggeduserid,
                'pc_updatedon' => $this->updatedon,
                'pc_israwmaterial' => 1
            );
            $insertset = $this->prdcat->update($editid, $updacc, TRUE);
        }
        if($insertset)
        {
            $this->session->set_flashdata('messageS', lang('record_updated_success'));
        }
        else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('rawmaterial/materialcategory');
    }
    public function enabledisablecategory($editid, $action = 0)
    {
        $dsbledary = $this->prdcat->update($editid, ['pc_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('rawmaterial/materialcategory');
    }
    public function getcategorydetails()
    {
        $catid = $this->input->post('catid');
        $editdata = $this->prdcat->getrowbyid($catid);
        $this->output->set_content_type('application/json')->set_output(json_encode($editdata));
    }
    
    public function productstocks($active=0, $categoryid=0, $print=0)
    {
        $this->load->model('purchase/Productstock_model', 'prdstck');
        $this->data['title'] = "Products Stock";
        $this->data['active'] = $active;
        $this->data['categoryid'] = $categoryid;
        //$this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['categories'] = $this->prdcat->getactivematerialrows($this->buid);
        $this->data['productlist'] = $this->prdtmdl->getactivecategoryrows($this->buid, $categoryid, 1);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('productstocksprint', $this->data, FALSE);
        }
        else{
            $this->load->template('productstocks', $this->data, FALSE);
        }
    }
    public function productbatchwisestock($godownid=0, $categoryid=0, $print=0)
    {
        $this->load->model('purchase/Productstock_model', 'prdstck');
        $this->load->model('inventory/godowns_model', 'gdwn');
        $this->data['godowns'] = $this->gdwn->getactiverows($this->buid);

        $this->data['title'] = "Products Stock";
        $this->data['categoryid'] = $categoryid;
        $this->data['godownid'] = $godownid;
        //$this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['categories'] = $this->prdcat->getactivematerialrows($this->buid);
        $this->data['productlist'] = $this->prdstck->getproductstockcategorylist($this->buid, $godownid, $categoryid, 1);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('productbatchwisestockprint', $this->data, FALSE);
        }else{
            $this->load->template('productbatchwisestock', $this->data, FALSE);
        }
        
    }
}
