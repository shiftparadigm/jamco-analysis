# WordPress Build Plan - Jamco Premium Seating

## Questions to Answer Before Implementation

### 1. Scope & Purpose
**Question:** What is the goal of this WordPress build?
- [x] A. Determine feasibility of generating landing pages in WP the same way as Sanity/Astro
- [x] B. Complete replica of Premium Seating page
- [ ] C. Foundation for future client handoff

**Your Answer:** Feasibility study - can we replicate the Sanity/Astro content block approach in WordPress?

---

### 2. Content Management Strategy
**Question:** How should content be managed?

**Your Answer:** WordPress Native CMS - content lives in WordPress database, completely independent from Sanity. This is a parallel implementation to test the approach.

---

### 3. Technical Stack

#### Theme Framework
**Your Answer:** Custom theme from scratch - "lift and shift" of existing Astro build. No parent theme dependencies.

#### Page Builder
**Your Answer:** Gutenberg + ACF (Advanced Custom Fields) - Custom Gutenberg blocks powered by ACF

#### Component Architecture
**Your Answer:** ACF Blocks - Each Sanity content block becomes an ACF Gutenberg block. This matches the component-based approach of Sanity.

---

### 4. Development Environment

**Your Answer:** Docker with wp-env (official WordPress local environment) - lightweight, CLI-friendly, no GUI overhead

---

### 5. Deployment & Hosting

**Your Answer:** Not needed immediately, but architecture will support standard WordPress hosting (avoid vendor lock-in)

---

### 6. Feature Parity

**Your Answer:** All of the above - exact replica of the Astro build. Every Sanity content block becomes an ACF block:
- [x] Hero carousel with hotspots
- [x] Product carousel
- [x] Split feature sections (with background color variants)
- [x] Feature grid (3-column)
- [x] Testimonial section
- [x] CTA block
- [x] Products dropdown navigation
- [x] Breadcrumb system
- [x] Section intro blocks
- [x] Full-width image blocks

---

## Proposed Implementation Plan

### Phase 1: Setup & Foundation
1. **Local Environment Setup**
   - Install WordPress locally
   - Configure database
   - Set up theme structure
   - Install essential plugins

2. **Design System Integration**
   - Port design tokens from Astro
   - Set up CSS architecture
   - Configure fonts (Space Grotesk, Inter)
   - Create color/spacing variables

### Phase 2: Core Components
1. **Header Component**
   - Logo integration
   - Navigation menu
   - Products dropdown
   - Breadcrumb system

2. **Hero Section**
   - Background image support
   - Carousel functionality (if needed)
   - Hotspot overlays
   - CTA buttons

3. **Content Blocks**
   - Section intro block
   - Feature grid (3-column)
   - Split feature block
   - Product showcase
   - Testimonial block
   - CTA block

### Phase 3: Content Integration
1. **Products System**
   - Custom post type for products
   - Product taxonomy/categories
   - Product template
   - Archive page

2. **Page Templates**
   - Premium Seating template
   - Products archive
   - Single product
   - Default page

### Phase 4: Advanced Features
1. **Multi-language Support** (if needed)
   - WPML or Polylang
   - Translation workflow

2. **Performance Optimization**
   - Image optimization
   - Caching strategy
   - Asset minification
   - Lazy loading

### Phase 5: Comparison & Testing
1. **Performance Metrics**
   - Lighthouse scores
   - Page load times
   - Core Web Vitals

2. **Feature Comparison**
   - Side-by-side functionality test
   - Content management workflow comparison
   - Developer experience notes

---

## Technology Stack (FINALIZED)

### Core:
- WordPress 6.4+
- PHP 8.1+
- MySQL 8.0+
- Node.js 18+ (for build tools)

### WordPress Plugins:
- **Advanced Custom Fields PRO** - Block creation & field management
- **ACF Extended** (optional) - Enhanced ACF features
- **Classic Editor** (optional) - For testing/fallback

### Development Tools:
- wp-env (Docker-based WP environment)
- Composer (PHP dependencies)
- npm/webpack (Asset building if needed)

### Theme Architecture:
- Custom theme (no parent)
- ACF Blocks for all content components
- Direct CSS port from Astro build (design-tokens.css)
- Template hierarchy for pages

---

## Timeline Estimate (Rough)

- **Setup & Foundation:** 2-3 hours
- **Core Components:** 4-6 hours
- **Content Integration:** 2-3 hours
- **Advanced Features:** 3-4 hours
- **Testing & Comparison:** 1-2 hours

**Total:** ~12-18 hours (assuming no major blockers)

---

## Success Criteria

1. Visual parity with Astro/Figma design
2. All content blocks functioning correctly
3. Responsive design matching reference
4. Performance metrics documented
5. Clear comparison notes for decision-making

---

## Next Steps

1. Answer the questions above
2. Finalize technology choices
3. Begin Phase 1 implementation
4. Iterate based on findings

