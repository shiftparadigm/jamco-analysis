# Scripts

Utility scripts for content management, image processing, and deployment tasks.

## Usage

All scripts require the `SANITY_TOKEN` environment variable:

```bash
SANITY_TOKEN='your-token-here' node scripts/content/script-name.js
```

Or set it in your environment:
```bash
export SANITY_TOKEN='your-token-here'
node scripts/content/script-name.js
```

## Directory Structure

### `content/`
Scripts for managing and updating Sanity CMS content.

- **`populate-content.js`** - Initial content population for the Premium Seating page
- **`rebuild-content.js`** - Rebuild content structure from scratch
- **`update-content-final.js`** - Final content updates and refinements
- **`check-content.js`** - Validate and inspect current content structure
- **`fix-content-order.js`** - Reorder content blocks on pages
- **`update-design-fixes.js`** - Apply design specification updates to content
- **`fix-ui-issues.js`** - Fix UI-related content issues
- **`update-testimonial-bg.js`** - Update testimonial block background colors
- **`update-hero-carousel.js`** - Modify hero carousel content
- **`add-second-hero.js`** - Add second image to hero carousel
- **`fix-second-hero-image.js`** - Fix second hero image reference
- **`add-hotspots.js`** - Add interactive hotspots to carousel images

### `images/`
Scripts for uploading and managing images in Sanity.

- **`upload-images.js`** - Upload images from `exported-images/` to Sanity
- **`fix-images.js`** - Fix broken image references in content
- **`update-showcase-image.js`** - Update product showcase images

### `screenshots/`
Scripts for capturing reference screenshots of the site.

- **`capture-screenshots.js`** - Capture desktop screenshots of site sections
- **`capture-mobile.js`** - Capture mobile viewport screenshots

### `deployment/`
Scripts for deployment and webhook configuration.

- **`update-webhook.js`** - Update Sanity webhook configuration

## Common Patterns

### Running Content Scripts

Most content scripts follow this pattern:

```javascript
import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN,
  useCdn: false,
  apiVersion: '2024-01-01'
})

// Script logic here
```

### Image Upload Scripts

Image scripts typically:
1. Read images from a local directory
2. Upload to Sanity using the Assets API
3. Link uploaded assets to content documents

### Screenshot Scripts

Screenshot scripts use Playwright to:
1. Navigate to localhost:4321
2. Capture specific sections or viewports
3. Save to `screenshots/` directory

## Environment Variables

- **`SANITY_TOKEN`** (required) - Write token for Sanity API access
- **`SANITY_PROJECT_ID`** (optional) - Defaults to 'c94x8u55'
- **`SANITY_DATASET`** (optional) - Defaults to 'production'

## Notes

- These scripts are one-off utilities, not production application code
- Most scripts modify production data - use with caution
- Always test queries before running mutations
- Keep scripts for historical reference and future migrations

## Dependencies

Scripts may require:
- `@sanity/client` - Sanity API client
- `playwright` - Browser automation (screenshots)
- Node.js 18+ with ES modules support
