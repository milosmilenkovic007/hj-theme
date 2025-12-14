# Custom Theme - Setup Praktični Vodič

## 🚀 Brzi Početak

### 1. Aktivacija Teme

1. Idite u WordPress Admin → Izgled → Teme
2. Pronađite "Custom Theme"
3. Kliknite "Aktiviraj"

### 2. Instalacija Zavisnosti

```bash
cd wp-content/themes/custom-theme
npm install
```

### 3. Build Assets

```bash
# SCSS → CSS (Watch mode)
npm run sass

# JavaScript kompajliranje (Watch mode)
npm run dev

# Production build
npm run build
```

---

## 📁 Struktura Projekta

```
custom-theme/
├── 📄 functions.php              # Main theme file
├── 📄 index.php                  # Default template
├── 📄 header.php                 # Header template
├── 📄 footer.php                 # Footer template
├── 📄 style.css                  # Theme header info
├── 📄 theme.json                 # WordPress theme.json config
├── 📄 package.json               # NPM dependencies
├── 📄 webpack.config.js          # Webpack konfiguracija
├── 📄 README.md                  # Project documentation
├── 📄 ACF-SETUP.md              # ACF configuration guide
├── 📄 SETUP.md                   # This file
│
├── 📁 assets/
│   ├── css/
│   │   └── main.css             # Compiled CSS
│   ├── js/
│   │   └── main.js              # Compiled JavaScript
│   ├── images/                  # Image assets
│   └── scss/                    # SCSS source files
│       ├── variables.scss
│       ├── mixins.scss
│       ├── main.scss
│       ├── base/
│       │   ├── reset.scss
│       │   ├── typography.scss
│       │   └── colors.scss
│       ├── layout/
│       │   ├── container.scss
│       │   ├── grid.scss
│       │   └── buttons.scss
│       ├── modules/
│       │   ├── hero.scss
│       │   ├── cta.scss
│       │   ├── features.scss
│       │   ├── contact-form.scss
│       │   └── testimonials.scss
│       └── animations/
│           ├── fade-in.scss
│           └── transitions.scss
│
├── 📁 modules/                  # ACF Flexible Modules
│   ├── hero/
│   │   ├── hero.php            # Module template
│   │   ├── hero.json           # ACF field config
│   │   └── hero.js             # Module JavaScript
│   ├── cta/
│   │   ├── cta.php
│   │   ├── cta.json
│   │   └── cta.js
│   ├── features/
│   │   ├── features.php
│   │   ├── features.json
│   │   └── features.js
│   ├── contact-form/
│   │   ├── contact-form.php
│   │   ├── contact-form.json
│   │   └── contact-form.js
│   └── testimonials/
│       ├── testimonials.php
│       ├── testimonials.json
│       └── testimonials.js
│
├── 📁 templates/                # Page templates
│   ├── landing-page.php        # Landing page template
│   └── contact-page.php        # Contact page template
│
├── 📁 parts/                    # Template parts
│   └── navigation.php           # Navigation menu
│
└── 📁 inc/                      # Include files
    ├── theme-support.php        # Theme features & support
    ├── enqueue-assets.php       # Asset loading
    └── acf-flexible-modules.php # ACF module registration
```

---

## 🛠️ Razvoj

### SCSS Development

SCSS fajlovi su organizovani u sekcije:

```scss
// Koristi varijable
$color-primary: #007bff;
$spacing-md: 1rem;

// Koristi mixins
@include media-lg {
    font-size: 2rem;
}

@include flex-center {
    // centered content
}
```

### JavaScript Development

Svaki modul ima vlastitu JavaScript klasu:

```javascript
class HeroModule {
    constructor() {
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.setupAnimations();
    }
    
    setupEventListeners() {
        // Event listeners code
    }
    
    setupAnimations() {
        // Animation code
    }
}

// Initialize
new HeroModule();
```

### Dodavanje Novog Modula

1. **Kreirajte folder:**
   ```bash
   mkdir modules/my-module
   ```

2. **Kreirajte tri fajla:**
   - `my-module.php` - Template
   - `my-module.json` - ACF fields
   - `my-module.js` - JavaScript (opciono)

3. **my-module.php:**
   ```php
   <?php
   $field_value = get_sub_field( 'field_name' );
   ?>
   <section class="module module-my-module">
       <div class="container">
           <!-- Content -->
       </div>
   </section>
   ```

4. **my-module.json:**
   ```json
   {
       "name": "my-module",
       "label": "My Module",
       "display": "block",
       "sub_fields": [
           {
               "key": "field_name",
               "label": "Field Label",
               "name": "field_name",
               "type": "text"
           }
       ]
   }
   ```

5. **Registrujte u `inc/acf-flexible-modules.php`**

---

## 📋 Dostupni Moduli

### 1. Hero Module
**Korišćenje:** Veliki intro/banner sekcije
- Naslov, podnaslov, opis
- Slika
- CTA dugme
- Boja pozadine

### 2. CTA (Call To Action)
**Korišćenje:** Call-to-action sekcije
- Naslov i opis
- Dugme (primary, secondary, outline)
- Boje (pozadina, tekst)

### 3. Features
**Korišćenje:** Prikaz mogućnosti/prednosti
- Naslov i opis
- Broj kolona (2, 3, 4)
- Ikonice i opisi

### 4. Contact Form
**Korišćenje:** Kontakt forme
- Podrška za Fluent Forms
- Naslov i opis
- Boja pozadine

### 5. Testimonials
**Korišćenje:** Recenzije/iskazi
- Tekst iskaza
- Slika, ime, funkcija autora
- Ocena (★)
- Auto-slide carousel

---

## 🎨 Prilagođavanje

### Boje

Uređujte u `assets/scss/variables.scss`:

```scss
$color-primary: #007bff;      // Glavna boja
$color-secondary: #6c757d;    // Sekundarna
$color-success: #28a745;      // Uspeh
$color-danger: #dc3545;       // Greška
```

### Tipografija

```scss
$font-family-base: 'Your Font';
$font-family-heading: 'Your Heading Font';
$font-size-base: 16px;
$line-height-base: 1.6;
```

### Spacing

```scss
$spacing-xs: 0.25rem;
$spacing-sm: 0.5rem;
$spacing-md: 1rem;
$spacing-lg: 1.5rem;
$spacing-xl: 2rem;
$spacing-xxl: 3rem;
```

### Breakpoints

```scss
$breakpoint-sm: 576px;
$breakpoint-md: 768px;
$breakpoint-lg: 992px;
$breakpoint-xl: 1200px;
```

Korišćenje:
```scss
@include media-lg {
    // Styles za large screens
}
```

---

## 🔧 Konfiguracija ACF

Detaljne upute u **ACF-SETUP.md** fajlu.

### Brzi Start:

1. Idite u WordPress Admin → Custom Fields
2. Dodajte novu Field Group
3. Dodajte "page_sections" flexible content field
4. Dodajte module kao layouts

---

## 📦 Build Sistemi

### NPM Scripts

```bash
npm run sass         # Watch SCSS fajlove
npm run sass:build   # Build SCSS (production)
npm run dev          # Watch JavaScript
npm run build        # Build JavaScript (production)
```

### Webpack

`webpack.config.js` je konfiguriran za:
- ES6 transpilaciju (Babel)
- SCSS kompajliranje
- Source maps (development)
- Production optimization

---

## 🌐 WordPress Compatibility

- ✅ Tema je potpuno kompatibilna sa ACF Pro
- ✅ Podrška za theme.json (WordPress 5.8+)
- ✅ Full-width teme feature
- ✅ Gutenberg editor compatible
- ✅ Mobile responsive

---

## 🚢 Deployment

### Pre-deployment Checklist:

```bash
# 1. Install dependencies
npm install

# 2. Build production assets
npm run build
npm run sass:build

# 3. Remove node_modules and lock files
rm -rf node_modules package-lock.json

# 4. Ensure .gitignore is in place
# Sadrži: node_modules/, *.map, build files
```

### Production Branches:

U production okruženju, uključite samo:
- `/modules/` (PHP, JSON)
- `/assets/css/` i `/assets/js/` (kompajlirani fajlovi)
- `/templates/`, `/parts/`, `/inc/`
- PHP fajlovi
- Tekst fajlovi

Ne uključujte:
- `/node_modules/`
- SCSS source fajlove
- Source maps
- `.gitignore`

---

## 🐛 Troubleshooting

### Problem: SCSS se ne kompajlira
```bash
npm install sass --save-dev
npm run sass:build
```

### Problem: CSS se ne učitava
1. Očistite WordPress cache
2. Provjerite enqueue u `inc/enqueue-assets.php`
3. Proverite file paths

### Problem: JavaScript se ne inicijalizuje
1. Proverite browser console za greške
2. Provjerite da li su modulscript tagovi na dnu HTML-a
3. Koristite `npm run dev` za debugging

### Problem: ACF polja se ne prikazuju
1. Aktivirajte ACF Pro plugin
2. Idite u Custom Fields → importe fajlove
3. Provjerite Field Group lokacija

---

## 📚 Dodatni Resursi

- [WordPress Theme Development](https://developer.wordpress.org/themes/)
- [ACF Pro Documentation](https://www.advancedcustomfields.com/resources/)
- [SCSS Guide](https://sass-lang.com/guide)
- [Webpack Documentation](https://webpack.js.org/)

---

## 💡 Najbolje Prakse

1. **Modularnost:** Čuvajte module male i fokusirane
2. **Dokumentacija:** Dokumentujte custom polja i funkcije
3. **Performance:** Koristite intersection observer za lazy loading
4. **Accessibility:** Uvek koristite semantic HTML
5. **Testing:** Test na mobilnim uređajima pre nego što deploy-ujete
6. **Git:** Komitujte često sa jasnim porukama

---

## 📞 Podrška

Za probleme ili pitanja, pregledajte:
- `README.md` - Project overview
- `ACF-SETUP.md` - ACF konfiguracija
- Kod u `/modules/` - Primeri implementacije

---

**Verzija:** 1.0.0  
**Poslednja ažuriranja:** 2025  
**Kompatibilnost:** WordPress 5.8+, PHP 7.4+
