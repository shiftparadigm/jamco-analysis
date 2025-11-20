# Implementation Plan: Jamco Premium Seating Design

Based on Figma design analysis (`figma-design-analysis.md`)

## Overview

Building a single-page product landing page for Jamco Premium Seating with:
- **9 new content block types** (beyond existing generic blocks)
- **Design-specific components** matching Figma pixel-perfect
- **Sample content population** from design
- **Full Astro frontend** with responsive layouts

---

## Phase 1: Update Sanity Schemas (2-3 hours)

### New Block Types Needed

The existing Sanity setup has generic blocks. We need design-specific blocks:

#### ✅ Already Have (Can Reuse)
1. `hero.ts` - EXISTS, needs customization
2. `contentBlock.ts` - EXISTS
3. `ctaBlock.ts` - EXISTS
4. `testimonialBlock.ts` - EXISTS
5. `imageBlock.ts` - EXISTS

#### ❌ Need to Create (Design-Specific)

##### 1. **Section Intro Block** (`sectionIntroBlock.ts`)
```typescript
{
  heading: string          // H4, 48px
  description: text        // 18px body
  showDivider: boolean     // horizontal line
}
```

##### 2. **Feature Grid Block** (`featureGridBlock.ts`)
```typescript
{
  heading?: string
  description?: text
  features: array[
    image: image (432x432px)
    heading: string (16px)
    description?: text
  ]
  columns: '2-col' | '3-col' | '4-col'
}
```

##### 3. **Split Feature Block** (`splitFeatureBlock.ts`)
```typescript
{
  heading: string          // H2, 64px
  description: text        // 18px
  bulletPoints: array<string>
  ctaButton: cta
  featureImage: image
  backgroundImage?: image
  imagePosition: 'left' | 'right'
}
```

##### 4. **Product Carousel Block** (`productCarouselBlock.ts`)
```typescript
{
  heading: string          // H3, 52px
  description: text        // 18px
  label?: string           // "Related Products"
  products: array<reference to Product>
  showPagination: boolean
}
```

##### 5. **Pricing Card Block** (`pricingCardBlock.ts`)
```typescript
{
  cards: array[
    tierName: string       // "Essential", "Pro"
    heading?: string       // "Performance upgrade"
    price: number          // 89, 159
    pricePrefix: string    // "$"
    features?: array<string>
    backgroundImage?: image
    highlightCard: boolean
  ]
  layout: '2-col' | '3-col'
}
```

##### 6. **Full Width Image Block** (`fullWidthImageBlock.ts`)
```typescript
{
  image: image
  alt: string
  caption?: string
  height?: 'auto' | 'tall' | 'short'
}
```

##### 7. **Feature Callout** (`featureCalloutBlock.ts`)
```typescript
{
  label: string            // "Spatial Freedom"
  description: string      // Small description
  image?: image
  position: 'top-right' | 'top-left' | 'bottom-right' | 'bottom-left'
}
```

#### Update Existing Blocks

##### Enhance `hero.ts`
```typescript
// Add these fields:
{
  // ... existing fields
  floatingImage?: image           // Product shot overlay
  featureCallout?: featureCallout // Floating label
  carousel?: {
    indicator: string             // "01 / 02"
    showControls: boolean
  }
}
```

##### Enhance `testimonialBlock.ts`
```typescript
// Add these fields:
{
  // ... existing fields
  quoteSize: '48px' | '32px' | '24px'  // Large quote style
  showDivider: boolean
  layout: 'centered' | 'left-aligned'
}
```

### New Document Types

##### **Product Document** (`product.ts`)
```typescript
{
  name: string
  slug: slug
  description: text
  shortDescription?: string       // For carousel cards
  category: reference<ProductCategory>
  images: array<image>
  price?: number
  tierLabel?: string              // "Essential", "Pro"
  features?: array<string>
  relatedProducts?: array<reference<Product>>
}
```

##### **Product Category Document** (`productCategory.ts`)
```typescript
{
  name: string
  slug: slug
  description?: text
}
```

### Tasks

- [ ] Create 7 new block type schemas
- [ ] Update `hero.ts` with additional fields
- [ ] Update `testimonialBlock.ts` with layout options
- [ ] Create `product.ts` document type
- [ ] Create `productCategory.ts` document type
- [ ] Update `schemas/index.ts` to export all new types
- [ ] Update `page.ts` to include new block types in content array

---

## Phase 2: Build Astro Components (4-5 hours)

### Design System Setup

##### 1. **Global Styles** (`src/styles/design-tokens.css`)
```css
/* From design analysis */
:root {
  /* Colors */
  --color-primary: rgb(0, 85, 172);
  --color-primary-hover: rgb(11, 89, 169);
  --color-dark: rgb(7, 7, 7);
  --color-dark-bg: rgb(3, 35, 67);
  --color-light: rgb(255, 255, 255);
  --color-light-bg: rgb(245, 245, 245);

  /* Typography */
  --font-primary: 'Inter', sans-serif;
  --font-heading: 'Space Grotesk', sans-serif;

  /* Font Sizes */
  --text-h1: clamp(48px, 6vw, 96px);
  --text-h2: clamp(32px, 4vw, 64px);
  --text-h3: clamp(28px, 3.5vw, 52px);
  --text-h4: clamp(24px, 3vw, 48px);
  --text-h5: 18px;
  --text-h6: 16px;
  --text-body-lg: 20px;
  --text-body: 18px;
  --text-sm: 14px;
  --text-xs: 12px;

  /* Layout */
  --container-max: 1440px;
  --container-content: 1368px;
  --container-narrow: 1280px;

  /* Spacing */
  --section-gap: clamp(60px, 8vw, 100px);
  --card-gap: 24px;
}
```

##### 2. **Typography Component** (`src/components/Typography.astro`)
Reusable heading components with design system styles

### New Component Files

#### Layout Components
- [ ] `src/layouts/ProductLayout.astro` - Product page specific layout
- [ ] `src/components/Container.astro` - Max-width containers (1368px, 1280px)
- [ ] `src/components/Section.astro` - Full-width section wrapper

#### Block Components
- [ ] `src/components/blocks/SectionIntro.astro`
- [ ] `src/components/blocks/FeatureGrid.astro`
- [ ] `src/components/blocks/SplitFeature.astro`
- [ ] `src/components/blocks/ProductCarousel.astro`
- [ ] `src/components/blocks/PricingCards.astro`
- [ ] `src/components/blocks/FullWidthImage.astro`
- [ ] `src/components/blocks/FeatureCallout.astro`

#### UI Components
- [ ] `src/components/ui/Button.astro` - Primary/Secondary/Tertiary variants
- [ ] `src/components/ui/CarouselIndicator.astro` - "01 / 04" pagination
- [ ] `src/components/ui/ProductCard.astro` - Carousel item card

#### Update Existing Components
- [ ] Update `Hero.astro` - Add floating image, feature callout support
- [ ] Update `Testimonial.astro` - Add large quote style, divider option
- [ ] Update `PageBuilder.astro` - Add new block type cases

### Responsive Breakpoints

```css
/* Mobile First */
@media (min-width: 640px) { /* sm */ }
@media (min-width: 768px) { /* md */ }
@media (min-width: 1024px) { /* lg */ }
@media (min-width: 1280px) { /* xl */ }
@media (min-width: 1440px) { /* 2xl */ }
```

**Responsive Rules:**
- 3-column grid → 2-column (tablet) → 1-column (mobile)
- Split layouts → stacked on mobile
- Hero text → smaller sizes on mobile (clamp)
- Carousels → native horizontal scroll on mobile

---

## Phase 3: Populate Sample Content in Sanity (1-2 hours)

### Content from Design

#### 1. Create Product Category
```
Name: Premium Seating
Slug: premium-seating
```

#### 2. Create Products (5 items)
1. **Flight Deck Doors and Linings**
2. **Dividers & Partitions**
3. **Closets & Stowage**
4. **Lavatories**
5. **Comfort Module**

#### 3. Create Main Product Page
```
Title: Premium Seating
Slug: premium-seating
Language: en

Hero:
  Heading: "Jamco Premium Seating"
  Tagline: "Premium-density seats with direct aisle access, optimized living space, and intuitive passenger control."
  Primary CTA: "View premium seating suite"
  Secondary CTA: "Download the Brochure"
  Background Image: [hero-bg.jpg]
  Feature Callout:
    Label: "Spatial Freedom"
    Description: "Configurable rests ensure passengers have the room they need"

Content Blocks:
  1. Section Intro
     Heading: "Premium Seating"
     Description: "Direct aisle access, premium density, and curated surfaces for a calm, private environment—ready to scale across your fleet."

  2. Feature Grid (3-col)
     Features:
       - "Direct aisle access for every passenger"
       - "Premium density without the compromise"
       - "Optimized living space with smart storage"

  3. Section Intro
     Heading: "Our Premium Seating features"
     Description: "Deliver the passenger experience your brand promises, without sacrificing density or service efficiency."

  4. Split Feature (image right)
     Heading: "Control & Comfort"
     Description: "A unified control center uses capacitive touch input with LED lighting for clear, intuitive operation."
     Bullet Points:
       - "One-touch lighting"
       - "Power at hand for devices"
       - "Clear labeling for low-light use"
     CTA: "Contact Us"

  5. Split Feature (image left)
     Heading: "Private by Design"
     Description: "Sliding dividers provides privacy from zero to full as needed."
     Bullet Points:
       - "On-demand privacy divider"
       - "Shielded sightlines and calm surfaces"
     CTA: "Contact Us"

  6. Split Feature (image right)
     Heading: "Work and Entertain On-Demand"
     Description: "An immersive HD display and spacious tray surface supports both work and relaxation."
     Bullet Points:
       - "Immersive HD display options"
       - "Fast access to entertainment and information"
       - "Work surface/tray for devices and notes"
     CTA: "Contact Us"

  7. Split Feature (image left)
     Heading: "Spatial Freedom"
     Description: "Ample space for passenger comfort and curated storage locations."
     Bullet Points:
       - "Generous passenger space"
       - "Dedicated stowage for devices and small bags"
     CTA: "Contact Us"

  8. Testimonial
     Quote: "This isn't just a seat. It's a mobile office, entertainment center, and personal sanctuary."
     Author: "Maria Smith"
     Title: "CEO, Global Innovations"

  9. Product Carousel
     Heading: "Complete your travel ecosystem"
     Description: "Elevate every aspect of your journey."
     Label: "Related Products"
     Products: [refs to 5 products above]

  10. Pricing Cards
      Cards:
        - Tier: "Essential", Price: $89
        - Tier: "Pro", Heading: "Performance upgrade", Price: $159

  11. CTA Block
      Heading: "Ready to talk?"
      Description: "Our team is ready to meet your needs."
      CTA: "Contact Us"
```

#### 4. Update Site Settings
```
Contact Info:
  AOG Phone: "425-232-0770"
  Office Phone: "425-347-4735"

Footer:
  Copyright: "© 2025 Jamco America. All rights reserved."
```

#### 5. Update Navigation
```
Breadcrumb: Products > Premium Seating
```

### Content Entry Method

**Option A: Manual Entry**
- Use Sanity Studio UI to enter all content
- Copy/paste from design analysis

**Option B: Scripted Import**
- Create a Node script to populate content via Sanity API
- Faster for bulk content

**Recommendation:** Use Manual Entry for now (easier to verify), script later if needed.

---

## Phase 4: Asset Management (1 hour)

### Images Needed (33 total)

#### Priority 1: Essential (12 images)
- [ ] Hero background (1440x877px)
- [ ] Hero floating product image (730x575px)
- [ ] 3 feature grid images (432x432px each)
- [ ] 5 split feature images (various sizes)
- [ ] Testimonial avatar
- [ ] Jamco logo (2 variants)

#### Priority 2: Products (5 images)
- [ ] Flight Deck Doors image
- [ ] Dividers & Partitions image
- [ ] Closets & Stowage image
- [ ] Lavatories image
- [ ] Comfort Module image

#### Priority 3: Additional (16 images)
- [ ] Full-width lifestyle images (2)
- [ ] Pricing card backgrounds (2)
- [ ] Additional product shots (12)

### Image Sourcing Options

1. **Use placeholders initially:**
   - https://placehold.co/1440x877/0055AC/FFF
   - https://unsplash.com (aircraft interiors)

2. **Request from client:**
   - Product photography
   - Brand assets (logos)
   - Lifestyle imagery

3. **Generate with AI:**
   - Midjourney/DALL-E for concept images
   - Must match aircraft interior aesthetic

### Image Optimization

```bash
# Install Sharp for image optimization
npm install sharp

# Create image optimization script
# Convert to WebP, generate responsive sizes
```

---

## Phase 5: Build & Test (2 hours)

### Development Workflow

1. **Start Sanity Studio**
   ```bash
   cd jamco-sanity-studio
   npm run dev
   # Running at localhost:3333
   ```

2. **Start Astro Dev Server**
   ```bash
   cd jamco-astro-frontend
   npm run dev
   # Running at localhost:4321
   ```

3. **Create sample page in Sanity**
4. **Build Astro components iteratively**
5. **Test each block type**

### Testing Checklist

- [ ] Desktop layout (1440px)
- [ ] Tablet layout (768-1024px)
- [ ] Mobile layout (320-767px)
- [ ] All block types render correctly
- [ ] Images load and display properly
- [ ] CTAs link correctly
- [ ] Carousel navigation works
- [ ] Testimonial displays properly
- [ ] Pricing cards format correctly
- [ ] Typography matches design
- [ ] Colors match design tokens
- [ ] Spacing/padding consistent

### Browser Testing

- [ ] Chrome/Edge
- [ ] Firefox
- [ ] Safari
- [ ] Mobile Safari (iOS)
- [ ] Chrome Mobile (Android)

---

## Phase 6: Polish & Optimize (1-2 hours)

### Performance Optimization

- [ ] Lazy load images below fold
- [ ] Use `loading="lazy"` on img tags
- [ ] Implement responsive images (`srcset`)
- [ ] Minify CSS/JS
- [ ] Enable Astro's image optimization
- [ ] Add proper cache headers

### Accessibility

- [ ] Semantic HTML (header, nav, main, section, footer)
- [ ] Proper heading hierarchy (h1 → h2 → h3)
- [ ] Alt text for all images
- [ ] ARIA labels for carousels
- [ ] Focus states for interactive elements
- [ ] Keyboard navigation support
- [ ] Color contrast check (WCAG AA)

### SEO

- [ ] Meta title and description
- [ ] Open Graph tags
- [ ] Structured data (Product schema)
- [ ] Canonical URLs
- [ ] XML sitemap

---

## Implementation Order (Recommended)

### Day 1: Foundation (4-5 hours)
1. ✅ Create new Sanity schemas (Phase 1)
2. ✅ Set up design tokens/global styles
3. ✅ Build core layout components (Container, Section)
4. ✅ Update Hero component with new features

### Day 2: Block Components (5-6 hours)
1. ✅ Build SectionIntro component
2. ✅ Build FeatureGrid component
3. ✅ Build SplitFeature component
4. ✅ Build ProductCarousel component
5. ✅ Build PricingCards component
6. ✅ Test each component individually

### Day 3: Content & Integration (3-4 hours)
1. ✅ Populate sample content in Sanity
2. ✅ Source/create placeholder images
3. ✅ Update PageBuilder with new blocks
4. ✅ Create product page route
5. ✅ End-to-end testing

### Day 4: Polish (2-3 hours)
1. ✅ Responsive design refinements
2. ✅ Performance optimization
3. ✅ Accessibility improvements
4. ✅ Cross-browser testing
5. ✅ Final QA

**Total Estimated Time:** 14-18 hours

---

## Success Criteria

✅ **Phase Complete When:**
- All 9 new block types functional in Sanity Studio
- All corresponding Astro components render correctly
- Sample "Premium Seating" page fully populated
- Page matches Figma design at desktop (1440px) width
- Responsive layouts work on mobile/tablet
- All images load and display properly
- CTAs and navigation work
- Performance is acceptable (< 3s load time)
- Accessibility passes basic checks

---

## Next Steps After Completion

1. **Client Review**
   - Share staging URL
   - Gather feedback on design match
   - Identify any missing features

2. **Content Population**
   - Create remaining product pages
   - Populate all product categories
   - Add real product photography

3. **Additional Features**
   - Search functionality
   - Product filtering
   - Related product recommendations
   - Contact form integration

4. **Deployment**
   - Set up hosting (Vercel/Netlify)
   - Configure domain
   - Set up analytics
   - Enable CDN for images

---

## Resources

- **Design Analysis:** `figma-design-analysis.md`
- **Figma JSON:** `frame4-clean.json`
- **Sanity Docs:** https://www.sanity.io/docs
- **Astro Docs:** https://docs.astro.build
- **Design Tokens Reference:** Section 11 of design analysis

---

## Notes

- Prioritize desktop-first since design is 1440px
- Use CSS Grid for layout (better than flexbox for this)
- Implement carousel with native CSS scroll-snap (no JS library needed)
- Consider using Swiper.js only if native scroll insufficient
- Keep components pure/functional - avoid unnecessary client JS
- Use Astro's partial hydration for interactive components only
