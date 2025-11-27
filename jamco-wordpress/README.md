# Jamco WordPress Implementation

WordPress implementation of the Jamco Premium Seating page, replicating the Sanity/Astro content block approach.

## Status: ✅ Ready for Testing

The WordPress theme is fully built and functional. All components from the Sanity/Astro build have been ported to WordPress ACF blocks.

## Quick Start

### Starting the Environment

```bash
cd jamco-wordpress
npm run start  # Starts wp-env on http://localhost:8888
```

### Login Credentials

- **Site URL**: http://localhost:8888
- **Admin URL**: http://localhost:8888/wp-admin
- **Username**: admin
- **Password**: password

### Stopping the Environment

```bash
npm run stop   # Stops wp-env
```

## What's Built

### ✅ Complete

1. **WordPress Environment**
   - wp-env configuration (Docker-based)
   - WordPress 6.4+ with PHP 8.1+
   - ACF plugin installed and activated
   - Jamco custom theme activated

2. **Theme Structure**
   - Custom theme with full design system port
   - Header with logo, navigation, and breadcrumbs
   - Footer template
   - Product custom post type with taxonomy

3. **Design System**
   - Complete CSS port from Astro
   - design-tokens.css (all color, typography, spacing variables)
   - global.css (base styles, resets, utilities)
   - blocks.css (all block-specific styles)
   - Identical styling to Astro build

4. **ACF Blocks** (7 blocks total)
   - **Hero Block** - Hero section with heading, image, and dual CTAs
   - **Section Intro** - Eyebrow, heading, and description
   - **Feature Grid** - 3-column feature showcase with images
   - **Split Feature** - Content/image split with background variants
   - **Product Carousel** - Product showcase with relationship to Product CPT
   - **Testimonial** - Customer quote with author details
   - **CTA Block** - Call-to-action with background image overlay

5. **ACF Field Groups**
   - All field groups registered programmatically
   - Complete field definitions matching Sanity schemas
   - Relationship fields for Products
   - Group fields for CTAs
   - Repeater fields for Feature Grid
   - Color pickers and image fields configured

6. **Sample Content**
   - Premium Seating page created
   - 3 sample products created:
     - ZODIAC Cirrus IV
     - Premium Economy Seating
     - Business Class Suite

## Architecture

### Block System

Each block follows this structure:

```
theme/
├── blocks/
│   ├── hero.php              # Block template (rendering)
│   ├── section-intro.php
│   ├── feature-grid.php
│   └── ...
├── inc/
│   └── acf-field-groups.php  # Field definitions (data structure)
└── functions.php             # Block registration
```

### How It Works

1. **functions.php** - Registers blocks with ACF using `acf_register_block_type()`
2. **inc/acf-field-groups.php** - Defines fields for each block using `acf_add_local_field_group()`
3. **blocks/*.php** - PHP templates that render block content using `get_field()`
4. **assets/css/blocks.css** - Styling for all blocks

### Comparison with Sanity/Astro

| Sanity/Astro | WordPress/ACF |
|--------------|---------------|
| Sanity schema | ACF field group |
| Sanity document | WordPress page/post |
| Astro component | ACF block template |
| Content API | WordPress API |
| Portable Text | WYSIWYG field |
| References | Relationship field |

## Testing the Blocks

1. Visit http://localhost:8888/wp-admin
2. Edit the "Premium Seating" page
3. Click the "+" button to add a block
4. Look for the "Jamco Blocks" category
5. Add any of the 7 custom blocks
6. Configure fields in the right sidebar
7. Preview or publish to see the results

## File Structure

```
jamco-wordpress/
├── .wp-env.json              # Docker environment config
├── package.json              # npm scripts for wp-env
├── PLAN.md                   # Original planning document
├── BLOCKS-MAPPING.md         # Sanity → ACF mapping
├── README.md                 # This file
└── theme/                    # Custom theme
    ├── style.css             # Theme registration
    ├── functions.php         # Theme functions, block registration
    ├── header.php            # Site header with nav
    ├── footer.php            # Site footer
    ├── index.php             # Main template
    ├── assets/
    │   └── css/
    │       ├── design-tokens.css   # Design system variables
    │       ├── global.css          # Base styles
    │       └── blocks.css          # Block-specific styles
    ├── blocks/               # ACF block templates
    │   ├── hero.php
    │   ├── section-intro.php
    │   ├── feature-grid.php
    │   ├── split-feature.php
    │   ├── product-carousel.php
    │   ├── testimonial.php
    │   └── cta.php
    └── inc/
        └── acf-field-groups.php    # ACF field definitions
```

## Key Features

### Content Flexibility

Just like Sanity/Astro, editors can:
- Add blocks in any order
- Duplicate blocks
- Reorder blocks via drag-and-drop
- Remove blocks
- Configure each block independently

### Design Consistency

- Exact CSS port maintains visual parity with Astro build
- Same color palette, typography, and spacing
- Responsive breakpoints match Astro version
- Button styles (primary, secondary, outline) identical

### Product System

- Product custom post type with featured images
- Product category taxonomy
- Relationship field in Product Carousel connects to products
- Products dropdown in navigation auto-populated
- Reusable across multiple pages

## WP-CLI Commands

The environment includes WP-CLI for command-line management:

```bash
# List all themes
npm run wp-env -- run cli wp theme list

# Create a new page
npm run wp-env -- run cli wp post create --post_type=page --post_title="New Page" --post_status=publish

# Create a product
npm run wp-env -- run cli wp post create --post_type=product --post_title="New Product" --post_status=publish

# List plugins
npm run wp-env -- run cli wp plugin list
```

## Feasibility Assessment

### ✅ Proven Feasible

1. **Content Block Architecture** - ACF blocks provide the same flexibility as Sanity
2. **Design Consistency** - CSS can be ported 1:1 maintaining visual parity
3. **Reusable Components** - Block templates are reusable like Astro components
4. **Content Relationships** - ACF relationship fields work like Sanity references
5. **Developer Experience** - wp-env provides zero-config local environment
6. **No Vendor Lock-in** - Standard WordPress + free ACF plugin

### Considerations

1. **ACF PRO** - For advanced features (repeater, relationship, gallery), ACF PRO license needed ($49/site)
2. **Performance** - WordPress requires more server resources than static Astro site
3. **Caching** - Production would need caching layer (WP Rocket, Redis, etc.)
4. **Hosting** - Requires PHP/MySQL hosting vs. static hosting for Astro
5. **Visual Editing** - Less intuitive than Sanity Studio's real-time preview

## Next Steps

1. ✅ Environment setup
2. ✅ Theme structure
3. ✅ CSS port
4. ✅ Block templates
5. ✅ Field groups
6. ✅ Sample content
7. 🔲 Add actual content and images
8. 🔲 Test all blocks with real content
9. 🔲 Performance optimization
10. 🔲 Production hosting evaluation

## Conclusion

The WordPress implementation successfully replicates the Sanity/Astro content block approach. The ACF block system provides equivalent flexibility for content editors, and the design can be maintained 1:1. The main trade-offs are hosting requirements and performance compared to a static site.
