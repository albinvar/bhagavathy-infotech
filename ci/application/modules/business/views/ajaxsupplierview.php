<div class="row col-md-12">
    <div class="col-md-6">
        <table class="table w-100 " >
            <tr>
                <td>Company Name</td>
                <td><b>: <?= $suplierdet->sp_name ?></b></td>
            </tr>
            <tr>
                <td>City</td>
                <td><b>: <?= $suplierdet->sp_city ?></b></td>
            </tr>
            <tr>
                <td>State</td>
                <td><b>: <?= $suplierdet->statename ?></b></td>
            </tr>
            <tr>
                <td>Mobile</td>
                <td><b>: <?= $suplierdet->sp_mobile ?></b></td>
            </tr>
            <tr>
                <td>Contact Person</td>
                <td><b>: <?= $suplierdet->sp_contactperson ?></b></td>
            </tr>
            <tr>
                <td><?= $this->isvatgstname ?> No</td>
                <td><b>: <?= $suplierdet->sp_gstno ?></b></td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table w-100 " >
            <tr>
                <td>Address</td>
                <td><b>: <?= $suplierdet->sp_address ?></b></td>
            </tr>
            <tr>
                <td>Country</td>
                <td><b>: <?= $suplierdet->countryname ?></b></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><b>: <?= $suplierdet->sp_contactnumber ?></b></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><b>: <?= $suplierdet->sp_email ?></b></td>
            </tr>
            <tr>
                <td>Person Mobile</td>
                <td><b>: <?= $suplierdet->sp_contactphone ?></b></td>
            </tr>
            <tr>
                <td>Balance Amount</td>
                <td><b>: <?= $suplierdet->sp_balanceamount ?></b></td>
            </tr>
        </table>
    </div>
</div>
