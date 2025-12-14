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

		// Video play button functionality
		const videoWrappers = heroSection.querySelectorAll('.video-wrapper');
		videoWrappers.forEach(wrapper => {
			const playButton = wrapper.querySelector('.video-play-button');
			if (playButton) {
				playButton.addEventListener('click', (e) => {
					e.preventDefault();
					this.playVideo(wrapper);
				});
			}
		});
	}

	playVideo(wrapper) {
		const videoId = wrapper.getAttribute('data-video-id');
		if (!videoId) return;

		// Create iframe
		const iframe = document.createElement('iframe');
		iframe.setAttribute('width', '560');
		iframe.setAttribute('height', '315');
		iframe.setAttribute('src', `https://www.youtube.com/embed/${videoId}?autoplay=1`);
		iframe.setAttribute('title', 'YouTube video player');
		iframe.setAttribute('frameborder', '0');
		iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
		iframe.setAttribute('allowfullscreen', '');

		// Replace thumbnail and button with iframe
		wrapper.innerHTML = '';
		wrapper.appendChild(iframe);
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
