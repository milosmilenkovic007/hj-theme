/**
 * CTA Module - cta.js
 */

(function() {
	'use strict';

	class CTAModule {
		constructor() {
			this.init();
		}

		init() {
			this.setupEventListeners();
			this.setupIntersectionObserver();
		}

		setupEventListeners() {
			const ctaSection = document.querySelector('.module-cta');
			if ( ! ctaSection ) return;

			const button = ctaSection.querySelector('.btn');
			if ( button ) {
				button.addEventListener( 'click', this.onButtonClick.bind( this ) );
			}

			console.log('CTA module initialized');
		}

		setupIntersectionObserver() {
			const ctaSection = document.querySelector('.module-cta');
			if ( ! ctaSection ) return;

			const observer = new IntersectionObserver( (entries) => {
				entries.forEach( entry => {
					if ( entry.isIntersecting ) {
						ctaSection.classList.add('in-view');
					}
				});
			}, { threshold: 0.1 });

			observer.observe( ctaSection );
		}

		onButtonClick(e) {
			console.log('CTA button clicked');
			// Add custom analytics or event tracking here
		}
	}

	// Initialize when document is ready
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', function() {
			new CTAModule();
		});
	} else {
		new CTAModule();
	}
})();
