<?php

// Function to get remaining subscription time for a user
function get_user_remaining_subscription($user_id)
{
	// Load subscriptions
	if (class_exists('YITH_WC_Subscription')) {
		// Get user subscriptions
		$subscriptions = YITH_WC_Subscription()->get_user_subscriptions(array('user_id' => $user_id));

		$user=wp_get_current_user();
		$subs=YWSBS_Subscription_Helper::get_instance()->get_subscriptions_by_user( $user->ID);
		$subscription_status_list = ywsbs_get_status();

		foreach ( $subs as $subscription_post ) {

			$subscription_id       = is_numeric( $subscription_post ) ? $subscription_post : $subscription_post->ID;
			$subscription          = ywsbs_get_subscription( $subscription_id );
			$subscription_name     = sprintf( '%s - %s', $subscription->get_number(), $subscription->get( 'product_name' ) );
			$subscription_status   = $subscription_status_list[ $subscription->get_status() ];
			$next_payment_due_date = ( ! in_array( $subscription_status, array( 'paused', 'cancelled' ), true ) && $subscription->get( 'payment_due_date' ) ) ? date_i18n( wc_date_format(), $subscription->get( 'payment_due_date' ) ) : '<span class="empty-date">-</span>';
			$start_date            = ( $subscription->get( 'start_date' ) ) ? date_i18n( wc_date_format(), $subscription->get( 'start_date' ) ) : '<div class="empty-date">-</div>';
			$end_date              = ( $subscription->get( 'end_date' ) ) ? date_i18n( wc_date_format(), $subscription->get( 'end_date' ) ) : false;
			$end_date              = ! $end_date && ( $subscription->get( 'expired_date' ) ) ? date_i18n( wc_date_format(), $subscription->get( 'expired_date' ) ) : date("Y-m-d");

			// Calculate remaining time
			$today = new DateTime(date("Y-m-d"));
			$end = new DateTime($end_date);

			// Calculate the difference
			$interval = $today->diff($end);

			// Calculate the total number of days
			$total_days = $interval->days;

			// Convert days to weeks
			$weeks = floor($total_days / 7);

			// Calculate remaining days after accounting for full weeks
			$remaining_days = $total_days % 7;

			echo  sprintf(
				'%d weeks, %d days remaining',
				$weeks,
				$remaining_days
			);



		}

		return 'No active subscriptions found';
	} else {
		return 'YITH WooCommerce Subscription plugin not found';
	}
}


?>
