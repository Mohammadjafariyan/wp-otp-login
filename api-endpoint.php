<?php


function mjkh_verify_endpoint($request)
{
	// Retrieve the 'key' parameter from the request
	$key = $request->get_param('key');
	$email = $request->get_param('email');
	$product_id = $request->get_param('product_id');


	$user = mjkh_findUser($email);


	if ($user) {

		$message = mjkh_get_user_subscriptions_remain($user->ID, $product_id);
	
		// Dummy logic for verification
		return new WP_REST_Response(array('key' => $key,

			'message' => $message,
			'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
			'HTTP_REFERER' => $_SERVER['HTTP_REFERER'],
			'REMOTE_HOST' => $_SERVER['REMOTE_HOST'],
			'HOST_NAME' => $_SERVER['HOST_NAME'],
			'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
			'GEOIP_COUNTRY_CODE' => $_SERVER["GEOIP_COUNTRY_CODE"],
		), 200); // HTTP 200: OK
	} else {


		//return new WP_REST_Response(array('key' => $key,'message'=>'ایمیل شما نیست'), 50); // HTTP 200: OK
		return new WP_Error('not_found', __('اطلاعات ارسالی معتبر نیست'), array('status' => 404));
		//	return new WP_Error( 'wrong_input', __('اطلاعات ارسالی معتبر نیست'), array( 'status' => 404 ) );

	}


}

function mjkh_verify_endpoint_register()
{

	register_rest_route('api/v1', '/verify/', array(
		'methods' => 'GET', // Accept only GET requests
		'callback' => 'mjkh_verify_endpoint', // Function to handle the request
		'args' => array( // Define the expected arguments
			'key' => array(
				'required' => true, // Key is required
				'type' => 'string', // Expected data type
				'validate_callback' => function ($param) {
					// Optional: Validate the parameter
					return is_string($param);
				}
			),
			'email' => array(
				'required' => true, // Key is required
				'type' => 'string', // Expected data type
				'validate_callback' => function ($param) {
					// Optional: Validate the parameter
					return is_string($param);
				}
			)
		),
	));
}

add_action('rest_api_init', 'mjkh_verify_endpoint_register');


/*--------------------------------------------------------------------------------------------*/

function mjkh_get_user_subscriptions_remain($user_id, $productId)
{

	$subs = YWSBS_Subscription_Helper::get_instance()->get_subscriptions_by_user($user_id);
	$subscription_status_list = ywsbs_get_status();

	foreach ($subs as $subscription_post) {

		$subscription_id = is_numeric($subscription_post) ? $subscription_post : $subscription_post->ID;
		$subscription = ywsbs_get_subscription($subscription_id);
		$subscription_name = sprintf('%s - %s', $subscription->get_number(), $subscription->get('product_name'));
		$subscription_status = $subscription_status_list[$subscription->get_status()];
		$next_payment_due_date = (!in_array($subscription_status, array('paused', 'cancelled'), true) && $subscription->get('payment_due_date')) ? date_i18n(wc_date_format(), $subscription->get('payment_due_date')) : '<span class="empty-date">-</span>';
		$start_date = ($subscription->get('start_date')) ? date_i18n(wc_date_format(), $subscription->get('start_date')) : '<div class="empty-date">-</div>';
		$end_date = ($subscription->get('end_date')) ? date_i18n(wc_date_format(), $subscription->get('end_date')) : false;
		$end_date = !$end_date && ($subscription->get('expired_date')) ? date_i18n(wc_date_format(), $subscription->get('expired_date')) : date("Y-m-d");

		if ($subscription->get_status() != 'active') {
			continue;
		}

		// Calculate remaining time
		$start = new DateTime(date("Y-m-d"));
		$today = new DateTime(date("Y-m-d"));
		$end = new DateTime($end_date);

		if ($today >= $start && $end >= $today) {
		} else {
			continue;
		}


		// Calculate the difference
		$interval = $today->diff($end);

		// Calculate the total number of days
		$total_days = $interval->days;

		// Convert days to weeks
		$weeks = floor($total_days / 7);

		// Calculate remaining days after accounting for full weeks
		$remaining_days = $total_days % 7;

		// Get the product from the subscription
		$product = $subscription->get_product();


		if ($productId) {
			if ($productId == $product->get_id()) {
				return sprintf(
					$remaining_days > 0 ? 'اشتراک باقیمانده : %d هفته و %d روز '
						: 'اشتراک باقیمانده : %d هفته ',
					$weeks,
					$remaining_days
				);
			}
		} else {
			if ($remaining_days > 0) {
				return sprintf(
					'اشتراک باقیمانده : %d هفته و %d روز برای %s '					,
					$weeks,
					$remaining_days,
					$product->get_name()
				);
			} else {
				return sprintf(
					'اشتراک باقیمانده : %d هفته برای %s '					,
					$weeks,
					$product->get_name()
				);
			}

		}

		/*$tempArr= array(
			'text'=>sprintf(
				'اشتراک باقیمانده : %d هفته و %d روز ',
				$weeks,
				$remaining_days
			),
			"weeks"=>$weeks,
			"remaining_days"=>$remaining_days,
			"product_id"=>$product->get_id(),
			"product_name"=>$product->get_name()
		);*/

	}
	return  null;

}

function mjkh_findUser($usernameOrEmail)
{
	if (username_exists($usernameOrEmail)) {
		return get_user_by('login', $usernameOrEmail);
	}

	// Check if the email already exists
	if (email_exists($usernameOrEmail)) {
		return get_user_by_email($usernameOrEmail);
	}

	return null;
}
