/**
 * Testimonials Module - testimonials.js
 */

(function() {
	'use strict';

	class TestimonialsModule {
		constructor() {
			this.currentIndex = 0;
			this.init();
		}

		init() {
			this.setupSlider();
			this.setupControls();
		}

		setupSlider() {
			const slider = document.querySelector('.testimonials-slider');
			if ( ! slider ) return;

			const items = slider.querySelectorAll('.testimonial-item');
			this.totalItems = items.length;

			if ( this.totalItems > 1 ) {
				this.startAutoPlay();
			}

			console.log('Testimonials module initialized with ' + this.totalItems + ' items');
		}

		setupControls() {
			const slider = document.querySelector('.testimonials-slider');
			if ( ! slider ) return;

			// Add custom controls here (prev/next buttons, dots, etc.)
		}

		startAutoPlay() {
			this.autoPlayInterval = setInterval( () => {
				this.nextSlide();
			}, 5000 ); // Change slide every 5 seconds
		}

		nextSlide() {
			this.currentIndex = ( this.currentIndex + 1 ) % this.totalItems;
			this.updateSlider();
		}

		updateSlider() {
			const slider = document.querySelector('.testimonials-slider');
			if ( ! slider ) return;

			const items = slider.querySelectorAll('.testimonial-item');
			items.forEach( (item, index) => {
				item.classList.remove( 'active' );
				if ( index === this.currentIndex ) {
					item.classList.add( 'active' );
				}
			});
		}
	}

	// Initialize when document is ready
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', function() {
			new TestimonialsModule();
		});
	} else {
		new TestimonialsModule();
	}
})();
