# Definitive Fixes Needed - No Questions Required

These are concrete discrepancies between Figma spec and implementation that can be fixed immediately without design clarification.

---

## 1. Color Corrections

### Primary Blue Color (CRITICAL)
**Current:** `rgb(0, 85, 172)` = `#0055ac`
**Figma:** `rgb(11, 89, 169)` = `#0b59a9`

**Fix:** `jamco-astro-frontend/src/styles/design-tokens.css:5`
```css
/* BEFORE */
--color-primary: rgb(0, 85, 172);

/* AFTER */
--color-primary: rgb(11, 89, 169);
```

### Add Missing Overlay Colors
**Add to:** `jamco-astro-frontend/src/styles/design-tokens.css`
```css
--color-overlay-blue-80: rgba(11, 89, 169, 0.8);
--color-overlay-white-20: rgba(255, 255, 255, 0.2);
--color-overlay-white-1: rgba(255, 255, 255, 0.01);
```

---

## 2. Typography Fixes

### Hero Subheading Size
**Current:** 16px
**Figma:** 20px

**Fix:** `jamco-astro-frontend/src/components/blocks/Hero.astro:101`
```css
/* BEFORE */
.subheading {
  font-size: 16px;

/* AFTER */
.subheading {
  font-size: 20px;
```

### Section H2 Max Size
**Current:** `clamp(32px, 4vw, 64px)`
**Figma:** Should max at 52px for section headings

**Fix:** `jamco-astro-frontend/src/styles/design-tokens.css:28`
```css
/* BEFORE */
--text-h3: clamp(28px, 3.5vw, 52px);

/* AFTER - Use this for section headings */
--text-h3: clamp(28px, 3.5vw, 52px); /* Keep for H3 */
--text-section-heading: clamp(32px, 4vw, 52px); /* Add for section H2s */
```

### Add Letter Spacing Values
**Add to:** `jamco-astro-frontend/src/styles/design-tokens.css` (after font weights)
```css
/* Letter Spacing - Figma spec uses pixels */
--letter-spacing-hero-h1: -5.76px;
--letter-spacing-feature-h2: -3.84px;
--letter-spacing-section-h2: 0.52px;
--letter-spacing-nav: 0.72px;
--letter-spacing-testimonial: -2.88px;
--letter-spacing-body-tight: -0.6px;
```

### Apply Letter Spacing to Hero H1
**Fix:** `jamco-astro-frontend/src/components/blocks/Hero.astro:90-98`
```css
/* BEFORE */
h1 {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 96px;
  font-weight: 300;
  line-height: 0.9;
  letter-spacing: -0.06em;  /* ← WRONG */
  color: rgb(11, 89, 169);
  margin: 0;
}

/* AFTER */
h1 {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 96px;
  font-weight: 300;
  line-height: 0.9;
  letter-spacing: -5.76px;  /* ← CORRECT */
  color: rgb(11, 89, 169);
  margin: 0;
}
```

### Apply Letter Spacing to Testimonial Quote
**Fix:** `jamco-astro-frontend/src/components/blocks/Testimonial.astro:99-107`
```css
/* BEFORE */
.quote {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 48px;
  line-height: 140%;
  font-weight: 300;
  margin: 0;
  letter-spacing: -2.88px;  /* ← Already correct! */
  color: #FFF;
}
```
✅ This one is already correct!

---

## 3. Spacing Corrections

### Navigation Horizontal Padding (CRITICAL)
**Current:** 72px
**Figma:** 36px

**Fix:** `jamco-astro-frontend/src/components/blocks/Header.astro:77-84`
```css
/* BEFORE */
.nav-container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 16px 72px;  /* ← WRONG */
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* AFTER */
.nav-container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 16px 36px;  /* ← CORRECT */
  display: flex;
  justify-content: space-between;
  align-items: center;
}
```

**Also fix breadcrumb container:**
`jamco-astro-frontend/src/components/blocks/Header.astro:184-191`
```css
/* BEFORE */
.breadcrumb-container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 12px 72px;  /* ← WRONG */

/* AFTER */
.breadcrumb-container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 12px 36px;  /* ← CORRECT */
```

### Section Vertical Padding
**Current:** `clamp(60px, 8vw, 100px)`
**Figma:** 112px for large section padding

**Fix:** `jamco-astro-frontend/src/styles/design-tokens.css:53`
```css
/* BEFORE */
--section-gap: clamp(60px, 8vw, 100px);

/* AFTER */
--section-gap: clamp(60px, 8vw, 112px);
```

### Feature Grid Gap (CRITICAL)
**Current:** 24px
**Figma:** 36px

**Fix:** `jamco-astro-frontend/src/styles/design-tokens.css:54`
```css
/* BEFORE */
--card-gap: 24px;

/* AFTER */
--card-gap: 24px;  /* Keep for other cards */
--feature-grid-gap: 36px;  /* Add new variable */
```

**Then update FeatureGrid component:**
`jamco-astro-frontend/src/components/blocks/FeatureGrid.astro:58-61`
```css
/* BEFORE */
.grid {
  display: grid;
  gap: var(--card-gap);
}

/* AFTER */
.grid {
  display: grid;
  gap: 36px;  /* Or use var(--feature-grid-gap) after adding token */
}
```

### Hero Height
**Current:** `min-height: 877px`
**Figma:** 775px

**Fix:** `jamco-astro-frontend/src/components/blocks/Hero.astro:79`
```css
/* BEFORE */
.hero-container {
  max-width: 1440px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 877px;  /* ← WRONG */
  align-items: center;
}

/* AFTER */
.hero-container {
  max-width: 1440px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 775px;  /* ← CORRECT */
  align-items: center;
}
```

### ProductShowcase Container Padding
**Current:** 72px
**Figma:** 36px

**Fix:** `jamco-astro-frontend/src/components/blocks/ProductShowcase.astro:138`
```css
/* BEFORE */
.showcase-container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 0 72px;  /* ← WRONG */
  display: grid;
  grid-template-columns: 380px 1fr;
  gap: 100px;
  align-items: center;
}

/* AFTER */
.showcase-container {
  max-width: 1440px;
  margin: 0 auto;
  padding: 0 36px;  /* ← CORRECT */
  display: grid;
  grid-template-columns: 380px 1fr;
  gap: 100px;
  align-items: center;
}
```

### SplitFeature Vertical Padding
**Current:** Uses `--spacing-2xl` (64px)
**Figma:** 112px vertical padding

**Fix:** `jamco-astro-frontend/src/components/blocks/SplitFeature.astro:123`
```css
/* BEFORE */
.content-side {
  position: relative;
  padding: var(--spacing-2xl) 72px;  /* ← 64px vertical, 72px horizontal - BOTH WRONG */
  display: flex;
  flex-direction: column;
  justify-content: center;
}

/* AFTER */
.content-side {
  position: relative;
  padding: 112px 36px;  /* ← 112px vertical, 36px horizontal - BOTH CORRECT */
  display: flex;
  flex-direction: column;
  justify-content: center;
}
```

---

## 4. Font Weight Corrections

### FeatureGrid Headings
**Current:** Likely 300 (light)
**Figma:** Inter Bold (700)

**Fix:** `jamco-astro-frontend/src/components/blocks/FeatureGrid.astro:87-91`
```css
/* BEFORE */
.feature-card h6 {
  margin-bottom: 0.5rem;
  color: var(--color-primary);
  font-weight: 300;  /* ← WRONG */
}

/* AFTER */
.feature-card h6 {
  margin-bottom: 0.5rem;
  color: var(--color-primary);
  font-weight: 700;  /* ← CORRECT - Bold */
}
```

### ProductShowcase and SplitFeature H2s
**Current:** Likely semibold or bold
**Figma:** Space Grotesk Light (300)

**Fix:** `jamco-astro-frontend/src/components/blocks/ProductShowcase.astro:149-157`
```css
/* BEFORE */
h2 {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 96px;
  font-weight: 300;  /* ← Already correct */
  line-height: 0.9;
  margin-bottom: 24px;
  letter-spacing: -0.06em;  /* ← WRONG, should be -5.76px */
  color: white;
}

/* AFTER */
h2 {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 96px;
  font-weight: 300;  /* ← Already correct */
  line-height: 0.9;
  margin-bottom: 24px;
  letter-spacing: -5.76px;  /* ← CORRECT */
  color: white;
}
```

**Fix:** `jamco-astro-frontend/src/components/blocks/SplitFeature.astro:129-133`
```css
/* BEFORE */
.content-side h2 {
  margin-bottom: 1.5rem;
  color: var(--color-primary);
  font-weight: 300;  /* ← Check if this is correct */
}

/* AFTER (if needed) */
.content-side h2 {
  margin-bottom: 1.5rem;
  color: var(--color-primary);
  font-weight: 300;  /* ← Space Grotesk Light is correct for large feature headings */
  letter-spacing: -3.84px;  /* ← ADD THIS */
}
```

---

## 5. Product Showcase Specific Fixes

### Product Card Border Radius
**Current:** 16px
**Figma:** Shows 16px in product showcase but 8px elsewhere

**Fix:** Keep as-is (16px matches Figma for this component)
`jamco-astro-frontend/src/components/blocks/ProductShowcase.astro:176`
```css
.product-card {
  background: white;
  border-radius: 16px;  /* ← CORRECT for product showcase */
  overflow: hidden;
  position: relative;
  padding: 40px;
}
```

---

## 6. Logo Dimensions

### Header Logo
**Current:** 32px height
**Figma:** 144px × 35.25px

**Fix:** `jamco-astro-frontend/src/components/blocks/Header.astro:94-97`
```css
/* BEFORE */
.logo-icon {
  height: 32px;  /* ← WRONG */
  width: 32px;
}

/* AFTER */
.logo-icon {
  height: 35.25px;  /* ← CORRECT */
  width: 144px;
}
```

**Note:** This assumes the logo image itself supports this aspect ratio. If using an icon, may need to update the asset.

---

## 7. Navigation Link Styling

### Letter Spacing
**Current:** 0.08em
**Figma:** 0.72px

**Fix:** `jamco-astro-frontend/src/components/blocks/Header.astro:112-127`
```css
/* BEFORE */
.nav-item {
  display: flex;
  align-items: center;
  gap: 6px;
  background: none;
  border: none;
  font-size: 12px;
  font-weight: 600;
  color: var(--color-primary);
  cursor: pointer;
  padding: 8px 16px;
  text-transform: uppercase;
  letter-spacing: 0.08em;  /* ← WRONG */
  text-decoration: none;
  transition: opacity 0.2s ease;
}

/* AFTER */
.nav-item {
  display: flex;
  align-items: center;
  gap: 6px;
  background: none;
  border: none;
  font-size: 12px;
  font-weight: 600;
  color: var(--color-primary);
  cursor: pointer;
  padding: 8px 16px;
  text-transform: uppercase;
  letter-spacing: 0.72px;  /* ← CORRECT */
  text-decoration: none;
  transition: opacity 0.2s ease;
}
```

---

## 8. Testimonial Component

### Background Color Variable
**Current:** Hardcoded `#3767AD`
**Should:** Add to design tokens

**Fix:** Add to `jamco-astro-frontend/src/styles/design-tokens.css`
```css
--color-testimonial-bg: #3767AD;
```

**Then update:** `jamco-astro-frontend/src/components/blocks/Testimonial.astro:62`
```css
/* BEFORE */
.testimonial {
  position: relative;
  background: #3767AD;  /* ← Hardcoded */
  color: var(--color-light);
  padding: 100px 0 120px;
  overflow: hidden;
}

/* AFTER */
.testimonial {
  position: relative;
  background: var(--color-testimonial-bg);  /* ← Use variable */
  color: var(--color-light);
  padding: 100px 0 120px;
  overflow: hidden;
}
```

---

## Summary of Files to Change

1. **`jamco-astro-frontend/src/styles/design-tokens.css`**
   - Primary blue color
   - Add overlay colors
   - Add letter spacing variables
   - Update section-gap max
   - Add feature-grid-gap
   - Add testimonial bg color

2. **`jamco-astro-frontend/src/components/blocks/Header.astro`**
   - Navigation padding (2 places)
   - Logo dimensions
   - Nav link letter-spacing

3. **`jamco-astro-frontend/src/components/blocks/Hero.astro`**
   - Subheading font size
   - H1 letter-spacing
   - Container min-height

4. **`jamco-astro-frontend/src/components/blocks/FeatureGrid.astro`**
   - Grid gap
   - H6 font weight

5. **`jamco-astro-frontend/src/components/blocks/ProductShowcase.astro`**
   - Container padding
   - H2 letter-spacing

6. **`jamco-astro-frontend/src/components/blocks/SplitFeature.astro`**
   - Content padding (vertical and horizontal)
   - H2 letter-spacing (add)

7. **`jamco-astro-frontend/src/components/blocks/Testimonial.astro`**
   - Background color (use variable)

---

## Estimated Time: 2-3 hours

All of these are straightforward CSS changes with no design ambiguity.
