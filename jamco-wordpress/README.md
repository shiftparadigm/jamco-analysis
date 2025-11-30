# Jamco WordPress Implementation

WordPress implementation of the Jamco Premium Seating page, using native Gutenberg blocks with content synced from Sanity CMS.

## Status: ✅ Production Ready

Full visual parity achieved with the Astro/Sanity reference site. All 10 custom blocks are built, content is populated from Sanity, and styling matches the reference implementation.

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

## Architecture

### Modern Gutenberg Block System

This implementation uses **native WordPress Gutenberg blocks** (not ACF blocks) with a modern architecture:

```
theme/blocks/
├── hero/
│   ├── block.json          # Block metadata & attributes
│   ├── render.php          # Server-side rendering
│   ├── style.css           # Block styles
│   ├── src/
│   │   └── index.js        # Editor component (React)
│   ├── index.js            # Built editor script
│   ├── webpack.config.js   # Build configuration
│   └── frontend.js         # (Optional) frontend interactions
├── product-carousel/
│   └── ... (same structure)
└── ... (10 blocks total)
```

### Key Architectural Decisions

1. **Native Gutenberg Blocks** - Full WordPress editor integration
2. **Block.json API** - Modern block registration with metadata
3. **Server-Side Rendering** - PHP templates for frontend output
4. **React Editor Components** - Custom controls in WordPress editor
5. **Webpack Build Process** - Modern JavaScript tooling
6. **Sanity CMS as Source** - Content synced from headless CMS

## Complete Block List

### ✅ All 10 Blocks Implemented

1. **Hero** - Main hero section with floating image, dual CTAs, feature callout
2. **Section Intro** - Eyebrow label, heading, and description
3. **Feature Grid** - 3-column grid with images, headings, descriptions
4. **Split Feature** - Content/image 50/50 split with alternating layout
5. **Product Carousel** - Interactive 4-product carousel with controls
6. **Product Showcase** - Large product display with description and CTA
7. **Seating Diagram** - Interactive seating chart with annotations
8. **Full Width Image** - Full-bleed image with optional watermark
9. **Testimonial** - Customer quote with author image and details
10. **CTA Block** - Call-to-action section with optional background image

## Content Population

Content is synced from Sanity CMS using PHP scripts:

```bash
# Sync content from Sanity to WordPress
npx wp-env run cli php /var/www/html/wp-content/themes/jamco/sync-from-sanity.php
```

This process:
- Fetches page data from Sanity CMS
- Downloads all images from Sanity CDN
- Uploads images to WordPress media library
- Creates block markup with correct attributes
- Updates the Premium Seating page

**Result**: http://localhost:8888

## Block Development

### Building Blocks

Each block's JavaScript needs to be built with webpack:

```bash
cd theme/blocks/[block-name]
npx webpack --config webpack.config.js
```

Or build all blocks:

```bash
# From theme/blocks directory
for dir in */; do
  cd "$dir"
  npx webpack --config webpack.config.js 2>/dev/null
  cd ..
done
```

### Block Registration

Blocks are registered in `theme/functions.php`:

```php
function jamco_register_blocks() {
    register_block_type(__DIR__ . '/blocks/hero');
    register_block_type(__DIR__ . '/blocks/product-carousel');
    // ... etc
}
add_action('init', 'jamco_register_blocks');
```

### Block Attributes

Block attributes are defined in `block.json`:

```json
{
  "attributes": {
    "heading": {
      "type": "string",
      "default": ""
    },
    "description": {
      "type": "string",
      "default": ""
    }
  }
}
```

### Editor Component

Editor controls are built in React (`src/index.js`):

```javascript
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';

registerBlockType('jamco/block-name', {
  edit: ({ attributes, setAttributes }) => {
    return (
      <InspectorControls>
        <TextControl
          label="Heading"
          value={attributes.heading}
          onChange={(value) => setAttributes({ heading: value })}
        />
      </InspectorControls>
    );
  }
});
```

### Render Template

Frontend rendering in `render.php`:

```php
<?php
$heading = $attributes['heading'] ?? '';
$description = $attributes['description'] ?? '';
?>

<section class="my-block">
  <h2><?php echo esc_html($heading); ?></h2>
  <p><?php echo esc_html($description); ?></p>
</section>
```

## Design System

### Complete CSS Architecture

```
theme/assets/css/
└── blocks.css              # All block styles (consolidated)
```

All block styles are consolidated in a single `blocks.css` file for optimal performance. Individual block `style.css` files are included but not used in production.

### Design Tokens

CSS custom properties define the design system:

```css
:root {
  /* Colors */
  --color-primary: #3767AD;
  --color-secondary: #1E3A5F;
  --color-accent: #FF6B35;
  --color-light: #F8F9FA;

  /* Typography */
  --font-heading: 'Space Grotesk', sans-serif;
  --font-body: 'Inter', sans-serif;

  /* Spacing */
  --spacing-xs: 0.5rem;
  --spacing-sm: 1rem;
  --spacing-md: 2rem;
  --spacing-lg: 4rem;

  /* Layout */
  --max-width: 1440px;
  --section-gap: 80px;
}
```

### Visual Parity

The WordPress implementation achieves pixel-perfect visual parity with the Astro reference:

- ✅ Identical color palette
- ✅ Matching typography and font sizes
- ✅ Same spacing and layout
- ✅ Consistent component styling
- ✅ Responsive breakpoints aligned
- ✅ Hover states and transitions matched

## File Structure

```
jamco-wordpress/
├── .wp-env.json              # Docker environment config
├── package.json              # npm scripts
├── README.md                 # This file
└── theme/                    # Custom theme
    ├── style.css             # Theme registration
    ├── functions.php         # Block registration, CPT, enqueues
    ├── header.php            # Site header with nav
    ├── footer.php            # Site footer
    ├── index.php             # Main template
    │
    ├── assets/css/
    │   └── blocks.css        # All block styles
    │
    ├── blocks/               # Gutenberg blocks (10 total)
    │   ├── hero/
    │   │   ├── block.json
    │   │   ├── render.php
    │   │   ├── style.css
    │   │   ├── src/index.js
    │   │   ├── index.js (built)
    │   │   └── webpack.config.js
    │   │
    │   ├── section-intro/
    │   ├── feature-grid/
    │   ├── split-feature/
    │   ├── product-carousel/
    │   ├── product-showcase/
    │   ├── seating-diagram/
    │   ├── full-width-image/
    │   ├── testimonial/
    │   └── cta/
    │
    ├── sanity-images/        # Downloaded from Sanity CDN
    ├── sync-from-sanity.php  # Content sync script
    └── ... (utility scripts)
```

## Product Custom Post Type

Products are managed as a custom post type:

```php
// Register product CPT
register_post_type('product', [
    'public' => true,
    'label' => 'Products',
    'supports' => ['title', 'editor', 'thumbnail'],
    'has_archive' => true,
    'show_in_rest' => true,
]);
```

Products are referenced by blocks using product slugs:

```json
{
  "productRefs": [
    "flight-deck-doors-linings",
    "dividers-partitions",
    "closets-stowage",
    "lavatories"
  ]
}
```

## Comparison with Sanity/Astro

### Architecture Mapping

| Sanity/Astro | WordPress |
|--------------|-----------|
| Sanity schema | block.json attributes |
| Sanity document | WordPress page with blocks |
| Astro component | Block render.php template |
| Content API | WordPress REST API |
| Portable Text | WordPress blocks |
| References | Post relationships by slug |
| Sanity Studio | WordPress block editor |

### Advantages of WordPress Approach

1. **No Build Step** - Content changes are immediately live
2. **Familiar Interface** - WordPress editor is widely known
3. **Self-Hosted** - No external CMS dependency (though we sync from Sanity)
4. **Plugin Ecosystem** - Thousands of WordPress plugins available
5. **SEO Tools** - Built-in SEO capabilities with plugins like Yoast

### Trade-offs

1. **Performance** - Server-rendered vs. static site generation
2. **Hosting** - Requires PHP/MySQL vs. static hosting
3. **Scaling** - More server resources needed
4. **Caching** - Need Redis/Varnish for high traffic
5. **Build Tools** - Blocks require webpack build step

## Development Workflow

### Making Changes to a Block

1. **Edit the source**: `theme/blocks/[name]/src/index.js` or `render.php`
2. **Rebuild**: `cd theme/blocks/[name] && npx webpack`
3. **Refresh**: Hard refresh browser (Cmd+Shift+R / Ctrl+Shift+R)
4. **Test**: Check both editor and frontend

### Syncing Content from Sanity

1. **Update content** in Sanity Studio
2. **Run sync script**: `npx wp-env run cli php /var/www/html/wp-content/themes/jamco/sync-from-sanity.php`
3. **Verify**: Check http://localhost:8888

### Updating Styles

1. **Edit**: `theme/assets/css/blocks.css`
2. **Changes are immediate** - CSS is not built, directly loaded
3. **Hard refresh** browser to see changes

## WP-CLI Commands

Useful commands for managing the WordPress environment:

```bash
# List all pages
npx wp-env run cli wp post list --post_type=page

# List products
npx wp-env run cli wp post list --post_type=product

# Get page content
npx wp-env run cli wp post get 5 --field=post_content

# List uploaded images
npx wp-env run cli wp media list

# Flush rewrite rules
npx wp-env run cli wp rewrite flush

# List registered blocks
npx wp-env run cli wp block list
```

## Testing

### Visual Comparison

Screenshots are available in `screenshots/` directory:

- `astro-full.png` - Reference Astro implementation
- `wordpress-full.png` - WordPress implementation
- Various comparison screenshots for debugging

### Browser Testing

Test in multiple browsers:
- Chrome/Edge (Chromium)
- Firefox
- Safari

### Responsive Testing

Test breakpoints:
- Mobile: 375px, 414px
- Tablet: 768px, 1024px
- Desktop: 1280px, 1440px, 1920px

## Production Deployment

### Build Checklist

- [ ] All blocks built with webpack
- [ ] Images optimized and uploaded
- [ ] CSS minified (optional)
- [ ] Database exported
- [ ] wp-config.php configured for production
- [ ] Caching plugin installed (WP Rocket, W3 Total Cache)
- [ ] Security hardening applied
- [ ] SSL certificate installed

### Performance Optimization

1. **Caching**: Install Redis object cache
2. **CDN**: Use Cloudflare or similar for static assets
3. **Image Optimization**: Install Imagify or ShortPixel
4. **Lazy Loading**: Enabled by default in WordPress 5.5+
5. **Database**: Optimize tables regularly

## Support & Documentation

- **WordPress Block Editor**: https://wordpress.org/gutenberg/
- **Block.json API**: https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/
- **wp-env**: https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/

## License

Custom implementation for Jamco. All rights reserved.
