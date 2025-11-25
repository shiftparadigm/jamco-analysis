# Figma Design Analysis: Jamco Premium Seating Product Page

**File:** `/home/tony/projects/timbertech-analysis/frame4-clean.json`
**Size:** 687KB (17,649 lines)
**Design:** Aircraft interior product page (Jamco Premium Seating)

---

## Executive Summary

This Figma export represents a single-page product landing page for Jamco's Premium Seating product. The design follows a modern, content-rich layout with full-width sections alternating between content and imagery. The page is 8,769px tall and 1,440px wide (desktop layout).

**Key Characteristics:**
- Single-page scroll layout with 12+ distinct sections
- Heavy use of full-bleed background images
- Feature-focused content blocks with image/text split layouts
- Minimal navigation (header + footer)
- Strong emphasis on product photography and lifestyle imagery
- Clean, modern typography using Inter, Space Grotesk, and Roboto

---

## 1. Page Structure & Sections

### Overall Layout
- **Total height:** 8,769px
- **Width:** 1,440px (desktop)
- **Total nodes:** 254 elements
- **Sections:** 16 major frames/groups

### Section Hierarchy (Top to Bottom)

#### 1. **Hero Section** (`Frame 4`)
- **Size:** 1440x877px
- **Purpose:** Main hero with headline, tagline, and primary CTA
- **Elements:** Background image with blur effect, heading, description, dual CTAs
- **Y-position:** -6227 (top)

#### 2. **Header/Navbar** (`Navbar / 6 /`, `Main Container`)
- **Size:** 1440x72px
- **Purpose:** Global navigation
- **Y-position:** -6227 (sticky/fixed position)

#### 3. **Footer** (`Footer`)
- **Size:** 1440x70px
- **Purpose:** Breadcrumb navigation and contact CTA
- **Y-position:** -6155

#### 4. **Product Overview** (`Frame 9`)
- **Size:** 1440x775px
- **Purpose:** Secondary hero with product tagline and main product image
- **Elements:** Large product image, tagline, carousel indicator (01/02)

#### 5. **Feature Grid** (`Container` - 3-column layout)
- **Size:** 1368x478px
- **Purpose:** Showcase 3 key features with icons/images
- **Layout:** 3 equal columns (~432px each)
- **Features:**
  - Direct aisle access for every passenger
  - Premium density without the compromise
  - Optimized living space with smart storage

#### 6. **Section Divider** (`Frame 18`)
- **Size:** 1440x122px
- **Purpose:** Section heading with description
- **Content:** "Our Premium Seating features"

#### 7. **Full-Width Image Gallery** (`Frame 31`)
- **Size:** 1440x658px
- **Purpose:** Large lifestyle imagery showing product in context

#### 8. **Section Divider** (`Frame 9`)
- **Size:** 1440x159px
- **Purpose:** "Passenger Features" section intro

#### 9. **Feature Showcase - Control & Comfort** (`Frame 19` - Container 1)
- **Size:** 1440x648px
- **Layout:** Split layout (image right, content left)
- **Content:**
  - Heading: "Control & Comfort"
  - Description + bullet list
  - CTA button

#### 10. **Feature Showcase - Private by Design** (`Frame 19` - Container 2)
- **Size:** 1440x648px
- **Layout:** Split layout (image left, content right)
- **Content:**
  - Heading: "Private by Design"
  - Description + bullet list
  - CTA button

#### 11. **Feature Showcase - Work and Entertain** (Multiple `Container` instances)
- **Size:** 1440x648px (repeated 3 times)
- **Layout:** Alternating split layouts
- **Content:** Same pattern as above sections

#### 12. **Testimonial/Quote** (`CTA / 25 /`)
- **Size:** 1440x618px
- **Purpose:** Social proof with avatar and quote
- **Content:**
  - Quote: "This isn't just a seat. It's a mobile office, entertainment center, and personal sanctuary."
  - Attribution: Maria Smith, CEO, Global Innovations

#### 13. **Related Products Carousel** (`Frame 22` - `Product / 11 /`)
- **Size:** 1440x866px
- **Purpose:** Cross-sell related products
- **Layout:** Horizontal scrolling carousel (indicated by 01/04)
- **Products:**
  - Flight Deck Doors and Linings
  - Dividers & Partitions
  - Closets & Stowage
  - Lavatories
  - Comfort module

#### 14. **Pricing Section** (within `Frame 22`)
- **Size:** Part of carousel
- **Content:**
  - "Essential" plan: $89
  - "Pro" plan: $159

#### 15. **CTA Section** (`Frame 22` - bottom portion)
- **Size:** 1440x383px
- **Purpose:** Final conversion point
- **Content:**
  - Heading: "Ready to talk?"
  - Subheading: "Our team is ready to meet your needs."
  - CTA button

#### 16. **Footer** (`Frame 28` - `Group 5`)
- **Size:** 1440x231px (with logo group)
- **Purpose:** Site footer with logo, contact info, copyright
- **Content:**
  - Jamco logo
  - Company names: "Jamco America, Inc" / "Jamco Corporation"
  - Contact: "AOG: 425-232-0770 Office: 425-347-4735"
  - Copyright: "© 2025 Jamco America. All rights reserved."

---

## 2. Component Types

### Reusable Components Defined
The Figma file includes 2 component definitions:
1. **Platform=X (Twitter), Color=Negative** - Social media icon component
2. **Platform=LinkedIn, Color=Negative** - Social media icon component

### UI Pattern Components (Observed)

#### A. **Hero Block**
- Full-width background image with overlay
- Large heading (96px)
- Supporting text (16px)
- Dual CTAs (primary + secondary)
- Optional floating image/video element

#### B. **Feature Card** (3-column grid)
- Icon/image placeholder (432x432px)
- Heading (16px, Semi Bold)
- Optional description text
- Used in grid layout (3 across)

#### C. **Split Feature Block**
- 50/50 split layout (666px content, 774px image)
- Large heading (64px)
- Body text (18px)
- Bullet-style feature list
- CTA button
- Background image on one side
- Alternates left/right

#### D. **Section Header**
- Full-width container
- Heading (48px)
- Description text (18px)
- Optional horizontal line separator

#### E. **Product Card** (Carousel item)
- Image placeholder (varied sizes)
- Product name heading (18px)
- Optional price indicator (22px)
- Optional label/badge (14px)

#### F. **Testimonial Block**
- Large quote text (48px)
- Avatar image (circular)
- Name (16px)
- Title/company (14px)

#### G. **CTA Block**
- Centered layout
- Heading (52px)
- Supporting text (18px)
- Button
- Background rectangle with optional gradient/image

#### H. **Button Component**
- Primary button style (solid fill)
- Text: 14px, Semi Bold
- Padding: appears to be 16-24px horizontal
- Observed variants:
  - "Contact Us" (primary CTA)
  - "View premium seating suite" (secondary style)
  - "Download the Brochure" (secondary style)

### Navigation Elements

#### Header/Navbar
- Logo (144x35.25px) - Jamco logo image
- Minimal navigation (no visible menu items in this export)
- Transparent/overlay on hero

#### Footer
- Breadcrumb navigation: "Products > Premium Seating"
- Single CTA button: "Contact Us"
- Secondary footer with logo, contact info, copyright

#### Interactive Elements
- Carousel indicators: "01 / 02", "01 / 04" format
- Multiple "Contact Us" CTAs throughout
- Link to "Products" category

---

## 3. Content Blocks

### Block Type Inventory

#### **Block Type 1: Hero**
- **Count:** 2 instances
- **Fields:**
  - Heading (H1, 96px)
  - Tagline/Description (16px)
  - Primary CTA button
  - Secondary CTA button
  - Background image
  - Optional floating product image
- **Layout:** Full-width, centered text
- **Special styling:** Background blur effect (172.6px radius), image overlay at 20% opacity

#### **Block Type 2: Section Intro**
- **Count:** 3 instances
- **Fields:**
  - Heading (H4, 48px)
  - Description text (18px)
  - Optional separator line
- **Layout:** Contained, centered text
- **Width:** ~1366px container

#### **Block Type 3: Feature Grid (3-column)**
- **Count:** 1 instance
- **Fields:**
  - 3 feature items, each with:
    - Image (432x432px)
    - Heading (16px)
    - Optional description
- **Layout:** 3 equal columns in 1368px container
- **Special styling:** Cards appear to have consistent spacing

#### **Block Type 4: Split Feature (Image/Content)**
- **Count:** 5 instances (alternating layouts)
- **Fields:**
  - Heading (H2, 64px)
  - Description paragraph (18px)
  - Bullet list (18px, separated by |)
  - CTA button
  - Background/feature image
- **Layout:**
  - Content area: 666px width
  - Image area: 774px width
  - Alternates left/right
- **Special styling:** Full-width (1440px), images often full-bleed

#### **Block Type 5: Full-Width Image**
- **Count:** 2 instances
- **Fields:**
  - Single large image
- **Layout:** Full-width (1440px)
- **Height:** 658-771px
- **Special styling:** No text overlay

#### **Block Type 6: Testimonial/Quote**
- **Count:** 1 instance
- **Fields:**
  - Quote text (48px, styled as quote)
  - Avatar image (circular)
  - Name (16px)
  - Title/Company (14px)
  - Separator line
- **Layout:** Centered content, ~1248px wide container
- **Special styling:** Large quote styling, prominent visual hierarchy

#### **Block Type 7: Product Carousel**
- **Count:** 1 instance
- **Fields:**
  - Section heading (52px)
  - Section tagline (18px)
  - Label: "Related Products" (12px)
  - Carousel indicator (01/04)
  - Multiple product cards:
    - Product image
    - Product name (18px)
- **Layout:** Horizontal scroll/carousel
- **Special styling:** Pagination indicator, appears to show 3-4 items at a time

#### **Block Type 8: Pricing Cards**
- **Count:** 2 card types within carousel
- **Fields:**
  - Plan name heading (18px)
  - Tier label (14px: "Essential", "Pro")
  - Price (22px: "$89", "$159")
  - Optional background image
- **Layout:** Cards within carousel
- **Special styling:** Different visual treatment from product cards

#### **Block Type 9: CTA Section**
- **Count:** 2 instances
- **Fields:**
  - Heading (52px)
  - Supporting text (18px)
  - CTA button
  - Background rectangle/color
- **Layout:** Centered content
- **Width:** ~1280px container
- **Height:** 383-618px

#### **Block Type 10: Carousel/Gallery**
- **Count:** 2 instances
- **Fields:**
  - Carousel indicator (text: "01 / 02" or "01 / 04")
  - Tagline text (20px)
  - Large product/feature image
  - Optional heading
- **Layout:** Full-width
- **Special styling:** Pagination controls

---

## 4. Typography System

### Font Families
- **Primary:** Inter (39 instances) - Body text, most UI elements
- **Secondary:** Space Grotesk (15 instances) - Headings, emphasis
- **Tertiary:** Roboto (10 instances) - UI elements, labels
- **Accent:** ABC Normal (1 instance) - Special use

### Heading Hierarchy

#### **H1 - Hero Headings**
- **Font size:** 96px
- **Font:** Space Grotesk
- **Weight:** 700 (Bold)
- **Usage:** Main page headline
- **Examples:**
  - "Jamco Premium Seating"
  - "Premium Seating"
- **Count:** 2 instances

#### **H2 - Section Headings**
- **Font size:** 64px
- **Font:** Space Grotesk
- **Weight:** 600 (Semi Bold)
- **Usage:** Major feature section headings
- **Examples:**
  - "Control & Comfort"
  - "Private by Design"
  - "Work and Entertain On-Demand"
  - "Spatial Freedom"
- **Count:** 5 instances

#### **H3 - Sub-Section Headings**
- **Font size:** 52px
- **Font:** Space Grotesk
- **Weight:** 600 (Semi Bold)
- **Usage:** Secondary section headings, CTA headings
- **Examples:**
  - "Complete your travel ecosystem"
  - "Ready to talk?"
- **Count:** 2 instances

#### **H4 - Section Intro Headings**
- **Font size:** 48px
- **Font:** Space Grotesk
- **Weight:** 600 (Semi Bold)
- **Usage:** Section introductions, testimonial quotes
- **Examples:**
  - "Our Premium Seating features"
  - "Passenger Features"
  - "This isn't just a seat..." (quote)
- **Count:** 3 instances

#### **H5 - Card Headings**
- **Font size:** 18px
- **Font:** Inter
- **Weight:** 600 (Semi Bold)
- **Usage:** Product names, feature list headings
- **Examples:**
  - "Flight Deck Doors and Linings"
  - "Dividers & Partitions"
  - Product names in carousel
- **Count:** ~21 instances

#### **H6 - Feature Titles**
- **Font size:** 16px
- **Font:** Inter
- **Weight:** 600 (Semi Bold)
- **Usage:** Feature card titles, small headings
- **Examples:**
  - "Direct aisle access for every passenger"
  - "Premium density without the compromise"
  - "Optimized living space with smart storage"
- **Count:** ~8 instances

### Body Text Styles

#### **Large Body**
- **Font size:** 20px
- **Font:** Inter
- **Weight:** 400 (Regular)
- **Usage:** Taglines, prominent descriptions
- **Examples:**
  - "Showcase every aspect of your journey."
  - "Spatial Freedom" (product feature label)
- **Count:** 2 instances

#### **Medium Body**
- **Font size:** 18px
- **Font:** Inter
- **Weight:** 400 (Regular)
- **Usage:** Main body copy, descriptions, feature lists
- **Line height:** Appears generous (likely 1.5-1.7)
- **Examples:**
  - Section descriptions
  - Feature bullet lists
  - Product descriptions
- **Count:** ~21 instances

#### **Small Body**
- **Font size:** 14px
- **Font:** Inter
- **Weight:** 500-600
- **Usage:** Button text, labels, navigation, metadata
- **Examples:**
  - "Contact Us"
  - "View premium seating suite"
  - "Download the Brochure"
  - "Products > Premium Seating"
  - Carousel indicators: "01 / 02"
- **Count:** ~15 instances

#### **Caption/Fine Print**
- **Font size:** 12px
- **Font:** Inter/Roboto
- **Weight:** 300-400 (Light/Regular)
- **Usage:** Labels, copyright, contact info, small descriptions
- **Examples:**
  - "Related Products"
  - "Configurable rests ensure passengers have the room they need"
  - "© 2025 Jamco America. All rights reserved."
  - "AOG: 425-232-0770 Office: 425-347-4735"
- **Count:** ~5 instances

#### **Price Display**
- **Font size:** 22px
- **Font:** Inter
- **Weight:** 600 (Semi Bold)
- **Usage:** Pricing information
- **Examples:**
  - "$89"
  - "$159"
- **Count:** 2 instances

### Font Weight Distribution
- **Light (300):** 10 uses - Fine print, captions
- **Regular (400):** 17 uses - Body text
- **Medium (500):** 9 uses - Emphasized body text, labels
- **Semi Bold (600):** 22 uses - Headings, buttons, product names
- **Bold (700):** 7 uses - Main headings, hero text

---

## 5. Color System

### Fill Colors

#### **Primary Brand Colors**
- **Primary Blue:** `rgb(0, 85, 172)` - Primary brand color, accent elements
- **Primary Blue Variant 1:** `rgb(0, 85, 173)` - Slight variation
- **Primary Blue Variant 2:** `rgb(11, 89, 169)` - Lighter blue, hover states

#### **Neutral Colors**
- **True Black:** `rgb(0, 0, 0)` - Pure black for text
- **Near Black 1:** `rgb(4, 4, 4)` - Dark backgrounds
- **Near Black 2:** `rgb(7, 7, 7)` - Text color
- **Dark Blue:** `rgb(3, 35, 67)` - Navy/dark blue accent
- **White:** `rgb(255, 255, 255)` - Backgrounds, light text
- **Light Gray:** `rgb(245, 245, 245)` - Light backgrounds, subtle sections
- **Light Blue Gray:** `rgb(204, 222, 235)` - Subtle accents, borders

#### **Special**
- **IMAGE fills:** 33 instances - Background images, product photos, lifestyle imagery

### Stroke/Border Colors
- **White:** `rgb(255, 255, 255)` - Lines, separators
- **Primary Blue:** `rgb(11, 89, 169)` - Accent lines, borders (at 20% opacity)

### Color Usage Patterns
- **Background:** Primarily white with dark overlay sections using near-black colors
- **Text:** Black/near-black on light backgrounds, white on dark backgrounds
- **Accents:** Primary blue for CTAs, links, and interactive elements
- **Images:** Heavy use of full-bleed background images with opacity overlays (20%)

---

## 6. Images & Media

### Image Inventory
**Total image references:** 33

### Image Types

#### **1. Background/Hero Images**
- **Count:** 3-4 instances
- **Usage:** Full-width background images with blur/overlay effects
- **Treatment:**
  - Often with 20% opacity white/dark overlay
  - Blur effect: 172.6px radius on hero
- **References:**
  - `b007ec2c6e8ddd226ddf...` (Hero background, 1440x877px)
  - `a603c6d6bf5878e7ac61...` (Screenshot/product, 730x575px)

#### **2. Logo**
- **Count:** 4 instances
- **Size:** 144x35.25px
- **Usage:** Header, footer
- **References:**
  - `360a96446b11de7b2a90...` (Jamco logo)
  - `7bfd3444586ea9c002b0...` (Jamco logo variant)

#### **3. Product Photography**
- **Count:** 10+ instances
- **Sizes:** Primarily 432x432px (feature cards) and 707x507px (large product shot)
- **Usage:** Feature grid cards, carousel items, split-screen features
- **References:**
  - `79382df862d0d1c604fc...` (Placeholder Image, 707x507px)
  - `dd205ceadcee5e8938ee...` (Placeholder Image, 432x432px)
  - `79a4cb53a9776fc148f5...` (Placeholder Image, 432x432px)
  - `57bbf5299ebd48dcf713...` (Placeholder Image, 432x432px)
  - Multiple additional placeholder references

#### **4. Lifestyle/Context Images**
- **Count:** 5-6 instances
- **Sizes:** Large format (1440px wide, various heights)
- **Usage:** Split-screen feature sections, full-width image blocks
- **Treatment:** Often as background images in feature sections

#### **5. Avatar/Testimonial Images**
- **Count:** 1 instance
- **Treatment:** Circular crop
- **Usage:** Testimonial section with quote

#### **6. Icon/Illustration Placeholders**
- **Count:** 5 instances (Group 2, Group 3 vectors)
- **Usage:** Decorative elements, feature icons
- **Treatment:** Vector graphics, SVG-style elements

### Image Scale Modes
- **FILL:** Most common - images fill their container
- Background images use fill mode to cover entire section

### Media Organization
- Images referenced by hash ID (e.g., `b007ec2c6e8ddd226ddf9721ad5aa6f94c353bb8`)
- No direct file paths - would need to be mapped to actual assets

---

## 7. Interactive Elements

### Buttons & CTAs

#### **Primary CTA Button**
- **Text:** "Contact Us"
- **Count:** 9 instances throughout page
- **Style:**
  - Size: 116x32px typical
  - Font: 14px, Semi Bold
  - Color: Likely white text on primary blue background
- **Locations:**
  - Footer
  - Feature sections (multiple)
  - Pricing/CTA sections
  - Final conversion section

#### **Secondary CTA Buttons**
- **Text:** "View premium seating suite"
- **Count:** 1 instance
- **Style:** Similar to primary but likely outlined/ghost variant
- **Location:** Hero section

#### **Tertiary CTA**
- **Text:** "Download the Brochure"
- **Count:** 1 instance
- **Style:** Link or minimal button style
- **Location:** Hero section

### Navigation Elements

#### **Header Navigation**
- **Elements:**
  - Jamco logo (clickable)
  - Minimal menu (not fully visible in export)
  - Appears to be fixed/sticky navigation

#### **Breadcrumb Navigation**
- **Format:** "Products > Premium Seating"
- **Location:** Footer area
- **Font:** 14px

#### **Carousel Controls**
- **Indicators:**
  - "01 / 02" format
  - "01 / 04" format
- **Count:** 2 carousels
- **Locations:**
  - Product showcase carousel
  - Related products carousel

#### **Footer Navigation**
- **Links:**
  - "Products" category link
  - Contact button
- **Contact Info:**
  - "AOG: 425-232-0770"
  - "Office: 425-347-4735"

### Interactive Patterns Observed

#### **Hover States** (inferred from structure)
- Button hover states likely defined in Figma prototype (not visible in JSON)
- Carousel/image gallery interactions

#### **Scroll Behaviors**
- Carousel horizontal scroll
- Possible parallax effects on background images (blur effect suggests depth)
- Fixed/sticky header navigation

### Forms
- **Count:** 0
- No visible form elements in this design
- CTAs link to contact page or trigger contact modal (likely)

---

## 8. Content Inventory

### Page Content Structure

#### **Hero Section**
- **Headline:** "Jamco Premium Seating"
- **Tagline:** "Premium-density seats with direct aisle access, optimized living space, and intuitive passenger control."
- **CTA 1:** "View premium seating suite"
- **CTA 2:** "Download the Brochure"
- **Feature Callout:** "Spatial Freedom"
- **Feature Description:** "Configurable rests ensure passengers have the room they need"

#### **Product Overview Section**
- **Tagline:** "Showcase every aspect of your journey."
- **Carousel Indicator:** "01 / 02"
- **Description:** "Direct aisle access, premium density, and curated surfaces for a calm, private environment—ready to scale across your fleet."
- **Heading:** "Premium Seating"

#### **Feature Grid Section (3 Features)**
1. "Direct aisle access for every passenger"
2. "Premium density without the compromise"
3. "Optimized living space with smart storage"

#### **Section: Our Premium Seating Features**
- **Heading:** "Our Premium Seating features"
- **Description:** "Deliver the passenger experience your brand promises, without sacrificing density or service efficiency."

#### **Section: Passenger Features**
- **Heading:** "Passenger Features"
- **Description:** "Thoughtful design that keep passengers comfortable, productive, and at ease."

#### **Feature Deep-Dive Sections**

##### Feature 1: Control & Comfort
- **Heading:** "Control & Comfort"
- **Description:** "A unified control center uses capacitive touch input with LED lighting for clear, intuitive operation. Lighting, power, and adjustments are all at the passenger's fingertips."
- **Bullet Points:**
  - "One-touch lighting"
  - "Power at hand for devices"
  - "Clear labeling for low-light use"
- **CTA:** "Contact Us"

##### Feature 2: Private by Design
- **Heading:** "Private by Design"
- **Description:** "Sliding dividers provides privacy from zero to full as needed. Shielding and geometry help reduce distractions while maintaining an open, airy feel."
- **Bullet Points:**
  - "On-demand privacy divider"
  - "Shielded sightlines and calm surfaces"
- **CTA:** "Contact Us"

##### Feature 3: Work and Entertain On-Demand
- **Heading:** "Work and Entertain On-Demand"
- **Description (Variant 1):** "An immersive HD display and spacious tray surface supports both work and relaxation. Content is accessible quickly without complicated menus."
- **Description (Variant 2):** "Immersive HD displays and spacious tray surfaces support both work briefings and relaxation. Content is accessible quickly without complicated menus."
- **Bullet Points:**
  - "Immersive HD display options"
  - "Fast access to entertainment and information"
  - "Work surface/tray for devices and notes"
- **CTA:** "Contact Us"

##### Feature 4: Spatial Freedom
- **Heading:** "Spatial Freedom"
- **Description:** "Ample space for passenger comfort and curated storage locations keep personal items tidy from taxi to touchdown."
- **Bullet Points:**
  - "Generous passenger space"
  - "Dedicated stowage for devices and small bags"
- **CTA:** "Contact Us"

#### **Testimonial Section**
- **Quote:** "This isn't just a seat. It's a mobile office, entertainment center, and personal sanctuary."
- **Attribution:** "Maria Smith"
- **Title:** "CEO, Global Innovations"

#### **Related Products Section**
- **Heading:** "Complete your travel ecosystem"
- **Description:** "Elevate every aspect of your journey."
- **Label:** "Related Products"
- **Carousel Indicator:** "01 / 04"

**Product List:**
1. Flight Deck Doors and Linings
2. Dividers & Partitions
3. Closets & Stowage
4. Lavatories
5. Comfort module

#### **Pricing Cards** (within carousel)
- **Plan 1:**
  - Tier: "Essential"
  - Price: "$89"

- **Plan 2:**
  - Tier: "Pro"
  - Heading: "Performance upgrade"
  - Price: "$159"

#### **Final CTA Section**
- **Heading:** "Ready to talk?"
- **Description:** "Our team is ready to meet your needs."
- **CTA:** "Contact Us"

#### **Footer Content**
- **Breadcrumb:** "Products > Premium Seating"
- **Company Names:** "Jamco America, Inc" / "Jamco Corporation"
- **Contact Numbers:**
  - "AOG: 425-232-0770"
  - "Office: 425-347-4735"
- **Copyright:** "© 2025 Jamco America. All rights reserved."
- **CTA:** "Contact Us"

---

## 9. Design Patterns & Layout System

### Grid System
- **Container width:** 1440px (full width)
- **Content container:** ~1366-1368px (typical max-width)
- **Narrow container:** ~1248-1280px (CTA sections, centered content)

### Spacing/Padding Observations
- **Section vertical spacing:** Appears to be 100-200px between major sections
- **Card spacing:** Consistent spacing in 3-column grid
- **Button padding:** ~16-24px horizontal

### Layout Patterns

#### **1. Full-Width Hero**
- Background image (full-bleed)
- Centered content overlay
- Max-width container for text content

#### **2. Split Screen (50/50)**
- Content: 666px
- Image: 774px
- Alternating left/right
- Full-width container (1440px)

#### **3. 3-Column Grid**
- Equal columns (~432px each)
- Contained within ~1368px
- Image above text pattern

#### **4. Centered Content Block**
- Max-width: 1248-1368px
- Center-aligned headings and text
- Used for section intros, CTAs

#### **5. Carousel/Gallery**
- Horizontal scrolling
- Pagination indicators
- Multiple items visible (3-4)

---

## 10. Recommendations for Implementation

### Sanity CMS Schema Requirements

#### **1. Page Schema**
```
- Hero Section
  - heading (string)
  - tagline (text)
  - primaryCTA (object: link + text)
  - secondaryCTA (object: link + text)
  - backgroundImage (image)
  - featureCallout (object: heading + description)

- Section Intro Block
  - heading (string)
  - description (text)
  - showDivider (boolean)

- Feature Grid Block
  - heading (string)
  - description (text)
  - features (array of objects)
    - image (image)
    - heading (string)
    - description (text, optional)

- Split Feature Block
  - heading (string)
  - description (text)
  - bulletPoints (array of strings)
  - ctaButton (object: link + text)
  - image (image)
  - imagePosition (string: 'left' | 'right')
  - backgroundImage (image, optional)

- Testimonial Block
  - quote (text)
  - avatar (image)
  - name (string)
  - title (string)
  - company (string, optional)

- Product Carousel Block
  - heading (string)
  - description (text)
  - products (array of references to Product documents)

- Pricing Card
  - tierName (string)
  - heading (string, optional)
  - price (number)
  - features (array of strings, optional)

- CTA Block
  - heading (string)
  - description (text)
  - ctaButton (object: link + text)
  - backgroundColor (color, optional)

- Full Width Image Block
  - image (image)
  - alt (string)
```

#### **2. Global Schemas**
```
- Navigation
  - logo (image)
  - menuItems (array)

- Footer
  - logo (image)
  - contactInfo (object)
    - aogPhone (string)
    - officePhone (string)
  - copyright (string)
  - ctaButton (object)

- Product Document
  - name (string)
  - slug (slug)
  - description (text)
  - images (array of images)
  - category (reference)
  - price (number, optional)
```

### Astro Component Structure

#### **Core Components**
1. `Hero.astro` - Hero section with dual CTAs
2. `SectionIntro.astro` - Section heading + description
3. `FeatureGrid.astro` - 3-column feature grid
4. `SplitFeature.astro` - Image/content split layout (alternating)
5. `Testimonial.astro` - Quote block with avatar
6. `ProductCarousel.astro` - Horizontal scrolling product showcase
7. `PricingCard.astro` - Pricing display card
8. `CTABlock.astro` - Call-to-action section
9. `FullWidthImage.astro` - Full-bleed image block
10. `Header.astro` - Global navigation
11. `Footer.astro` - Site footer
12. `Button.astro` - Reusable button component (primary/secondary variants)

#### **Layout Components**
1. `BaseLayout.astro` - Page wrapper with header/footer
2. `Container.astro` - Max-width content container (1368px)
3. `Section.astro` - Full-width section wrapper

#### **Utility Components**
1. `Image.astro` - Optimized image component
2. `CarouselIndicator.astro` - "01 / 04" pagination display

### Technical Considerations

#### **Performance**
- Implement lazy loading for images (33 images total)
- Use responsive images with `srcset`
- Consider using Astro's Image component for optimization
- Implement intersection observer for scroll animations

#### **Responsive Design**
- Desktop layout: 1440px
- Need to define tablet (768-1024px) and mobile (320-767px) breakpoints
- 3-column grid → 2-column → 1-column on mobile
- Split layouts → stacked on mobile
- Carousel → native scroll on mobile

#### **Accessibility**
- Semantic HTML structure (header, nav, main, section, footer)
- Proper heading hierarchy (h1 → h2 → h3)
- Alt text for all 33 images
- ARIA labels for carousel controls
- Focus states for buttons and links
- Color contrast compliance (check blue on white)

#### **Interactions**
- Carousel swipe gestures (mobile)
- Smooth scroll to sections (if implementing anchor navigation)
- Button hover/active states
- Possible parallax effects on hero background
- Image zoom/lightbox for product photos (optional)

---

## 11. Design System Summary

### Component Library Needed
1. **Typography:** 6 heading levels + 4 body text styles
2. **Buttons:** Primary, Secondary, Tertiary variants
3. **Cards:** Feature card, Product card, Pricing card
4. **Sections:** 9 distinct section types
5. **Navigation:** Header, Footer, Breadcrumb
6. **Media:** Image, Background Image, Avatar

### Style Tokens Required
```css
/* Colors */
--color-primary: rgb(0, 85, 172);
--color-primary-hover: rgb(11, 89, 169);
--color-dark: rgb(7, 7, 7);
--color-dark-bg: rgb(3, 35, 67);
--color-light: rgb(255, 255, 255);
--color-light-bg: rgb(245, 245, 245);
--color-light-blue: rgb(204, 222, 235);

/* Typography */
--font-primary: 'Inter', sans-serif;
--font-heading: 'Space Grotesk', sans-serif;
--font-mono: 'Roboto', sans-serif;

/* Font Sizes */
--text-h1: 96px;
--text-h2: 64px;
--text-h3: 52px;
--text-h4: 48px;
--text-h5: 18px;
--text-h6: 16px;
--text-body-lg: 20px;
--text-body: 18px;
--text-sm: 14px;
--text-xs: 12px;
--text-price: 22px;

/* Font Weights */
--weight-light: 300;
--weight-regular: 400;
--weight-medium: 500;
--weight-semibold: 600;
--weight-bold: 700;

/* Layout */
--container-max: 1440px;
--container-content: 1368px;
--container-narrow: 1280px;
--split-content: 666px;
--split-image: 774px;

/* Spacing */
--section-gap: 100px; /* approximate */
--card-gap: 24px; /* approximate */
```

### Asset Requirements
- **Logo:** 2 versions (light/dark or different sizes)
- **Product images:** 10+ high-quality product photos (432x432px minimum)
- **Background images:** 6-8 lifestyle/context images (1440px+ width)
- **Avatar images:** 1+ for testimonials
- **Icons:** Social media icons (Twitter/X, LinkedIn)

---

## 12. Content Migration Checklist

### Text Content to Migrate
- [ ] Hero headline and tagline
- [ ] 5 feature section headings and descriptions
- [ ] 12+ bullet points across features
- [ ] 1 testimonial quote with attribution
- [ ] 5 related product names
- [ ] 2 pricing tiers with prices
- [ ] Contact information (2 phone numbers)
- [ ] Copyright notice
- [ ] All button/CTA text

### Images to Source
- [ ] 1 hero background image (1440x877px)
- [ ] 1 hero product floating image (730x575px)
- [ ] 3 feature grid images (432x432px each)
- [ ] 5+ split feature images (varied sizes)
- [ ] 2 full-width lifestyle images (1440px wide)
- [ ] 5 related product images
- [ ] 1 testimonial avatar image
- [ ] 2-4 logo variations
- [ ] Social media icons

### Interactive Elements to Implement
- [ ] 9 "Contact Us" button instances
- [ ] 2 carousel controls (01/02, 01/04)
- [ ] Navigation menu (structure TBD)
- [ ] Breadcrumb navigation
- [ ] All CTA buttons with proper linking

---

## Conclusion

This Figma design represents a comprehensive, modern product landing page with:
- **12+ distinct sections** organized in a single-page scroll layout
- **9 content block types** that can be reused across pages
- **Sophisticated typography system** with 6 heading levels and 4 body styles
- **Minimal but effective color palette** focused on blues and neutrals
- **33 images** requiring optimization and responsive treatment
- **Multiple CTAs** driving to contact/conversion

The design is well-suited for implementation as a modular Astro + Sanity CMS website, with each section type mapping to a flexible content block that can be reordered and reused.

**Next Steps:**
1. Create Sanity schemas for all content block types
2. Build Astro components for each block type
3. Source/optimize all 33+ images
4. Implement responsive layouts for tablet/mobile
5. Add interactions and animations
6. Set up page builder in Sanity for flexible content management
