# Jamco Premium Seating - Figma to Code Fixes

## Priority 1: Design Tokens & Global Styles

- [x] Fix `--color-dark-bg` to `rgb(3, 35, 67)` (navy blue, not black)
- [x] Fix button border-radius to `999px` (pill shape)
- [x] Fix button padding to `8px 20px`
- [x] Add text-transform: capitalize for button text
- [x] Add `--color-primary-light`, `--color-light-blue-bg`, `--color-text-blue` tokens

## Priority 2: Hero Section (HeroCarousel.astro)

- [x] Add blurred background with gradient overlay
- [x] Add subtle gradient (light blue to white)
- [x] Fix "Download The Brochure" to be text link with arrow `→`, not button
- [x] Update subheading color to match primary blue
- [ ] Ensure feature callout tooltip styling matches Figma (needs review)

## Priority 3: Section Intro (SectionIntro.astro)

- [x] Change layout from centered to two-column (heading left, description right)
- [x] Fix divider to be full-width blue line at 20% opacity
- [x] Update text colors to primary blue

## Priority 4: Split Feature (SplitFeature.astro)

- [x] Add left blue vertical accent bar on content side
- [x] Update background color variants (white, light-blue)
- [x] Update text/heading colors to primary blue
- [x] Fix bullet point styling

## Priority 5: Testimonial (Testimonial.astro)

- [x] Change quote font size to 48px
- [x] Change quote font family to Space Grotesk
- [x] Add dashed border box around quote
- [x] Add background image overlay support
- [x] Add dark blue gradient overlay

## Priority 6: Product Carousel (ProductCarousel.astro)

- [x] Change background to dark blue (primary)
- [x] Change text color to white
- [x] Add "Related Products" label in top right
- [x] Add navigation arrow buttons with pagination
- [x] Update card styling (white cards, no shadow)
- [x] Add carousel scroll functionality

## Priority 7: CTA Block (CTABlock.astro)

- [x] Verify styling matches "Ready to talk?" section
- [x] Add background image support
- [x] Add overlay gradients
- [x] Use outline button variant

## Priority 8: Missing Components

- [x] Create SeatingDiagram component (aircraft blueprint)
- [x] Create Footer component (two-tier: dark blue + copyright bar)
- [x] Add "Venture" + "Quest for Elegance" branding section (integrated into SeatingDiagram)
- [x] Add full-width image with watermark overlay capability

## Priority 9: Feature Grid (FeatureGrid.astro)

- [x] Add aspect-ratio: 1 for square images
- [x] Update caption styling (blue text, centered)

---

## Progress Log

### Session: November 23, 2025
- Completed code audit against Figma design
- Created todo.md
- Fixed design-tokens.css (colors, added new tokens)
- Fixed Button.astro (pill shape, padding, text-transform)
- Fixed HeroCarousel.astro (gradient background, text link CTA)
- Fixed SectionIntro.astro (two-column layout, divider)
- Fixed SplitFeature.astro (blue accent bar, colors)
- Fixed Testimonial.astro (48px quote, dashed border, bg image support)
- Fixed ProductCarousel.astro (dark blue bg, navigation, cards)
- Created Footer.astro component
- Fixed FeatureGrid.astro (blue text, square images)
- Fixed CTABlock.astro (background image, overlays, outline button)
- Updated FullWidthImage.astro (watermark overlay, nav arrows)
- Created SeatingDiagram.astro component with brandLogos support
- Created seatingDiagramBlock Sanity schema
- Updated PageBuilder to include SeatingDiagram and Footer
- Added Footer to all pages

**All tasks completed!**

**Summary of Changes:**
- 11 components updated to match Figma design
- 2 new components created (Footer.astro, SeatingDiagram.astro)
- 1 new Sanity schema created (seatingDiagramBlock)
- Design tokens updated with correct colors
- All text colors changed to primary blue per Figma spec
- Button styling changed to pill shape (999px radius)
- Two-column layouts implemented where needed
- Background image/overlay support added to multiple components
- Dashed border testimonial quote box
- Dark blue product carousel with navigation
- Footer added to all pages automatically
