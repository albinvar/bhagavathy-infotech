<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('welcome/userauthentication_model', 'usersigin');
        $this->load->model('admin/business_model', 'bus');
        $this->load->model('admin/businessunit_model', 'busunt');
        
        ini_set('max_execution_time', 35000);
    }

    public function purchasetax($fromdate=0, $todate=0, $print=0)
    {
        $this->load->model('purchase/Purchasemaster_model', 'purmstr');

        $this->data['title'] = "Purchase Tax";

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }
        $this->data['businessdet'] = $businessdet = $this->busunt->getprintbusinessunitdetails($this->buid);
        $this->data['purchaselist'] = $this->purmstr->getpurchasetaxlist($this->buid, $fromdate, $todate);

        if($print == 1)
        {
            
            $this->load->view('purchasetaxprint', $this->data, FALSE);
        }else{
            $this->load->template('purchasetax', $this->data, FALSE);
        }
        
    }
    public function purchasetaxcsv($fromdate=0, $todate=0)
    {
        $this->load->model('purchase/Purchasemaster_model', 'purmstr');
        $purchaselist = $this->purmstr->getpurchasetaxlist($this->buid, $fromdate, $todate);

        $filename = 'Purchase Tax Report '.date('d-m-Y').'.csv';
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$filename"); 
         header("Content-Type: application/csv; ");

         $businessdet = $this->busunt->getprintbusinessunitdetails($this->buid);

         // file creation 
         $file = fopen('php://output', 'w');
         // $header = array("Bill No","Bill Date");

        if($this->isvatgst == 0){
            $header = array("#", "Bill Date","Bill No","Purchase CGST","Purchase SGST", "Purchase IGST", "Return CGST","Return SGST", "Return IGST"); 
        }else{
            $header = array("#", "Bill Date","Bill No","Purchase VAT", "Return VAT"); 
        }
         fputcsv($file, $header);
         $totalpcgst =0;
        $totalpsgst = 0;
        $totalpigst = 0;

        $totalrtcgst =0;
        $totalrtsgst = 0;
        $totalrtigst = 0;

        if($purchaselist)
        {
            $k=1;
            foreach($purchaselist as $stvl)
            {

                if($stvl->sp_state == '4028')
                {
                    $pucgst = $stvl->pm_totalgstamount/2;
                    $pusgst = $stvl->pm_totalgstamount/2;
                    $puigst = 0;
                }else{
                    $pucgst = 0;
                    $pusgst = 0;
                    $puigst = $stvl->pm_totalgstamount;
                }
                $totalpcgst = $totalpcgst + $pucgst;
                $totalpsgst = $totalpsgst + $pusgst;
                $totalpigst = $totalpigst + $puigst;

                $rtcgst = 0;
                $rtsgst = 0;
                $rtigst = 0;
                if($stvl->pm_type == 2)
                {
                    if(($stvl->sp_state == $businessdet->bu_state || $stvl->rb_state == '') || $businessdet->bu_country != '101')
                    {
                        $rtcgst = $stvl->pm_totalgstamount/2;
                        $rtsgst = $stvl->pm_totalgstamount/2;
                        $rtigst = 0;
                    }else{
                        $rtcgst = 0;
                        $rtsgst = 0;
                        $rtigst = $stvl->pm_totalgstamount;
                    }
                }else{
                    if($stvl->pm_partialreturn == 1)
                    {
                        $retrndet = $this->purmstr->getpurchasereturndetails($stvl->pm_purchaseid);
                        if($retrndet)
                        {
                            if(($stvl->sp_state == $businessdet->bu_state || $stvl->rb_state == '') || $businessdet->bu_country != '101')
                            {
                                $rtcgst = $retrndet->pm_totalgstamount/2;
                                $rtsgst = $retrndet->pm_totalgstamount/2;
                                $rtigst = 0;
                            }else{
                                $rtcgst = 0;
                                $rtsgst = 0;
                                $rtigst = $retrndet->pm_totalgstamount;
                            }
                    
                        }
                    }
                    
                }

                $totalrtcgst = $totalrtcgst + $rtcgst;
                $totalrtsgst = $totalrtsgst + $rtsgst;
                $totalrtigst = $totalrtigst + $rtigst;

                if($this->isvatgst == 0){
                    $line = array($k, date('d-M-Y', strtotime($stvl->pm_date)) . " ". date('H:i', strtotime($stvl->pm_time)),$stvl->pm_purchaseprefix . $stvl->pm_purchaseno,$pucgst,$pusgst, $puigst, $rtcgst, $rtsgst,$rtigst); 
                }else{
                    $line = array($k, date('d-M-Y', strtotime($stvl->pm_date)) . " ". date('H:i', strtotime($stvl->pm_time)),$stvl->pm_purchaseprefix . $stvl->pm_purchaseno,$puigst,$rtigst); 
                }

                    fputcsv($file,$line); 
                    $k++;
                }
            }
            if($this->isvatgst == 0){
                $line = array("", "Total","", $totalpcgst, $totalpsgst, $totalpigst,$totalrtcgst,$totalrtsgst,$totalrtigst); 
            }else{
                $line = array("", "Total","", $totalpigst,$totalrtigst); 
            }

            fputcsv($file,$line);
            
         
         
         fclose($file); 
         exit;
    }

    public function saletax($type='0', $fromdate=0, $todate=0, $print=0)
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->data['type'] = $type;
        if($type == 'all')
        {
            $this->data['title'] = "Sale Tax";
        }else if($type == '0')
        {
            $this->data['title'] = "Retail Tax";
        }else if($type == '1'){
            $this->data['title'] = "Wholesale Tax";
        }else if($type == '7'){
            $this->data['title'] = "C Sale Tax";
        }else if($type == '8'){
            $this->data['title'] = "D Sale Tax";
        }

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);

        $this->data['salelist'] = $this->retlmstr->getretailbilllist($this->buid, $type, $fromdate, $todate);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('saletaxprint', $this->data, FALSE);
        }else{
            $this->load->template('saletax', $this->data, FALSE);
        }
    }
    public function saletaxcsv($type='0', $fromdate=0, $todate=0)
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $salelist = $this->retlmstr->getretailbilllist($this->buid, $type, $fromdate, $todate);

        if($type == 'all')
        {
            $filename = 'Sale Tax Report '.date('d-m-Y').'.csv';
        }else if($type == '0')
        {
            $filename = 'Retail Tax Report '.date('d-m-Y').'.csv';
        }else if($type == '1'){
            $filename = 'Wholesale Tax Report '.date('d-m-Y').'.csv';
        }else if($type == '7'){
            $filename = 'C Sale Tax Report '.date('d-m-Y').'.csv';
        }else if($type == '8'){
            $filename = 'D Sale Tax Report '.date('d-m-Y').'.csv';
        }

        $businessdet = $this->busunt->getprintbusinessunitdetails($this->buid);
        
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$filename"); 
         header("Content-Type: application/csv; ");

         // file creation 
         $file = fopen('php://output', 'w');
         // $header = array("Bill No","Bill Date");
         if($this->isvatgst == 0){
             $header = array("#", "Bill Date","Bill No","Sale CGST","Sale SGST", "Sale IGST", "Return CGST","Return SGST", "Return IGST"); 
        }else{
             $header = array("#", "Bill Date","Bill No","Sale VAT", "Return VAT"); 
        }
         fputcsv($file, $header);
         
         $totalpcgst =0;
        $totalpsgst = 0;
        $totalpigst = 0;

        $totalrtcgst =0;
        $totalrtsgst = 0;
        $totalrtigst = 0;
        if($salelist)
        {
            $k=1;
            foreach($salelist as $stvl)
            {

                if(($stvl->rb_state == $businessdet->bu_state || $stvl->rb_state == '') || $businessdet->bu_country != '101')
                {
                    $pucgst = $stvl->rb_totalgstamnt/2;
                    $pusgst = $stvl->rb_totalgstamnt/2;
                    $puigst = 0;
                }else{
                    $pucgst = 0;
                    $pusgst = 0;
                    $puigst = $stvl->rb_totalgstamnt;
                }
                $totalpcgst = $totalpcgst + $pucgst;
                $totalpsgst = $totalpsgst + $pusgst;
                $totalpigst = $totalpigst + $puigst;

                $retcgst = 0;
                $retsgst = 0;
                $retigst = 0;
                if($stvl->rb_partialreturn == 1)
                {
                    $retrndet = $this->retlmstr->getsalereturndetails($stvl->rb_retailbillid);
                    if($retrndet)
                    {
                        if(($stvl->rb_state == $businessdet->bu_state || $stvl->rb_state == '') || $businessdet->bu_country != '101')
                        {
                            $retcgst = $retrndet->rb_totalgstamnt/2;
                            $retsgst = $retrndet->rb_totalgstamnt/2;
                            $retigst = 0;
                        }else{
                            $retcgst = 0;
                            $retsgst = 0;
                            $retigst = $retrndet->rb_totalgstamnt;
                        }
                        $totalrtcgst = $totalrtcgst + $retcgst;
                        $totalrtsgst = $totalrtsgst + $retsgst;
                        $totalrtigst = $totalrtigst + $retigst;
                    }
                }
                    if($this->isvatgst == 0){
                        $line = array($k, date('d-M-Y', strtotime($stvl->rb_date)) . " ". date('H:i', strtotime($stvl->rb_time)),$stvl->rb_billprefix . $stvl->rb_billno,$pucgst,$pusgst, $puigst, $retcgst, $retsgst,$retigst); 
                    }else{
                        $line = array($k, date('d-M-Y', strtotime($stvl->rb_date)) . " ". date('H:i', strtotime($stvl->rb_time)),$stvl->rb_billprefix . $stvl->rb_billno,$puigst,$retigst); 
                    }

                    fputcsv($file,$line); 
                    $k++;
                }

                if($this->isvatgst == 0){
                    $line = array("", "Total","", $totalpcgst, $totalpsgst, $totalpigst,$totalrtcgst,$totalrtsgst,$totalrtigst); 
                }else{
                    $line = array("", "Total","", $totalpigst,$totalrtigst); 
                }

                fputcsv($file,$line);
            }
            
         fclose($file); 
         exit;
    }
    public function billwiseprofitreport($type='all', $fromdate=0, $todate=0, $print=0)
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('inventory/products_model', 'prdtmdl');

        $this->data['type'] = $type;
        if($type == 'all')
        {
            $this->data['title'] = "Bill Wise Profit Report";
        }else if($type == '0')
        {
            $this->data['title'] = "Retail Bill Wise Profit Report";
        }else{
            $this->data['title'] = "Wholesale Bill Wise Profit Report";
        }

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['billlist'] = $this->retlmstr->getretailbilllist($this->buid, $type, $fromdate, $todate);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('billwiseprofitreportprint', $this->data, FALSE);
        }else{
            $this->load->template('billwiseprofitreport', $this->data, FALSE);
        }
    }
    public function billwiseprofitreportcsv($type, $fromdate, $todate)
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('inventory/products_model', 'prdtmdl');

        $billlist = $this->retlmstr->getretailbilllist($this->buid, $type, $fromdate, $todate);

        if($type == 'all')
        {
            $filename = 'Bill Wise Profit Report '.date('d-m-Y').'.csv';
        }else if($type == '0')
        {
            $filename = 'Retail Bill Wise Profit Report '.date('d-m-Y').'.csv';
        }else{
            $filename = 'Wholesale Bill Wise Profit Report '.date('d-m-Y').'.csv';
        }
        
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$filename"); 
         header("Content-Type: application/csv; ");

         // file creation 
         $file = fopen('php://output', 'w');
         $header = array("#", "Bill No","Bill Date","Purchase Price","Sale Price", "Profit"); 
         fputcsv($file, $header);
         
        $totalpurchase =0;
        $totalsaleprice = 0;
        $totalprofit = 0;

        if($billlist)
        {
            $k=1;
            foreach($billlist as $blvl)
            {
                $biltot = $this->retlslv->getbillsalesumbyid($blvl->rb_retailbillid);

                $totalpurchase = $totalpurchase + $biltot->totpurchase;
                $totalsaleprice = $totalsaleprice + $biltot->totsale;
                $itemprofit = $biltot->totsale-$biltot->totpurchase;
                $totalprofit = $totalprofit + $itemprofit;

                
                $line = array($k, ($blvl->rb_billprefix . " " . $blvl->rb_billno),(date('d-M-Y', strtotime($blvl->rb_date)) . " " . date('H:i', strtotime($blvl->rb_time))), price_roundof($biltot->totpurchase), price_roundof($biltot->totsale), price_roundof($itemprofit)); 

                fputcsv($file,$line); 
                $k++;
             }

            $line = array("", "", "Total", price_roundof($totalpurchase), price_roundof($totalsaleprice), price_roundof($totalprofit)); 

            fputcsv($file,$line);
            }
            
         fclose($file); 
         exit;
    }
    public function itemprofitreport($type='all', $fromdate=0, $todate=0, $print=0)
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('inventory/products_model', 'prdtmdl');

        $this->data['type'] = $type;
        if($type == 'all')
        {
            $this->data['title'] = "Itemwise Profit Report";
        }else if($type == '0')
        {
            $this->data['title'] = "Retail Itemwise Profit Report";
        }else{
            $this->data['title'] = "Wholesale Itemwise Profit Report";
        }

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['productlist'] = $this->prdtmdl->getprofitproductrows($this->buid);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('itemprofitreportprint', $this->data, FALSE);
        }else{
            $this->load->template('itemprofitreport', $this->data, FALSE);
        }
    }
    public function itemprofitreportcsv($type, $fromdate, $todate)
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('inventory/products_model', 'prdtmdl');

        $productlist = $this->prdtmdl->getprofitproductrows($this->buid);

        if($type == 'all')
        {
            $filename = 'Itemwise Profit Report '.date('d-m-Y').'.csv';
        }else if($type == '0')
        {
            $filename = 'Retail Itemwise Profit Report '.date('d-m-Y').'.csv';
        }else{
            $filename = 'Wholesale Itemwise Profit Report '.date('d-m-Y').'.csv';
        }
        
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$filename"); 
         header("Content-Type: application/csv; ");

         // file creation 
         $file = fopen('php://output', 'w');
         $header = array("#", "Code","Product","Purchase Price","Sale Price", "Total Qty", "Profit"); 
         fputcsv($file, $header);
         
         $totalqty=0;
            $totalpurprice =0;
            $totalsaleprice = 0;
            $totalprofit = 0;

        if($productlist)
        {
            $k=1;
            foreach($productlist as $prdvl)
            {
                $prdcttot = $this->retlslv->getproductsalesum($prdvl->pd_productid, $type, $fromdate, $todate);

                $totalpurprice = $totalpurprice + $prdcttot->totpurchase;
                $totalsaleprice = $totalsaleprice + $prdcttot->totsale;
                $totalqty = $totalqty + $prdcttot->totqty;
                $itemprofit = $prdcttot->totsale-$prdcttot->totpurchase;
                $totalprofit = $totalprofit + $itemprofit;
                
                $line = array($k, $prdvl->pd_productcode, ($prdvl->pd_productname . " " . $prdvl->pd_size . " " . $prdvl->pd_brand), price_roundof($prdcttot->totpurchase), price_roundof($prdcttot->totsale), $prdcttot->totqty, price_roundof($itemprofit)); 

                fputcsv($file,$line); 
                $k++;
             }

            $line = array("", "", "Total", price_roundof($totalpurprice), price_roundof($totalsaleprice), $totalqty, price_roundof($totalprofit)); 

            fputcsv($file,$line);
            }
            
         fclose($file); 
         exit;
    }

    public function hsnreport($type='all', $fromdate=0, $todate=0, $print=0)
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('inventory/products_model', 'prdtmdl');

        $this->data['type'] = $type;
        if($type == 'all')
        {
            $this->data['title'] = "HSN Report";
        }else if($type == '0')
        {
            $this->data['title'] = "HSN Retail Report";
        }else{
            $this->data['title'] = "HSN Wholesale Report";
        }

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['productlist'] = $this->prdtmdl->gethsnproductrows($this->buid);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('hsnreportprint', $this->data, FALSE);
        }else{
            $this->load->template('hsnreport', $this->data, FALSE);
        }
    }
    public function hsnreportcsv($type, $fromdate, $todate)
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('inventory/products_model', 'prdtmdl');

        $productlist = $this->prdtmdl->gethsnproductrows($this->buid);

        if($type == 'all')
        {
            $filename = 'HSN Report '.date('d-m-Y').'.csv';
        }else if($type == '0')
        {
            $filename = 'HSN Retail Report '.date('d-m-Y').'.csv';
        }else{
            $filename = 'HSN Wholesale Report '.date('d-m-Y').'.csv';
        }
        
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$filename"); 
         header("Content-Type: application/csv; ");

         // file creation 
         $file = fopen('php://output', 'w');
         if($this->isvatgst == 0){
            $header = array("#", "HSN","Total Qty","Taxable Amt", "Tax %", "Tax Amt","Total Amt", "CGST", "SGST", "IGST"); 
        }else{
            $header = array("#", "HSN","Total Qty","Taxable Amt", "Tax %", "Tax Amt","Total Amt"); 
        }
         fputcsv($file, $header);
         
         $totalqty=0;
        $totaltaxableamt =0;
        $totaltaxamt = 0;
        $totalamount = 0;
        $totalcgst =0;
        $totalsgst = 0;
        $totaligst = 0;
        if($productlist)
        {
            $k=1;
            foreach($productlist as $prdvl)
            {
                $prdcttot = $this->retlslv->gethsnproductkeralasalesum($prdvl->pd_hsnno, $type, $fromdate, $todate);
                $prdcttotcgst = $this->retlslv->gethsnproductoutkeralasalesum($prdvl->pd_hsnno, $type, $fromdate, $todate);

                if(($prdcttot->totqty + $prdcttotcgst->totqty) > 0)
                {
                    $totalqty = $totalqty + $prdcttot->totqty + $prdcttotcgst->totqty;
                    $totaltaxableamt = $totaltaxableamt + $prdcttot->totnet + $prdcttotcgst->totnet;
                    $totaltaxamt = $totaltaxamt + $prdcttot->totgst + $prdcttotcgst->totgst;
                    $totalamount = $totalamount + $prdcttot->totamnt + $prdcttotcgst->totamnt;
                    $totalcgst = $totalcgst + ($prdcttot->totgst/2);
                    $totalsgst = $totalsgst + ($prdcttot->totgst/2);
                    $totaligst = $totaligst + ($prdcttotcgst->totgst);
                    
                    if($this->isvatgst == 0){
                        $line = array($k, $prdvl->pd_hsnno, ($prdcttot->totqty + $prdcttotcgst->totqty), price_roundof($prdcttot->totnet + $prdcttotcgst->totnet), $prdvl->tb_tax, price_roundof($prdcttot->totgst + $prdcttotcgst->totgst), price_roundof($prdcttot->totamnt + $prdcttotcgst->totamnt), price_roundof($prdcttot->totgst/2), price_roundof($prdcttot->totgst/2), price_roundof($prdcttotcgst->totgst)); 
                    }else{
                        $line = array($k, $prdvl->pd_hsnno, ($prdcttot->totqty + $prdcttotcgst->totqty), price_roundof($prdcttot->totnet + $prdcttotcgst->totnet), $prdvl->tb_tax, price_roundof($prdcttot->totgst + $prdcttotcgst->totgst), price_roundof($prdcttot->totamnt + $prdcttotcgst->totamnt)); 
                    }

                    fputcsv($file,$line); 
                    $k++;
                }
             }
            if($this->isvatgst == 0){
                $line = array("", "Total", $totalqty, price_roundof($totaltaxableamt), "", price_roundof($totaltaxamt), price_roundof($totalamount), price_roundof($totalcgst), price_roundof($totalsgst), price_roundof($totaligst)); 
            }else{
                $line = array("", "Total", $totalqty, price_roundof($totaltaxableamt), "", price_roundof($totaltaxamt), price_roundof($totalamount)); 
            }

            fputcsv($file,$line);
            }
            
         fclose($file); 
         exit;
    }
    public function itemwisereport($type='all', $fromdate=0, $todate=0, $print=0)
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('inventory/products_model', 'prdtmdl');

        $this->data['type'] = $type;
        if($type == 'all')
        {
            $this->data['title'] = "Item Wise Report";
        }else if($type == '0')
        {
            $this->data['title'] = "Retail Item Wise Report";
        }else{
            $this->data['title'] = "Wholesale Item Wise Report";
        }

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['productlist'] = $this->prdtmdl->getactiverows($this->buid);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('itemwisereportprint', $this->data, FALSE);
        }else{
            $this->load->template('itemwisereport', $this->data, FALSE);
        }
    }
    public function itemwisereportcsv($type, $fromdate, $todate)
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('inventory/products_model', 'prdtmdl');

        $productlist = $this->prdtmdl->getactiverows($this->buid);

        if($type == 'all')
        {
            $filename = 'Item Wise Report '.date('d-m-Y').'.csv';
        }else if($type == '0')
        {
            $filename = 'Retail Item Wise Report '.date('d-m-Y').'.csv';
        }else{
            $filename = 'Wholesale Item Wise Report '.date('d-m-Y').'.csv';
        }
        
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$filename"); 
         header("Content-Type: application/csv; ");

         // file creation 
         $file = fopen('php://output', 'w');
         if($this->isvatgst == 0){
            $header = array("#", "HSN","Product","Total Qty","Taxable Amt", "Tax %", "Tax Amt","Total Amt", "CGST", "SGST", "IGST"); 
        }else{
            $header = array("#", "HSN","Product","Total Qty","Taxable Amt", "Tax %", "Tax Amt","Total Amt"); 
        }
         fputcsv($file, $header);
         
         $totalqty=0;
        $totaltaxableamt =0;
        $totaltaxamt = 0;
        $totalamount = 0;
        $totalcgst =0;
        $totalsgst = 0;
        $totaligst = 0;
        if($productlist)
        {
            $k=1;
            foreach($productlist as $prdvl)
            {
                $prdcttot = $this->retlslv->getproductkeralasalesum($prdvl->pd_productid, $type, $fromdate, $todate);
                $prdcttotcgst = $this->retlslv->getproductoutkeralasalesum($prdvl->pd_productid, $type, $fromdate, $todate);

                if(($prdcttot->totqty + $prdcttotcgst->totqty) > 0)
                {
                $totalqty = $totalqty + $prdcttot->totqty + $prdcttotcgst->totqty;
                $totaltaxableamt = $totaltaxableamt + $prdcttot->totnet + $prdcttotcgst->totnet;
                $totaltaxamt = $totaltaxamt + $prdcttot->totgst + $prdcttotcgst->totgst;
                $totalamount = $totalamount + $prdcttot->totamnt + $prdcttotcgst->totamnt;
                $totalcgst = $totalcgst + ($prdcttot->totgst/2);
                $totalsgst = $totalsgst + ($prdcttot->totgst/2);
                $totaligst = $totaligst + ($prdcttotcgst->totgst);
                
                if($this->isvatgst == 0){
                    $line = array($k, $prdvl->pd_hsnno, ($prdvl->pd_productname . " " . $prdvl->pd_size . " " . $prdvl->pd_brand), ($prdcttot->totqty + $prdcttotcgst->totqty), price_roundof($prdcttot->totnet + $prdcttotcgst->totnet), $prdvl->tb_tax, price_roundof($prdcttot->totgst + $prdcttotcgst->totgst), price_roundof($prdcttot->totamnt + $prdcttotcgst->totamnt), price_roundof($prdcttot->totgst/2), price_roundof($prdcttot->totgst/2), price_roundof($prdcttotcgst->totgst)); 
                }else{
                    $line = array($k, $prdvl->pd_hsnno, ($prdvl->pd_productname . " " . $prdvl->pd_size . " " . $prdvl->pd_brand), ($prdcttot->totqty + $prdcttotcgst->totqty), price_roundof($prdcttot->totnet + $prdcttotcgst->totnet), $prdvl->tb_tax, price_roundof($prdcttot->totgst + $prdcttotcgst->totgst), price_roundof($prdcttot->totamnt + $prdcttotcgst->totamnt)); 
                }

                fputcsv($file,$line); 
                $k++;
                }
             }

             if($this->isvatgst == 0){
                $line = array("", "", "Total", $totalqty, price_roundof($totaltaxableamt), "", price_roundof($totaltaxamt), price_roundof($totalamount), price_roundof($totalcgst), price_roundof($totalsgst), price_roundof($totaligst)); 
            }else{
                $line = array("", "", "Total", $totalqty, price_roundof($totaltaxableamt), "", price_roundof($totaltaxamt), price_roundof($totalamount)); 
            }

            fputcsv($file,$line);
            }
            
         fclose($file); 
         exit;
    }

    public function taxpercentagereport($type='all', $fromdate=0, $todate=0, $print=0)
    {
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('business/taxbands_model', 'txbnds');

        $this->data['type'] = $type;
        if($type == 'all')
        {
            $this->data['title'] = "Tax Percentage Wise Report";
        }else if($type == '0')
        {
            $this->data['title'] = "Retail Tax Percentage Wise Report";
        }else{
            $this->data['title'] = "Wholesale Tax Percentage Wise Report";
        }

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['taxbands'] = $this->txbnds->getactiverows($this->buid);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('taxpercentagereportprint', $this->data, FALSE);
        }else{
            $this->load->template('taxpercentagereport', $this->data, FALSE);
        }
    }
    public function taxpercentagereportcsv($type, $fromdate, $todate)
    {
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('business/taxbands_model', 'txbnds');

        $taxbands = $this->txbnds->getactiverows($this->buid);

        if($type == 'all')
        {
            $filename = 'Tax Percentage Wise Report '.date('d-m-Y').'.csv';
        }else if($type == '0')
        {
            $filename = 'Retail Tax Percentage Wise Report '.date('d-m-Y').'.csv';
        }else{
            $filename = 'Wholesale Tax Percentage Wise Report '.date('d-m-Y').'.csv';
        }
        
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$filename"); 
         header("Content-Type: application/csv; ");

         // file creation 
         $file = fopen('php://output', 'w');
         if($this->isvatgst == 0){
            $header = array("#", "Tax Band","Tax %","Taxable Amt", "Tax Amt","Total Amt", "CGST", "SGST", "IGST"); 
        }else{
            $header = array("#", "Tax Band","Tax %","Taxable Amt", "Tax Amt","Total Amt"); 
        }
         fputcsv($file, $header);
         
         $totalqty=0;
        $totaltaxableamt =0;
        $totaltaxamt = 0;
        $totalamount = 0;

        $totalcgst =0;
        $totalsgst = 0;
        $totaligst = 0;
        if($taxbands)
        {
            $k=1;
            foreach($taxbands as $txvl)
            {
                $prdcttot = $this->retlslv->gettaxvaluekeralasalesum($txvl->tb_tax, $type, $fromdate, $todate);
                $prdcttotcgst = $this->retlslv->gettaxvalueoutkeralasalesum($txvl->tb_tax, $type, $fromdate, $todate);

                $totaltaxableamt = $totaltaxableamt + $prdcttot->totnet + $prdcttotcgst->totnet;
                $totaltaxamt = $totaltaxamt + $prdcttot->totgst + $prdcttotcgst->totgst;
                $totalamount = $totalamount + $prdcttot->totamnt + $prdcttotcgst->totamnt;
                $totalcgst = $totalcgst + ($prdcttot->totgst/2);
                $totalsgst = $totalsgst + ($prdcttot->totgst/2);
                $totaligst = $totaligst + ($prdcttotcgst->totgst);
                
                if($this->isvatgst == 0){
                    $line = array($k, $txvl->tb_taxband, $txvl->tb_tax, price_roundof($prdcttot->totnet + $prdcttotcgst->totnet),  price_roundof($prdcttot->totgst + $prdcttotcgst->totgst), price_roundof($prdcttot->totamnt + $prdcttotcgst->totamnt), price_roundof($prdcttot->totgst/2), price_roundof($prdcttot->totgst/2), price_roundof($prdcttotcgst->totgst)); 
                }else{
                    $line = array($k, $txvl->tb_taxband, $txvl->tb_tax, price_roundof($prdcttot->totnet + $prdcttotcgst->totnet),  price_roundof($prdcttot->totgst + $prdcttotcgst->totgst), price_roundof($prdcttot->totamnt + $prdcttotcgst->totamnt)); 
                }

                fputcsv($file,$line); 
                $k++;
             }

            if($this->isvatgst == 0){
                $line = array("", "", "Total", price_roundof($totaltaxableamt), price_roundof($totaltaxamt), price_roundof($totalamount), price_roundof($totalcgst), price_roundof($totalsgst), price_roundof($totaligst)); 
            }else{
                $line = array("", "", "Total", price_roundof($totaltaxableamt), price_roundof($totaltaxamt), price_roundof($totalamount)); 
            }

            fputcsv($file,$line);
            }
            
         fclose($file); 
         exit;
    }

    public function gstrb2breport($fromdate=0, $todate=0, $print=0)
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['salelist'] = $this->retlslv->getretailgstrb2blist($this->buid, $fromdate, $todate);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('gstrb2breportprint', $this->data, FALSE);
        }else{
            $this->load->template('gstrb2breport', $this->data, FALSE);
        }
    }

    public function gstrb2breportcsv($fromdate, $todate, $json=0)
    {
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('purchase/Purchaseslave_model', 'purslv');

        $salelist = $this->retlslv->getretailgstrb2blist($this->buid, $fromdate, $todate);

        $totalgstamt =0;
        $totaltaxableamnt = 0;
        $totalamount = 0;
        $invoices = array();
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
                }

                if($prvl->rb_customerid == 0)
                {
                    $customr = $prvl->rb_customername;
                    $custmrgst = $prvl->rb_gstno;
                }else{
                    $customr = $prvl->ct_name;
                    $custmrgst = $prvl->ct_gstin;
                }
                $billno = $prvl->rb_billprefix . $prvl->rb_billno;
                $totaltaxableamnt = $totaltaxableamnt + $prvl->rbs_nettotal;
                $totalgstamt = $totalgstamt + $prvl->rbs_totalgst;
                $totalamount = $totalamount + $prvl->rbs_totalamount;

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

                ${"customername".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $customr;
                ${"customergst".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $custmrgst;
                ${"billno".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $billno;
                ${"billdate".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rb_date;
                }
            }
        }

        if($json == 0)
        {
            $filename = 'B2B Report '.date('d-m-Y').'.csv';
             header("Content-Description: File Transfer"); 
             header("Content-Disposition: attachment; filename=$filename"); 
             header("Content-Type: application/csv; ");

             // file creation 
             $file = fopen('php://output', 'w');
             // $header = array("Bill No","Bill Date");

             $header = array("#", "Invoice Date","Invoice No","Customer Name","GST No", "Taxable Amt", "Tax %", "Tax Amt","Cess Amt", "Grand Total"); 
             fputcsv($file, $header);
             if($invoices)
             {
                $k=1;
             foreach ($invoices as $invl)
             { 
                if(${"taxvalues".$invl})
                {
                    foreach(${"taxvalues".$invl} as $taxvl)
                    {
                        $line = array($k, date('d-m-Y', strtotime(${"billdate".$invl."-" . $taxvl})),${"billno".$invl."-" . $taxvl},${"customername".$invl."-" . $taxvl},${"customergst".$invl."-" . $taxvl}, price_roundof(${"taxableamnt".$invl."-" . $taxvl}), $taxvl, price_roundof(${"totalgst".$invl."-" . $taxvl}),price_roundof(${"cessamnt".$invl."-" . $taxvl}), price_roundof(${"totalamnt".$invl."-" . $taxvl})); 

                        fputcsv($file,$line); 
                        $k++;
                    }
                }
                
             }
             }
             fclose($file); 
             exit;
        }
        else{
            $data = array();
            if($invoices)
            {
                $k=1;
             foreach ($invoices as $invl)
             { 
                if(${"taxvalues".$invl})
                {
                    foreach(${"taxvalues".$invl} as $taxvl)
                    {
                        $data[] = array(
                            "Invoice Date" => date('d-m-Y', strtotime(${"billdate".$invl."-" . $taxvl})), 
                            "Invoice No" => ${"billno".$invl."-" . $taxvl},
                            "Customer Name" => ${"customername".$invl."-" . $taxvl},
                            "GST No" => ${"customergst".$invl."-" . $taxvl},
                            "Taxable Amt" => price_roundof(${"taxableamnt".$invl."-" . $taxvl}),
                            "Tax %" => $taxvl,
                            "Tax Amt" => price_roundof(${"totalgst".$invl."-" . $taxvl}),
                            "Cess Amt" => price_roundof(${"cessamnt".$invl."-" . $taxvl}),
                            "Grand Total" => price_roundof(${"totalamnt".$invl."-" . $taxvl})
                        );
                    }
                }
            }
            }
                
            
            $json = json_encode($data, JSON_PRETTY_PRINT);

           /* $output_filename = 'uploads/reports/B2B Report '.date('d-m-Y').'.json';
            file_put_contents($output_filename, $json);*/

            header('Content-disposition: attachment; filename=B2B Report '.date('d-m-Y').'.json');
            header('Content-type: application/json');
            echo $json;
        }

    }

    public function gstrb2creport($fromdate=0, $todate=0, $print=0)
    {
        $this->load->model('sale/Retailbillmaster_model', 'retlmstr');
        $this->load->model('sale/Retailbillslave_model', 'retlslv');

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['salelist'] = $this->retlslv->getretailgstrb2clist($this->buid, $fromdate, $todate);

        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('gstrb2creportprint', $this->data, FALSE);
        }else{
            $this->load->template('gstrb2creport', $this->data, FALSE);
        }
        
    }
    public function gstrb2creportcsv($fromdate=0, $todate=0, $json=0)
    {
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('purchase/Purchaseslave_model', 'purslv');

        $salelist = $this->retlslv->getretailgstrb2clist($this->buid, $fromdate, $todate);

        $totalgstamt =0;
        $totaltaxableamnt = 0;
        $totalamount = 0;
        $invoices = array();
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
                }

                if($prvl->rb_customerid == 0)
                {
                    $customr = $prvl->rb_customername;
                    $custmrgst = $prvl->rb_gstno;
                }else{
                    $customr = $prvl->ct_name;
                    $custmrgst = $prvl->ct_gstin;
                }
                $billno = $prvl->rb_billprefix . $prvl->rb_billno;
                $totaltaxableamnt = $totaltaxableamnt + $prvl->rbs_nettotal;
                $totalgstamt = $totalgstamt + $prvl->rbs_totalgst;
                $totalamount = $totalamount + $prvl->rbs_totalamount;

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

                ${"customername".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $customr;
                ${"customergst".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $custmrgst;
                ${"billno".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $billno;
                ${"billdate".$prvl->rb_retailbillid."-" . $prvl->rbs_gstpercent} = $prvl->rb_date;
                }
            }
        }

        if($json == 0)
        {
            $filename = 'B2C Report '.date('d-m-Y').'.csv';
             header("Content-Description: File Transfer"); 
             header("Content-Disposition: attachment; filename=$filename"); 
             header("Content-Type: application/csv; ");

             // file creation 
             $file = fopen('php://output', 'w');
             // $header = array("Bill No","Bill Date");

             $header = array("#", "Invoice Date","Invoice No","Customer Name", "Taxable Amt", "Tax %", "Tax Amt","Cess Amt", "Grand Total"); 
             fputcsv($file, $header);
             if($invoices)
             {
                $k=1;
             foreach ($invoices as $invl)
             { 
                if(${"taxvalues".$invl})
                {
                    foreach(${"taxvalues".$invl} as $taxvl)
                    {
                        $line = array($k, date('d-m-Y', strtotime(${"billdate".$invl."-" . $taxvl})),${"billno".$invl."-" . $taxvl},${"customername".$invl."-" . $taxvl}, price_roundof(${"taxableamnt".$invl."-" . $taxvl}), $taxvl, price_roundof(${"totalgst".$invl."-" . $taxvl}),price_roundof(${"cessamnt".$invl."-" . $taxvl}), price_roundof(${"totalamnt".$invl."-" . $taxvl})); 

                        fputcsv($file,$line); 
                        $k++;
                    }
                }
                
             }
             }
             fclose($file); 
             exit;
        }
        else{
            $data = array();
            if($invoices)
            {
                $k=1;
             foreach ($invoices as $invl)
             { 
                if(${"taxvalues".$invl})
                {
                    foreach(${"taxvalues".$invl} as $taxvl)
                    {
                        $data[] = array(
                            "Invoice Date" => date('d-m-Y', strtotime(${"billdate".$invl."-" . $taxvl})), 
                            "Invoice No" => ${"billno".$invl."-" . $taxvl},
                            "Customer Name" => ${"customername".$invl."-" . $taxvl},
                            "Taxable Amt" => price_roundof(${"taxableamnt".$invl."-" . $taxvl}),
                            "Tax %" => $taxvl,
                            "Tax Amt" => price_roundof(${"totalgst".$invl."-" . $taxvl}),
                            "Cess Amt" => price_roundof(${"cessamnt".$invl."-" . $taxvl}),
                            "Grand Total" => price_roundof(${"totalamnt".$invl."-" . $taxvl})
                        );
                    }
                }
            }
            }
                
            
            $json = json_encode($data, JSON_PRETTY_PRINT);

            /*$output_filename = 'uploads/reports/B2C Report '.date('d-m-Y').'.json';
            file_put_contents($output_filename, $json);*/

            header('Content-disposition: attachment; filename=B2C Report '.date('d-m-Y').'.json');
            header('Content-type: application/json');
            echo $json;
        }
    }

    public function creditdebitb2breport($fromdate=0, $todate=0, $print=0)
    {
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('purchase/Purchaseslave_model', 'purslv');

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['salelist'] = $this->retlslv->getretailreturngstrb2blist($this->buid, $fromdate, $todate);
        $this->data['purchaselist'] = $this->purslv->gerpurchasegstb2blist($this->buid, $fromdate, $todate);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('creditdebitb2breportprint', $this->data, FALSE);
        }else{
            $this->load->template('creditdebitb2breport', $this->data, FALSE);
        }
        
    }
    public function creditdebitb2breportcsv($fromdate, $todate, $json=0)
    {
        $this->load->model('sale/Retailbillslave_model', 'retlslv');
        $this->load->model('purchase/Purchaseslave_model', 'purslv');

        $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
        $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));

        $salelist = $this->retlslv->getretailreturngstrb2blist($this->buid, $fromdate, $todate);
        $purchaselist = $this->purslv->gerpurchasegstb2blist($this->buid, $fromdate, $todate);

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

        if($invoicewithdate)
        {
            usort($invoicewithdate, function($a, $b) { 
              return strtotime($a['date']) - strtotime($b['date']); 
            });

        }

        if($json == 0)
        {
            $filename = 'Credit Note and Debit Note Report -B2B'.date('d-m-Y').'.csv';
             header("Content-Description: File Transfer"); 
             header("Content-Disposition: attachment; filename=$filename"); 
             header("Content-Type: application/csv; ");

             // file creation 
             $file = fopen('php://output', 'w');
             // $header = array("Bill No","Bill Date");

             $header = array("#", "GSTIN", "Name of Recipient", "Note Number","Note Date","Note Type", "Place of Supply", "Note value", "Tax Percentage","Taxable Value", "Cess Amt"); 
             fputcsv($file, $header);
             if($invoicewithdate)
             {
                $k=1;
             foreach ($invoicewithdate as $indatevl)
             { 
                $invl = $indatevl['invoiceid'];
                if(${"taxvalues".$invl})
                {
                    foreach(${"taxvalues".$invl} as $taxvl)
                    {
                        $line = array($k, ${"customergst".$invl."-" . $taxvl},${"customername".$invl."-" . $taxvl},${"billno".$invl."-" . $taxvl}, date('d-m-Y', strtotime(${"billdate".$invl."-" . $taxvl})), ${"notetype".$invl."-" . $taxvl}, ${"statecode".$invl."-" . $taxvl},price_roundof(${"totalamnt".$invl."-" . $taxvl}), $taxvl,price_roundof(${"taxableamnt".$invl."-" . $taxvl}),price_roundof(${"cessamnt".$invl."-" . $taxvl})); 

                        fputcsv($file,$line); 
                        $k++;
                    }
                }
                
             }
             }
             fclose($file); 
             exit;
        }
        else{
            $data = array();
            if($invoicewithdate)
            {
                $k=1;
             foreach ($invoicewithdate as $indatevl)
             { 
                $invl = $indatevl['invoiceid'];
                if(${"taxvalues".$invl})
                {
                    foreach(${"taxvalues".$invl} as $taxvl)
                    {
                        $data[] = array(
                            "GSTIN" => ${"customergst".$invl."-" . $taxvl},
                            "Name of Recipient" => ${"customername".$invl."-" . $taxvl}, 
                            "Note Number" => ${"billno".$invl."-" . $taxvl},
                            "Note Date" => date('d-m-Y', strtotime(${"billdate".$invl."-" . $taxvl})),
                            "Note Type" => ${"notetype".$invl."-" . $taxvl},
                            "Place of Supply" => ${"statecode".$invl."-" . $taxvl},
                            "Note value" => price_roundof(${"totalamnt".$invl."-" . $taxvl}),
                            "Tax Percentage" => $taxvl,
                            "Taxable Value" => price_roundof(${"taxableamnt".$invl."-" . $taxvl}),
                            "Cess Amt" =>price_roundof(${"cessamnt".$invl."-" . $taxvl})
                        );
                    }
                }
            }
            }
                
            
            $json = json_encode($data, JSON_PRETTY_PRINT);

            /*$output_filename = 'uploads/reports/Credit Note and Debit Note Report -B2B '.date('d-m-Y').'.json';
            file_put_contents($output_filename, $json);*/

            header('Content-disposition: attachment; filename=Credit Note and Debit Note Report -B2B'.date('d-m-Y').'.json');
            header('Content-type: application/json');
            echo $json;
        }
    }
    
    public function creditdebitb2creport($fromdate=0, $todate=0, $print=0)
    {
        $this->load->model('sale/Retailbillslave_model', 'retlslv');

        if($fromdate == 0)
        {
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime('-30 days'));
            $this->data['todate'] = $todate = date('Y-m-d');
        }else{
            $this->data['fromdate'] = $fromdate = date('Y-m-d', strtotime($fromdate));
            $this->data['todate'] = $todate = date('Y-m-d', strtotime($todate));
        }

        $this->data['salelist'] = $this->retlslv->getretailreturngstrb2clist($this->buid, $fromdate, $todate);
        if($print == 1)
        {
            $this->data['businessdet'] = $this->busunt->getprintbusinessunitdetails($this->buid);
            $this->load->view('creditdebitb2creportprint', $this->data, FALSE);
        }else{
            $this->load->template('creditdebitb2creport', $this->data, FALSE);
        }
        
    }
    public function creditdebitb2creportcsv($fromdate, $todate, $json=0)
    {
        $this->load->model('sale/Retailbillslave_model', 'retlslv');

        $fromdate = date('Y-m-d', strtotime($fromdate));
        $todate = date('Y-m-d', strtotime($todate));

        $salelist = $this->retlslv->getretailreturngstrb2clist($this->buid, $fromdate, $todate);

        $totalgstamt =0;
        $totaltaxableamnt = 0;
        $totalamount = 0;
        $invoices = array();
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

        if($json == 0)
        {
            $filename = 'Credit Note and Debit Note Report -B2C'.date('d-m-Y').'.csv';
             header("Content-Description: File Transfer"); 
             header("Content-Disposition: attachment; filename=$filename"); 
             header("Content-Type: application/csv; ");

             // file creation 
             $file = fopen('php://output', 'w');
             // $header = array("Bill No","Bill Date");

             $header = array("#", "Name of Recipient", "Note Number","Note Date","Note Type", "Place of Supply", "Note value", "Tax Percentage","Taxable Value", "Cess Amt"); 
             fputcsv($file, $header);
             if($invoices)
             {
                $k=1;
             foreach ($invoices as $invl)
             { 
                 if(${"taxvalues".$invl})
                {
                    foreach(${"taxvalues".$invl} as $taxvl)
                    {
                        $line = array($k, ${"customername".$invl."-" . $taxvl},${"billno".$invl."-" . $taxvl}, date('d-m-Y', strtotime(${"billdate".$invl."-" . $taxvl})), ${"notetype".$invl."-" . $taxvl}, ${"statecode".$invl."-" . $taxvl},price_roundof(${"totalamnt".$invl."-" . $taxvl}), $taxvl,price_roundof(${"taxableamnt".$invl."-" . $taxvl}),price_roundof(${"cessamnt".$invl."-" . $taxvl})); 

                        fputcsv($file,$line); 
                        $k++;
                    }
                }
                
             }
             }
             fclose($file); 
             exit;
        }
        else{
            $data = array();
            if($invoices)
             {
                $k=1;
             foreach ($invoices as $invl)
             { 
                 if(${"taxvalues".$invl})
                {
                    foreach(${"taxvalues".$invl} as $taxvl)
                    {
                        $data[] = array(
                            "Name of Recipient" => ${"customername".$invl."-" . $taxvl}, 
                            "Note Number" => ${"billno".$invl."-" . $taxvl},
                            "Note Date" => date('d-m-Y', strtotime(${"billdate".$invl."-" . $taxvl})),
                            "Note Type" => ${"notetype".$invl."-" . $taxvl},
                            "Place of Supply" => ${"statecode".$invl."-" . $taxvl},
                            "Note value" => price_roundof(${"totalamnt".$invl."-" . $taxvl}),
                            "Tax Percentage" => $taxvl,
                            "Taxable Value" => price_roundof(${"taxableamnt".$invl."-" . $taxvl}),
                            "Cess Amt" =>price_roundof(${"cessamnt".$invl."-" . $taxvl})
                        );
                    }
                }
            }
            }
                
            
            $json = json_encode($data, JSON_PRETTY_PRINT);

            /*$output_filename = 'uploads/reports/Credit Note and Debit Note Report -B2C '.date('d-m-Y').'.json';
            file_put_contents($output_filename, $json);*/

            header('Content-disposition: attachment; filename=Credit Note and Debit Note Report -B2C'.date('d-m-Y').'.json');
            header('Content-type: application/json');
            echo $json;
        }
    }
    
    
}
