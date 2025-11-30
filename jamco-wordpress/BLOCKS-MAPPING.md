# Sanity → ACF Blocks Mapping

This document maps each Sanity content block to its WordPress ACF block equivalent.

---

## Block Inventory

### 1. Hero Block
**Sanity Schema:** `hero.ts`
**ACF Block:** `acf/hero`

**Fields:**
- `heading` (text) - Main H1 heading
- `subheading` (textarea) - Subtitle text
- `background_image` (image) - Hero background
- `floating_image` (image) - Product image overlay
- `primary_cta` (group)
  - `text` (text)
  - `url` (url)
  - `style` (select: primary, secondary, outline)
- `secondary_cta` (group)
  - `text` (text)
  - `url` (url)
  - `style` (select)
- `feature_callout` (group)
  - `label` (text)
  - `description` (textarea)
- `carousel_indicator` (text) - e.g. "01 / 02"

**Template:** `blocks/hero.php`

---

### 2. Hero Carousel Block
**Sanity Schema:** `heroCarousel.ts`
**ACF Block:** `acf/hero-carousel`

**Fields:**
- `slides` (repeater)
  - `image` (image)
  - `hotspots` (repeater)
    - `x_position` (number) - Percentage
    - `y_position` (number) - Percentage
    - `label` (text)
    - `description` (textarea)
- `heading` (text)
- `subheading` (textarea)
- `cta_buttons` (repeater)
  - Same as hero CTA structure

**Template:** `blocks/hero-carousel.php`

---

### 3. Section Intro Block
**Sanity Schema:** `sectionIntro.ts`
**ACF Block:** `acf/section-intro`

**Fields:**
- `eyebrow` (text) - Small text above heading
- `heading` (text) - Section H2
- `description` (wysiwyg) - Rich text content
- `alignment` (select: left, center, right)

**Template:** `blocks/section-intro.php`

---

### 4. Feature Grid Block
**Sanity Schema:** `featureGrid.ts`
**ACF Block:** `acf/feature-grid`

**Fields:**
- `features` (repeater) - 3 items
  - `image` (image)
  - `heading` (text)
  - `description` (textarea)
  - `icon` (image) - Optional small icon

**Template:** `blocks/feature-grid.php`

---

### 5. Split Feature Block
**Sanity Schema:** `splitFeature.ts`
**ACF Block:** `acf/split-feature`

**Fields:**
- `heading` (text)
- `description` (wysiwyg)
- `feature_image` (image)
- `image_position` (select: left, right)
- `background_color` (select: white, light-blue, blue)
- `cta_button` (group)
  - `text` (text)
  - `url` (url)
  - `style` (select: primary, secondary, outline)

**Template:** `blocks/split-feature.php`

---

### 6. Product Carousel Block
**Sanity Schema:** `productCarousel.ts`
**ACF Block:** `acf/product-carousel`

**Fields:**
- `heading` (text)
- `description` (textarea)
- `label` (text) - e.g. "RELATED PRODUCTS"
- `products` (relationship) - Link to Product CPT
- `show_pagination` (true/false)

**Template:** `blocks/product-carousel.php`

---

### 7. Product Showcase Block
**Sanity Schema:** `productShowcase.ts`
**ACF Block:** `acf/product-showcase`

**Fields:**
- `heading` (text)
- `description` (wysiwyg)
- `product_image` (image)
- `features` (repeater)
  - `title` (text)
  - `description` (textarea)
- `cta_button` (group)

**Template:** `blocks/product-showcase.php`

---

### 8. Testimonial Block
**Sanity Schema:** `testimonial.ts`
**ACF Block:** `acf/testimonial`

**Fields:**
- `quote` (textarea)
- `author_name` (text)
- `author_title` (text)
- `author_company` (text)
- `author_image` (image)
- `background_color` (color_picker)

**Template:** `blocks/testimonial.php`

---

### 9. CTA Block
**Sanity Schema:** `ctaBlock.ts`
**ACF Block:** `acf/cta`

**Fields:**
- `heading` (text)
- `subheading` (textarea)
- `background_image` (image)
- `cta_button` (group)
  - `text` (text)
  - `url` (url)
  - `style` (select)

**Template:** `blocks/cta-block.php`

---

### 10. Full Width Image Block
**Sanity Schema:** `fullWidthImage.ts`
**ACF Block:** `acf/full-width-image`

**Fields:**
- `image` (image)
- `alt_text` (text)
- `caption` (text)
- `watermark` (image) - Optional overlay
- `show_nav_arrows` (true/false)

**Template:** `blocks/full-width-image.php`

---

## Custom Post Types

### Product CPT
**Post Type:** `product`
**Slug:** `/products/`

**Fields (ACF Field Group):**
- `short_description` (textarea)
- `long_description` (wysiwyg)
- `product_images` (gallery)
- `features` (repeater)
  - `feature_name` (text)
  - `feature_value` (text)
- `tier_label` (text) - e.g. "Premium", "Standard"
- `category` (taxonomy: product_category)

**Template:** `single-product.php`

---

## Navigation & Structure

### Header
- **Template:** `header.php`
- **ACF Options Page:** Site Settings
- **Fields:**
  - `logo` (image)
  - `navigation_menu` (WordPress menu)
  - `products_dropdown` (relationship to Product CPT)

### Breadcrumbs
- **Function:** `jamco_breadcrumbs()`
- **Location:** `functions.php`
- Uses WordPress taxonomy and parent pages

---

## Implementation Priority

1. **Phase 1:** Basic theme + Hero block
2. **Phase 2:** Split Feature + Feature Grid
3. **Phase 3:** Product CPT + Product Carousel
4. **Phase 4:** Testimonial + CTA + Full Width Image
5. **Phase 5:** Hero Carousel with hotspots
6. **Phase 6:** Navigation + Header + Breadcrumbs

---

## ACF Block Registration Pattern

Each block will be registered in `functions.php`:

```php
acf_register_block_type([
    'name'            => 'hero',
    'title'           => 'Hero Section',
    'description'     => 'A hero section with heading, image, and CTAs',
    'render_template' => 'blocks/hero.php',
    'category'        => 'jamco',
    'icon'            => 'cover-image',
    'keywords'        => ['hero', 'banner', 'header'],
    'supports'        => [
        'align' => false,
        'mode' => false,
        'jsx' => true
    ]
]);
```

---

## CSS Architecture

All CSS from `jamco-astro-frontend/src/styles/` will be ported to:
- `style.css` - WordPress theme stylesheet (registration only)
- `assets/css/design-tokens.css` - Same variables as Astro
- `assets/css/global.css` - Global styles
- `assets/css/blocks/` - Individual block styles

CSS will be enqueued via `functions.php` with `wp_enqueue_style()`.

