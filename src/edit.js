/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import {__} from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {useBlockProps} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import {useState, useEffect} from 'react';
import {Card, Button, CardBody, TextControl} from '@wordpress/components';

import apiFetch from '@wordpress/api-fetch';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit() {
	const [emailOrMobile, setEmailOrMobile] = useState('');
	const [otp, setOtp] = useState('');
	const [isOtpSent, setIsOtpSent] = useState(false);
	const [isLoginSuccessful, setIsLoginSuccessful] = useState(false);
	const [error, setError] = useState(null);

	const isEmail = (value) => {
		const emailRegex = /^[\w.%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
		return emailRegex.test(value);
	}

	const isMobile = (value) => {
		const isMobileRegex = /^\+?[1-9]\d{1,14}$/;
		return isMobileRegex.test(value);
	}
	const fetchRequestOtp = async () => {

		setIsOtpSent(true)

	};

	const fetchLogin = async () => {

		setIsLoginSuccessful(true)

		setIsOtpSent(true)
	};

	const SendOtpForm = () => {
		return (
			<div>

				<TextControl
					label={__('Email or Mobile', 'mjkh-otp')}
					help={__('Please enter your Mobile Or Email', 'mjkh-otp')}
					value={emailOrMobile}
					onChange={setEmailOrMobile}
				/>

				<Button onClick={async () => {
					await fetchRequestOtp()
				}} variant="primary">
					{__('Login', 'mjkh-otp')}
				</Button>
			</div>
		)
	}

	const EnterOtpCode = ({emailOrMobile, setEmailOrMobile}) => {
		return (
			<div>

				{isLoginSuccessful && <div>

					<p>{__('Login Successful', 'mjkh-otp')}</p>
				</div>
				}
				{!isLoginSuccessful && <div>

					{isEmail(emailOrMobile) && <p>{__('Code is Sent to Your Email', 'mjkh-otp')}</p>}
					{isMobile(emailOrMobile) && <p>{__('Code is Sent to Your Mobile', 'mjkh-otp')}</p>}


					<TextControl
						label={__('Otp', 'mjkh-otp')}
						value={otp}
						onChange={setOtp}
					/>


					<Button onClick={async () => {
						await fetchLogin()
					}} variant="primary">
						{__('Login', 'mjkh-otp')}
					</Button>
				</div>}

			</div>)
	}

	return (
		<div {...useBlockProps()}>

			{!isOtpSent && <SendOtpForm
				emailOrMobile={emailOrMobile} setEmailOrMobile={setEmailOrMobile}/>}

			{isOtpSent && <EnterOtpCode/>}

		</div>
	);
}


