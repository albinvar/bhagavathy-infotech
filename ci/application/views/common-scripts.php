<?php echo PHP_EOL; ?>
<script type="text/javascript">
	function changepremisepublicid(premseid) {
		$.ajax({
			url: '<?php echo site_url('settings/changepublicpremiseid') ?>',
			type: 'POST',
			data: {
				id: premseid
			},
			success: function(response) {
				location.reload();
			}
		});
	}
	$(document).ready(function() {

		<?php if(!empty($this->notificationcount)): ?>

			$("#pulsating-green-dot").removeClass('d-none')

		<?php endif; ?>

		$(".suretodisable").click(function() {
			if(confirm('<?php echo lang('record_disable_question') ?>'))return true;return false;
		});
		$(".suretoenable").click(function() {
			if(confirm('<?php echo lang('record_enable_question') ?>'))return true;return false;
		});


		
		

		// FORM CANCEL BUTTON CLICK
		$("#cancel_button").click(function() {
			if(confirm("<?php echo lang('cancel_form'); ?>")) {
				location.href = this.value;
			} return false; 
		});
// for dual forms in one page
$(".cancel_button").click(function() {
	if(confirm("<?php echo lang('cancel_form'); ?>")) {
		location.href = this.value;
	} return false; 
});
});


	

</script>