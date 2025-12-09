# HJ Theme - Developer Quick Reference

## 🚀 Quick Start

```bash
# Install dependencies
npm install

# Watch mode (development)
npm run dev

# Production build
npm run build

# Watch SCSS only
npm run sass
```

## 📁 Project Structure

```
hj-theme/
├── inc/                          # Theme functions
│   ├── theme-support.php        # Theme features
│   ├── enqueue-assets.php       # CSS/JS loading
│   ├── acf-flexible-modules.php # Flexible content field
│   ├── acf-theme-settings.php   # Settings panel
│   ├── theme-settings-helpers.php # 30+ helper functions
│   └── acf-page-sections-import.json
├── modules/                      # Flexible content modules
│   ├── hero/
│   ├── cta/
│   ├── features/
│   ├── contact-form/
│   └── testimonials/
├── templates/                    # Page templates
│   ├── landing-page.php
│   └── contact-page.php
├── assets/
│   ├── scss/                     # SCSS source
│   │   ├── base/
│   │   ├── layout/
│   │   ├── modules/
│   │   ├── animations/
│   │   └── theme-settings.scss
│   ├── css/                      # Compiled CSS
│   └── js/                       # Compiled JavaScript
├── styles/                       # Block editor styles
├── patterns/                     # Block patterns (100+)
├── parts/                        # HTML template parts
├── examples/                     # Example code
└── Documentation files
```

## 🏗️ Creating a New Module

1. **Create folder structure:**
```bash
mkdir -p modules/my-module
```

2. **Create files:**
   - `modules/my-module/my-module.php` - Rendering
   - `modules/my-module/my-module.json` - ACF config
   - `modules/my-module/my-module.js` - JavaScript (optional)

3. **Register in `inc/acf-flexible-modules.php`:**
```php
array(
    'key' => 'layout_hj_my_module',
    'name' => 'my-module',
    'label' => 'My Module',
    'display' => 'block',
    'sub_fields' => array(
        array(
            'key' => 'field_my_title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'text',
        ),
        // ... more fields
    ),
),
```

4. **Build assets:**
```bash
npm run build
```

## 📝 Module Template Example

```php
<?php
// modules/my-module/my-module.php
$title = get_sub_field( 'title' );
$description = get_sub_field( 'description' );
?>

<section class="my-module">
    <h2><?php echo esc_html( $title ); ?></h2>
    <p><?php echo wp_kses_post( $description ); ?></p>
</section>

<style>
.my-module {
    padding: var(--spacing-lg);
}
</style>
```

## 🎨 Using Theme Settings

```php
<?php
// Get theme settings
$primary_color = get_theme_primary_color();
$logo = get_header_logo();
$social = get_social_links();

// Generic getter
$custom = get_theme_setting( 'field_name' );
?>
```

## 🎯 Available Helper Functions

### Header
- `get_header_logo()` - Header logo image ID
- `get_header_nav_position()` - Logo position (left/right)
- `get_header_bg_color()` - Header background color
- `get_header_text_color()` - Header text color
- `get_header_sticky()` - Sticky header enabled?

### Footer
- `get_footer_logo()` - Footer logo image ID
- `get_footer_copyright()` - Copyright text
- `get_footer_bg_color()` - Background color
- `get_footer_text_color()` - Text color
- `get_footer_description()` - Footer description

### Typography
- `get_theme_font_primary()` - Primary font
- `get_theme_font_heading()` - Heading font
- `get_theme_font_size_base()` - Base font size
- `get_theme_line_height()` - Line height

### Colors
- `get_theme_primary_color()` - Primary brand color
- `get_theme_secondary_color()` - Secondary color
- `get_theme_accent_color()` - Accent color
- `get_theme_text_color()` - Text color
- `get_theme_bg_color()` - Background color

### Social
- `get_social_links()` - Array of social links
- `get_social_link_by_name( 'facebook' )` - Specific link

### SEO
- `get_seo_meta_description()` - Meta description
- `get_seo_og_image()` - OG image
- `get_seo_og_title()` - OG title
- `get_seo_twitter_card()` - Twitter card type

### Generic
- `get_theme_setting( 'field_name' )` - Any setting value
- `get_theme_setting( 'field_name', 'option' )` - From options page

## 🎨 SCSS Utilities

### Variables
```scss
// Colors
$color-primary: #FF6B6B;
$color-secondary: #4ECDC4;
$color-text: #333;
$color-bg: #fff;

// Fonts
$font-family-base: 'Inter', sans-serif;
$font-family-heading: 'Poppins', sans-serif;

// Spacing
$spacing-xs: 0.25rem;
$spacing-sm: 0.5rem;
$spacing-md: 1rem;
$spacing-lg: 1.5rem;
$spacing-xl: 2rem;
$spacing-xxl: 3rem;

// Breakpoints
$breakpoint-xs: 320px;
$breakpoint-sm: 576px;
$breakpoint-md: 768px;
$breakpoint-lg: 992px;
$breakpoint-xl: 1200px;
$breakpoint-xxl: 1400px;
```

### Mixins
```scss
// Media queries
@include media-sm { /* mobile first */ }
@include media-md { }
@include media-lg { }

// Flex utilities
@include flex-center;      // Flex + align + justify center
@include flex-between;     // Space between
@include flex-column;      // Flex column

// Text utilities
@include text-truncate;    // Single line ellipsis
@include text-clamp( $lines ); // Multi-line truncate

// Effects
@include transition();     // Smooth animation
@include shadow-sm;        // Small shadow
@include shadow-lg;        // Large shadow
```

## 🔄 ACF Functions in Templates

```php
<?php
// Flexible content
if ( have_rows( 'page_sections' ) ) {
    while ( have_rows( 'page_sections' ) ) {
        the_row();
        $layout = get_row_layout();
        $field = get_sub_field( 'field_name' );
    }
}

// Repeater
if ( have_rows( 'repeater_name' ) ) {
    while ( have_rows( 'repeater_name' ) ) {
        the_row();
        $item = get_sub_field( 'item' );
    }
}

// Options
$value = get_field( 'field_name', 'option' );
?>
```

## 🐛 Debugging

```php
<?php
// Log variable to console
error_log( json_encode( $variable ) );

// Debug ACF fields
error_log( print_r( get_fields( $post_id ), true ) );

// Check if field exists
if ( function_exists( 'get_field' ) ) {
    $value = get_field( 'field_name' );
}

// WordPress debug mode
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
?>
```

## 📦 Build Commands

```bash
# Production build (minified)
npm run build

# Development mode with file watching
npm run dev

# Watch SCSS only
npm run sass

# Watch JavaScript only
npm run js
```

## 🚀 Performance Tips

1. **Use lazy loading** for images:
```php
wp_get_attachment_image( $id, 'large', false, array(
    'loading' => 'lazy',
) );
```

2. **Optimize CSS** - Only include what you use
3. **Minify assets** - Use production build
4. **Cache ACF fields** - Use `wp_cache_*` functions
5. **Defer JavaScript** - Scripts are deferred by default

## 📱 Responsive Breakpoints

```scss
// Mobile first approach
.element {
    // Mobile styles (320px+)
    font-size: 16px;

    @include media-sm { /* 576px+ */ }
    @include media-md { /* 768px+ */ }
    @include media-lg { /* 992px+ */ }
    @include media-xl { /* 1200px+ */ }
}
```

## 🎯 Common Tasks

### Add Custom Style to Module
```scss
// assets/scss/modules/_my-module.scss
.my-module {
    padding: var(--spacing-lg);
    background: var(--primary-color);
    
    h2 {
        color: white;
        font-size: 2rem;
    }
}

// Import in main.scss
@import 'modules/my-module';
```

### Add Custom Font
```php
// inc/enqueue-assets.php
wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap' );
```

### Add Custom JavaScript
```js
// assets/js/modules/my-module.js
class MyModule {
    constructor() {
        this.init();
    }
    
    init() {
        console.log( 'My module initialized' );
    }
}

new MyModule();
```

## 🔐 Security

- Always use `esc_html()` for text output
- Use `esc_url()` for URLs
- Use `esc_attr()` for HTML attributes
- Use `wp_kses_post()` for rich HTML content
- Sanitize input with `sanitize_*()` functions

## 📚 Useful Links

- [ACF Pro Documentation](https://www.advancedcustomfields.com/resources/)
- [WordPress Theme Handbook](https://developer.wordpress.org/themes/)
- [SCSS Documentation](https://sass-lang.com/documentation)
- [Webpack Documentation](https://webpack.js.org/concepts/)

## 💡 Tips

- Use CSS variables for dynamic values
- Keep modules independent and reusable
- Test responsive design on real devices
- Use developer tools to debug
- Minify production assets
- Document your code with comments

---

**Need more help?** Check out:
- `FLEXIBLE-CONTENT-SETUP.md` - Complete page building guide
- `ACF-SETUP.md` - ACF configuration
- `SETUP.md` - Complete setup instructions
