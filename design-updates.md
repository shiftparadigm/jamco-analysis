# Design Updates Required

## Hero Section
- [ ] **Gradient Overlay**: The bottom gradient fade in the screenshot appears too abrupt/dark compared to the smoother transition in the reference.
- [ ] **Navigation**: Ensure the logo positioning matches exactly (padding from top/left).
- [ ] **Typography**: "Premium Seating" heading weight looks slightly lighter in screenshot than reference.

## Section 2 (Product Overview)
- [ ] **Spacing**: Vertical spacing between the "Premium Seating" heading and the carousel indicator "01 / 02" needs adjustment.
- [ ] **Image Scaling**: The product image in the screenshot seems to be cropped differently or has different aspect ratio compared to reference.

## Section 3 (Feature Grid)
- [ ] **Icons/Images**: Verify the size of the icons/images in the 3-column grid. Reference shows them as quite large.
- [ ] **Alignment**: Text in the grid columns should be perfectly left-aligned with the images.

## Section 4 & 5 (Split Features)
- [ ] **Background Color**: The blue background in the "Control & Comfort" section (if applicable) needs to match the specific `rgb(3, 35, 67)` or `rgb(11, 89, 169)` tone.
- [ ] **Bullet Points**: Check the custom bullet styling (pipes `|` or specific dots).
- [ ] **Button Alignment**: Ensure "Contact Us" buttons are aligned with the text block bottom.

## General
- [ ] **Fonts**: Verify `Space Grotesk` is loading correctly for all headings.
- [ ] **Padding**: Global section padding seems inconsistent in screenshots.

## Testimonial Section
- [ ] **Quote Style**: Verify the dashed border implementation matches the reference's specific dash pattern and color.
- [ ] **Avatar**: Ensure the avatar image is perfectly circular and centered if applicable.

## Footer
- [ ] **Layout**: Confirm the two-tier layout (dark blue + copyright bar) matches the reference's vertical spacing.

## Schema & Code Analysis
- [ ] **Hero Gradient**: `HeroCarousel.astro` uses a hardcoded linear gradient. Reference likely requires a smoother, custom gradient or an image overlay.
- [ ] **Hero Hotspots**: Hardcoded to `var(--color-primary)`. Design might need specific opacity or color overrides.
- [ ] **Split Feature Backgrounds**: `splitFeatureBlock.ts` only offers 'white', 'light-blue', 'blue'. The design uses a "Dark Blue" (`rgb(3, 35, 67)`) which is missing from the schema options and frontend mapping.
- [ ] **Bullet Points**: `SplitFeature.astro` hardcodes `•`. Design uses pipes `|` or other styles in some contexts.
- [ ] **Feature Grid**: No schema control for icon size. Frontend defaults might be too small compared to reference.
- [ ] **Testimonial Border**: `Testimonial.astro` likely hardcodes the border style. Schema has no control for this.
