<div <?php echo get_block_wrapper_attributes(); ?>>


	<?php

	$nds_add_meta_nonce = wp_create_nonce('nds_add_user_meta_ajax_form_nonce');

	// Build the Form


	?>
	<?php if (!is_user_logged_in()) { ?>
		<div class="nds_add_user_meta_ajax_form">


			<style>
				#mj_timeout_table, #mj_timeout_table * {
					border:none
				}
				#mj_timeout_table a{
				}

				#mj_timeout_table a:hover{
					color:#0ea5e9;
					cursor:pointer;
				}
			</style>

			<h3><?php echo __('Login or Register', 'mjkh-otp') ?></h3>
			<form action="<?php echo esc_url('/wp/v2/users/sendotp'); ?>" method="post" id="mjkh-otp-request-code">

				<input type="hidden" name="action" value="mjkh_request_code_post">
				<input type="hidden" name="nds_add_user_meta_nonce" value="<?php echo $nds_add_meta_nonce ?>" />
				<div>
					<br>
					<label for="<?php echo 'mjkh-otp'; ?>-emailOrMobile"> <?php _e('Email or Mobile', 'mjkh-otp'); ?> </label><br>
					<input style="width: 100%;" required id="<?php echo 'mjkh-otp'; ?>-emailOrMobile" type="text" name="emailOrMobile" value="" placeholder="<?php _e('Please enter your Mobile Or Email', 'mjkh-otp'); ?>" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" /><br>
					<small style="color:#aeb5bb"><?php echo __('Please enter your Mobile Or Email', 'mjkh-otp') ?></small>
				</div>

				<br />


				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __('Login Send Code', 'mjkh-otp') ?>"></p>
			</form>

			<form style="display: none" action="<?php echo esc_url('/wp/v2/users/login'); ?>" method="post" id="mjkh-otp-login">

				<input type="hidden" name="action" value="mjkh_request_code_post">
				<input type="hidden" name="nds_add_user_meta_nonce" value="<?php echo $nds_add_meta_nonce ?>" />
				<div>
					<br>
					<label for="<?php echo 'mjkh-otp'; ?>-emailOrMobile"> <?php _e('Please Enter code :', 'mjkh-otp'); ?> </label><br>
					<input maxlength="4" style="width: 100%;text-align: center" required id="<?php echo 'mjkh-otp'; ?>-otp" type="text" name="otp" value="" placeholder="****" /><br>
					<small style="color:#aeb5bb" id="otp-message"><?php echo __('Please Enter code Enter the code we sent to Your Mobile/Email', 'mjkh-otp') ?></small>
				</div>
				<br />

				<table id="mj_timeout_table">
					<tbody>
					<tr>
						<td class="mjkh_timeout mjkh_timeout_text">
							مانده تا دریافت مجدد کد:
						</td>
						<td class="mjkh_timeout">
							<div  style=""><label id="mjkh_minutes">02</label>:<label id="mjkh_seconds">30</label></div>

						</td>
						<td>
							<div  style=""><a  id="mjkh_resend"> <?php echo __('ارسال مجدد رمز یکبار مصرف', 'mjkh-otp') ?> </a></div>

						</td>
					</tr>
					</tbody>
				</table>

				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __('Login - Confirm', 'mjkh-otp') ?>"></p>
			</form>
			<br /><br />
			<div id="nds_form_feedback"></div>
			<br /><br />
		</div>

</div>


<?php } else {

	/*
<h3><?php echo __("Already Logged in ", "mjkh-otp")  ?></h3>
<br />
<a href="<?php echo site_url()  ?>/dashboard"><?php echo __("Access Dashboard", "mjkh-otp")  ?></a>

<script>
		//window.location.href = '<?php echo site_url()  ?>/dashboard'
</script>

*/
	?>




<?php  } ?>

