# Likewize WordPress Gutenberg Block Plan

## Overview
Convert the Likewize Device Protection HTML page into a fully-editable WordPress site using Gutenberg blocks. Deploy as a containerized WordPress instance that can replace the existing JAMCO deployment.

---

## Page Structure Analysis

### 1. **Hero Block** (lines 93-156)
**Purpose:** Main landing section with dual-column layout
- **Left Column:**
  - Badge (with icon/dot + text)
  - Main heading (with highlighted span)
  - Description paragraph
  - Two CTA buttons (primary + secondary)
- **Right Column:**
  - Decorative "Coverage Status" card
  - Device info display
  - Billing info
  - "Manage Device" button

**Key Features:**
- Custom clip-path background effect
- Abstract SVG background pattern
- Responsive grid layout
- Animated badge dot
- Card with rotation hover effect

---

### 2. **Feature Grid Block** (lines 158-202)
**Purpose:** Display 4 coverage types in card grid
- Section heading + description
- 4 cards in responsive grid (4 cols desktop, 2 cols tablet, 1 col mobile)
- Each card contains:
  - Icon with background color
  - Title
  - Description
  - Hover effect (icon background changes)

**Key Features:**
- Lucide icon integration
- Color-coded icons (red, blue, gray, purple)
- Group hover effects
- Soft shadows

---

### 3. **Process Steps Block** (lines 204-290)
**Purpose:** Show claims process with visual timeline
- **Left Column (50%):**
  - Section heading
  - Description
  - 3 numbered steps with icon circles
  - Each step: title + description
- **Right Column (50%):**
  - Decorative claim status card
  - Visual timeline with 3 stages:
    - Claim Approved (completed, green)
    - Replacement Shipped (active, blue, pulsing)
    - Delivered (pending, gray)
  - CTA button at bottom

**Key Features:**
- Numbered circle badges
- Vertical timeline with connecting line
- Status indicators (completed/active/pending)
- Animated pulse on active step
- Complex card layout

---

### 4. **Pricing Table Block** (lines 292-349)
**Purpose:** Display pricing tiers in table format
- Section heading + description
- Responsive table/grid with 4 columns:
  - Column 1: Feature name (with icon)
  - Columns 2-4: Tier pricing
- 4 rows:
  - Monthly Premium
  - Screen Repair Deductible
  - Replacement Deductible
  - Claim Limit (spans 3 columns)
- Highlighted "recommended" column

**Key Features:**
- Icons in row labels
- Highlighted column styling
- Responsive collapse on mobile
- Hover effects on rows
- Badge in claim limit row

---

### 5. **FAQ Accordion Block** (lines 351-397)
**Purpose:** Collapsible Q&A section
- Section heading
- Repeatable FAQ items:
  - Question button (with chevron icon)
  - Collapsible answer content
  - Border styling
- JavaScript accordion functionality

**Key Features:**
- Smooth expand/collapse animation
- Rotating chevron icons
- Only one item open at a time
- Accessible keyboard navigation

---

## Block Development Plan

### **Phase 1: Core Blocks (Reuse from JAMCO where possible)**

#### Block 1: `likewize/hero`
**Editable Fields:**
- Badge text (text)
- Badge icon toggle (boolean)
- Main heading (rich text)
- Highlighted heading text (text)
- Description (textarea)
- Primary CTA label + URL (text + URL picker)
- Secondary CTA label + URL (text + URL picker)
- **Card Fields:**
  - Card title (text)
  - Status label (text)
  - Status color (color picker)
  - Device name (text)
  - Plan name (text)
  - Billing amount (text)
  - Button label (text)
- Background color (color picker)
- Enable/disable card (toggle)

**Styling Options:**
- Background overlay opacity
- Clip-path toggle
- Text alignment
- Card rotation angle

**Template:**
```php
<section class="hero-likewize">
  <div class="container">
    <div class="hero-content">
      <!-- Badge, heading, CTAs -->
    </div>
    <div class="hero-card">
      <!-- Coverage status card -->
    </div>
  </div>
</section>
```

---

#### Block 2: `likewize/feature-grid`
**Editable Fields:**
- Section heading (text)
- Section description (textarea)
- Features (repeater, max 4-6 items):
  - Icon name (icon picker - Lucide icons)
  - Icon color (color picker)
  - Title (text)
  - Description (textarea)

**Styling Options:**
- Columns (2, 3, 4)
- Card background color
- Hover effect color
- Shadow intensity

**Similarities to JAMCO:**
- Similar to JAMCO's `feature-grid-block`
- Can reuse card styling
- Different icon system (Lucide vs images)

---

#### Block 3: `likewize/process-steps`
**Editable Fields:**
- Section heading (text)
- Description (textarea)
- Steps (repeater, typically 3):
  - Number badge color (color picker)
  - Title (text)
  - Description (textarea)
- **Timeline Card:**
  - Card heading (text)
  - Reference number (text)
  - Timeline items (repeater, 3-4):
    - Icon (icon picker)
    - Status (select: completed/active/pending)
    - Label (text)
    - Timestamp (text, optional)
  - CTA button label + URL

**Styling Options:**
- Timeline line color
- Status colors (completed/active/pending)
- Enable/disable card
- Two-column layout toggle

**New Pattern:**
- Vertical timeline is NEW (not in JAMCO)
- Numbered steps similar to JAMCO's process blocks

---

#### Block 4: `likewize/pricing-table`
**Editable Fields:**
- Section heading (text)
- Description (textarea)
- Column headers (repeater, 4 items):
  - Tier name (text)
  - Tier description (text)
  - Highlight toggle (boolean)
- Rows (repeater):
  - Feature label (text)
  - Icon (icon picker)
  - Tier 1 value (text)
  - Tier 2 value (text)
  - Tier 3 value (text)
  - Highlighted tier (select)
  - Full-width toggle (for claim limit row)

**Styling Options:**
- Header background color
- Highlighted column color
- Border colors
- Hover effects

**New Pattern:**
- Table/grid layout is NEW
- More complex than JAMCO's simple feature comparisons

---

#### Block 5: `likewize/faq-accordion`
**Editable Fields:**
- Section heading (text)
- FAQ items (repeater):
  - Question (text)
  - Answer (rich text)
  - Initial state (open/closed)

**Styling Options:**
- Background colors
- Border styling
- Chevron icon style
- Animation speed

**JavaScript Requirements:**
- Accordion toggle functionality
- Icon rotation animation
- Max-height transitions
- Single-item-open vs multi-open mode

**Similar to JAMCO:**
- JAMCO doesn't have accordions
- This is a NEW interactive pattern

---

### **Phase 2: Theme Foundation**

#### Design System
```css
/* Likewize Color Palette */
:root {
  --color-navy: #003D7C;      /* Primary brand */
  --color-red: #E63026;       /* Accent/CTA */
  --color-blue: #0070B8;      /* Secondary actions */
  --color-gray-bg: #F4F4F4;   /* Light backgrounds */

  /* Neutral palette */
  --color-slate-50: #f8fafc;
  --color-slate-100: #f1f5f9;
  --color-slate-500: #64748b;
  --color-slate-700: #334155;
  --color-slate-800: #1e293b;

  /* Shadows */
  --shadow-soft: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
  --shadow-card: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
```

#### Typography
- **Font:** Public Sans (Google Fonts)
- **Weights:** 300, 400, 600, 700
- **Scale:**
  - Headings: 3xl (1.875rem) - 6xl (3.75rem)
  - Body: base (1rem)
  - Small: sm (0.875rem), xs (0.75rem)

#### Icon System
- **Library:** Lucide Icons (https://lucide.dev)
- **Implementation:**
  - Option 1: Enqueue Lucide from CDN
  - Option 2: Bundle specific icons as SVGs
  - Option 3: Create SVG icon picker in block editor

---

### **Phase 3: Technical Implementation**

#### Block Structure (Following JAMCO Pattern)
```
theme/
├── blocks/
│   ├── hero/
│   │   ├── block.json
│   │   ├── edit.js
│   │   ├── save.js
│   │   ├── style.css
│   │   └── editor.css
│   ├── feature-grid/
│   ├── process-steps/
│   ├── pricing-table/
│   └── faq-accordion/
├── inc/
│   ├── blocks.php           # Register blocks
│   ├── icons.php            # Icon system
│   └── enqueue.php          # Scripts/styles
└── functions.php
```

#### Key Differences from JAMCO:
1. **Icon System:** Lucide vs image uploads
2. **Interactive Elements:** Accordion needs JS
3. **Timeline Component:** New visual pattern
4. **Table/Grid:** More complex than JAMCO's grids
5. **Clip-path effects:** Custom CSS shapes

---

### **Phase 4: Data Migration**

#### Content Extraction from HTML
1. **Hero Section:**
   - Heading: "Stay Connected. Stay Protected."
   - Subheading: "Protection powered by Likewize"
   - Description: "Life happens. From cracked screens..."
   - CTA 1: "View Program Details"
   - CTA 2: "Check Deductible"

2. **Coverage Cards:**
   - Liquid Damage (droplets icon, red)
   - Screen Cracks (smartphone-nfc icon, blue)
   - Theft & Loss (user-x icon, gray)
   - Hardware Failure (zap-off icon, purple)

3. **Process Steps:**
   - File a Claim 24/7
   - Pay Deductible
   - Get Reconnected

4. **Pricing Tiers:**
   - Tier 1: $7/mo, $29 screen, $99 replacement
   - Tier 2: $12/mo, $29 screen, $199 replacement
   - Tier 3: $18/mo, $49 screen, $299 replacement

5. **FAQs:**
   - When does coverage start?
   - What info needed to file claim?
   - Can I go to Apple Store?

#### WordPress Page Setup
```php
// Page template: page-likewize.php or Full Width template
// Post name: "device-protection" or custom slug
// Blocks in order:
1. likewize/hero
2. likewize/feature-grid
3. likewize/process-steps
4. likewize/pricing-table
5. likewize/faq-accordion
```

---

## Deployment Strategy

### Container Setup (Same as JAMCO)
```dockerfile
# Dockerfile.likewize
FROM wordpress:6.4-php8.1-apache

# Install MySQL, WP-CLI, etc (same as JAMCO)
RUN apt-get update && apt-get install -y \
    mysql-server \
    ...

# Copy Likewize theme
COPY theme /var/www/html/wp-content/themes/likewize

# Import database with Likewize content
COPY db-init/likewize.sql /docker-entrypoint-initdb.d/
```

### Deployment Options
1. **Replace JAMCO site:** Update jamco-wp-app container
2. **Separate deployment:** New App Service (jamco-likewize-app)
3. **Multi-site:** WordPress multisite with both themes

### URL Structure
- **Option A:** Replace existing site
  - https://jamco-wp-app.azurewebsites.net/ (becomes Likewize)
- **Option B:** New deployment
  - https://likewize-wp-app.azurewebsites.net/
- **Option C:** Subdomain/path
  - https://jamco-wp-app.azurewebsites.net/device-protection/

---

## Implementation Checklist

### Phase 1: Block Development (Est. 4-6 hours)
- [ ] Set up WordPress theme structure
- [ ] Implement icon system (Lucide)
- [ ] Create `hero` block
- [ ] Create `feature-grid` block
- [ ] Create `process-steps` block (with timeline)
- [ ] Create `pricing-table` block
- [ ] Create `faq-accordion` block (with JS)
- [ ] Add block styles and editor styles
- [ ] Test block interactions in editor

### Phase 2: Content Migration (Est. 1-2 hours)
- [ ] Extract content from HTML
- [ ] Create WordPress page
- [ ] Add all blocks with content
- [ ] Configure block settings
- [ ] Add icon selections
- [ ] Test responsive layouts

### Phase 3: Styling & Polish (Est. 2-3 hours)
- [ ] Match design system (colors, fonts, spacing)
- [ ] Implement clip-path hero effect
- [ ] Add hover animations
- [ ] Test accordion functionality
- [ ] Verify timeline styling
- [ ] Mobile responsiveness check
- [ ] Cross-browser testing

### Phase 4: Containerization (Est. 1-2 hours)
- [ ] Create Dockerfile.likewize
- [ ] Set up database with content
- [ ] Configure fix-urls.sh for Likewize
- [ ] Test local Docker build
- [ ] Export database with content

### Phase 5: Deployment (Est. 1 hour)
- [ ] Build and push Docker image
- [ ] Deploy to Azure App Service
- [ ] Configure environment variables
- [ ] Test deployed site
- [ ] Verify admin access
- [ ] Performance check

**Total Estimated Time:** 10-15 hours

---

## Key Technical Challenges

### 1. **Icon System Integration**
**Challenge:** Lucide uses SVG icons via JavaScript
**Solutions:**
- Option A: Load Lucide from CDN, use data attributes
- Option B: Create SVG icon library in PHP
- Option C: Use WordPress Dashicons or Font Awesome
**Recommendation:** Option B (SVG library) for performance

### 2. **Accordion JavaScript**
**Challenge:** Block editor doesn't support inline `onclick`
**Solutions:**
- Use `wp_add_inline_script()` to enqueue accordion JS
- Add event listeners in theme's main JS file
- Use vanilla JS, not jQuery, to match HTML
**Recommendation:** Enqueue separate accordion.js file

### 3. **Timeline Component**
**Challenge:** Complex CSS with ::before pseudo-element for line
**Solutions:**
- Use InnerBlocks for timeline items
- CSS Grid for alignment
- Data attributes for status (completed/active/pending)
**Recommendation:** Custom CSS with data-status attributes

### 4. **Pricing Table Responsiveness**
**Challenge:** Table breaks on mobile, needs card layout
**Solutions:**
- CSS Grid with responsive template columns
- Media queries to stack on mobile
- Consider using WordPress Table block as base
**Recommendation:** Custom responsive grid, not actual `<table>`

### 5. **Clip-path Hero Effect**
**Challenge:** Custom SVG shape on hero background
**Solutions:**
- Add clip-path CSS to hero block
- Make it toggleable in block settings
- Provide fallback for older browsers
**Recommendation:** CSS clip-path with toggle option

---

## Reusable Components from JAMCO

### What We Can Reuse:
1. ✅ **Container/Grid System** - Same responsive grid patterns
2. ✅ **Card Component** - Feature cards similar to JAMCO
3. ✅ **Button Styles** - CTA buttons match JAMCO patterns
4. ✅ **Section Headers** - Heading + description pattern
5. ✅ **Docker Infrastructure** - Same Dockerfile approach
6. ✅ **Deployment Scripts** - Same Azure deployment process

### What's New for Likewize:
1. ❌ **Icon System** - Need Lucide integration (JAMCO used images)
2. ❌ **Accordion** - Interactive collapse/expand (new JS)
3. ❌ **Timeline** - Vertical status timeline (new component)
4. ❌ **Pricing Table** - Grid-based table (more complex than JAMCO)
5. ❌ **Clip-path Effects** - Custom CSS shapes (JAMCO didn't use)

---

## Success Criteria

### Functional Requirements:
- [ ] All content from HTML is editable in WordPress
- [ ] Blocks render identically to original HTML design
- [ ] Accordion opens/closes smoothly
- [ ] Timeline displays status correctly
- [ ] Pricing table is responsive
- [ ] All links and buttons work
- [ ] Icons display correctly

### Technical Requirements:
- [ ] Site loads in <2 seconds
- [ ] Works on mobile, tablet, desktop
- [ ] Accessible (WCAG AA)
- [ ] Works in Chrome, Firefox, Safari, Edge
- [ ] Container builds successfully
- [ ] Deploys to Azure without errors

### WordPress Requirements:
- [ ] All blocks appear in block inserter
- [ ] Block editor is user-friendly
- [ ] No errors in browser console
- [ ] Blocks save/load correctly
- [ ] Preview matches frontend

---

## Next Steps

1. **Create theme structure** - Set up WordPress theme files
2. **Implement first block (hero)** - Start with simplest block
3. **Test block in WordPress** - Ensure it works in editor
4. **Iterate through all blocks** - Build remaining 4 blocks
5. **Create page with content** - Migrate HTML content to blocks
6. **Containerize** - Build Docker image with theme
7. **Deploy** - Push to Azure App Service

**Ready to begin implementation?**
