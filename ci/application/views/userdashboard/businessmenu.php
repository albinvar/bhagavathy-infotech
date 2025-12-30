<!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <div class="h-100" data-simplebar>
                    
                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul id="side-menu">
                
                            <li>
                                <a href="<?= base_url() ?>business/dashboard">
                                    <i data-feather="airplay"></i>
                                    <span> Dashboard </span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url() ?>business/businessalalyticview">
                                    <i data-feather="airplay"></i>
                                    <span> Business Analytics </span>
                                </a>
                            </li>

                            <!--<li>
                                <a href="#sidebarorder" data-bs-toggle="collapse">
                                    <i data-feather="shopping-cart"></i>
                                    <span> Order Management</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarorder">
                                    <ul class="nav-second-level">
                                        <li class="finyearaddbutton"><a href="<?= base_url() ?>sale/dashboard/6">Add New Order</a></li>
                                        <li><a href="<?= base_url() ?>sale/orderhistory">New Orders</a></li>
                                        <li><a href="<?= base_url() ?>sale/orderhistory/1">Confirmed Orders</a></li>
                                        <li><a href="<?= base_url() ?>sale/orderhistory/2">Cancelled Orders</a></li>
                                    </ul>
                                </div>
                            </li>-->

                            <li>
                                <a href="#sidebarsale" data-bs-toggle="collapse">
                                    <i data-feather="shopping-cart"></i>
                                    <span> Billing</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarsale">
                                    <ul class="nav-second-level">
                                        <li class="finyearaddbutton"><a href="<?= base_url() ?>sale/dashboard">Retail Billing</a></li>
                                        <!--<li class="finyearaddbutton"><a href="<?= base_url() ?>sale/speedbilling">Speed Billing</a></li>-->
                                        <li class="finyearaddbutton"><a href="<?= base_url() ?>sale/dashboard/1">Wholesale Billing</a></li>
                                        <?php 
                                        if($inventorysettings)
                                        {
                                            if($inventorysettings->is_isfourrate == 1)
                                            {
                                                ?>
                                                <li class="finyearaddbutton"><a href="<?= base_url() ?>sale/dashboard/7">C Sale Billing</a></li>
                                                <li class="finyearaddbutton"><a href="<?= base_url() ?>sale/dashboard/8">D Sale Billing</a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li class="finyearaddbutton"><a href="<?= base_url() ?>sale/dashboard/3">Retail Quotation</a></li>
                                        <li class="finyearaddbutton"><a href="<?= base_url() ?>sale/dashboard/5">Wholesale Quotation</a></li>
                                        <li class="finyearaddbutton"><a href="<?= base_url() ?>sale/dashboard/2">Retail Proforma Invoice</a></li>
                                        <li class="finyearaddbutton"><a href="<?= base_url() ?>sale/dashboard/4">Wholesale Proforma Invoice</a></li>
                                        <li class="finyearaddbutton"><a href="<?= base_url() ?>sale/servicebill">Service Bill</a></li>
                                        <!--<li class="finyearaddbutton"><a href="#">Delivery Note</a></li>-->
                                        <li class="finyearaddbutton"><a href="<?= base_url() ?>purchase/dashboard">Purchase Billing</a></li>
                                        <li class="finyearaddbutton"><a href="<?= base_url() ?>purchase/dashboard/1">Purchase Order</a></li>
                                        
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a href="#sidebarpurchase" data-bs-toggle="collapse">
                                    <i data-feather="file-text"></i>
                                    <span> Reports</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarpurchase">
                                    <ul class="nav-second-level">
                                        <li><a href="<?= base_url() ?>sale/salehistory">Retail History</a></li>
                                        <li><a href="<?= base_url() ?>sale/salehistory/1">Wholesale History</a></li>
                                        <?php 
                                        if($inventorysettings)
                                        {
                                            if($inventorysettings->is_isfourrate == 1)
                                            {
                                                ?>
                                                <li><a href="<?= base_url() ?>sale/salehistory/7">C Sale History</a></li>
                                                <li><a href="<?= base_url() ?>sale/salehistory/8">D Sale History</a></li>
                                                <?php 

                                            }
                                        }
                                        ?>
                                        <li><a href="<?= base_url() ?>sale/salereturns">Sale Returns</a></li>
                                        <li><a href="<?= base_url() ?>sale/salehistory/3">Retail Quotation History</a></li>
                                        <li><a href="<?= base_url() ?>sale/salehistory/2">Retail Proforma History</a></li>
                                        <li><a href="<?= base_url() ?>sale/salehistory/5">Wholesale Quotation History</a></li>
                                        <li><a href="<?= base_url() ?>sale/salehistory/4">Wholesale Proforma History</a></li>
                                        <li><a href="<?= base_url() ?>sale/servicebillhistory">Service Bill History</a></li>
                                        <li><a href="<?= base_url() ?>purchase/purchasehistory">Purchase History</a></li>
                                        <li><a href="<?= base_url() ?>purchase/purchasehistory/1">Purchase Order History</a></li>
                                        <li><a href="<?= base_url() ?>purchase/purchasereturns">Purchase Returns</a></li>
                                    </ul>
                                </div>
                            </li>
                            <?php 
                            if($this->withoutlogin != 1)
                            {
                            ?>
                            <li>
                                <a href="#sidebartaxreport" data-bs-toggle="collapse">
                                    <i data-feather="file-text"></i>
                                    <span> Tax Reports</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebartaxreport">
                                    <ul class="nav-second-level">
                                        <li><a href="<?= base_url() ?>reports/purchasetax">Purchase Tax</a></li>
                                        <li><a href="<?= base_url() ?>reports/saletax/0">Retail Tax</a></li>
                                        <li><a href="<?= base_url() ?>reports/saletax/1">Wholesale Tax</a></li>
                                        <?php 
                                        if($inventorysettings)
                                        {
                                            if($inventorysettings->is_isfourrate == 1)
                                            {
                                                ?>
                                                <li><a href="<?= base_url() ?>reports/saletax/7">C Sale Tax</a></li>
                                                <li><a href="<?= base_url() ?>reports/saletax/8">D Sale Tax</a></li>
                                                <?php 

                                            }
                                        }
                                        ?>
                                        <li><a href="<?= base_url() ?>reports/itemwisereport">Item Wise Report</a></li>
                                        <li><a href="<?= base_url() ?>reports/hsnreport">HSN Report</a></li>
                                        <li><a href="<?= base_url() ?>reports/taxpercentagereport">Tax% Wise Report</a></li>
                                        <?php if($this->isvatgst == 0){ ?>
                                        <li><a href="<?= base_url() ?>reports/gstrb2breport">GSTR1 B2B Report</a></li>
                                        <li><a href="<?= base_url() ?>reports/gstrb2creport">GSTR1 B2C Report</a></li>
                                        <li><a href="<?= base_url() ?>reports/creditdebitb2breport">CDN/DBN B2B Report</a></li>
                                        <li><a href="<?= base_url() ?>reports/creditdebitb2creport">CDN/DBN B2C Report</a></li>
                                    <?php } ?>
                                    </ul>
                                </div>
                            </li>
                            <?php 
                            }
                            ?>

                            <li>
                                <a href="#sidebartaxotherreport" data-bs-toggle="collapse">
                                    <i data-feather="file-text"></i>
                                    <span> Other Reports</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebartaxotherreport">
                                    <ul class="nav-second-level">
                                        <!--<li><a href="<?= base_url() ?>reports/itemprofitreport">Item Wise Profit Report</a></li>-->
                                        <li><a href="<?= base_url() ?>reports/billwiseprofitreport">Bill Wise Profit Report</a></li>
                                        <!--<li><a href="<?= base_url() ?>inventory/productutilization">Stock Utilization Report</a></li>-->
                                    </ul>
                                </div>
                            </li>
                            
                            
                            <li>
                                <a href="#sidebarinventory" data-bs-toggle="collapse">
                                    <i data-feather="activity"></i>
                                    <span> Inventory</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarinventory">
                                    <ul class="nav-second-level">
                                        <li><a href="<?= base_url() ?>inventory/products">Products</a></li>
                                        <li><a href="<?= base_url() ?>inventory/productbatchwisestock">Stocks</a></li>
                                        
                                        <li><a href="<?= base_url() ?>inventory/outofstocks">Out of Stock / Threshold</a></li>
                                        
                                        <?php 
                                        if($inventorysettings)
                                        {
                                            if($inventorysettings->is_expirydate == 1)
                                            {
                                            ?>
                                            <li><a href="<?= base_url() ?>inventory/expiredproducts">Expired Products</a></li>
                                            <?php 
                                            }
                                            if($inventorysettings->is_categorywise == 1)
                                            {
                                            ?>
                                            <li><a href="<?= base_url() ?>inventory/productcategory">Product Category</a></li>
                                            <?php 
                                            }
                                            if($inventorysettings->is_godown == 1)
                                            {
                                            ?>
                                            <li><a href="<?= base_url() ?>inventory/godowns">Godown/Department</a></li>
                                            <li><a href="<?= base_url() ?>inventory/stocktransfer">Stock Transfer</a></li>
                                            <?php 
                                            }
                                        }
                                        ?>
                                        <li><a href="<?= base_url() ?>inventory/productbarcodes">Barcode</a></li>
                                        <!--<li><a href="<?= base_url() ?>inventory/inventorysettings">Inventory Settings</a></li>-->
                                    </ul>
                                </div>
                            </li>
                            <?php 
                            if($this->withoutlogin != 1)
                            {
                            ?>
                            <li>
                                <a href="#sidebaraccounts" data-bs-toggle="collapse">
                                    <i data-feather="activity"></i>
                                    <span> Accounts </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebaraccounts">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="<?= base_url() ?>accounts/profiles">Account Profile</a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url() ?>accounts/accountgroups">Account Group</a>
                                        </li>
                                        <li><a href="<?= base_url() ?>accounts/accountledger">Ledgers</a></li>
                                        <!--<li><a href="<?= base_url() ?>accounts/accountjournals">Journal</a></li>-->
                                        <li>
                                            <a href="#sidebarMultilevel2" data-bs-toggle="collapse">
                                                Vouchers <span class="menu-arrow"></span>
                                            </a>
                                            <div class="collapse" id="sidebarMultilevel2">
                                                <ul class="nav-second-level">
                                                    <li>
                                                        <a href="<?= base_url() ?>accounts/vouchers/1">Payment Voucher</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= base_url() ?>accounts/vouchers/2">Receiver Voucher</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= base_url() ?>accounts/vouchers/3">Contra Voucher</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= base_url() ?>accounts/vouchers/4">Journal Voucher</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= base_url() ?>accounts/vouchers/5">Other Voucher</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <!--<li><a href="<?= base_url() ?>accounts/trialbalance">Trial Balance</a></li>-->
                                        <li><a href="<?= base_url() ?>accounts/daybook">Day Book</a></li>
                                        <!--<li><a href="<?= base_url() ?>accounts/profitandlossaccount">Profit & Loss Account</a></li>
                                        <li><a href="<?= base_url() ?>accounts/balancesheet">Balance Sheet</a></li>

                                        <li><a href="<?= base_url() ?>accounts/ledgerflowstatement/4">Cash Flow Statement</a></li>
                                        <li><a href="<?= base_url() ?>accounts/ledgerflowstatement/3">Bank Flow Statement</a></li>-->

                                        <!--<li><a href="<?= base_url() ?>accounts/accountsettings">Account Settings</a></li>-->
                                    </ul>
                                </div>
                            </li>

                            <!--<li>
                                <a href="#sidebarcrm" data-bs-toggle="collapse">
                                    <i data-feather="activity"></i>
                                    <span> CRM </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarcrm">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="<?= base_url() ?>crm/enquirylist">Enquiry Management</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>-->

                            <!--<li>
                                <a href="#sidebarmaterial" data-bs-toggle="collapse">
                                    <i data-feather="package"></i>
                                    <span> Raw Materials </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarmaterial">
                                    <ul class="nav-second-level">
                                        <li><a href="<?= base_url() ?>rawmaterial/dashboard/0">Material Purchase</a></li>
                                        <li><a href="<?= base_url() ?>rawmaterial/purchasehistory">Purchase History</a></li>
                                        <li><a href="<?= base_url() ?>rawmaterial/purchasereturns">Purchase Returns</a></li>
                                        <li><a href="<?= base_url() ?>rawmaterial/productbatchwisestock">Raw Materials Stock</a></li>
                                        <li><a href="<?= base_url() ?>rawmaterial/rawmateriallist">Raw Materials</a></li>
                                        <li><a href="<?= base_url() ?>rawmaterial/materialcategory">Material Category</a></li>
                                        
                                    </ul>
                                </div>
                            </li>-->

                            <!--<li>
                                <a href="#sidebarproduction" data-bs-toggle="collapse">
                                    <i data-feather="briefcase"></i>
                                    <span> Production </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarproduction">
                                    <ul class="nav-second-level">
                                        <li><a href="<?= base_url() ?>production/productionstart">Start Production</a></li>
                                        <li><a href="<?= base_url() ?>production/productionhistory">Production Report</a></li>
                                        <li><a href="<?= base_url() ?>production/deliverynotes">Delivery Notes</a></li>
                                        <li><a href="<?= base_url() ?>production/productdesign">Product Design</a></li>
                                        <li><a href="<?= base_url() ?>production/productionoperations">Production Operations</a></li>
                                    </ul>
                                </div>
                            </li>-->
                            <?php 
                            }
                            ?>

                            <!--<li>
                                <a href="#sidebardocuments" data-bs-toggle="collapse">
                                    <i data-feather="folder-plus"></i>
                                    <span> Documents </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebardocuments">
                                    <ul class="nav-second-level">
                                        <li><a href="<?= base_url() ?>documents/documentlist">Document List</a></li>
                                        <li><a href="<?= base_url() ?>documents/documentlist/1">Starred List</a></li>
                                        <li><a href="<?= base_url() ?>documents/documentlist/2">Recent Files</a></li>
                                        
                                        <li><a href="<?= base_url() ?>documents/documentfolders">Folders</a></li>
                                    </ul>
                                </div>
                            </li>-->

                            <!--<li>
                                <a href="#sidebarpos" data-bs-toggle="collapse">
                                    <i data-feather="folder-plus"></i>
                                    <span> POS System </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarpos">
                                    <ul class="nav-second-level">
                                        <li><a href="<?= base_url() ?>pos/customerorder">Customer Order</a></li>
                                        <li><a href="#">Kitchen Order</a></li>
                                    </ul>
                                </div>
                            </li>-->

                            
                            
                            <li class="menu-title mt-2">Business</li>

                            <?php 
                            if($this->withoutlogin != 1)
                            {
                            ?>
                            <li>
                                <a href="<?= base_url() ?>business/staff">
                                    <i data-feather="users"></i>
                                    <span> Staff</span>
                                </a>
                            </li>
                            <?php 
                            }
                            ?>

                            <li>
                                <a href="<?= base_url() ?>business/suppliers">
                                    <i data-feather="users"></i>
                                    <span> Suppliers</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url() ?>business/customers">
                                    <i data-feather="users"></i>
                                    <span> Customers</span>
                                </a>
                            </li>
                            

                             <li>
                                <a href="#sidebarsettings" data-bs-toggle="collapse">
                                    <i data-feather="cpu"></i>
                                    <span> Settings</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarsettings">
                                    <ul class="nav-second-level">
                                        <!--<li><a href="<?= base_url() ?>business/financialyear"> Financial Year</a></li>-->
                                        <li><a href="<?= base_url() ?>business/taxbands">Tax Bands</a></li>
                                        <li><a href="<?= base_url() ?>business/productunits">Units</a></li>
                                         <?php 
                                        if($this->withoutlogin != 1)
                                        {
                                        ?>
                                        <!--<li><a href="<?= base_url() ?>business/designations">Designations</a></li>-->
                                        <?php 
                                        }
                                        ?>
                                        <!--<li><a href="<?= base_url() ?>business/businessunits"> Business Units</a></li>
                                        <li><a href="<?= base_url() ?>business/billprintoptions"> Bill Print Options</a></li>-->
                                        <li><a href="<?= base_url() ?>business/updateprofile"> Update Profile</a></li>

                                        <li><a href="<?= base_url() ?>admin/dbbackup" target="_blank"> Backup DB</a></li>
                                    </ul>
                                </div>
                            </li>
                            
                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->