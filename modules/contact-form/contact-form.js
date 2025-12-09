/**
 * Contact Form Module - contact-form.js
 */

(function() {
	'use strict';

	class ContactFormModule {
		constructor() {
			this.init();
		}

		init() {
			this.setupFormHandling();
			this.setupValidation();
		}

		setupFormHandling() {
			const formContainer = document.querySelector('.form-container');
			if ( ! formContainer ) return;

			console.log('Contact form module initialized');
		}

		setupValidation() {
			const forms = document.querySelectorAll('.form-container form');
			if ( forms.length === 0 ) return;

			forms.forEach( form => {
				form.addEventListener( 'submit', this.onFormSubmit.bind( this ) );
			});
		}

		onFormSubmit(e) {
			console.log('Contact form submitted');
			// Add custom validation or tracking here
		}
	}

	// Initialize when document is ready
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', function() {
			new ContactFormModule();
		});
	} else {
		new ContactFormModule();
	}
})();
