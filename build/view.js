/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "@wordpress/api-fetch":
/*!**********************************!*\
  !*** external ["wp","apiFetch"] ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["wp"]["apiFetch"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*********************!*\
  !*** ./src/view.js ***!
  \*********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
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




/* eslint-disable no-console */

console.log('Hello World! (from mjkh-otp-login-mjkh-otp-login block)');
/* eslint-enable no-console */

let emailOrMobile;
let otp;
let isOtpSent;
let isLoginSuccessful;
let error;
const isEmail = value => {
  const emailRegex = /^[\w.%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
  return emailRegex.test(value);
};
const isMobile = value => {
  const isMobileRegex = /^0((?:90|91|92|93|99)[0-9]{8})$/;
  return isMobileRegex.test(value);
};
const fetchRequestOtp = async callback => {
  _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default()({
    path: '/wp/v2/users/sendotp',
    // This would require a custom REST API endpoint or AJAX handler
    method: 'POST',
    data: {
      email: isEmail(emailOrMobile) ? emailOrMobile : null,
      mobile: isMobile(emailOrMobile) ? emailOrMobile : null
    }
  }).then(response => {
    // Handle successful login
    jQuery('#mjkh-otp-request-code').find('input[type="submit"]').removeAttr('disabled');
    if (response.success) {
      // Maybe redirect or show success message
      console.log('otp request successful');
      if (response.content) {
        jQuery(' #nds_form_feedback ').html('<h2>otp request successful</h2><br>' + response.code + '<br/>' + '<h2>content</h2><br>' + response.content + '<br/>' + '<h2>sms</h2><br>' + response.sms + '<br/>');
      } else {
        jQuery(' #nds_form_feedback ').html('<p>' + response.message + '</p>');
      }

      /*
      jQuery(' #nds_form_feedback ').html(
      '<h2>otp request successful</h2><br>' + response.code
      )
      */
      isOtpSent = true;
      callback();
    } else {
      error = response.message || 'otp request failed';
    }
  }).catch(err => {
    jQuery('#mjkh-otp-request-code').find('input[type="submit"]').removeAttr('disabled');
    jQuery(' #nds_form_feedback ').html("<p style='color:red'>" + err.message + '</p><br>');
    error = 'An error occurred during login';
    console.error(err);
  });
};
const fetchLogin = async () => {
  _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default()({
    path: '/wp/v2/users/login',
    // This would require a custom REST API endpoint or AJAX handler
    method: 'POST',
    data: {
      email: isEmail(emailOrMobile) ? emailOrMobile : null,
      mobile: isMobile(emailOrMobile) ? emailOrMobile : null,
      code: otp
    },
    xhrFields: {
      withCredentials: true // Ensure cookies are included in cross-origin requests
    }
  }).then(response => {
    jQuery('#mjkh-otp-login').find('input[type="submit"]').removeAttr('disabled');
    // Handle successful login
    if (response.success) {
      // Maybe redirect or show success message
      console.log('Login successful');
      jQuery('#mjkh-otp-login').html('<p>' + response.message + '</p>');
      isLoginSuccessful = true;
      window.location.reload();
    } else {
      error = response.message || 'Login failed';
    }
  }).catch(err => {
    jQuery('#mjkh-otp-login').find('input[type="submit"]').removeAttr('disabled');
    error = 'An error occurred during login';
    jQuery(' #nds_form_feedback ').html("<p style='color:red'>" + err.message + '</p><br>');
    //jQuery(' #nds_form_feedback ').append('<p>Something went wrong.</p><br>')

    console.error(err);
  });
};

// Attach the component to a specific block element
document.addEventListener('DOMContentLoaded', () => {
  jQuery(document).ready(function () {
    'use strict';

    /**
     * The file is enqueued from inc/admin/class-admin.php.
     */
    jQuery('#mjkh-otp-request-code').submit(async function (event) {
      event.preventDefault(); // Prevent the default form submit.

      // serialize the form data
      var ajax_form_data = jQuery('#nds_add_user_meta_ajax_form').serialize();
      emailOrMobile = jQuery('#mjkh-otp-request-code').find('[name="emailOrMobile"]').val();
      jQuery('#nds_form_feedback').text('');
      if (!emailOrMobile) {
        jQuery('#nds_form_feedback').text((0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Please Enter A Valid Email Or Mobile', 'mjkh-otp'));
        return;
      }
      jQuery('#mjkh-otp-request-code').find('input[type="submit"]').attr('disabled', true);
      await fetchRequestOtp(() => {
        jQuery('#mjkh-otp-request-code').hide();
        jQuery('#mjkh-otp-login').show();
      });
    });
    jQuery('#mjkh-otp-login').submit(async function (event) {
      event.preventDefault(); // Prevent the default form submit.

      // serialize the form data
      var ajax_form_data = jQuery('#nds_add_user_meta_ajax_form').serialize();
      otp = jQuery('#mjkh-otp-login').find('[name="otp"]').val();
      jQuery('#nds_form_feedback').text('');
      if (!otp) {
        jQuery('#nds_form_feedback').text((0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Please Enter A Valid Code', 'mjkh-otp'));
        return;
      }
      jQuery('#mjkh-otp-login').find('input[type="submit"]').attr('disabled', true);
      await fetchLogin();
    });
  });
});
})();

/******/ })()
;
//# sourceMappingURL=view.js.map