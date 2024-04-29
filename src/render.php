<div <?php echo get_block_wrapper_attributes(); ?>>


	<?php

	$nds_add_meta_nonce = wp_create_nonce('nds_add_user_meta_ajax_form_nonce');

	// Build the Form


	?>

	<?php if (!is_user_logged_in()) { ?>
		<div class="nds_add_user_meta_ajax_form">



			<h3><?php echo __('Login or Register', 'mjkh-otp') ?></h3>
			<form action="<?php echo esc_url('/wp/v2/users/sendotp'); ?>" method="post" id="mjkh-otp-request-code">

				<input type="hidden" name="action" value="mjkh_request_code_post">
				<input type="hidden" name="nds_add_user_meta_nonce" value="<?php echo $nds_add_meta_nonce ?>" />
				<div>
					<br>
					<label for="<?php echo 'mjkh-otp'; ?>-emailOrMobile"> <?php _e('Email or Mobile', 'mjkh-otp'); ?> </label><br>
					<input style="width: 100%;" required id="<?php echo 'mjkh-otp'; ?>-emailOrMobile" type="text" name="emailOrMobile" value="" placeholder="<?php _e('Please enter your Mobile Or Email', 'mjkh-otp'); ?>" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" /><br>
					<small>Please enter your Mobile Or Email</small>
				</div>

				<br />
				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Login - Send Code"></p>
			</form>

			<form style="display: none" action="<?php echo esc_url('/wp/v2/users/login'); ?>" method="post" id="mjkh-otp-login">

				<input type="hidden" name="action" value="mjkh_request_code_post">
				<input type="hidden" name="nds_add_user_meta_nonce" value="<?php echo $nds_add_meta_nonce ?>" />
				<div>
					<br>
					<label for="<?php echo 'mjkh-otp'; ?>-emailOrMobile"> <?php _e('Please Enter code :', 'mjkh-otp'); ?> </label><br>
					<input style="width: 100%;" required id="<?php echo 'mjkh-otp'; ?>-otp" type="text" name="otp" value="" placeholder="<?php _e('Please Enter code Enter the code we sent to Your Mobile/Email', 'mjkh-otp'); ?>" /><br>
					<small id="otp-message">Please Enter code Enter the code we sent to Your Mobile/Email</small>
				</div>
				<br />

				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Login - Confirm"></p>
			</form>
			<br /><br />
			<div id="nds_form_feedback"></div>
			<br /><br />
		</div>

</div>


<?php } else {

?>


	<h3><?php echo __("Already Logged in ", "mjkh-otp")  ?></h3>
	<br />
	<a href="<?php echo site_url()  ?>/dashboard"><?php echo __("Access Dashboard", "mjkh-otp")  ?></a>

	<script>
		//	window.location.href = '<?php echo site_url()  ?>/dashboard'
	</script>

<?php  } ?>