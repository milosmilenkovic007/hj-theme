/**
 * Features Module - features.js
 */

(function() {
	'use strict';

	class FeaturesModule {
		constructor() {
			this.init();
		}

		init() {
			this.setupIntersectionObserver();
		}

		setupIntersectionObserver() {
			const featuresSection = document.querySelector('.module-features');
			if ( ! featuresSection ) return;

			const featureItems = featuresSection.querySelectorAll('.feature-item');

			const observer = new IntersectionObserver( (entries) => {
				entries.forEach( (entry, index) => {
					if ( entry.isIntersecting ) {
						setTimeout( () => {
							entry.target.classList.add('fade-in-up');
						}, index * 100 );
					}
				});
			}, { threshold: 0.1 });

			featureItems.forEach( item => observer.observe( item ) );

			console.log('Features module initialized');
		}
	}

	// Initialize when document is ready
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', function() {
			new FeaturesModule();
		});
	} else {
		new FeaturesModule();
	}
})();
