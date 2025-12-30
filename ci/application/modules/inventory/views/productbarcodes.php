
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
                            
                            <!--<a href="<?= base_url() ?>inventory/addproduct" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add New Product</button>
                            </a>

                            <a href="<?= base_url() ?>purchase/dashboard" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Purchase Product</button>
                            </a>-->
                                
                        </div>
                        <h4 class="page-title">Product Barcode</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form class="form-horizontal" method="post" target="_blank" action="<?= base_url() ?>inventory/generatebarcode">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Product</th>
                                        <th>Batch No</th>
                                        <!--<th>Unit</th>-->
                                        <th>Retail<br/> Price</th>
                                        <th>MRP</th>
                                        <!--<th>GST</th>
                                        <th>CESS</th>-->
                                        <th>Avail<br/> Stock</th>
                                        <th>No's</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($productlist)
                                    {
                                        $k=1;
                                        foreach($productlist as $stvl)
                                        {
                                            ?>
                                            <tr>
                                                <!--<td><?= $k ?></td>-->
                                                <td>
                                                    <input type="checkbox" name="productid[]" id="productid<?= $stvl->pt_stockid ?>" class="productcheck" value="<?= $stvl->pt_stockid ?>">
                                                </td>
                                                <td><?= $stvl->pd_productcode ?></td>
                                                <td>
                                                     <?php 
                                                if($inventorysettings)
                                                {
                                                    if($inventorysettings->is_image == 1)
                                                    {
                                                ?>
                                                    <img src="<?= base_url() ?>uploads/products/<?= $stvl->pd_prodimage ?>" onerror="this.onerror=null;this.src='<?= base_url() ?>components/images/no-item.png';" class="listpageprdimg">
                                                    <?php 
                                                    }
                                                }
                                                    ?>
                                                    <?= $stvl->pd_productname ?> <?= $stvl->pd_size ?> <?= $stvl->pd_brand ?>
                                                </td>
                                                <td><?= $stvl->pt_batchno ?></td>
                                                <!--<td><?= $stvl->un_unitname ?></td>-->
                                               <!-- <td><?= $stvl->pd_hsnno ?></td>
                                                <td><?= $stvl->tb_taxband ?></td>
                                                <td><?= $stvl->pd_cess ?></td>-->
                                                <td><?= $stvl->pd_retailprice ?></td>
                                                <td><?= $stvl->pd_mrp ?></td>
                                                <td>
                                                    <?= $stvl->pt_stock ?>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" style="width: 75px" name="barcount<?= $stvl->pt_stockid ?>" value="8">
                                                </td>
                                            </tr>
                                            <?php
                                            $k++;
                                        }
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-primary" name="print_bar" onclick="return validateproduct()">Print Barcodes</button> <i>(Please select products)</i>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div> <!-- container -->

    </div> <!-- content -->

    

    
    <script type="text/javascript">
    function validateproduct()
    {
        if($('input:checkbox:checked').length == 0)
        {
            alert('Please select atleast one product.');
            return false;
        }
    }

</script>