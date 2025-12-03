# Likewize Device Protection - WordPress Implementation

Complete WordPress theme with Gutenberg blocks for the Likewize Device Protection landing page.

## Project Structure

```
likewyze/
├── theme/                      # WordPress theme
│   ├── style.css              # Main theme stylesheet with design system
│   ├── functions.php          # Theme setup and configuration
│   ├── index.php              # Main template file
│   ├── blocks/                # Custom Gutenberg blocks
│   │   ├── editor-common.css  # Shared editor styles
│   │   ├── hero/              # Hero block (TO BE CREATED)
│   │   ├── feature-grid/      # Feature grid block (TO BE CREATED)
│   │   ├── process-steps/     # Process steps block (TO BE CREATED)
│   │   ├── pricing-table/     # Pricing table block (TO BE CREATED)
│   │   └── faq-accordion/     # FAQ accordion block (TO BE CREATED)
│   ├── inc/                   # Helper files
│   │   ├── blocks.php         # Block registration
│   │   └── icons.php          # Icon helper functions
│   └── js/                    # JavaScript files
│       ├── main.js            # Main theme scripts
│       └── accordion.js       # Accordion functionality
├── db-init/                   # Database initialization (TO BE CREATED)
│   ├── wordpress.sql          # Database with content
│   └── uploads/               # Media files (icons, etc)
├── Dockerfile                 # Docker configuration (copied from JAMCO)
├── docker-entrypoint.sh       # Container startup script
├── fix-urls.sh                # URL fixing script for deployments
├── supervisord.conf           # Supervisor config for MySQL + Apache
├── start-services.sh          # Service startup script
├── test-page.html             # Original HTML reference
├── BLOCK_PLAN.md             # Comprehensive block implementation plan
└── README.md                  # This file
```

## ✅ Completed

### Theme Foundation
- [x] **style.css** - Complete design system with CSS variables
  - Likewize color palette (Navy, Red, Blue, Slate)
  - Typography scale (Public Sans font)
  - Utility classes for layout and spacing
  - Button and card styles
  - Responsive grid system

- [x] **functions.php** - Theme setup
  - Google Fonts integration (Public Sans)
  - Lucide Icons enqueuing
  - Block registration
  - Theme supports (align-wide, responsive-embeds, etc)

- [x] **index.php** - Main template
  - Clean, minimal template that renders blocks
  - WordPress loop integration

- [x] **inc/blocks.php** - Block registration system
  - Auto-registers all blocks from `/blocks` directory
  - Creates custom "Likewize Blocks" category in editor
  - Enqueues editor assets

- [x] **inc/icons.php** - Icon system
  - Helper functions for Lucide icons
  - Icon list for use in blocks
  - Rendering functions with customizable wrapper/classes

- [x] **js/accordion.js** - Accordion functionality
  - Click handling for FAQ accordion
  - Smooth expand/collapse animations
  - Single-item-open mode
  - Icon rotation

- [x] **js/main.js** - Main theme scripts
  - Lucide icon initialization
  - Smooth scroll for anchor links

- [x] **Docker Files** - Copied from JAMCO
  - Dockerfile (updated for Likewize theme)
  - docker-entrypoint.sh
  - fix-urls.sh
  - supervisord.conf
  - start-services.sh

## 🚧 Next Steps

### 1. Create Gutenberg Blocks (4-6 hours)

Each block needs:
- `block.json` - Block configuration
- `edit.js` - Editor component
- `save.js` - Frontend rendering
- `style.css` - Frontend styles
- `editor.css` - Editor-specific styles (optional)

#### Block 1: Hero (`blocks/hero/`)
Two-column hero with badge, heading, CTAs, and decorative coverage card.

**Key features:**
- Badge with animated dot
- Dual-column responsive layout
- Primary + secondary CTA buttons
- Coverage status card (right column)
- Clip-path background effect
- Abstract SVG background

#### Block 2: Feature Grid (`blocks/feature-grid/`)
4-column grid of coverage types with icons.

**Key features:**
- Section heading + description
- Repeatable items (4 default)
- Lucide icon picker per item
- Icon color customization
- Hover effects
- Responsive (4 cols → 2 cols → 1 col)

#### Block 3: Process Steps (`blocks/process-steps/`)
Steps with timeline visualization.

**Key features:**
- Two-column layout
- Left: 3 numbered steps
- Right: Timeline card with status indicators
- Timeline states: completed, active, pending
- Animated pulse on active step

#### Block 4: Pricing Table (`blocks/pricing-table/`)
Responsive pricing table with 3 tiers.

**Key features:**
- Grid layout (not actual `<table>`)
- 4 columns: Feature name + 3 tiers
- Highlighted "recommended" column
- Icons in row labels
- Responsive collapse to cards on mobile

#### Block 5: FAQ Accordion (`blocks/faq-accordion/`)
Collapsible Q&A section.

**Key features:**
- Repeatable FAQ items
- Question/answer fields
- Chevron icon rotation
- Uses accordion.js for functionality
- Smooth transitions

### 2. Database Setup (1-2 hours)

Create database dump with Likewize content:

```bash
# Export structure from JAMCO, modify content
# Or create fresh WordPress install and export

# Files needed:
db-init/
├── wordpress.sql      # Database with page content
└── uploads/           # Any uploaded images/icons
```

### 3. Content Migration (1-2 hours)

Create WordPress page with all blocks populated from `test-page.html`:
- Hero: "Stay Connected. Stay Protected."
- Features: Liquid Damage, Screen Cracks, Theft & Loss, Hardware Failure
- Steps: File Claim, Pay Deductible, Get Reconnected
- Pricing: 3 tiers ($7/12/18 monthly)
- FAQs: 3 questions about coverage

### 4. Deployment Scripts (1 hour)

Create deployment script similar to JAMCO:

```bash
# deploy-likewize.sh
#!/bin/bash

# Build Docker image
docker build -t likewize-wordpress:latest .

# Tag for Azure Container Registry
docker tag likewize-wordpress jamcoregistry.azurecr.io/likewize-wordpress:latest

# Push to registry
docker push jamcoregistry.azurecr.io/likewize-wordpress:latest

# Deploy to new Azure App Service
az webapp config container set \
  --name likewize-wp-app \
  --resource-group likewize-rg \
  --docker-custom-image-name jamcoregistry.azurecr.io/likewize-wordpress:latest

# Restart app
az webapp restart --name likewize-wp-app --resource-group likewize-rg
```

### 5. Azure Deployment (1 hour)

Deploy as new, separate instance:

```bash
# Create new resource group
az group create --name likewize-rg --location eastus

# Create App Service plan (can reuse JAMCO's plan to save $)
az appservice plan create --name likewize-wp-plan --resource-group likewize-rg --sku B1 --is-linux

# Create Web App
az webapp create \
  --resource-group likewize-rg \
  --plan likewize-wp-plan \
  --name likewize-wp-app \
  --deployment-container-image-name jamcoregistry.azurecr.io/likewize-wordpress:latest

# Configure container registry
az webapp config container set \
  --name likewize-wp-app \
  --resource-group likewize-rg \
  --docker-registry-server-url https://jamcoregistry.azurecr.io \
  --docker-registry-server-user <username> \
  --docker-registry-server-password <password>

# Set environment variables
az webapp config appsettings set \
  --name likewize-wp-app \
  --resource-group likewize-rg \
  --settings SITE_URL=https://likewize-wp-app.azurewebsites.net
```

**Result:**
- JAMCO site: `https://jamco-wp-app.azurewebsites.net/` (unchanged)
- Likewize site: `https://likewize-wp-app.azurewebsites.net/` (new)

## Design System

### Colors
```css
--color-navy: #003D7C;      /* Primary brand */
--color-red: #E63026;       /* Accent/CTA */
--color-blue: #0070B8;      /* Secondary actions */
--color-gray-bg: #F4F4F4;   /* Light backgrounds */
--color-slate-*: /* Neutral palette */
```

### Typography
- **Font:** Public Sans (weights: 300, 400, 600, 700)
- **Scale:** h1 (3rem) → h6 (1rem)

### Icons
- **Library:** Lucide Icons (https://lucide.dev)
- **Implementation:** CDN with `lucide.createIcons()`
- **Helper:** `likewize_icon($icon_name, $class, $size)`

### Spacing
- Container: 1200px max-width
- Section padding: 5rem vertical (py-20)
- Grid gap: 1.5rem

## Local Development

### Quick Start

```bash
# Start WordPress locally
npm start
# or
docker-compose up --build

# Access the site
# URL: http://localhost:8889
# Admin: http://localhost:8889/wp-admin
# Username: admin
# Password: JamcoAdmin2024!
```

### Available Commands

```bash
npm start          # Start WordPress (builds and runs)
npm stop           # Stop all containers
npm run restart    # Restart containers
npm run logs       # View container logs
npm run build      # Build Docker image
npm run clean      # Remove all containers and volumes
```

### Development Workflow

1. Start the containers: `npm start`
2. Wait ~60 seconds for initialization
3. Visit http://localhost:8889
4. Log in to wp-admin (admin / JamcoAdmin2024!)
5. Edit blocks in WordPress editor
6. Theme files are live-mounted, so changes appear immediately
7. Stop containers: `npm stop`

## Testing Checklist

- [ ] All 5 blocks appear in block inserter
- [ ] Blocks render correctly in editor
- [ ] Blocks render correctly on frontend
- [ ] Accordion expands/collapses smoothly
- [ ] Icons display (Lucide)
- [ ] Responsive on mobile/tablet/desktop
- [ ] Colors match design system
- [ ] Fonts load (Public Sans)
- [ ] Docker build succeeds
- [ ] Deployment to Azure works
- [ ] Admin login functional

## Cost Estimate (Separate Deployment)

- **App Service (B1):** ~$13/month
- **Container Registry (shared with JAMCO):** Already paid for
- **Total:** ~$13/month for new instance

**Alternative:** Share App Service plan with JAMCO to reduce costs.

## Reference Files

- `test-page.html` - Original HTML design
- `BLOCK_PLAN.md` - Detailed block specifications
- JAMCO theme (../jamco-wordpress/theme/) - Reference for block structure

## Questions?

See BLOCK_PLAN.md for detailed implementation guidance for each block.
