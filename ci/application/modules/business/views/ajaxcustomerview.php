<div class="row col-md-12">
    <div class="col-md-6">
        <table class="table w-100 " >
            <tr>
                <td>Customer Name</td>
                <td><b>: <?= $customerdet->ct_name ?></b></td>
            </tr>
            <tr>
                <td>City</td>
                <td><b>: <?= $customerdet->ct_city ?></b></td>
            </tr>
            <tr>
                <td>State</td>
                <td><b>: <?= $customerdet->statename ?></b></td>
            </tr>
            <tr>
                <td>Mobile</td>
                <td><b>: <?= $customerdet->ct_mobile ?></b></td>
            </tr>
            <tr>
                <td>Balance Amount</td>
                <td><b>: <?= $customerdet->ct_balanceamount ?></b></td>
            </tr>
            <tr>
                <td>Type</td>
                <td><b>: <?php 
                if($customerdet->ct_type == 0)
                {
                    echo 'B2C';
                }else{
                    echo 'B2B, '. $this->isvatgstname .' No: ' . $customerdet->ct_gstin;
                }
                ?></b></td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table w-100 " >
            <tr>
                <td>Address</td>
                <td><b>: <?= $customerdet->ct_address ?></b></td>
            </tr>
            <tr>
                <td>Country</td>
                <td><b>: <?= $customerdet->countryname ?></b></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><b>: <?= $customerdet->ct_phone ?></b></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><b>: <?= $customerdet->ct_email ?></b></td>
            </tr>
            
            <tr>
                <td>Added On</td>
                <td><b>: <?= date('d-M-Y H:i', strtotime($customerdet->ct_updatedon)) ?></b></td>
            </tr>
        </table>
    </div>
</div>
