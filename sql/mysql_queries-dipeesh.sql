/**** 30-08-2022 ****/
CREATE TABLE IF NOT EXISTS ub_usertypes(
    ut_usertypeid INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(ut_usertypeid),
    ut_usertype VARCHAR(350),
    ut_businessid INT,
    ut_isvisible INT DEFAULT 0,
    ut_isactive INT DEFAULT 0
);
CREATE TABLE IF NOT EXISTS ub_authentication(
    at_authid INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(at_authid),
    at_username VARCHAR(200),
    at_password VARCHAR(450),
    at_name VARCHAR(200),
    at_phone VARCHAR(200),
    at_mobile VARCHAR(200),
    at_email VARCHAR(200),
    at_photo VARCHAR(650),
    at_usertypeid INT,
    at_businessid INT,
    at_addedby INT,
    at_addedon DATETIME,
    at_isactive INT DEFAULT 0
);


/* 31-08-2022*/

CREATE TABLE IF NOT EXISTS ub_business(
    bs_businessid INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(bs_businessid),
    bs_name VARCHAR(450),
    bs_logo VARCHAR(350),
    bs_address VARCHAR(550),
    bs_website VARCHAR(250),
    bs_email VARCHAR(450),
    bs_phone VARCHAR(20),
    bs_panelcolorcode VARCHAR(30),
    bs_addedon DATETIME,
    bs_addedby INT,
    bs_status INT DEFAULT 0,
    bs_subscriptiontype INT
);

/******** 29-11-2022 ********/
CREATE TABLE IF NOT EXISTS ub_accountprofile(ap_accprofileid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ap_accprofileid), ap_businessunitid INT, ap_branchcode VARCHAR(150), ap_country INT, ap_state INT, ap_pincode VARCHAR(20), ap_gstno VARCHAR(450), ap_otherlicenceno VARCHAR(550), ap_financialyearname VARCHAR(250), ap_startdate DATE, ap_enddate DATE, ap_transcationstartdate DATE, ap_isactive INT DEFAULT 0, ap_updatedon DATETIME, ap_updatedby INT);

CREATE TABLE IF NOT EXISTS ub_financialyears(ay_financialyearid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ay_financialyearid), ay_financialname VARCHAR(250), ay_startdate DATE, ay_enddate DATE, ay_isactive INT DEFAULT 0);

CREATE TABLE IF NOT EXISTS ub_country(countryid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(countryid), countryname VARCHAR(250));

/************ 19-12-2022 ****/
CREATE TABLE IF NOT EXISTS ub_accountgroups(ag_groupid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ag_groupid), ag_buid INT, ag_group VARCHAR(450), ag_description TEXT, ag_issub INT DEFAULT 0, ag_maingroupid INT, ag_isactive INT DEFAULT 0, ag_updatedby INT, ag_updatedon DATETIME);

/********** 21-12-2022 ***********/
CREATE TABLE IF NOT EXISTS ub_accountledgers(al_ledgerid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(al_ledgerid), al_buid INT, al_groupid INT, al_ledger VARCHAR(450), al_closingbalance FLOAT, al_description TEXT, al_issub INT DEFAULT 0, al_mainledgerid INT, al_isactive INT DEFAULT 0, al_updatedby INT, al_updatedon DATETIME);

/************26-12-2022 **************/
CREATE TABLE IF NOT EXISTS ub_ledgerentries(le_ledgerentryid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(le_ledgerentryid), le_buid INT, le_ledgerid INT, le_amount FLOAT, le_isdebit INT DEFAULT 0 COMMENT '0-debit, 1-credit', le_journalid INT DEFAULT 0, le_date DATETIME, le_note TEXT, le_closingamount FLOAT, le_isactive INT DEFAULT 0, le_updatedby INT, le_updatedon DATETIME);

CREATE TABLE IF NOT EXISTS ub_journalentry(je_journalentryid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(je_journalentryid), je_buid INT, je_journalnumber INT, je_date DATETIME, je_amount FLOAT, je_crediamount FLOAT, je_debitamount FLOAT, je_file VARCHAR(450), je_description TEXT, je_status INT DEFAULT 0 COMMENT '0-published, 1-draft', je_updatedby INT, je_updatedon DATETIME, je_isactive INT DEFAULT 0);

ALTER TABLE ub_ledgerentries ADD le_ispublish INT DEFAULT 0 COMMENT '0-publish, 1-draft';

/************ 16-01-2023 *******************/
ALTER TABLE ub_journalentry ADD je_type INT DEFAULT 0 COMMENT '0-journal, 1-vouchers', ADD je_vouchertype INT COMMENT '1-Payment voucher, 2-Receiver voucher, 3-Contra voucher, 4-Journal voucher, 5-other voucher';

/**************** 15-02-2023 *********************/
ALTER TABLE ub_accountprofile ADD ap_showcurrency INT DEFAULT 0, ADD ap_sufprefixsymbol INT DEFAULT 0, ADD ap_noofdecimal INT DEFAULT 0;

ALTER TABLE ub_country ADD currency VARCHAR(20), ADD ishow INT DEFAULT 1;

ALTER TABLE ub_country CONVERT TO CHARACTER SET utf8mb4;

/*************** 15-03-2023 *****************/
CREATE TABLE IF NOT EXISTS ub_inventorysettings(is_inventorysettingid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(is_inventorysettingid), is_buid INT, is_categorywise INT, is_batchwise INT, is_expirydate INT, is_image INT, is_wastage INT, is_barqr INT COMMENT '1-bar, 2-qr', is_hsn INT, is_isactive INT DEFAULT 0, is_updatedby INT, is_updatedon DATETIME);

ALTER TABLE ub_inventorysettings ADD is_supplier INT DEFAULT '0' AFTER is_hsn;
ALTER TABLE ub_inventorysettings ADD is_godown INT DEFAULT '0' AFTER is_hsn;

/************* 25-03-2023 **********/
CREATE TABLE IF NOT EXISTS ub_suppliers(sp_supplierid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(sp_supplierid), sp_buid INT, sp_name VARCHAR(450), sp_address VARCHAR(550), sp_city VARCHAR(350), sp_state INT, sp_country INT, sp_contactnumber VARCHAR(20), sp_mobile VARCHAR(20), sp_email VARCHAR(450), sp_website VARCHAR(350), sp_contactperson VARCHAR(250), sp_contactphone VARCHAR(20), sp_gstno VARCHAR(150), sp_balanceamount FLOAT, sp_notes TEXT, sp_isactive INT DEFAULT 0, sp_updatedby INT, sp_updatedon DATETIME);

CREATE TABLE IF NOT EXISTS ub_customers(ct_cstomerid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ct_cstomerid), ct_buid INT, ct_name VARCHAR(350), ct_address VARCHAR(550), ct_city VARCHAR(350), ct_state INT, ct_country INT, ct_phone VARCHAR(20), ct_mobile VARCHAR(20), ct_email VARCHAR(350), ct_balanceamount FLOAT, ct_notes TEXT, ct_isactive INT DEFAULT 0, ct_updatedby INT, ct_updatedon DATETIME);

CREATE TABLE IF NOT EXISTS ub_taxbands(tb_taxbandid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(tb_taxbandid), tb_buid INT, tb_taxband VARCHAR(150), tb_tax FLOAT, tb_notes TEXT, tb_isactive INT DEFAULT 0, tb_updatedby INT, tb_updatedon DATETIME);

/********** 31-03-2023 **************/
CREATE TABLE IF NOT EXISTS ub_productcategories(pc_productcategoryid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(pc_productcategoryid), pc_buid INT, pc_categoryname VARCHAR(450), pc_description TEXT, pc_issub INT DEFAULT 0, pc_maincategoryid INT DEFAULT 0, pc_updatedby INT, pc_updatedon DATETIME, pc_isactive INT DEFAULT 0);

/********* 06-04-2023 ***********/
CREATE TABLE IF NOT EXISTS ub_godowns(gd_godownid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(gd_godownid), gd_buid INT, gd_godowncode VARCHAR(150), gd_godownname VARCHAR(350), gd_address VARCHAR(550), gd_racknumbers INT DEFAULT 0, gd_isgatepass INT DEFAULT 0, gd_description TEXT, gd_isactive INT DEFAULT 0, gd_updatedby INT, gd_updatedon DATETIME);

/*********** 12-04-2023 *************/
CREATE TABLE IF NOT EXISTS ub_units(un_unitid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(un_unitid), un_buid INT, un_unitname VARCHAR(100), un_description TEXT, un_isactive INT DEFAULT 0, un_updatedon DATETIME, un_updatedby INT);

CREATE TABLE IF NOT EXISTS ub_products(pd_productid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(pd_productid), pd_buid INT, pd_productcode VARCHAR(150), pd_productname VARCHAR(350), pd_categoryid INT, pd_productshortcode VARCHAR(150), pd_hsnno VARCHAR(150), pd_description TEXT, pd_prodimage VARCHAR(450), pd_taxbandid INT, pd_taxpercent FLOAT, pd_cess FLOAT, pd_unitid INT, pd_unitname VARCHAR(100), pd_purchaseprice FLOAT, pd_profittype INT COMMENT '1-%, 2-amount', pd_retailprofit FLOAT, pd_retailprice FLOAT, pd_wholesaleprofit FLOAT, pd_wholesaleprice FLOAT, pd_stock INT DEFAULT 0, pd_isactive INT DEFAULT 0, pd_addedby INT, pd_addedon DATETIME);

ALTER TABLE ub_products ADD pd_mrp FLOAT AFTER `pd_purchaseprice`;

/************ 28-04-2023 **********/
CREATE TABLE IF NOT EXISTS ub_purchasemaster(pm_purchaseid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(pm_purchaseid), pm_buid INT, pm_godownid INT, pm_purchaseno VARCHAR(100), pm_date DATE, pm_time TIME, pm_supplierid INT, pm_vehicleno VARCHAR(150), pm_invoiceno VARCHAR(150), pm_discount FLOAT, pm_freight FLOAT, pm_totalamount FLOAT, pm_grandtotal FLOAT, pm_oldbalance FLOAT, pm_paidamount FLOAT, pm_balanceamount FLOAT, pm_paymentmethod INT, pm_purchasenote TEXT, pm_updatedon DATETIME, pm_updatedby INT, pm_isactive INT DEFAULT 0);

CREATE TABLE IF NOT EXISTS ub_purchaseslave(ps_purchaseslaveid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ps_purchaseslaveid), ps_buid INT, ps_purchaseid INT, ps_productid INT, ps_batchno VARCHAR(100), ps_expirydate DATE, ps_purchaseprice FLOAT, ps_mrp FLOAT, ps_gstpercent FLOAT, ps_gstamnt FLOAT, ps_discountpercent FLOAT, ps_discountamnt FLOAT, ps_purchaserate FLOAT, ps_qty INT, ps_netamount FLOAT, ps_totalgst FLOAT, ps_totalamount FLOAT, ps_updatedon DATETIME, ps_updatedby INT, ps_isactive INT DEFAULT 0);

CREATE TABLE IF NOT EXISTS ub_productstock(pt_stockid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(pt_stockid), pt_buid INT, pt_productid INT, pt_batchno VARCHAR(100), pt_godownid INT, pt_expirydate DATE, pt_purchaseprice FLOAT, pt_stock INT, pt_isactive INT DEFAULT 0);

/************* 05-05-2023 ************/
CREATE TABLE IF NOT EXISTS ub_retailbillmaster(rb_retailbillid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(rb_retailbillid), rb_buid INT, rb_billno VARCHAR(100), rb_date DATE, rb_time TIME, rb_existcustomer INT DEFAULT 0, rb_customerid INT DEFAULT 0, rb_customername VARCHAR(250), rb_phone VARCHAR(20), rb_address VARCHAR(350), rb_gstno VARCHAR(100), rb_placeofsupply INT, rb_vehicleno VARCHAR(100), rb_salesperson VARCHAR(200), rb_salephone VARCHAR(20), rb_shippingaddress VARCHAR(350), rb_billtype INT COMMENT "1-tax invoice, 2-customer invoice", rb_totalamount FLOAT, rb_discount FLOAT, rb_freight FLOAT, rb_grandtotal FLOAT, rb_balanceamount FLOAT, rb_paidamount FLOAT, rb_paymentmethod INT, rb_advance100 INT COMMENT "0-No, 1-Yes", rb_pagesize INT, rb_notes TEXT, rb_addedby INT, rb_addedon DATETIME, rb_updatedby INT, rb_updatedon DATETIME, rb_isactive INT DEFAULT 0);

CREATE TABLE IF NOT EXISTS ub_retailbillslave(rbs_retailbillslaveid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(rbs_retailbillslaveid), rbs_buid INT, rbs_retailbillid INT, rbs_productid INT, rbs_hsnno VARCHAR(150), rbs_stockid INT, rbs_batchno VARCHAR(100), rbs_expirydate DATE, rbs_purchaseprice FLOAT, rbs_mrp FLOAT, rbs_netamount FLOAT, rbs_unitprice FLOAT, rbs_gstpercent FLOAT, rbs_gstamnt FLOAT, rbs_cesspercent FLOAT, rbs_cessamount FLOAT, rbs_discountpercent FLOAT, rbs_discountamnt FLOAT, rbs_qty INT, rbs_totalamount FLOAT, rbs_totalgst FLOAT, rbs_totalcess FLOAT, rbs_totaldiscount FLOAT, rbs_nettotal FLOAT, rbs_updatedby INT, rbs_updatedon DATETIME, rbs_isactive INT DEFAULT 0);

ALTER TABLE ub_retailbillmaster ADD rb_oldbalance FLOAT AFTER `rb_grandtotal`;
ALTER TABLE ub_retailbillslave ADD rbs_totalcess FLOAT AFTER `rbs_totalgst`;
ALTER TABLE ub_retailbillmaster ADD rb_state INT AFTER `rb_shippingaddress`;
ALTER TABLE ub_customers ADD ct_gstin VARCHAR(150) AFTER `ct_mobile`;



/************* 04-06-2023*********/
ALTER TABLE ub_productstock ADD pt_supplierid INT AFTER `pt_godownid`;
ALTER TABLE ub_retailbillmaster ADD rb_billingtype INT DEFAULT 0 COMMENT '0-retail, 1-wholesale' AFTER `rb_buid`;
ALTER TABLE ub_accountgroups ADD ag_isdefault INT DEFAULT 0;
ALTER TABLE ub_accountledgers ADD al_isdefault INT DEFAULT 0;

CREATE TABLE IF NOT EXISTS ub_accountmaingroups(am_maingroupid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(am_maingroupid), am_maingroup VARCHAR(250), am_isactive INT DEFAULT 0);

ALTER TABLE ub_accountgroups ADD ag_accmain INT AFTER `ag_buid`;

/*************** 05-06-2023 ****************/
ALTER TABLE ub_accountledgers ADD al_usertype INT DEFAULT 0 COMMENT '1-customer, 2-supplier', ADD al_userid INT;

/**************** 08-06-2023 ****************/
ALTER TABLE ub_purchasemaster ADD pm_totalgstamount FLOAT AFTER `pm_totalamount`;
ALTER TABLE ub_ledgerentries ADD le_issale INT DEFAULT 0 COMMENT '1-sale, 2-purchase' AFTER `le_closingamount`, ADD le_salepurchaseid INT DEFAULT 0 AFTER le_issale;

/****************** 09-06-2023 ***********************/
ALTER TABLE ub_financialyears ADD ay_buid INT AFTER `ay_financialyearid`;

ALTER TABLE ub_financialyears ADD ay_buid INT AFTER `ay_financialyearid`; ADD ay_isdefault INT DEFAULT 0 AFTER `ay_enddate`, ADD ay_updatedby INT, ADD ay_updatedon DATETIME;

ALTER TABLE ub_journalentry ADD je_finyearid INT AFTER `je_buid`;
ALTER TABLE ub_ledgerentries ADD le_finyearid INT AFTER `le_buid`;
ALTER TABLE ub_purchasemaster ADD pm_finyearid INT AFTER `pm_buid`;
ALTER TABLE ub_purchaseslave ADD ps_finyearid INT AFTER `ps_buid`;
ALTER TABLE ub_retailbillmaster ADD rb_finyearid INT AFTER `rb_buid`;
ALTER TABLE ub_retailbillslave ADD rbs_finyearid INT AFTER `rbs_buid`;

/****************** 10-06-2023 ***************/
ALTER TABLE ub_retailbillslave ADD rbs_type INT DEFAULT 0 COMMENT '0-retail, 1-wholesale, 2-proforma';
ALTER TABLE ub_retailbillslave ADD rbs_status INT DEFAULT 0 COMMENT '0-new, 1-billed';


CREATE TABLE IF NOT EXISTS ub_servicebillmaster(sb_servicebillid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(sb_servicebillid), sb_buid INT, sb_finyearid INT, sb_billno INT, sb_date DATE, sb_time TIME, sb_existcustomer INT DEFAULT 0, sb_customerid INT, sb_customername VARCHAR(250), sb_phone VARCHAR(20), sb_place VARCHAR(300), sb_billdate DATE, sb_discount FLOAT, sb_freight FLOAT, sb_oldbalance FLOAT, sb_totalamount FLOAT, sb_paidamount FLOAT, sb_balanceamount FLOAT, sb_updatedby INT, sb_updatedon DATETIME, sb_isactive INT DEFAULT 0);

CREATE TABLE IF NOT EXISTS ub_servicebillslave(sbs_serviceslaveid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(sbs_serviceslaveid), sbs_buid INT, sbs_finyearid INT, sbs_servicebillid INT, sbs_productname VARCHAR(500), sbs_complaint TEXT, sbs_price FLOAT, sbs_isactive INT DEFAULT 0, sbs_updatedby INT, sbs_updatedon DATETIME);


/********************* 12-06-2023 ******************/
ALTER TABLE ub_purchasemaster ADD pm_type INT DEFAULT 0 COMMENT '0-purchase, 1-purchaseorder' AFTER `pm_finyearid`;
ALTER TABLE ub_purchaseslave ADD ps_type INT DEFAULT 0 COMMENT '0-purchase, 1-purchaseorder' AFTER `ps_finyearid`;

ALTER TABLE ub_purchasemaster ADD pm_expecteddelivery DATE AFTER `pm_invoiceno`;

/********************** 21-06-2023 ********************/
ALTER TABLE ub_retailbillmaster ADD rb_totprofit FLOAT AFTER `rb_paidamount`;
ALTER TABLE ub_retailbillslave ADD rbs_profit FLOAT AFTER `rbs_nettotal`;


ALTER TABLE `ub_purchasemaster` CHANGE `pm_totalamount` `pm_totalamount` DOUBLE NULL DEFAULT NULL; 
ALTER TABLE `ub_purchasemaster` CHANGE `pm_grandtotal` `pm_grandtotal` DOUBLE NULL DEFAULT NULL; 
ALTER TABLE `ub_purchasemaster` CHANGE `pm_oldbalance` `pm_oldbalance` DOUBLE NULL DEFAULT NULL; 
ALTER TABLE `ub_purchasemaster` CHANGE `pm_paidamount` `pm_paidamount` DOUBLE NULL DEFAULT NULL; 
ALTER TABLE `ub_purchasemaster` CHANGE `pm_balanceamount` `pm_balanceamount` DOUBLE NULL DEFAULT NULL; 
ALTER TABLE `ub_ledgerentries` CHANGE `le_amount` `le_amount` DOUBLE NULL DEFAULT NULL; 
ALTER TABLE `ub_ledgerentries` CHANGE `le_closingamount` `le_closingamount` DOUBLE NULL DEFAULT NULL; 
ALTER TABLE `ub_journalentry` CHANGE `je_crediamount` `je_crediamount` DOUBLE NULL DEFAULT NULL; 
ALTER TABLE `ub_journalentry` CHANGE `je_debitamount` `je_debitamount` DOUBLE NULL DEFAULT NULL; 
ALTER TABLE `ub_journalentry` CHANGE `je_amount` `je_amount` DOUBLE NULL DEFAULT NULL; 
ALTER TABLE `ub_accountledgers` CHANGE `al_closingbalance` `al_closingbalance` DOUBLE NULL DEFAULT NULL; 


ALTER TABLE `ub_suppliers` CHANGE `sp_balanceamount` `sp_balanceamount` DOUBLE NULL DEFAULT NULL;

ALTER TABLE ub_businessunit ADD bu_mobile VARCHAR(20) AFTER `bu_phone`;
ALTER TABLE ub_businessunit ADD bu_country INT AFTER `bu_website`, ADD bu_state INT AFTER bu_country;

ALTER TABLE ub_businessunit ADD bu_bankname VARCHAR(250) AFTER bu_state, ADD bu_accountnumber VARCHAR(250) AFTER bu_bankname, ADD bu_ifsccode VARCHAR(150) AFTER bu_accountnumber, ADD bu_bankbranch VARCHAR(350) AFTER bu_ifsccode;

/************* 24-06-2023 ***************/
ALTER TABLE ub_purchaseslave ADD ps_productstockid INT AFTER `ps_batchno`;


UPDATE ub_purchaseslave t1  INNER JOIN ub_productstock t2  ON t1.ps_productid = t2.pt_productid SET t1.ps_productstockid = t2.pt_stockid; 

/************ 25-06-2023 *****************/
ALTER TABLE `ub_purchasemaster` CHANGE `pm_type` `pm_type` INT(11) NULL DEFAULT '0' COMMENT '0-purchase, 1-purchaseorder, 2-return';
ALTER TABLE `ub_purchaseslave` CHANGE `ps_type` `ps_type` INT(11) NULL DEFAULT '0' COMMENT '0-purchase, 1-purchaseorder, 3-return';

ALTER TABLE ub_purchasemaster ADD pm_returnedby INT, ADD pm_returnedon DATETIME, ADD pm_returncomments TEXT;
ALTER TABLE ub_purchasemaster ADD pm_returnamount DOUBLE;

/****************** 26-06-2023 *****************/
ALTER TABLE ub_products ADD pd_stockthreshold INT DEFAULT 0 AFTER `pd_stock`;

/****************27-06-2023 ****************/
ALTER TABLE ub_purchasemaster ADD pm_partialreturn INT DEFAULT 0;

/************** 30-06-2023 ************/
ALTER TABLE ub_usertypes ADD ut_notes TEXT;
ALTER TABLE ub_usertypes ADD ut_updatedby INT, ADD ut_updatedon DATETIME;
ALTER TABLE ub_retailbillmaster ADD rb_godownid INT AFTER `rb_vehicleno`;

ALTER TABLE ub_businessunit ADD bu_franchisefrom VARCHAR(350), ADD bu_franchiselogo VARCHAR(350);

/************* 02-07-2023*********/
CREATE TABLE IF NOT EXISTS ub_billprintsettings(bp_printsettingid INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(bp_printsettingid), bp_buid INT, bp_billdesign VARCHAR(250), bp_retailprefix VARCHAR(100), bp_wholesaleprefix VARCHAR(100), bp_proformaprefix VARCHAR(100), bp_quotationprefix VARCHAR(100), bp_servicebillprefix VARCHAR(100), bp_purchasebillprefix VARCHAR(100), bp_purchaseorderprefix VARCHAR(100), bp_islogo INT DEFAULT 1, bp_defaultpagesize INT, bp_defaultsaleplace INT, bp_updatedby INT, bp_updatedon DATETIME);

/************** 03-07-2023 *************/
ALTER TABLE ub_products ADD pd_brand VARCHAR(250) AFTER `pd_productshortcode`, ADD pd_company VARCHAR(250) AFTER `pd_brand`;
ALTER TABLE ub_products ADD pd_size VARCHAR(150) AFTER `pd_productname`;

ALTER TABLE ub_customers ADD ct_type INT DEFAULT 0 COMMENT '0-B2C, 1-B2B' AFTER `ct_name`;

/************** 04-07-2023 *****************/
ALTER TABLE ub_businessunit ADD bu_companyseal VARCHAR(350);
ALTER TABLE ub_retailbillmaster ADD rb_billprefix VARCHAR(250) AFTER `rb_billingtype` 

/*************** 05-07-2023 ***************/
ALTER TABLE ub_billprintsettings ADD bp_remarkcolumn INT DEFAULT 0;
ALTER TABLE ub_billprintsettings ADD bp_hidepurchaseprice INT DEFAULT 0;
ALTER TABLE ub_retailbillslave ADD rbs_remarks VARCHAR(550);

ALTER TABLE ub_states ADD statecode INT;

/************** 06-07-2023 ****************/
ALTER TABLE ub_retailbillslave ADD rbs_discountedprice FLOAT AFTER `rbs_unitprice`;

ALTER TABLE ub_retailbillslave ADD rbs_itemunitprice FLOAT;

/************** 10-07-2023 ******************/
ALTER TABLE ub_purchasemaster ADD pm_invoicedate DATE AFTER `pm_invoiceno`;

/************* 11-07-2023 ****************/
ALTER TABLE ub_retailbillmaster ADD rb_roundoffvalue FLOAT DEFAULT 0 AFTER `rb_grandtotal`;

/****************12-07-2023 ****************/
ALTER TABLE ub_purchasemaster ADD pm_roundoffvalue FLOAT AFTER `pm_grandtotal`, ADD pm_freightgst FLOAT AFTER `pm_freight`, ADD pm_freigtgstamnt FLOAT AFTER pm_freightgst;

ALTER TABLE ub_purchasemaster ADD pm_purchaseprefix VARCHAR(150) AFTER `pm_godownid`;

/***************** 15-07-2023 *******************/
ALTER TABLE ub_purchasemaster ADD pm_returnid INT;
ALTER TABLE ub_retailbillmaster ADD rb_isreturn INT DEFAULT 0, ADD rb_returnedon DATETIME, ADD rb_returnedby INT, ADD rb_returncomment TEXT, ADD rb_returnamount DOUBLE, ADD rb_partialreturn INT DEFAULT 0, ADD rb_returnid INT;

/**************** 17-07-2023 ****************/
ALTER TABLE ub_productstock ADD pt_barcode VARCHAR(250);
ALTER TABLE ub_productstock ADD pt_barcodevalue VARCHAR(150);

/************* 25-07-2023 ***************/
ALTER TABLE ub_journalentry ADD je_customerid INT;

/*********** 26-07-2023 ****************/
ALTER TABLE ub_purchasemaster ADD pm_postatus INT DEFAULT 0;
ALTER TABLE ub_purchasemaster ADD pm_confirmid INT DEFAULT 0;

/************ 02-08-2023 *******************/
ALTER TABLE `ub_retailbillmaster` CHANGE `rb_billingtype` `rb_billingtype` INT(11) NULL DEFAULT '0' COMMENT '0-retail, 1-wholesale, 2-retailproforma, 3-retailquotaion,4-wholesaleproforma, 5-wholesalequatation';

/********** 05-08-2023 *****************/
ALTER TABLE ub_billprintsettings ADD bp_wholesaleproformaprefix VARCHAR(100) AFTER `bp_proformaprefix`, ADD bp_wholesalequotationprefix VARCHAR(100) AFTER `bp_quotationprefix`;

ALTER TABLE ub_retailbillmaster ADD rb_orderstatus INT DEFAULT 0, ADD rb_confirmid INT DEFAULT 0;

/************07-08-2023 **************/
ALTER TABLE ub_businessunit ADD bu_withoutlogin INT DEFAULT 0, ADD bu_composittax INT DEFAULT 0, ADD bu_isvat INT DEFAULT 0 COMMENT '0-gst, 1-vat';

/************ 09-08-2023 ***************/
ALTER TABLE ub_accountledgers ADD al_vatledgername VARCHAR(250);

/******************* 18-08-2023 ********************/
ALTER TABLE ub_retailbillmaster ADD rb_ewaybillno VARCHAR(150), ADD rb_deliverydate DATETIME, ADD rb_ponumber VARCHAR(100), ADD rb_podate DATE;