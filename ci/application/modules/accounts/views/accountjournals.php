
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<style type="text/css">

</style>

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <a href="<?= base_url() ?>accounts/addjournal/<?= $buid ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="fas fa-plus-circle"></i> Add Journal</button>
                            </a>

                            <a href="<?= base_url() ?>accounts/accountprofileview/<?= $buid ?>" class="ms-1">
                                <button type="button" class="btn btn-primary waves-effect waves-light listbtns"><i class="far fa-arrow-alt-circle-left"></i> Back</button>
                            </a>
                        </div>
                        <h4 class="page-title">Account Journals</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Journal No</th>
                                        <th>Status</th>
                                        <th>Description</th>
                                        <th>Credit</th>
                                        <th>Debit</th>
                                        <!--<th>Document</th>-->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php 
                                    if($journals)
                                    {
                                        $k=1;
                                        foreach($journals as $bvl)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $k ?></td>
                                                <td><?= date('d-M-Y H:i', strtotime($bvl->je_date)) ?></td>
                                                <td><?= $bvl->je_journalnumber ?></td>
                                                <td>
                                                    <?php 
                                                    if($bvl->je_status == '0')
                                                    {
                                                        ?>
                                                        <span class="badge bg-primary">Published</span>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <span class="badge bg-success">Draft</span>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                
                                                 <td><?= $bvl->je_description ?></td>
                                                 <td><?= $bvl->je_crediamount ?></td>
                                                 <td><?= $bvl->je_debitamount ?></td>
                                                 <!--<td><?= $bvl->je_file ?></td>-->
                                                 <td>
                                                     <a href="javascript:void(0)" onclick="viewjournalfun('<?= $bvl->je_journalentryid ?>')" class="text-primary"><i class="fas fa-eye"></i> View</a> &nbsp;
                                                     <a href="#" class="text-warning"><i class="fas fa-print"></i> Print</a> &nbsp;
                                                     <?php 
                                                    if($bvl->je_status == '1')
                                                    {
                                                        ?>
                                                     <a href="<?= base_url() ?>accounts/publishjournal/<?= $bvl->je_journalentryid ?>/<?= $buid ?>" onclick="return confirm('Are you sure?')" class="text-success"><i class="fas fa-pen"></i> Publish</a>
                                                     <?php 
                                                    }
                                                     ?>
                                                 </td>
                                                
                                            </tr>
                                            <?php
                                            $k++;
                                        }
                                    }
                                    ?>
                                    

                                </tbody>
                            </table>


                            

                        </div>
                    </div>
                </div>
            </div>

            
            
        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Add modal content -->
        <div id="viewjournalentrymmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Journal Details</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body" id="journaldetailsdiv">

                       
                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light listbtns" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

<script type="text/javascript">
    function viewjournalfun(jrnlid)
    {
        $.ajax({
          url: '<?php echo site_url('accounts/getjournaldetails') ?>',
          type: 'POST',
          dataType: 'html',
          data: {journalid: jrnlid},
        })
        .done(function(result) {
          // console.log("success");
          $("#journaldetailsdiv").html(result);

        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });

        $('#viewjournalentrymmodal').modal('show');
    }
    
    
</script>