<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('welcome/userauthentication_model', 'usersigin');
        $this->load->model('admin/business_model', 'bus');
        $this->load->model('admin/businessunit_model', 'busunt');
        $this->load->model('inventory/products_model', 'prdtmdl');
        $this->load->model('inventory/inventorysettings_model', 'invset');
        $this->load->model('inventory/productcategories_model', 'prdcat');
    }
    public function productstocks($active=0, $categoryid=0, $print=0)
    {
        $this->load->model('purchase/Productstock_model', 'prdstck');
        $this->data['title'] = "Products Stock";
        $this->data['active'] = $active;
        $this->data['categoryid'] = $categoryid;
        //$this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['categories'] = $this->prdcat->getactiverows($this->buid);
        $this->data['productlist'] = $this->prdtmdl->getactivecategoryrows($this->buid, $categoryid);
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
        $this->data['categories'] = $this->prdcat->getactiverows($this->buid);
        $this->data['productlist'] = $this->prdstck->getproductstockcategorylist($this->buid, $godownid, $categoryid);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('productbatchwisestockprint', $this->data, FALSE);
        }else{
            $this->load->template('productbatchwisestock', $this->data, FALSE);
        }
        
    }
    public function productutilization()
    {
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('purchase/Purchaseslave_model', 'purslv');
        $this->load->model('purchase/Productstock_model', 'prdstck');
        $this->data['title'] = "Products Stock";
        //$this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['productlist'] = $this->prdtmdl->getactiverows($this->buid);
        $this->load->template('productutilization', $this->data, FALSE);
    }
    public function productutilizehistory($prdctid, $fromdate=0, $todate=0)
    {
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('purchase/Purchaseslave_model', 'purslv');
        $this->load->model('purchase/Productstock_model', 'prdstck');

        $this->data['title'] = "Product Utilization History";
        $this->data['productid'] = $prdctid;

        $this->data['productdet'] = $this->prdtmdl->getproductdetailsbyid($prdctid);

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['purchasehistory'] = $this->purslv->getproductpurchasehistory($prdctid, $fromdate, $todate);
        $this->data['salehistory'] = $this->retlslv->getproductsalehistory($prdctid, $fromdate, $todate);

        $this->load->template('productutilizehistory', $this->data, FALSE);
    }
    public function outofstocks()
    {
        $this->data['title'] = "Products Out of Stock";
        //$this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['productlist'] = $this->prdtmdl->getproductoutofstocks($this->buid);
        $this->load->template('productoutofstocks', $this->data, FALSE);
    }
    public function expiredproducts()
    {
        $this->data['title'] = "Products Expired";

        $todaydate = date('Y-m-d');
        //$this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['productlist'] = $this->prdtmdl->getproductexpiredlist($this->buid, $todaydate);
        $this->load->template('expiredproducts', $this->data, FALSE);
    }
    public function products($active=0)
    {
        
        $this->data['active'] = $active;
        $this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['maincategories'] = $this->prdcat->getmaincategories($this->buid);
        if($active == 0)
        {
            $this->data['title'] = "Active Products";
            $this->data['productlist'] = $this->prdtmdl->getactiverows($this->buid);
        }else{
            $this->data['title'] = "Deleted Products";
            $this->data['productlist'] = $this->prdtmdl->getdeletedrows($this->buid);
        }
        
        $this->load->template('products', $this->data, FALSE);
    }
    public function addproduct($editid=0)
    {
        $this->load->model('units_model', 'unmdl');
        $this->load->model('business/taxbands_model', 'txbnds');
        $this->data['editid'] = $editid;
        if($editid == 0)
        {
            $this->data['title'] = "Add Product";
        }
        else{
            $this->data['title'] = "Edit Product";
            $this->data['editdata'] = $this->prdtmdl->getproductdetailsbyid($editid);
        }
        $this->data['units'] = $this->unmdl->getactiverows($this->buid);
        $this->data['taxbands'] = $this->txbnds->getactiverows($this->buid);
        $this->data['categories'] = $this->prdcat->getactiverows($this->buid);
        $this->load->template('addproduct', $this->data, FALSE);
    }
    public function addingproductsprocess()
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

        $protype = $this->input->post('protype');
        $retailprofit = $this->input->post('retailprofit');
        $retailamount = $this->input->post('retailamount');
        $wholesaleprofit = $this->input->post('wholesaleprofit');
        $wholesaleamount = $this->input->post('wholesaleamount');
        $csaleprofit = $this->input->post('csaleprofit');
        $csaleamount = $this->input->post('csaleamount');
        $dsaleprofit = $this->input->post('dsaleprofit');
        $dsaleamount = $this->input->post('dsaleamount');

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
                    'pd_profittype' => $protype[$k],
                    'pd_retailprofit' => $retailprofit[$k],
                    'pd_retailprice' => $retailamount[$k],
                    'pd_wholesaleprofit' => $wholesaleprofit[$k],
                    'pd_wholesaleprice' => $wholesaleamount[$k],
                    'pd_csaleprofit' => $csaleprofit[$k],
                    'pd_csaleprice' => $csaleamount[$k],
                    'pd_dsaleprofit' => $dsaleprofit[$k],
                    'pd_dsaleprice' => $dsaleamount[$k],
                    'pd_stock' => 0,
                    'pd_stockthreshold' => $thresholdstock[$k],
                    'pd_addedby' => $this->loggeduserid,
                    'pd_addedon' => $this->updatedon,
                    'pd_size' => $productsize[$k],
                    'pd_brand' => $productbrand[$k],
                    'pd_company' => $productcompany[$k]
                ), TRUE);

                $prodctid = $prdinsrt;

                $flshmsg = "Product added successfully.";
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
                    'pd_profittype' => $protype[$k],
                    'pd_retailprofit' => $retailprofit[$k],
                    'pd_retailprice' => $retailamount[$k],
                    'pd_wholesaleprofit' => $wholesaleprofit[$k],
                    'pd_wholesaleprice' => $wholesaleamount[$k],
                    'pd_csaleprofit' => $csaleprofit[$k],
                    'pd_csaleprice' => $csaleamount[$k],
                    'pd_dsaleprofit' => $dsaleprofit[$k],
                    'pd_dsaleprice' => $dsaleamount[$k],
                    'pd_stockthreshold' => $thresholdstock[$k],
                    'pd_addedby' => $this->loggeduserid,
                    'pd_addedon' => $this->updatedon,
                    'pd_size' => $productsize[$k],
                    'pd_brand' => $productbrand[$k],
                    'pd_company' => $productcompany[$k]
                );

                $insert_data = $this->prdtmdl->update($prodctid, $updacc, TRUE);

                $flshmsg = "Product updated successfully.";
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
        redirect('inventory/products');
    }
    public function enabledisableproduct($editid, $action = 0)
    {
        $dsbledary = $this->prdtmdl->update($editid, ['pd_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('inventory/products');
    }

    public function productcategory()
    {
        $this->data['title'] = "Product Categories";
        $this->data['categories'] = $this->prdcat->getallrows($this->buid);
        $this->data['maincategories'] = $this->prdcat->getmaincategories($this->buid);
        $this->load->template('productcategory', $this->data, FALSE);
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
                'pc_updatedon' => $this->updatedon
            ), TRUE);
        }else{
            $updacc = array(
                'pc_buid' => $this->buid,
                'pc_categoryname' => $categoryname,
                'pc_description' => $notes,
                'pc_issub' => $issubgroup,
                'pc_maincategoryid' => $maincategoryid,
                'pc_updatedby' => $this->loggeduserid,
                'pc_updatedon' => $this->updatedon
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
        redirect('inventory/productcategory');
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
        redirect('inventory/productcategory');
    }
    public function getcategorydetails()
    {
        $catid = $this->input->post('catid');
        $editdata = $this->prdcat->getrowbyid($catid);
        $this->output->set_content_type('application/json')->set_output(json_encode($editdata));
    }

    public function godowns($type=0)
    {
        $this->load->model('inventory/godowns_model', 'gdwn');
        $this->data['type'] = $type;
        if($type == 0)
        {
            $this->data['title'] = "Godown";
        }
        else{
             $this->data['title'] = "Department";
        }
        $this->data['godowns'] = $this->gdwn->getallrowsbytype($this->buid, $type);
        $this->load->template('godowns', $this->data, FALSE);
    }
    public function addinggodown()
    {
        $this->load->model('inventory/godowns_model', 'gdwn');

        $editid = $this->input->post('editid');
        $type = $this->input->post('type');
        $code = $this->input->post('code');
        
        $godownname = $this->input->post('godownname');
        
        $address = $this->input->post('address');
        $racknumbers = $this->input->post('racknumbers');
        $gatepass = $this->input->post('gatepass');
        $notes = $this->input->post('notes');

        if($editid == "")
        {
            $insertset = $this->gdwn->insert(array(
                'gd_buid' => $this->buid,
                'gd_godowncode' => $code,
                'gd_godownname' => $godownname,
                'gd_address' => $address,
                'gd_racknumbers' => $racknumbers,
                'gd_isgatepass' => $gatepass,
                'gd_description' => $notes,
                'gd_updatedby' => $this->loggeduserid,
                'gd_updatedon' => $this->updatedon,
                'gd_isdepartment' => $type
            ), TRUE);
        }else{
            $updacc = array(
                'gd_buid' => $this->buid,
                'gd_godowncode' => $code,
                'gd_godownname' => $godownname,
                'gd_address' => $address,
                'gd_racknumbers' => $racknumbers,
                'gd_isgatepass' => $gatepass,
                'gd_description' => $notes,
                'gd_updatedby' => $this->loggeduserid,
                'gd_updatedon' => $this->updatedon,
                'gd_isdepartment' => $type
            );
            $insertset = $this->gdwn->update($editid, $updacc, TRUE);
        }
        if($insertset)
        {
            $this->session->set_flashdata('messageS', lang('record_added_success'));
        }
        else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('inventory/godowns/'.$type);
    }
    public function enabledisablegodown($editid, $action = 0)
    {
        $this->load->model('inventory/godowns_model', 'gdwn');
        $dsbledary = $this->gdwn->update($editid, ['gd_isactive' => $action], TRUE);
        $msg = $action ? lang('record_disabled_success') : lang('record_enabled_success');
        if ($dsbledary) {
            $this->session->set_flashdata('messageS', $msg);
        } else {
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('inventory/godowns');
    }

    public function inventorysettings()
    {
        $this->data['title'] = "Inventory Settings";
        $this->data['inventorysetting'] = $this->invset->getinventorysettings($this->buid);
        $this->load->template('inventorysettings', $this->data, FALSE);
    }
    public function updateinventorysettings()
    {
        $inventsettid = $this->input->post('inventsettid');

        $prodcategory = $this->input->post('prodcategory');
        $prodimage = $this->input->post('prodimage');
        $prodexpiry = $this->input->post('prodexpiry');
        $barqr = $this->input->post('barqr');
        $prodhsn = $this->input->post('prodhsn');
        $prodwastage = $this->input->post('prodwastage');
        $batchwise = $this->input->post('batchwise');

        $is_supplier = $this->input->post('is_supplier');
        $is_godown = $this->input->post('is_godown');
        $is_isfourrate = $this->input->post('is_isfourrate');

        if($inventsettid == "")
        {
            $insertset = $this->invset->insert(array(
                'is_buid' => $this->buid,
                'is_categorywise' => $prodcategory,
                'is_batchwise' => $batchwise,
                'is_expirydate' => $prodexpiry,
                'is_image' => $prodimage,
                'is_wastage' => $prodwastage,
                'is_barqr' => $barqr,
                'is_hsn' => $prodhsn,
                'is_supplier' => $is_supplier,
                'is_godown' => $is_godown,
                'is_updatedby' => $this->loggeduserid,
                'is_updatedon' => $this->updatedon,
                'is_isfourrate' => $is_isfourrate
            ), TRUE);
        }else{
            $updacc = array(
                'is_categorywise' => $prodcategory,
                'is_batchwise' => $batchwise,
                'is_expirydate' => $prodexpiry,
                'is_image' => $prodimage,
                'is_wastage' => $prodwastage,
                'is_barqr' => $barqr,
                'is_hsn' => $prodhsn,
                'is_supplier' => $is_supplier,
                'is_godown' => $is_godown,
                'is_updatedby' => $this->loggeduserid,
                'is_updatedon' => $this->updatedon,
                'is_isfourrate' => $is_isfourrate
            );
            $insertset = $this->invset->update($inventsettid, $updacc, TRUE);
        }
        if($insertset)
        {
            $this->session->set_flashdata('messageS', lang('record_updated_success'));
        }
        else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }
        redirect('inventory/inventorysettings');
    }

    // Import products

    public function importproducts()
    {
        ini_set('memory_limit', '-1');

        $c = 0;
        $k = 1;
        if (!is_dir('uploads/productimports')) {
            create_directory('uploads/productimports');
            $c = 1;
        }

        move_uploaded_file($_FILES["productcsv"]["tmp_name"],
            "uploads/productimports/" . $_FILES["productcsv"]["name"]);
        $xl   = "uploads/productimports/" . $_FILES["productcsv"]["name"];
        $xlno = $_FILES["productcsv"]["name"];

        $file = 'uploads/productimports/' . $_FILES["productcsv"]["name"];

        if (!empty($_FILES['productcsv']['name'])) {
            $file        = fopen($file, "r");
            $headers_arr = fgetcsv($file);
        }

        $i      = 1;
        $handle = array();
        while (($result = fgetcsv($file)) !== false) {
            if (array(null) !== $result) {
                $handle[] = array_combine($headers_arr, $result);
                $i++;
            }
        }
        fclose($file);
        $postdata = array();
        foreach ($handle as $val) {
            $val    = array_map('trim', $val);

            $productcode    = $val['code'];
            $product    = $val['product'];
            $size    = $val['size'];
            $category    = $val['category'];
            $brand    = $val['brand'];
            $company    = $val['company'];
            $hsn    = $val['hsn'];
            $unit = $val['unit'];
            $taxband    = $val['taxband'];
            $cess    = $val['cess'];
            $purchaseprice    = $val['purchaseprice'];
            //$unitprice    = $val['unitprice'];
            $mrp    = $val['mrp'];

            $profittype    = $val['profittype'];
            /*if($profittype == "")
            {
                $profittype    = 2;
                $retailamount    = $val['retailamount'];
                $retailprofit = $retailamount - $unitprice;
            }*/
            $retailamount    = $val['retailamount'];
            $retailprofit    = $val['retailprofit'];
            $wholesaleprofit    = $val['wholesaleprofit'];
            $wholesaleamount    = $val['wholesaleamount'];
            $threshold    = $val['threshold'];

            $postdata[] = array(
                'pd_buid'          => $this->buid,
                'pd_productcode' => $productcode,
                'pd_productname'      => $product,
                'pd_size'            => $size,
                'pd_categoryid'         => $category,
                'pd_brand'        => $brand,
                'pd_company'        => $company,
                'pd_hsnno'       => $hsn,
                'pd_taxbandid'      => $taxband,
                'pd_cess'       => $cess,
                'pd_unitid'       => $unit,
                'pd_purchaseprice'       => $purchaseprice,
                'pd_mrp'        => $mrp,
                'pd_profittype'       => $profittype,
                'pd_retailprofit'        => $retailprofit,
                'pd_retailprice'        => $retailamount,
                'pd_wholesaleprofit'        => $wholesaleprofit,
                'pd_wholesaleprice'        => $wholesaleamount,
                'pd_stockthreshold'        => $threshold,
                'pd_addedby'        => $this->loggeduserid,
                'pd_addedon' => $this->updatedon
            );
        }

        if (!empty($postdata)) {
            //insert record
            $insertdrg = $this->prdtmdl->insert_batch($postdata);

            $this->session->set_flashdata('messageS', 'Products Imported Successfully.');
        }else{
            $this->session->set_flashdata('messageE', lang('oops_error'));
        }

        redirect('inventory/products');
    }

    public function csvproductexport($active=0)
    {
        $productlist= $this->prdtmdl->getcsvexprotproducts($this->buid, $active);

        $filename = 'products_'.date('d-m-Y').'.csv';
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$filename"); 
         header("Content-Type: application/csv; ");

         // file creation 
         $file = fopen('php://output', 'w');

         $header = array("Code","Product","Category","Unit", "HSN", "GST", "CESS"); 
         fputcsv($file, $header);
         if($productlist)
         {
         foreach ($productlist as $key=>$line){ 
            fputcsv($file,$line); 
         }
         }
         fclose($file); 
         exit; 
    }

    public function productbarcodes()
    {
        $this->load->model('purchase/Productstock_model', 'prdstck');
        $this->data['title'] = "Barcode";
        $this->data['productlist'] = $this->prdstck->getproductstocklist($this->buid);
        $this->load->template('productbarcodes', $this->data, FALSE);
    }
    public function generatebarcode()
    {
        $this->load->model('purchase/Productstock_model', 'prdstck');
        $this->data['productstockid'] = $prodstockids = $this->input->post('productid');
        $barcount = array();
        foreach($prodstockids as $stckid)
        {
            $barcount[] = $this->input->post('barcount'.$stckid);
        }
        $this->data['productcount'] = $barcount;

        $this->load->view('generatebarcode', $this->data, FALSE);
    }

    public function stocktransferlist($fromdate=0, $todate=0)
    {
        $this->load->model('inventory/stocktransfermaster_model', 'trsfms');
        $this->load->model('inventory/stocktransferslave_model', 'trfslv');

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['transferlist'] = $this->trsfms->getalltranfersfromtodate($this->buid, $fromdate, $todate);
        $this->load->template('stocktransferlist', $this->data, FALSE);
    }
    public function getitemdetails()
    {
        $this->load->model('inventory/stocktransferslave_model', 'trfslv');
        $billid = $this->input->post('billid');
        $this->data['itemdetails'] = $this->trfslv->gettranferproducts($billid);
        $this->load->view('ajaxtransferitemview', $this->data);
    }
    public function stocktransfer($fromid=0, $toid=0)
    {
        $this->load->model('inventory/godowns_model', 'gdwn');

        $this->data['fromid'] = $fromid;
        $this->data['toid'] = $toid;

        $this->data['fromgodowns'] = $this->gdwn->getactiverows($this->buid);
        $transferform = 0;
        if($fromid != 0)
        {
            $this->data['togodowns'] = $this->gdwn->getgodowntransferto($this->buid, $fromid);
            if($toid != 0)
            {
                $transferform = 1;
            }
        }
        $this->data['transferform'] = $transferform;

        $this->data['type'] = 0;
        
        $this->load->template('stocktransfer', $this->data, FALSE);
    }
    public function transferingstock()
    {
        $this->load->model('inventory/godowns_model', 'gdwn');
        $this->load->model('inventory/stocktransfermaster_model', 'trsfms');
        $this->load->model('inventory/stocktransferslave_model', 'trfslv');
        $this->load->model('purchase/Productstock_model', 'prdstck');

        $billid = $this->input->post('billid');

        $fromgodownid = $this->input->post('fromgodownid');
        $togodownid = $this->input->post('togodownid');

        $transferdate = date('Y-m-d', strtotime($this->input->post('transferdate')));
        $transfertime = date('H:i:s', strtotime($this->input->post('transfertime')));
        $datetime = $transferdate . " " . $transfertime;

        $productid = $this->input->post('productid');
        $stockid = $this->input->post('stockid');
        $batchno = $this->input->post('batchno');
        $expirydate = $this->input->post('expirydate');
        $productcode = $this->input->post('productcode');
        $purchasepriceval = $this->input->post('purchasepriceval');
        $purchaseprice = $this->input->post('purchaseprice');
        $mrp = $this->input->post('mrp');
        $qty = $this->input->post('qty');
        $itemtotalamt = $this->input->post('itemtotalamt');

        $totalamount = $this->input->post('totalamount');

        $masterid = $this->trsfms->insert(array(
            'st_buid'       => $this->buid,
            'st_fromid' => $fromgodownid,
            'st_toid' => $togodownid,
            'st_totalamount' => $totalamount,
            'st_updatedon'  => $datetime,
            'st_updatedby'  => $this->loggeduserid
        ), TRUE);

        if($masterid)
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

                    $updtestck = $this->prdstck->reduceproductstockbyid($stockid[$k], $qty[$k]);

                    $prsstockdet = $this->prdstck->getproductstockdetails($this->buid, $prvl, $batch, $togodownid);
                    if($prsstockdet)
                    {
                        $prdctstockid = $prsstockdet->pt_stockid;
                        $updtestck = $this->prdstck->addproductstockbyid($prdctstockid, $qty[$k]);
                    }else{
                        $prdctstockid = $this->prdstck->insert(array(
                            'pt_buid' => $this->buid,
                            'pt_productid' => $prvl,
                            'pt_batchno'  => $batch,
                            'pt_godownid' => $togodownid,
                            'pt_expirydate' => $expiry,
                            'pt_purchaseprice' => $purchasepriceval[$k],
                            'pt_mrp' => $mrp[$k],
                            'pt_stock' => $qty[$k]
                        ), TRUE);
                    }

                    $insert_batch_data[] = array(
                        'sts_buid' => $this->buid,
                        'sts_stocktransferid' => $masterid,
                        'sts_productid' => $prvl,
                        'sts_fromstockid' => $stockid[$k],
                        'sts_tostickid' => $prdctstockid,
                        'sts_qty' => $qty[$k],
                        'sts_mrp' => $mrp[$k],
                        'sts_purchaseprice' => $purchaseprice[$k],
                        'sts_totalprice' => $itemtotalamt[$k],
                        'sts_updatedon' => $this->updatedon,
                        'sts_updatedby' => $this->loggeduserid
                    );

                }
                $k++;
            }
            $insertprdcts = $this->trfslv->insert_batch($insert_batch_data);

            $this->session->set_flashdata('messageS', "Stock transfered successfully.");
        }else{
            $this->session->set_flashdata('messageS', "Error occured, please try again.");
        }

        redirect('inventory/stocktransferlist');
    }

    public function checkproductcodeexists()
    {
        $prodcode = $this->input->post('prodcode');

        $checkexist = $this->prdtmdl->checkproductcodeexists($this->buid, $prodcode);
        if($checkexist == 0)
        {
            $output = array(
               'success' => true
              );
              echo json_encode($output);
        }
    }

}
