/**
 * Hero Module - hero.js
 */

(function() {
	'use strict';

	class HeroModule {
		constructor() {
			this.init();
		}

		init() {
			this.setupEventListeners();
			this.setupAnimations();
		}

		setupEventListeners() {
			const heroSection = document.querySelector('.module-hero');
			if ( ! heroSection ) return;

			// Add your event listeners here
			console.log('Hero module initialized');
		}

		setupAnimations() {
			const heroText = document.querySelector('.hero-text');
			const heroImage = document.querySelector('.hero-image');

			if ( heroText ) {
				heroText.classList.add('fade-in');
			}

			if ( heroImage ) {
				heroImage.classList.add('fade-in-delayed');
			}
		}
	}

	// Initialize when document is ready
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', function() {
			new HeroModule();
		});
	} else {
		new HeroModule();
	}
})();
