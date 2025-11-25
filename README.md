# Jamco America - Premium Seating Website

A modern, JAMstack website for Jamco America's premium aircraft seating products, built with Astro and Sanity CMS.

## Tech Stack

- **Frontend**: [Astro](https://astro.build) - Static site generator
- **CMS**: [Sanity](https://www.sanity.io) - Headless CMS
- **Hosting**: [Azure Static Web Apps](https://azure.microsoft.com/en-us/products/app-service/static)
- **Deployment**: GitHub Actions + Cloudflare Workers
- **Styling**: Custom CSS with design tokens

## Project Structure

```
jamco-analysis/
├── jamco-astro-frontend/          # Astro frontend application
│   ├── src/
│   │   ├── components/            # Reusable UI components
│   │   │   ├── blocks/            # CMS-driven content blocks
│   │   │   └── ui/                # Base UI components
│   │   ├── layouts/               # Page layouts
│   │   ├── pages/                 # Route pages
│   │   ├── lib/                   # Utilities (Sanity client, etc.)
│   │   └── styles/                # Global styles and design tokens
│   └── public/                    # Static assets
│
├── jamco-sanity-studio/           # Sanity CMS Studio
│   ├── schemas/                   # Content schemas
│   │   ├── documents/             # Document types (page, product, etc.)
│   │   └── objects/               # Reusable blocks and components
│   └── src/actions/               # Custom Studio actions
│
├── webhook-worker/                # Cloudflare Worker for build triggers
│   ├── index.js                   # Worker code
│   └── wrangler.toml              # Worker configuration
│
└── reference-images/              # Design reference files from Figma
```

## Getting Started

### Prerequisites

- Node.js 18+ and npm
- Sanity account
- Azure account (for deployment)
- Cloudflare account (for webhook worker)

### Environment Variables

Create `.env` files in both frontend and studio directories:

**jamco-astro-frontend/.env**
```env
SANITY_PROJECT_ID=c94x8u55
SANITY_DATASET=production
SANITY_API_VERSION=2024-01-01
```

**jamco-sanity-studio/.env**
```env
SANITY_STUDIO_PROJECT_ID=c94x8u55
SANITY_STUDIO_DATASET=production
```

### Local Development

1. **Install dependencies**
   ```bash
   # Install Astro frontend dependencies
   cd jamco-astro-frontend
   npm install

   # Install Sanity Studio dependencies
   cd ../jamco-sanity-studio
   npm install
   ```

2. **Start development servers**

   In separate terminals:
   ```bash
   # Terminal 1 - Astro frontend (http://localhost:4321)
   cd jamco-astro-frontend
   npm run dev

   # Terminal 2 - Sanity Studio (http://localhost:3333)
   cd jamco-sanity-studio
   npm run dev
   ```

3. **Access the applications**
   - Frontend: http://localhost:4321
   - Sanity Studio: http://localhost:3333

## Content Management

### Sanity Schemas

Content types are defined in `jamco-sanity-studio/schemas/`:

**Document Types** (Top-level content):
- `page` - Website pages (Premium Seating, etc.)
- `product` - Individual products
- `productCategory` - Product categories
- `post` - Blog posts
- `navigation` - Site navigation menus
- `siteSettings` - Global site settings
- `translations` - Multi-language content

**Block Types** (Reusable content blocks):
- `hero` / `heroCarousel` - Hero sections with image carousels
- `sectionIntroBlock` - Section introductions
- `featureGridBlock` - 3-column feature grids with images
- `splitFeatureBlock` - Two-column layouts with image and text
- `productCarouselBlock` - Scrollable product showcases
- `productShowcaseBlock` - Featured product displays
- `testimonialBlock` - Customer testimonials
- `ctaBlock` - Call-to-action sections
- `pricingCardBlock` - Pricing/feature comparison cards
- `fullWidthImageBlock` - Full-width image sections
- `seatingDiagramBlock` - Aircraft seating diagrams

### Content Editing

1. Access the production Sanity Studio at: https://jamco-seating.sanity.studio/
2. Make content changes
3. Click "Publish" - this automatically triggers a site rebuild (see Automated Deployments below)

## Automated Deployments

The site uses an automated rebuild system that triggers whenever content is published in Sanity:

### How It Works

1. **Publish Action**: Editor clicks "Publish" in Sanity Studio
2. **Custom Action**: A custom document action runs in the browser
3. **Webhook Relay**: Calls Cloudflare Worker at `jamco-webhook-relay.tony-mishler.workers.dev`
4. **GitHub Trigger**: Worker sends `repository_dispatch` event to GitHub
5. **Build & Deploy**: GitHub Actions rebuilds the Astro site and deploys to Azure

### Components

**Sanity Custom Action** (`jamco-sanity-studio/src/actions/triggerRebuild.ts`)
- Replaces the default Publish button
- Calls Cloudflare Worker when publishing content

**Cloudflare Worker** (`webhook-worker/index.js`)
- Serverless relay between Sanity and GitHub
- Includes CORS headers for browser requests
- Deployed at: https://jamco-webhook-relay.tony-mishler.workers.dev

**GitHub Actions** (`.github/workflows/azure-static-web-apps-*.yml`)
- Triggers on: push, PR, workflow_dispatch, and `repository_dispatch`
- Builds Astro site
- Deploys to Azure Static Web Apps

### Manual Deployment

If needed, you can manually trigger a deployment:
```bash
gh workflow run azure-static-web-apps-blue-island-0b5fa6310.yml
```

## Deployment Setup

### Sanity Studio

Deploy the Studio to Sanity's hosting:
```bash
cd jamco-sanity-studio
npx sanity deploy
```

Access at: https://jamco-seating.sanity.studio/

### Cloudflare Worker

Deploy the webhook relay worker:
```bash
cd webhook-worker
npx wrangler login
npx wrangler secret put GITHUB_TOKEN  # Enter your GitHub token
npx wrangler deploy
```

### Azure Static Web Apps

The site is automatically deployed via GitHub Actions when pushing to the `master` branch.

**Manual setup** (if needed):
1. Create Azure Static Web App
2. Connect to GitHub repository
3. Configure build settings:
   - App location: `/jamco-astro-frontend`
   - Output location: `dist`

## Development Scripts

### Astro Frontend
```bash
npm run dev          # Start dev server
npm run build        # Build for production
npm run preview      # Preview production build
```

### Sanity Studio
```bash
npm run dev          # Start Studio dev server
npx sanity deploy    # Deploy Studio to production
npx sanity graphql deploy  # Deploy GraphQL API
```

## Key Features

- **Fully Static**: Astro builds a completely static site for fast performance
- **Headless CMS**: Sanity provides a powerful, flexible content management system
- **Automated Rebuilds**: Content changes trigger automatic site rebuilds
- **Responsive Design**: Mobile-first design matching Figma specifications
- **Multi-language Support**: English and Japanese content
- **Product Showcase**: Interactive product carousels and feature grids
- **SEO Optimized**: Meta tags, structured data, and semantic HTML

## Live URLs

- **Production Site**: https://blue-island-0b5fa6310.azurestaticapps.net
- **Sanity Studio**: https://jamco-seating.sanity.studio
- **GitHub Repository**: https://github.com/shiftparadigm/jamco-analysis

## Troubleshooting

### Content not updating on the site
1. Check GitHub Actions for build status
2. Verify the Cloudflare Worker is responding
3. Check browser console in Sanity Studio for publish errors

### Local development issues
- Ensure both dev servers are running
- Clear browser cache and restart dev servers
- Check that environment variables are set correctly

### Sanity Studio deployment fails
```bash
# Clear cache and redeploy
rm -rf node_modules
npm install
npx sanity deploy
```

## Contributing

1. Create a feature branch
2. Make changes
3. Test locally with both Astro and Sanity running
4. Commit and push (triggers automatic deployment)

## Architecture Decisions

- **Static Generation**: Chose Astro over server-rendered options for better performance and simpler hosting
- **Sanity CMS**: Selected for its excellent developer experience and real-time collaboration
- **Custom Publish Action**: Preferred over Sanity webhooks for more reliable browser-based triggering
- **Cloudflare Worker**: Used as a lightweight relay to keep GitHub tokens secure
- **Azure Static Web Apps**: Provides free hosting with global CDN and GitHub integration

## License

Proprietary - Jamco America
