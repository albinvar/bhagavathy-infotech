<!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <?= date('Y') ?> &copy; Finova Productions 
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-sm-block">
                                <a href="javascript:void(0);">About Us</a>
                                <a href="javascript:void(0);">Help</a>
                                <a href="javascript:void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

   

     <!-- Vendor js -->
    <script src="<?= base_url() ?>components/js/vendor.min.js"></script>

     <!-- Plugins js -->
    <script src="<?= base_url() ?>components/libs/quill/quill.min.js"></script>

    <!-- Init js-->
    <script src="<?= base_url() ?>components/js/pages/form-quilljs.init.js"></script>

    <!-- third party js -->
    <script src="<?= base_url() ?>components/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>components/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= base_url() ?>components/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>components/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="<?= base_url() ?>components/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>components/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="<?= base_url() ?>components/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>components/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?= base_url() ?>components/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>components/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url() ?>components/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    <script src="<?= base_url() ?>components/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>components/libs/pdfmake/build/vfs_fonts.js"></script>
    <!-- third party js ends -->



    <!-- Datatables init -->
    <script src="<?= base_url() ?>components/js/pages/datatables.init.js"></script>

    <!-- Plugins js-->
    <script src="<?= base_url() ?>components/libs/flatpickr/flatpickr.min.js"></script>
    <script src="<?= base_url() ?>components/libs/apexcharts/apexcharts.min.js"></script>

    <script src="<?= base_url() ?>components/libs/selectize/js/standalone/selectize.min.js"></script>
    <script src="<?= base_url() ?>components/libs/multiselect/js/jquery.multi-select.js"></script>
    <script src="<?= base_url() ?>components/libs/select2/js/select2.min.js"></script>

    <script src="<?= base_url() ?>components/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <!-- Dashboar 1 init js-->
    <script src="<?= base_url() ?>components/js/pages/dashboard-1.init.js"></script>

    <!-- Tost-->
    <script src="<?= base_url() ?>components/libs/jquery-toast-plugin/jquery.toast.min.js"></script>

    <!-- Plugin js-->
    <script src="<?= base_url() ?>components/libs/parsleyjs/parsley.min.js"></script>

    <!-- App js-->
    <script src="<?= base_url() ?>components/js/app.min.js"></script>

    


    <script type="text/javascript">
        function tofixed_amount(amnt)
    {
        var decml = <?= $this->decimalpoints ?>;
        return amnt.toFixed(decml);
    }
    <?php
    $classname = $this->router->fetch_class();
    $methodname = $this->router->fetch_method();

    if($classname == 'business' && $methodname == 'dashboard')
    {
    ?>
        $( document ).ready(function() {
<?php 
$todaydate = date('Y-m-d');
$startdate = date('Y-m-d', strtotime('-30 days'));
$salestartdate = date('Y-m-d', strtotime('-30 days'));
$profitstartdate = date('Y-m-d', strtotime('-30 days'));
$days=30;
?>
colors = ["#1abc9c", "#4a81d4"];
(dataColors = $("#sales-analytics").data("colors")) && (colors = dataColors.split(","));
options = {
    series: [{
        name: "Profit",
        type: "column",
        data: [
        <?php
        for($i=0; $i<=30; $i++)
        {
            $saledate = date('Y-m-d', strtotime($profitstartdate. '+'.$i.' days'));
            $profitamnt = $this->retlmstr->getsaleprofitbydate($this->buid, $saledate);
            if($profitamnt == "")
            {
                $profitamnt = 0;
            }
            ?>
            tofixed_amount(<?= $profitamnt ?>),
            <?php
        }
        ?>
        ]
    }, {
        name: "Sales",
        type: "line",
        data: [
        <?php
        for($i=0; $i<=30; $i++)
        {
            $saledate = date('Y-m-d', strtotime($salestartdate. '+'.$i.' days'));
            $salecnt = $this->retlmstr->getsalecountbydate($this->buid, $saledate);

            ?>
            <?= $salecnt ?>,
            <?php
        }
        ?>
        ]
    }],
    chart: {
        height: 378,
        type: "line",
        offsetY: 10
    },
    stroke: {
        width: [2, 3]
    },
    plotOptions: {
        bar: {
            columnWidth: "50%"
        }
    },
    colors: colors,
    dataLabels: {
        enabled: !0,
        enabledOnSeries: [1]
    },
    labels: [
    <?php
    for($i=1; $i<=31; $i++)
    {
        $showdate = date('d M Y', strtotime($startdate. '+'.$i.' days'));
        ?>
        "<?= $showdate ?>",
        <?php
    }
    ?>
    ],
    xaxis: {
        type: "datetime"
    },
    legend: {
        offsetY: 7
    },
    grid: {
        padding: {
            bottom: 20
        }
    },
    fill: {
        type: "gradient",
        gradient: {
            shade: "light",
            type: "horizontal",
            shadeIntensity: .25,
            gradientToColors: void 0,
            inverseColors: !0,
            opacityFrom: .75,
            opacityTo: .75,
            stops: [0, 0, 0]
        }
    },
    yaxis: [{
        title: {
            text: "Net Profit"
        }
    }, {
        opposite: !0,
        title: {
            text: "Number of Sales"
        }
    }]
};
(chart = new ApexCharts(document.querySelector("#sales-analytics"), options)).render(), $("#dash-daterange").flatpickr({
    altInput: !0,
    mode: "range",
    altFormat: "F j, y",
    defaultDate: "today"
});

});

    <?php 
}
    ?>

        $('.searchselect').select2({
          placeholder: 'Search..',
          dropdownParent: $('#addformmodal')
        });

        $('.pagesearchselect').select2({
          placeholder: 'Search..',
        });

    $(function() {
         $(".addformvalidate").parsley();

         window.ParsleyValidator.addValidator('checkproductcode', {
          validateString: function(value)
          {
            return $.ajax({
              url:'<?= base_url() ?>inventory/checkproductcodeexists',
              method:"POST",
              data:{prodcode:value},
              dataType:"json",
              success:function(data)
              {
                return true;
              }
            });
          }
        });

         $(".datetime-datepicker").flatpickr({enableTime:!0,dateFormat:"d-M-Y H:i"});
    });

    

    ! function(p) {
        "use strict";

        function t() {}
        t.prototype.send = function(t, i, o, e, n, a, s, r) {
            var c = {
                heading: t,
                text: i,
                position: o,
                loaderBg: e,
                icon: n,
                hideAfter: a = a || 3e3,
                stack: s = s || 1
            };
            r && (c.showHideTransition = r), console.log(c), p.toast().reset("all"), p.toast(c)
        }, p.NotificationApp = new t, p.NotificationApp.Constructor = t
    }(window.jQuery),
    function(i) {
        "use strict";
        i("#toastr-one").on("click", function(t) {
            i.NotificationApp.send("Heads up!", "This alert needs your attention, but it is not super important.", "top-right", "#3b98b5", "info")
        }), 
        <?php if ($this->session->flashdata('messageS')) {?>
            i.NotificationApp.send("Success", "<?php echo $this->session->flashdata('messageS'); ?>", "top-center", "#5ba035", "success"),
        <?php }?>
        <?php if ($this->session->flashdata('messageE')) {?>
            i.NotificationApp.send("Failed!", "<?php echo $this->session->flashdata('messageE'); ?>", "top-center", "#5ba035", "danger"),
        <?php }?> 
        i("#toastr-ten").on("click", function(t) {
            i.NotificationApp.send("Plain transition", "Set the `showHideTransition` property to fade|plain|slide to achieve different transitions.", "top-right", "#3b98b5", "info", 3e3, 1, "plain")
        })
    }(window.jQuery);


//$('.productcodes').on('keypress', function(e) {
$('body').on("keypress", '.productcodes', function(e) {
    var keyCode = e.keyCode;
      if (keyCode === 13) {
        e.preventDefault();
            var valu =this.value;
            var no =this.title;
         searchproductcodefun(valu, no, 1);
        return false;
       }
    });


/*$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});*/
    </script>


    
</body>
</html>