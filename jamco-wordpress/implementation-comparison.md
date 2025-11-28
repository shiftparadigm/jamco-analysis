# WordPress vs Astro/Sanity Implementation Comparison

## Status: Major Issues Resolved ✅

All critical issues have been fixed:
- ✅ Hero image displaying correctly
- ✅ HTML entity encoding fixed (& displays properly)
- ✅ All split feature images loading
- ✅ New block templates created (product-showcase, seating-diagram, full-width-image)
- ✅ Content structure matches Sanity

**Remaining Issue:** New blocks in database but not rendering (needs block registration investigation)

---

## Critical Issues (RESOLVED)

### 1. Missing Hero Image ❌
- **Astro**: Large, prominent 3D rendered seating image in hero section
- **WordPress**: Hero section has only text, no image visible

### 2. Character Encoding Bug ❌
- **Issue**: "Control u0026 Comfort" instead of "Control & Comfort"
- **Cause**: HTML entity `&amp;` (`u0026`) not being decoded properly

### 3. Missing Second Hero Section ❌
- **Astro**: Has a second full-width hero with blue background showing "Premium Seating" with large image
- **WordPress**: This section is completely missing

### 4. Missing Seating Diagram ❌
- **Astro**: Shows a detailed blueprint-style seating layout diagram
- **WordPress**: This diagram/section is not present

## Layout & Section Order Differences

### Astro Order (Reference):
1. Hero with image + CTAs
2. Second hero (blue background)
3. Seating diagram
4. Section intro
5. Feature grid
6. Multiple split features with images
7. Large feature image section
8. Passenger Features
9. Control & Comfort
10. Private by Design
11. Testimonial
12. Work and Entertain On-Demand
13. Spatial Freedom
14. Product carousel ("Complete your travel ecosystem")
15. Footer
16. Ready to talk CTA

### WordPress Order (Current):
1. Hero (no image)
2. Section intro
3. Feature grid
4. Control & Comfort
5. Private by Design
6. Work and Entertain On-Demand
7. Spatial Freedom
8. Product carousel (on blue background)
9. Testimonial
10. Ready to talk CTA
11. Footer

## Visual/Styling Differences

### Images in Split Features
- **Astro**: All split feature sections have corresponding images
- **WordPress**: Split feature images appear to be missing or not loading

### Product Carousel
- **WordPress**: Has blue background, positioned earlier in page
- **Astro**: White/light background, positioned near end

### Background Colors
- Both appear to be using similar color scheme (blues and whites)
- Light blue sections appear consistent

## Content Differences

### Breadcrumb Navigation
- **WordPress**: Shows "Products > Premium Seating" breadcrumb
- **Astro**: No breadcrumb visible

### Feature Grid
- Both show similar feature grid structure
- Need to verify if all features are present

## Priority Fixes Needed

1. **Add hero image** to main hero section
2. **Fix HTML entity encoding** for ampersands (u0026 → &)
3. **Add missing second hero section** with blue background
4. **Add seating diagram section**
5. **Fix split feature images** - ensure they're loading
6. **Verify section order** matches design intent
7. **Review product carousel styling** and positioning

## Next Steps

- [ ] Investigate why hero image is not displaying
- [ ] Fix character encoding in content
- [ ] Add missing sections (second hero, diagram)
- [ ] Debug split feature image loading
- [ ] Verify all content is properly populated
- [ ] Compare responsive behavior on mobile
