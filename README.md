# HJ Theme

Professional modular WordPress theme with ACF Pro integration and advanced flexible content system.

## Features

- **Modular Architecture**: Each section is a separate module with its own PHP, JSON config, and JavaScript
- **ACF Flexible Content**: Drag-and-drop page builder with 5 pre-built modules (Hero, CTA, Features, Contact Form, Testimonials)
- **Theme Settings Panel**: Comprehensive ACF settings for typography, colors, social links, SEO, etc.
- **SCSS Compilation**: Modern SCSS with variables, mixins, and organized structure
- **JavaScript Modules**: ES6 module-based JavaScript with Intersection Observer for animations
- **Responsive Design**: Mobile-first approach with breakpoint mixins
- **Professional Structure**: Clean, organized folder structure
- **Helper Functions**: 30+ helper functions for easy access to theme settings

## Folder Structure

```
hj-theme/
├── assets/
│   ├── css/              # Compiled CSS files
│   ├── js/               # Compiled JavaScript files
│   ├── images/           # Theme images
│   ├── fonts/            # Custom fonts
│   └── scss/             # SCSS source files
│       ├── base/
│       ├── layout/
│       ├── modules/
│       ├── animations/
│       └── theme-settings.scss
├── modules/              # ACF flexible content modules
│   ├── hero/
│   │   ├── hero.php
│   │   ├── hero.json
│   │   └── hero.js
│   ├── cta/
│   ├── features/
│   ├── contact-form/
│   └── testimonials/
├── templates/            # Page templates
│   ├── landing-page.php
│   └── contact-page.php
├── parts/               # Template parts
│   ├── header.html
│   ├── footer.html
│   └── sidebar.html
├── patterns/            # Block patterns (100+ included)
├── styles/              # WordPress block editor styles
├── inc/                 # Include files
│   ├── theme-support.php
│   ├── enqueue-assets.php
│   ├── acf-flexible-modules.php (ACF Flexible Content Registration)
│   ├── acf-theme-settings.php
│   ├── theme-settings-helpers.php
│   └── acf-page-sections-import.json
├── functions.php        # Theme main file
├── index.php           # Default template
├── header.php          # Header template
├── footer.php          # Footer template
├── style.css           # Theme header
├── theme.json          # WordPress block editor config
├── package.json        # NPM dependencies
├── webpack.config.js   # Webpack configuration
├── README.md           # This file
├── SETUP.md            # Detailed setup guide
├── ACF-SETUP.md        # ACF configuration guide
├── FLEXIBLE-CONTENT-SETUP.md (NEW - Flexible content guide)
└── .gitignore         # Git ignore rules
```

## Pre-Built Modules

### 1. **Hero Section**
- Large hero banner with title, subtitle, image
- Call-to-action button with custom link
- Customizable background color
- Perfect for homepage introductions

### 2. **Call To Action (CTA)**
- Promotional section with heading and description
- Button with 3 style options (primary, secondary, outline)
- Customizable background and text colors
- Great for promotions, offers, and announcements

### 3. **Features Section**
- Display features in 2, 3, or 4 columns
- Icon + title + description for each feature
- Unlimited features via repeater field
- Responsive grid layout

### 4. **Contact Form**
- Integration with Fluent Forms
- Just add form ID - theme handles the rest
- Customizable background color
- Form title and description

### 5. **Testimonials Section**
- Display unlimited customer testimonials
- Author image, name, title, and rating
- Star rating (1-5)
- Social proof section for conversions

## Quick Start Guide

### Installation

1. Copy theme to `/wp-content/themes/hj-theme/`
2. Activate theme in WordPress admin: **Themes** → **hj-theme** → **Activate**
3. Install ACF Pro plugin (required)
4. Install dependencies: `npm install`

### Building Assets

```bash
# Watch SCSS and JavaScript files for changes (development)
npm run dev

# Build production assets (minified)
npm run build

# Watch only SCSS changes
npm run sass
```

### Creating Pages With Flexible Content

1. Create a new **Page** in WordPress
2. Choose template: **Landing Page** or **Contact Page**
3. Scroll to **"Page Sections"** panel
4. Click **"Add Section"** button
5. Select module type (Hero, CTA, Features, etc.)
6. Fill in the fields
7. Reorder sections by drag-and-drop
8. Publish/Update the page

### Adding Custom Modules

See **FLEXIBLE-CONTENT-SETUP.md** for detailed instructions on adding new modules.

# Build SCSS only (no source maps)
npm run sass:build
```

## Modules Included

### 1. Hero Module
- Title, subtitle, description
- Background image
- CTA button
- Customizable background color

### 2. CTA (Call To Action) Module
- Heading and description
- Button with multiple styles (primary, secondary, outline)
- Background and text color customization
- Intersection observer animation

### 3. Features Module
- Multiple columns (2, 3, or 4)
- Icon, title, and description per feature
- Hover animations
- Responsive grid

### 4. Contact Form Module
- Supports Fluent Forms
- Heading and description
- Background color customization

### 5. Testimonials Module
- Repeater field for testimonials
- Author image, name, title
- Star rating system
- Auto-sliding carousel

## Requirements

- **WordPress**: 6.0 or higher
- **PHP**: 7.4 or higher
- **ACF Pro**: Required for flexible content and theme settings
- **Node.js**: 14+ (for building assets)

## ACF Setup (Automatic)

The theme **automatically registers** the flexible content field group on activation:

✅ `page_sections` field is created automatically
✅ All 5 modules are registered as layouts
✅ Field configuration is done via PHP (no manual setup needed)

If you ever need to re-import the field group manually:
1. Go to **ACF** → **Tools** → **Import Field Groups**
2. Upload: `inc/acf-page-sections-import.json`
3. Click **Import**

See **FLEXIBLE-CONTENT-SETUP.md** for complete documentation.

## Styling

All styles are written in SCSS with:
- Color variables from theme settings
- Responsive mixins for all breakpoints
- Animation utilities
- Component-based organization
- CSS custom properties (CSS variables) for dynamic theming

### Variables Available

- Colors: `$color-primary`, `$color-secondary`, etc.
- Typography: `$font-family-base`, `$font-family-heading`
- Spacing: `$spacing-xs` through `$spacing-xxl`
- Breakpoints: `$breakpoint-xs` through `$breakpoint-xxl`

### Dynamic CSS From Theme Settings

The file `assets/scss/theme-settings.scss` automatically generates CSS variables from ACF theme settings:

```scss
:root {
    --primary-color: #FF6B6B;
    --secondary-color: #4ECDC4;
    --heading-font: 'Poppins', sans-serif;
    /* ... more from theme settings ... */
}
```

Use them in your SCSS:
```scss
.btn-primary {
    background-color: var(--primary-color);
}
```

## JavaScript

Each module can have its own JavaScript class for initialization and interactions. Scripts are automatically initialized on DOM ready and support:

- Intersection Observer API for animations
- Event delegation for performance
- Modern ES6 syntax with Webpack transpilation

## Helper Functions

The theme includes **30+ helper functions** in `inc/theme-settings-helpers.php` for easy access to theme settings:

```php
// Get theme setting value
get_theme_setting( 'setting_name' );

// Get header settings
get_header_logo();
get_header_nav_position();
get_header_bg_color();

// Get footer settings
get_footer_copyright();
get_footer_bg_color();

// Get typography
get_theme_font_primary();
get_theme_font_heading();

// Get colors
get_theme_primary_color();
get_theme_secondary_color();

// Get social links
get_social_links();

// Get SEO settings
get_seo_meta_description();
get_seo_og_image();
```

See `inc/theme-settings-helpers.php` for the complete list.

## Documentation Files

- **README.md** (this file) - Overview and quick start
- **SETUP.md** - Detailed installation and configuration
- **FLEXIBLE-CONTENT-SETUP.md** - Complete guide to page building with modules
- **ACF-SETUP.md** - ACF configuration and troubleshooting
- **ACF-THEME-SETTINGS.md** - Theme settings panel documentation
- **ACF-THEME-SETTINGS-SETUP.md** - Theme settings setup guide

## Troubleshooting

### Modules not appearing in ACF?
- Ensure ACF Pro is activated
- Refresh the page (Ctrl+R or Cmd+R)
- Check browser console for JavaScript errors
- See **FLEXIBLE-CONTENT-SETUP.md** → "Tipske Greške"

### Styles not compiling?
- Run `npm install` to install dependencies
- Run `npm run build` to compile
- Check for SCSS syntax errors in terminal output

### JavaScript not working?
- Ensure assets are properly enqueued: Check `inc/enqueue-assets.php`
- Check browser console for JavaScript errors
- Verify `assets/js/main.js` is loading

## Support & Customization

This theme is designed to be easily customizable. To extend functionality:

1. Add new modules by creating `modules/new-name/` folder
2. Register them in `inc/acf-flexible-modules.php`
3. Add SCSS to `assets/scss/modules/`
4. Add JavaScript to `assets/js/`
5. Run `npm run build` to compile

## License

GPL v2 or later

