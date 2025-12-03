# Likewize WordPress - Testing Guide

## Pre-requisites

- Docker installed and running
- Node.js 18+ (for local theme development)
- npm or yarn

## Quick Start - Local Testing

### 1. Build and Start

```bash
cd /home/tony/projects/jamco-analysis/likewyze

# Start WordPress (this will build everything)
npm start
```

**What happens:**
1. Docker builds the image (~3-5 minutes first time)
   - Installs Node.js, MySQL, Apache
   - Copies theme files
   - Runs `npm install` and `npm run build` for blocks
   - Removes node_modules to reduce image size
2. Container starts MySQL and Apache
3. WordPress auto-installs via WP-CLI
4. Theme activates automatically
5. Page created with all 5 blocks

**Wait ~60 seconds for initialization**

### 2. Access the Site

**Frontend:**
- URL: http://localhost:8889
- Should see the complete Device Protection page

**WordPress Admin:**
- URL: http://localhost:8889/wp-admin
- Username: `admin`
- Password: `JamcoAdmin2024!`

### 3. Test Checklist

#### Frontend Tests

- [ ] **Hero Section** displays
  - Badge with animated dot
  - Heading and highlighted text
  - Two CTA buttons
  - Coverage status card (right side)
  - Navy background with clip-path effect

- [ ] **Feature Grid** displays
  - 4 cards in grid (desktop)
  - Icons display correctly (Lucide)
  - Hover effects work
  - Responsive (2 cols tablet, 1 col mobile)

- [ ] **Process Steps** displays
  - Left: 3 numbered steps
  - Right: Timeline card with status indicators
  - Completed (green), Active (blue, pulsing), Pending (gray)

- [ ] **Pricing Table** displays
  - Header row with 4 columns
  - 4 data rows
  - Highlighted column
  - Icons in labels
  - Responsive

- [ ] **FAQ Accordion** displays
  - 3 FAQ items
  - Click to expand/collapse
  - Smooth animation
  - Chevron rotates
  - Only one open at a time

#### Block Editor Tests

1. **Log into wp-admin**
2. **Edit the "Device Protection" page**
3. **Check block inserter** (+ button)
   - [ ] "Likewize Blocks" category appears
   - [ ] All 5 blocks listed:
     - Hero Section
     - Feature Grid
     - Process Steps
     - Pricing Table
     - FAQ Accordion

4. **Select each block** and verify:
   - [ ] Block preview shows in editor
   - [ ] Right sidebar shows block settings
   - [ ] Can edit content inline
   - [ ] Can edit settings in sidebar
   - [ ] Changes appear in preview

5. **Test block interactions:**
   - [ ] Add new FAQ item
   - [ ] Remove FAQ item
   - [ ] Change hero background color
   - [ ] Edit pricing tiers
   - [ ] Add/remove feature cards

#### Responsive Tests

Resize browser or use DevTools:
- [ ] Desktop (1200px+): All layouts correct
- [ ] Tablet (768px-1199px): Grids adjust
- [ ] Mobile (< 768px): Single column layouts

#### Performance Tests

- [ ] Page loads in < 3 seconds
- [ ] No JavaScript errors in console
- [ ] Icons render (Lucide initialized)
- [ ] Accordion animations smooth
- [ ] No broken images

## Common Issues & Solutions

### Issue: Container won't start

```bash
# Check logs
docker-compose logs

# Common fix: Port 8889 already in use
# Change port in docker-compose.yml or stop other containers
```

### Issue: Blocks don't appear in editor

**Solution:**
```bash
# Rebuild with clean slate
npm run clean
npm start
```

**Or manually build blocks:**
```bash
cd theme
npm install
npm run build
```

### Issue: Icons don't display

**Check:**
1. Browser console for Lucide errors
2. Lucide script loaded: View Source → search for "lucide"
3. Icons initialized: Console → `typeof lucide` should be "object"

### Issue: Accordion doesn't work

**Check:**
1. `theme/js/accordion.js` loaded
2. Console for JavaScript errors
3. FAQ block has class `likewize-accordion-button`

### Issue: Styles don't match design

**Check:**
1. Theme is activated (wp-admin → Appearance → Themes)
2. Browser cache cleared (Cmd+Shift+R / Ctrl+Shift+R)
3. CSS files loaded: View Source → search for "likewize"

## Development Workflow

### Making Changes to Blocks

For live development with hot reload:

```bash
# Terminal 1: Run WordPress
cd /home/tony/projects/jamco-analysis/likewyze
npm start

# Terminal 2: Watch for changes
cd theme
npm start  # Starts webpack in watch mode
```

Changes to block files will rebuild automatically.

### Making Changes to PHP/CSS

PHP and CSS changes are reflected immediately (theme is volume-mounted).

Just refresh the browser.

### Rebuilding Blocks

```bash
cd theme
npm run build
```

## Clean Start

If things get messed up:

```bash
# Stop and remove everything
npm run clean

# Rebuild from scratch
npm start
```

## Next Steps After Testing

Once local testing passes:

1. ✅ **Commit changes to git**
2. ✅ **Push to GitHub**
3. 🚀 **Deploy to Azure** (Phase 3)

## Azure Deployment (Not Yet)

After local testing succeeds, we'll:
1. Build Docker image for Azure
2. Push to Azure Container Registry
3. Deploy to new App Service
4. Access at: `https://likewize-wp-app.azurewebsites.net/`

---

## Success Criteria

You're ready for Azure deployment when:

- [ ] All blocks display correctly on frontend
- [ ] All blocks work in editor
- [ ] No console errors
- [ ] Accordion works
- [ ] Icons display
- [ ] Responsive design works
- [ ] Page loads quickly
- [ ] Can edit all block content

**Test thoroughly locally before deploying to Azure!**
