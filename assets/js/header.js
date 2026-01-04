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

	const resetMobileSubmenus = () => {
		const openItems = mobileMenu.querySelectorAll('li.is-submenu-open');
		openItems.forEach((li) => li.classList.remove('is-submenu-open'));
		const toggles = mobileMenu.querySelectorAll('button.submenu-toggle[aria-expanded="true"]');
		toggles.forEach((btn) => btn.setAttribute('aria-expanded', 'false'));
	};

	const enhanceMobileSubmenus = () => {
		const items = mobileMenu.querySelectorAll('li.menu-item-has-children');
		items.forEach((li, index) => {
			const submenu = li.querySelector(':scope > ul.sub-menu');
			const link = li.querySelector(':scope > a');
			if (!submenu || !link) return;
			if (li.querySelector(':scope > button.submenu-toggle')) return;

			const existingId = submenu.getAttribute('id');
			const submenuId = existingId && existingId.trim() ? existingId : `mobile-submenu-${index}-${Math.random().toString(36).slice(2, 8)}`;
			submenu.setAttribute('id', submenuId);

			const btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'submenu-toggle';
			btn.setAttribute('aria-expanded', 'false');
			btn.setAttribute('aria-controls', submenuId);
			btn.setAttribute('aria-label', 'Toggle submenu');

			// Insert toggle between the parent link and submenu.
			li.insertBefore(btn, submenu);

			btn.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();

				// Close other open submenus in the mobile menu.
				mobileMenu.querySelectorAll('li.is-submenu-open').forEach((openLi) => {
					if (openLi === li) return;
					openLi.classList.remove('is-submenu-open');
					const openBtn = openLi.querySelector(':scope > button.submenu-toggle');
					if (openBtn) openBtn.setAttribute('aria-expanded', 'false');
				});

				const isOpen = li.classList.toggle('is-submenu-open');
				btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
			});
		});
	};

	enhanceMobileSubmenus();

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
			resetMobileSubmenus();
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
			resetMobileSubmenus();
			document.body.style.overflow = '';
		});
	});

	// Close menu when pressing Escape
	document.addEventListener('keydown', function(e) {
		if (e.key === 'Escape' && menuToggle.getAttribute('aria-expanded') === 'true') {
			menuToggle.setAttribute('aria-expanded', 'false');
			menuToggle.classList.remove('active');
			mobileMenu.classList.remove('active');
			resetMobileSubmenus();
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
			resetMobileSubmenus();
			document.body.style.overflow = '';
		}
	});
});
