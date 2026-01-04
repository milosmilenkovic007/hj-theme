/**
 * Header Menu Toggle Functionality
 */
document.addEventListener('DOMContentLoaded', function() {
	const headerEl = document.getElementById('masthead') || document.querySelector('.site-header');
	const setScrolledState = () => {
		if (!headerEl) return;
		headerEl.classList.toggle('scrolled', window.scrollY > 0);
	};

	setScrolledState();
	window.addEventListener('scroll', setScrolledState, { passive: true });

	const menuToggle = document.getElementById('header-menu-toggle');
	const mobileMenu = document.getElementById('header-mobile-menu');

	if (!menuToggle || !mobileMenu) {
		return;
	}

	// Toggle menu on button click
	menuToggle.addEventListener('click', function(e) {
		e.preventDefault();
		const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
		
		menuToggle.setAttribute('aria-expanded', !isExpanded);
		menuToggle.classList.toggle('active');
		mobileMenu.classList.toggle('active');

		// Prevent body scroll when menu is open
		if (!isExpanded) {
			document.body.style.overflow = 'hidden';
		} else {
			document.body.style.overflow = '';
		}
	});

	// Close menu when clicking on a link
	const menuLinks = mobileMenu.querySelectorAll('a');
	menuLinks.forEach(link => {
		link.addEventListener('click', function() {
			menuToggle.setAttribute('aria-expanded', 'false');
			menuToggle.classList.remove('active');
			mobileMenu.classList.remove('active');
			document.body.style.overflow = '';
		});
	});

	// Close menu when pressing Escape
	document.addEventListener('keydown', function(e) {
		if (e.key === 'Escape' && menuToggle.getAttribute('aria-expanded') === 'true') {
			menuToggle.setAttribute('aria-expanded', 'false');
			menuToggle.classList.remove('active');
			mobileMenu.classList.remove('active');
			document.body.style.overflow = '';
		}
	});

	// Close menu when clicking outside
	document.addEventListener('click', function(e) {
		const header = document.querySelector('.site-header');
		if (!header.contains(e.target) && menuToggle.getAttribute('aria-expanded') === 'true') {
			menuToggle.setAttribute('aria-expanded', 'false');
			menuToggle.classList.remove('active');
			mobileMenu.classList.remove('active');
			document.body.style.overflow = '';
		}
	});
});
