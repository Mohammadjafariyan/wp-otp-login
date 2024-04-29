<?php

/**
 * Plugin Name:       Otp login
 * Plugin URI:        bulus.ir
 * Description:       Email and Mobile Otp Login Plugin
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Mohammad Jafariyan Khosrowshahi
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mjkh-otp
 * Domain Path:       mjkh-otp
 *
 * @package MjkhOtpLogin
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}


function mjkh_plugin_load_textdomain() {
    load_plugin_textdomain('mjkh-otp', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'mjkh_plugin_load_textdomain');


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function mjkh_otp_login_mjkh_otp_login_block_init()
{
	register_block_type(__DIR__ . '/build');
}

add_action('init', 'mjkh_otp_login_mjkh_otp_login_block_init');



/*-----------------------------------------admin menu--------------------------------------------------------*/

add_action('admin_menu', 'mjkh_create_menu');
add_action('admin_init', 'mjkh_register_settings');

function mjkh_create_menu()
{
	//create custom top-level menu
	add_menu_page(
		'OTP Login Settings',
		'OTP Login Settings',
		'manage_options',
		'mjkh_otp_options',
		'mjkh_main_menu_callback',
		'dashicons-smiley',
		99
	);
}

function mjkh_register_settings()
{
	register_setting('mjkh_otp_login_settings_group', 'mjkh_otp_login_0098sms_username');
	register_setting('mjkh_otp_login_settings_group', 'mjkh_otp_login_0098sms_password');
	register_setting('mjkh_otp_login_settings_group', 'mjkh_otp_login_0098sms_PnlNo');
	register_setting('mjkh_otp_login_settings_group', 'mjkh_otp_login_0098sms_code_template');

	// Add a new section to the custom settings page
	add_settings_section(
		'mjkh_otp_login_custom_main_section',       // Section ID
		'Main Settings',             // Section title
		'otp_plugin_section_text',                        // Callback function to output content
		'mjkh_otp_options'            // Page slug
	);

	// Add a new field to the section
	add_settings_field(
		'mjkh_otp_login_0098sms_username',         // Field ID
		'نام کاربری پنل',                // Field label
		'mjkh_otp_login_0098sms_username', // Callback function for the field
		'mjkh_otp_options',           // Page slug
		'mjkh_otp_login_custom_main_section'        // Section ID
	);

	// Add a new field to the section
	add_settings_field(
		'mjkh_otp_login_0098sms_password',         // Field ID
		'پسورد پنل',                // Field label
		'mjkh_otp_login_0098sms_password', // Callback function for the field
		'mjkh_otp_options',           // Page slug
		'mjkh_otp_login_custom_main_section'        // Section ID
	);

	// Add a new field to the section
	add_settings_field(
		'mjkh_otp_login_0098sms_PnlNo',         // Field ID
		' شماره اختصاصی پنل شما در سامانه',                // Field label
		'mjkh_otp_login_0098sms_PnlNo', // Callback function for the field
		'mjkh_otp_options',           // Page slug
		'mjkh_otp_login_custom_main_section'        // Section ID
	);

	// Add a new field to the section
	add_settings_field(
		'mjkh_otp_login_0098sms_code_template',         // Field ID
		'قالب ارسال پیامک',                // Field label
		'mjkh_otp_login_0098sms_code_template', // Callback function for the field
		'mjkh_otp_options',           // Page slug
		'mjkh_otp_login_custom_main_section'        // Section ID
	);
}



// Draw the section header
function otp_plugin_section_text()
{
	echo '<p>' . __("OTP Login Need Webservice Information to Work", "mjkh-otp") . '</p>';
}

function mjkh_otp_login_0098sms_code_template()
{
	// get option 'text_string' value from the database
	$value = get_option('mjkh_otp_login_0098sms_code_template', 'محرمانه رمز یکبار مصرف شما : #code	');
?>
	<textarea rows="5" dir="rtl" style="text-align: right;" type="text" name="mjkh_otp_login_0098sms_code_template"><?php echo esc_attr($value); ?></textarea>
<?php
}
function mjkh_otp_login_0098sms_username()
{
	// get option 'text_string' value from the database
	$value = get_option('mjkh_otp_login_0098sms_username', '');
?>
	<input type="text" name="mjkh_otp_login_0098sms_username" value="<?php echo esc_attr($value); ?>" />
<?php
}
function mjkh_otp_login_0098sms_password()
{
	// get option 'text_string' value from the database
	$value = get_option('mjkh_otp_login_0098sms_password', '');
?>
	<input type="text" name="mjkh_otp_login_0098sms_password" value="<?php echo esc_attr($value); ?>" />
<?php
}



function mjkh_otp_login_0098sms_PnlNo()
{
	// get option 'text_string' value from the database
	$value = get_option('mjkh_otp_login_0098sms_PnlNo', '');
?>
	<input type="text" name="mjkh_otp_login_0098sms_PnlNo" value="<?php echo esc_attr($value); ?>" />
<?php
}
// Create the option page
function mjkh_main_menu_callback()
{
?>
	<div class="wrap">
		<h2>OTP Login Plugin Setting Page</h2>
		<form action="options.php" method="post">
			<?php
			// Output the settings sections and settings fields
			settings_fields('mjkh_otp_login_settings_group');  // Identifies the settings group
			do_settings_sections('mjkh_otp_options');   // Identifies the settings page
			submit_button();  // Adds a submit button
			?>
		</form>
	</div>
<?php
}

/*-------------------------------------------------------------------------------------------------*/


function mjkh_login_endpoint($request)
{
	$parameters = $request->get_json_params();

	$email = $parameters['email'];
	$mobile = $parameters['mobile'];
	$otp = $parameters['code'];

	$code = get_user_session_data('mjkh-otp-code');
	$datetimeStr = get_user_session_data('mjkh-otp-code-time');
	$email = get_user_session_data('mjkh-otp-email'); // Store the value in the session
	$mobile = get_user_session_data('mjkh-otp-mobile'); // Store the value in the session


	$datetime = DateTime::createFromFormat('Y-m-d H:i:s', $datetimeStr);

	$now = new DateTime();
	$interval = $now->diff($datetime); // Get the difference between the two dates
	// Calculate total minutes
	$total_minutes = ($interval->days * 24 * 60) + // Convert days to minutes
		($interval->h * 60) +          // Convert hours to minutes
		$interval->i;                  // Add remaining minutes

	if ($total_minutes > 5) {
		return new WP_Error(
			'invalid_credentials',
			__('The code is expired', "mjkh-otp"),
			array('status' => 401)
		);
	}

	if ($otp != $code) {
		return new WP_Error(
			'invalid_credentials',
			__('The code is invalid', "mjkh-otp"),
			array('status' => 401)
		);
	}


	$user = create_user_if_not_exists($mobile, $email, $otp);


	mjkh_authenticate_user($user);

	// If needed, create a user session or perform other actions.
	// You can also return additional information or a JWT token if integrating with other services.

	return array(
		'success' => true,
		'message' => 'Login successful',
	);
}

function mjkh_register_login_endpoint()
{
	register_rest_route(
		'wp/v2',
		'/users/login',
		array(
			'methods' => 'POST',
			'callback' => 'mjkh_login_endpoint',
			'permission_callback' => '__return_true', // Be cautious with permissions
		)
	);
}

add_action('rest_api_init', 'mjkh_register_login_endpoint');


/*-------------------------------------------------------------------------------------------------*/

function get_user_session_data($key)
{
	return get_transient($key);
}

function mjkh_otp_request_code_endpoint($request)
{
	$parameters = $request->get_json_params();

	$email = $parameters['email'];
	$mobile = $parameters['mobile'];
	$code = mt_rand(1000, 9999);;

	/* -------------------------- prevent request code again in less than 2 minutes  */
	$datetimeStr = get_user_session_data('mjkh-otp-code-time');
	$lastEmail = get_user_session_data('mjkh-otp-email'); // Store the value in the session
	$lastMobile = get_user_session_data('mjkh-otp-mobile'); // Store the value in the session


	if ($datetimeStr && $lastEmail==$email && $lastMobile==$mobile ) {
		$datetime = DateTime::createFromFormat('Y-m-d H:i:s', $datetimeStr);

		$now = new DateTime();
		$interval = $now->diff($datetime); // Get the difference between the two dates
		// Calculate total minutes
		$total_minutes = ($interval->days * 24 * 60) + // Convert days to minutes
			($interval->h * 60) +          // Convert hours to minutes
			$interval->i;                  // Add remaining minutes

		if ($total_minutes < 2) {

			$codeSent = get_user_session_data('mjkh-otp-code');

			return new WP_Error(
				'invalid_credentials',
				__('The code = '. $codeSent.' has already been sent and it is still valid for 2 minutes ', "mjkh-otp"),
				array('status' => 401)
			);
		}
	}

	/* --------------------------  */

	// Create a DateTime object for the current time
	$now = new DateTime();

	$content = '';
	$sms = '';
	// Store the formatted date/time string in the session
	// ISO 8601 format
	set_transient('mjkh-otp-code-time', $now->format('Y-m-d H:i:s'), 5 * 60); // Store the value in the session




	if (preg_match("/^[\w.%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/", $email)) {

		$content=mjkh_send_email($code, $email);
	} else if (preg_match("/^0((?:90|91|92|93|99)[0-9]{8})$/", $mobile)) {

		$sms= mjkh_send_sms($code, $mobile);
	} else {
		//echo "username ok";

		return new WP_Error(
			'invalid_credentials',
			'Invalid Email or Mobile',
			array('status' => 401)
		);
	}




	set_transient('mjkh-otp-code', $code, 5 * 60); // Store the value in the session
	set_transient('mjkh-otp-email', $email, 5 * 60); // Store the value in the session
	set_transient('mjkh-otp-mobile', $mobile, 5 * 60); // Store the value in the session



	if (defined('WP_DEBUG') && WP_DEBUG) {

		return array(
			'success' => true,
			'message' => __("Otp Sent successfuly", "mjkh-otp"),
			'code' => $code,
			'content' => $content,
			'sms' => $sms,
		);

	} else {
		return array(
			'success' => true,
			'message' =>
			__("Otp Sent successfuly", "mjkh-otp")
		);

	}


}



function mjkh_register_send_otp_endpoint()
{
	register_rest_route(
		'wp/v2',
		'/users/sendotp',
		array(
			'methods' => 'POST',
			'callback' => 'mjkh_otp_request_code_endpoint',
			'permission_callback' => '__return_true', // Be cautious with permissions
		)
	);
}

add_action('rest_api_init', 'mjkh_register_send_otp_endpoint');


function mjkh_authenticate_user($user)
{
	wp_clear_auth_cookie();
	wp_set_auth_cookie($user->ID);
	wp_set_current_user($user->ID);
}

function create_user_if_not_exists($username, $email, $password, $role = 'customer')
{
	// Check if the username already exists
	if (username_exists($username)) {
		return get_user_by('login', $username);
	}

	// Check if the email already exists
	if (email_exists($email)) {
		return get_user_by_email($email);
	}

	// Create the user with the provided details
	$user_id = wp_create_user($username, $password, $email);

	if (is_wp_error($user_id)) {
		return "Error creating user: " . $user_id->get_error_message();
	}

	// Set the user's role
	$user = new WP_User($user_id);
	$user->set_role($role);

	return "User '$username' created successfully.";
}



function mjkh_send_sms($code, $mobile)
{

	$code_template = get_option('mjkh_otp_login_0098sms_code_template', '');

	$content = str_replace('#code', $code, $code_template);

	//turn off the WSDL cache
	ini_set("soap.wsdl_cache_enabled", "0");
	$sms_client = new
		SoapClient(
			'http://webservice.0098sms.com/service.asmx?wsdl',
			array('encoding' => 'UTF-8')
		);
	$parameters['username'] = get_option('mjkh_otp_login_0098sms_username', '');
	$parameters['password'] = get_option('mjkh_otp_login_0098sms_password', '');
	$parameters['mobileno'] = $mobile;
	$parameters['pnlno'] = get_option('mjkh_otp_login_0098sms_PnlNo', 'محرمانه رمز یکبار مصرف شما : #code');
	$parameters['text'] = $content;
	$parameters['isflash'] = false;

	$response = $sms_client->SendSMS($parameters)->SendSMSResult;

	return $parameters['pnlno'] .' =>' .$response;
}

function mjkh_send_email($code, $email)
{
	$site_title = get_bloginfo('name');

	$site_url = site_url();

	$desc = __('If you have not recently tried to sign into ', 'mjkh-otp');
	$title = __('Help us protect your account', 'mjkh-otp');

	$desc2 = __(' just ignore this email', 'mjkh-otp');

	$custom_logo_id = get_theme_mod('custom_logo');
	$image = wp_get_attachment_image_src($custom_logo_id, 'full');


	$site_icon_url = $image[0];

	$message = __('Before you sign in, we need to verify your
                              identity. Enter the following
                              code on the sign-in page.','mjkh-otp');

	$html_content = <<<EOT

<div
  style="
    text-align: center;
    min-width: 640px;
    width: 100%;
    height: 100%;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    margin: 0;
    padding: 0;
  "
  bgcolor="#fafafa"
>
  <table
    border="0"
    cellpadding="0"
    cellspacing="0"
    id="m_-318787932495669672body"
    style="
      text-align: center;
      min-width: 640px;
      width: 100%;
      margin: 0;
      padding: 0;
    "
    bgcolor="#fafafa"
  >
    <tbody>
      <tr>
        <td
          style="
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            height: 4px;
            font-size: 4px;
            line-height: 4px;
          "
          bgcolor="#114dd5"
        ></td>
      </tr>
      <tr>
        <td
          style="
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            line-height: 1.6;
            color: #5c5c5c;
            padding: 25px 0;
          "
        >
          <img
            alt="$site_title"
            src="$site_icon_url"
            width="55"
            height="55"
            class="CToWUd"
            data-bit="iit"
          />
        </td>
      </tr>
      <tr>
        <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif">
          <table
            border="0"
            cellpadding="0"
            cellspacing="0"
            class="m_-318787932495669672wrapper"
            style="
              width: 640px;
              border-collapse: separate;
              border-spacing: 0;
              margin: 0 auto;
            "
          >
            <tbody>
              <tr>
                <td
                  class="m_-318787932495669672wrapper-cell"
                  style="
                    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                    border-radius: 3px;
                    overflow: hidden;
                    padding: 18px 25px;
                    border: 1px solid #ededed;
                  "
                  align="left"
                  bgcolor="#fff"
                >
                  <table
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    style="
                      width: 100%;
                      border-collapse: separate;
                      border-spacing: 0;
                    "
                  >
                    <tbody>
                      <tr>
                        <td>
                          <div
                            style="
                              color: #1f1f1f;
                              line-height: 1.25em;
                              max-width: 400px;
                              margin: 0 auto;
                            "
                            align="center"
                          >
                            <h3>$title</h3>
                            <p style="font-size: 0.9em">
                              $message
                            </p>
                            <div
                              style="
                                width: 207px;
                                height: 53px;
                                background-color: #f0f0f0;
                                line-height: 53px;
                                font-weight: 700;
                                font-size: 1.5em;
                                color: #303030;
                                margin: 26px 0;
                              "
                            >
                              $code
                            </div>
                            <p style="font-size: 0.75em">
                              $desc $site_title $desc2

                            </p>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>

      <tr>
        <td
          style="
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            line-height: 1.6;
            color: #5c5c5c;
            padding: 25px 0;
          "
        >
          <img
            alt="$site_title"
            src="$site_icon_url"
            style="display: block;  margin: 0 auto 1em"
            class="CToWUd"
            width="50"
            data-bit="iit"
          />
          <div>
            You're receiving this email because of your account on
            <a
              rel="noopener noreferrer"
              href="$site_url"
              style="color: #3777b0; text-decoration: none"
              target="_blank"
              >$site_url</a
            >.

            ·
            <a
              href="$site_url/help"
              rel="noopener noreferrer"
              style="color: #3777b0; text-decoration: none"
              target="_blank"
              >Help</a
            >
          </div>
        </td>
      </tr>

      <tr>
        <td
          style="
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            line-height: 1.6;
            color: #5c5c5c;
            padding: 25px 0;
          "
        ></td>
      </tr>
    </tbody>
  </table>
  <div class="yj6qo"></div>
  <div class="adL"></div>
</div>
EOT;


	$headers = array('Content-Type: text/html; charset=UTF-8');

	wp_mail($email, __("Verify your identity", "mjkh-otp"), $html_content, $headers);
	return $html_content;

}
