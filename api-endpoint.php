<?php



function mjkh_verify_endpoint($request)
{
	// Retrieve the 'key' parameter from the request
	$key = $request->get_param('key');
	$email = $request->get_param('email');



	if(strtolower($email)=='farezvan@gmail.com'){

		// Dummy logic for verification
		return new WP_REST_Response(array('key' => $key,'message'=>'اشتراک باقیمانده : 54 هفته' ,
			'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
			'HTTP_REFERER' => $_SERVER['HTTP_REFERER'],
			'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
			'GEOIP_COUNTRY_CODE' =>$_SERVER["GEOIP_COUNTRY_CODE"],
			), 200); // HTTP 200: OK
	}else{

		return new WP_REST_Response(array('key' => $key,'message'=>'ایمیل شما نیست'), 50); // HTTP 200: OK
	}


}

function mjkh_verify_endpoint_register()
{

	register_rest_route('api/v1', '/verify/', array(
		'methods'  => 'GET', // Accept only GET requests
		'callback' => 'mjkh_verify_endpoint', // Function to handle the request
		'args'     => array( // Define the expected arguments
			'key' => array(
				'required' => true, // Key is required
				'type'     => 'string', // Expected data type
				'validate_callback' => function ($param) {
					// Optional: Validate the parameter
					return is_string($param);
				}
			),
			'email' => array(
				'required' => true, // Key is required
				'type'     => 'string', // Expected data type
				'validate_callback' => function ($param) {
					// Optional: Validate the parameter
					return is_string($param);
				}
			)
		),
	));
}

add_action('rest_api_init', 'mjkh_verify_endpoint_register');

