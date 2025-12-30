<div class="row">

	<div class="col-md-3">
        Customer Name
    </div>
    <div class="col-md-3">
    	: <b><?php 
            $pharr = array();
            if($enquirydet->en_existingcust == 1)
            {
                echo $enquirydet->ct_name;
                if($enquirydet->ct_phone != "")
                {
                    $pharr[] = $enquirydet->ct_phone;
                }
                if($enquirydet->ct_mobile != "")
                {
                    $pharr[] = $enquirydet->ct_mobile;
                }
            }else{
                echo $enquirydet->en_firstname;
                if($enquirydet->en_mobile != "")
                {
                    $pharr[] = $enquirydet->en_mobile;
                }
                if($enquirydet->en_phone != "")
                {
                    $pharr[] = $enquirydet->en_phone;
                }
            }
            ?></b>
    </div>

    <div class="col-md-3">
        Phone
    </div>
    <div class="col-md-3">
        : <b><?php 
        echo implode(', ', $pharr);
        ?></b>
    </div>

    <div class="col-md-3 mt-2">
        Enquiry Date
    </div>
    <div class="col-md-3 mt-2">
        : <b><?= date('d-M-Y H:i', strtotime($enquirydet->en_addedon)) ?></b>
    </div>

    <div class="col-md-6 mt-2">
        <?= $enquirydet->en_subject ?>
    </div>

    <div class="col-md-12 mt-2">
    	Follow Up Comment*
        <textarea name="followupcomment" class="form-control" required="required"></textarea>
        <input type="hidden" name="en_enquiryid" value="<?= $enquirydet->en_enquiryid ?>">
    </div>

    <div class="col-md-2 mt-2">
    Status*
	</div>
	<div class="col-md-10 mt-2">
    	<label> <input type="radio" required="required" onclick="followupfun(this.value)" name="follwup" value="1"> Further Followup Required </label> &nbsp;
    	<label> <input type="radio" name="follwup" onclick="followupfun(this.value)" value="2"> Confirmed </label>
    	&nbsp;
    	<label> <input type="radio" name="follwup" onclick="followupfun(this.value)" value="3"> Cancelled </label>
	</div>

	<div class="col-md-12 mt-3" id="followupdatediv" style="display: none;">
		<div class="row">
			<div class="col-md-4">
				Next Follow Up Date
			</div>
			<div class="col-md-3">
				<input type="date" name="nextfollowupdate" class="form-control" style="width: 150px;">
			</div>
			<div class="col-md-3">
				<input type="time" name="nextfollowuptime" class="form-control" style="width: 130px;">
			</div>

		</div>
    	
        
        
    </div>
    
</div>

<script type="text/javascript">
	function followupfun(val)
	{
		if(val == 1)
		{
			$('#followupdatediv').show();
		}else{
			$('#followupdatediv').hide();
		}
	}
</script>