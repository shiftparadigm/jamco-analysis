# Content Population Setup

## Quick Start

To populate your Sanity content, you need to generate an API token and run the population script.

### Step 1: Generate Sanity API Token

1. Go to https://www.sanity.io/manage/personal/tokens
2. Click "Add API token"
3. Name it: "Content Population Script"
4. Set Permissions: **Editor** (needs create/write access)
5. Copy the token (you'll only see it once)

### Step 2: Run the Population Script

```bash
# Set the token as an environment variable and run the script
SANITY_TOKEN='your-token-here' npm run populate
```

**Or** create a `.env` file:
```bash
echo "SANITY_TOKEN=your-token-here" > .env
npm run populate
```

### What Gets Created

The script will populate your Sanity Studio with:

**Product Category:**
- Premium Seating

**Products:**
- Flight Deck Doors and Linings
- Dividers & Partitions
- Closets & Stowage
- Lavatories
- Comfort module

**Page:**
- Premium Seating page with complete content structure:
  - Hero section with dual CTAs and feature callout
  - Section intro blocks
  - 3-column feature grid
  - 4 split feature sections (Control & Comfort, Private by Design, Work and Entertain, Spatial Freedom)
  - Product carousel with all 5 products
  - 2-column pricing cards (Essential and Pro tiers)

**Site Settings:**
- Site name: Jamco America
- Contact info: info@jamco-america.com, 425-347-4735

### After Population

1. View in Sanity Studio: http://localhost:3333
2. Navigate to Pages → Premium Seating
3. Start the Astro dev server to view the frontend:
   ```bash
   cd jamco-astro-frontend
   npm run dev
   ```
4. Visit: http://localhost:4321/premium-seating

### Note on Images

Images are not included in this automated script (would need actual image files). You can:
- Add images manually through Sanity Studio
- Or upload images and update the script to reference them
