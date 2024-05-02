/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json` it will be enqueued on the front end of the site.
 *
 * Example:
 *
 * ```js
 * {
 *   "viewScript": "file:./view.js"
 * }
 * ```
 *
 * If you're not making any changes to this file because your project doesn't need any
 * JavaScript running in the front-end, then you should delete this file and remove
 * the `viewScript` property from `block.json`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */
import apiFetch from '@wordpress/api-fetch'
import { useState } from 'react'
import { __ } from '@wordpress/i18n'

/* eslint-disable no-console */

console.log('Hello World! (from mjkh-otp-login-mjkh-otp-login block)')
/* eslint-enable no-console */

let emailOrMobile
let otp
let isOtpSent
let isLoginSuccessful
let error

const isEmail = value => {
	const emailRegex = /^[\w.%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/
	return emailRegex.test(value)
}

const isMobile = value => {
	const isMobileRegex = /^0((?:90|91|92|93|99)[0-9]{8})$/
	return isMobileRegex.test(value)
}

var totalSeconds = 0;

function setTime() {
  ++totalSeconds;
  $('#mjkh_seconds').text(pad(totalSeconds % 60));
	$('#mjkh_minutes').text(pad(parseInt(totalSeconds / 60)));

	if (totalSeconds / 60 >= 2) {
		clearInterval(setTime);
		totalSeconds = 0;

$('#mjkh_timeout').hide()
$('#mjkh_resend').show()


	}
}

function pad(val) {
	var valString = val + "";
	if (valString.length < 2) {
		return "0" + valString;
	} else {
		return valString;
	}
}

const fetchRequestOtp = async callback => {

	console.log('76')
if (totalSeconds != 0) {
		return;
	}

	apiFetch({
		path: '/wp/v2/users/sendotp', // This would require a custom REST API endpoint or AJAX handler
		method: 'POST',
		data: {
			email: isEmail(emailOrMobile) ? emailOrMobile : null,
			mobile: isMobile(emailOrMobile) ? emailOrMobile : null
		}
	})
		.then(response => {
			// Handle successful login
			jQuery('#mjkh-otp-request-code')
				.find('input[type="submit"]')
				.removeAttr('disabled')

			if (response.success) {
				// Maybe redirect or show success message
				console.log('otp request successful')

				if (response.content) {
					jQuery(' #nds_form_feedback ').html(
						'<h2>otp request successful</h2><br>' +
							response.code +
							'<br/>' +
							'<h2>content</h2><br>' +
							response.content +
							'<br/>' +
							'<h2>sms</h2><br>' +
							response.sms +
							'<br/>'
					)


					console.log('112');
				$('#mjkh_resend').hide()
				$('#mjkh_timeout').show();

					setInterval(setTime, 1000)

				} else {
					jQuery(' #nds_form_feedback ').html('<p>' + response.message + '</p>')
				}

				/*
				jQuery(' #nds_form_feedback ').html(
	'<h2>otp request successful</h2><br>' + response.code
)
 */
				isOtpSent = true

				callback()
			} else {
				error = response.message || 'otp request failed'
			}
		})
		.catch(err => {
			jQuery('#mjkh-otp-request-code')
				.find('input[type="submit"]')
				.removeAttr('disabled')

			jQuery(' #nds_form_feedback ').html(
				"<p style='color:red'>" + err.message + '</p><br>'
			)
			error = 'An error occurred during login'
			console.error(err)
		})
}

const fetchLogin = async () => {
	apiFetch({
		path: '/wp/v2/users/login', // This would require a custom REST API endpoint or AJAX handler
		method: 'POST',
		data: {
			email: isEmail(emailOrMobile) ? emailOrMobile : null,
			mobile: isMobile(emailOrMobile) ? emailOrMobile : null,
			code: otp
		},
		xhrFields: {
			withCredentials: true // Ensure cookies are included in cross-origin requests
		}
	})
		.then(response => {
			jQuery('#mjkh-otp-login')
				.find('input[type="submit"]')
				.removeAttr('disabled')
			// Handle successful login
			if (response.success) {
				// Maybe redirect or show success message
				console.log('Login successful')

				jQuery('#mjkh-otp-login').html('<p>' + response.message + '</p>')


				isLoginSuccessful = true

				window.location.reload()
			} else {
				error = response.message || 'Login failed'
			}
		})
		.catch(err => {
			jQuery('#mjkh-otp-login')
				.find('input[type="submit"]')
				.removeAttr('disabled')
			error = 'An error occurred during login'

			jQuery(' #nds_form_feedback ').html(
				"<p style='color:red'>" + err.message + '</p><br>'
			)
			//jQuery(' #nds_form_feedback ').append('<p>Something went wrong.</p><br>')

			console.error(err)
		})
}

// Attach the component to a specific block element
document.addEventListener('DOMContentLoaded', () => {
	jQuery(document).ready(function () {
		'use strict'
		/**
		 * The file is enqueued from inc/admin/class-admin.php.
		 */
		jQuery('#mjkh-otp-request-code').submit(async function (event) {
			event.preventDefault() // Prevent the default form submit.

			// serialize the form data
			var ajax_form_data = jQuery('#nds_add_user_meta_ajax_form').serialize()

			emailOrMobile = jQuery('#mjkh-otp-request-code')
				.find('[name="emailOrMobile"]')
				.val()

			jQuery('#nds_form_feedback').text('')

			if (!emailOrMobile) {
				jQuery('#nds_form_feedback').text(
					__('Please Enter A Valid Email Or Mobile', 'mjkh-otp')
				)

				return
			}

			jQuery('#mjkh-otp-request-code')
				.find('input[type="submit"]')
				.attr('disabled', true)
			await fetchRequestOtp(() => {
				jQuery('#mjkh-otp-request-code').hide()
				jQuery('#mjkh-otp-login').show()
			})
		})

		jQuery('#mjkh-otp-login').submit(async function (event) {
			event.preventDefault() // Prevent the default form submit.

			// serialize the form data
			var ajax_form_data = jQuery('#nds_add_user_meta_ajax_form').serialize()

			otp = jQuery('#mjkh-otp-login').find('[name="otp"]').val()

			jQuery('#nds_form_feedback').text('')

			if (!otp) {
				jQuery('#nds_form_feedback').text(
					__('Please Enter A Valid Code', 'mjkh-otp')
				)

				return
			}

			jQuery('#mjkh-otp-login')
				.find('input[type="submit"]')
				.attr('disabled', true)

			await fetchLogin()
		})
	})
})
