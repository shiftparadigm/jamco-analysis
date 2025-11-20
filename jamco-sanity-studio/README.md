# Jamco America - Sanity Studio

Sanity CMS backend for the Jamco America website with full content schema and bilingual support.

## Quick Start

### 1. Install Dependencies

```bash
npm install
```

### 2. Initialize Sanity Project

If you don't have a Sanity project yet:

```bash
npx sanity init
```

Follow the prompts:
- **Login/Sign up**: Use your Sanity account
- **Create new project**: Yes
- **Project name**: Jamco America (or your preferred name)
- **Dataset**: production
- **Output path**: Use current directory

This will create a `sanity.config.ts` file with your project ID.

### 3. Configure Environment

Copy the environment template:

```bash
cp .env.template .env
```

Edit `.env` and add your project details:

```env
SANITY_STUDIO_PROJECT_ID=your-project-id-here
SANITY_STUDIO_DATASET=production
```

### 4. Start Development Server

```bash
npm run dev
```

Visit `http://localhost:3333` to access Sanity Studio.

## Project Structure

```
jamco-sanity-studio/
├── schemas/
│   ├── documents/          # Main content types
│   │   ├── page.ts         # Pages with page builder
│   │   ├── post.ts         # News/blog posts
│   │   ├── siteSettings.ts # Global settings
│   │   ├── navigation.ts   # Menu structures
│   │   └── translations.ts # UI translations
│   │
│   ├── objects/            # Reusable components
│   │   ├── hero.ts         # Hero sections
│   │   ├── contentBlock.ts # Rich text blocks
│   │   ├── columnsBlock.ts # Multi-column layouts
│   │   ├── ctaBlock.ts     # Call-to-action banners
│   │   ├── imageBlock.ts   # Image blocks
│   │   ├── fileDownloadBlock.ts
│   │   ├── testimonialBlock.ts
│   │   ├── contactInfoBlock.ts
│   │   ├── marketoFormBlock.ts
│   │   ├── portableText.ts # Rich text config
│   │   ├── cta.ts          # CTA button component
│   │   └── seo.ts          # SEO metadata
│   │
│   └── index.ts            # Schema exports
│
├── deskStructure.ts        # Custom desk organization
├── sanity.config.ts        # Main configuration
├── sanity.cli.ts           # CLI configuration
└── package.json
```

## Features

### Content Types

**📄 Pages**
- Dynamic page builder with multiple block types
- Hero sections with background images
- SEO metadata
- Bilingual support (English/Japanese)

**📰 News Posts**
- Featured images
- Rich text content
- Publish dates
- Categories and tags
- SEO optimization

**⚙️ Site Settings**
- Global configuration (singleton)
- Site name, logo, contact info
- Social media links
- Footer text

**🗺️ Navigation**
- Flexible menu structures
- Nested sub-menus
- Internal/external links
- Language-specific menus

**🌐 Translations**
- UI string translations
- Key-value pairs for English/Japanese

### Content Blocks

All blocks are available in the page builder:

1. **Hero Section** - Large banner with image, heading, CTA
2. **Content Block** - Rich text with images, headings, lists
3. **Columns Block** - 2-4 column layouts
4. **CTA Block** - Call-to-action banner
5. **Image Block** - Standalone images with captions
6. **File Download Block** - Downloadable files (PDFs, docs)
7. **Testimonial Block** - Customer quotes and reviews
8. **Contact Info Block** - Address, phone, email, hours, map
9. **Marketo Form Block** - Embedded Marketo forms

### Bilingual Support

- English (en) and Japanese (ja) content
- Language-specific desk sections
- Document internationalization plugin
- Easy translation workflow

### Custom Desk Structure

Content is organized by language for easy management:

```
📁 Pages
  📁 English Pages
  📁 Japanese Pages
  📁 All Pages

📁 News
  📁 English News
  📁 Japanese News
  📁 All News

📁 Navigation
  📁 English Navigation
  📁 Japanese Navigation
  📁 All Navigation

📁 Translations
📁 Site Settings
```

## Usage Guide

### Creating a Page

1. Click **"Pages"** in the sidebar
2. Choose language (English or Japanese)
3. Click **"Create"**
4. Fill in:
   - **Title**: Page name
   - **Slug**: Auto-generated URL
   - **Hero**: Optional banner section
   - **Content**: Add blocks to build the page
   - **SEO**: Meta title, description, image

### Adding Content Blocks

1. In the **"Content"** field, click **"Add item"**
2. Choose a block type
3. Fill in the block fields
4. Reorder blocks by dragging
5. Remove blocks with the trash icon

### Setting Up Navigation

1. Click **"Navigation"** in sidebar
2. Create menu for each language
3. Add menu items:
   - **Label**: Text shown to users
   - **Link Type**: Internal (page/post) or External (URL)
   - **Sub-menu**: Optional nested items

### Managing Translations

1. Click **"Translations"**
2. Add UI strings like button labels, error messages, etc.
3. Provide English and Japanese versions
4. Use a clear key naming convention (e.g., `button.submit`, `nav.home`)

### Configuring Site Settings

1. Click **"Site Settings"**
2. Edit global settings:
   - Site name and URL
   - Logo
   - Contact information
   - Social media links
   - Footer text
3. Publish changes

## Development

### Adding a New Block Type

1. Create schema in `schemas/objects/myBlock.ts`
2. Export it from `schemas/index.ts`
3. Add to page content types in `schemas/documents/page.ts`

Example:

```typescript
// schemas/objects/myBlock.ts
import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'myBlock',
  title: 'My Block',
  type: 'object',
  fields: [
    defineField({
      name: 'title',
      title: 'Title',
      type: 'string',
    }),
  ],
})
```

### Customizing the Desk

Edit `deskStructure.ts` to change how content is organized in the Studio.

### Adding Document Types

1. Create schema in `schemas/documents/`
2. Export from `schemas/index.ts`
3. Add to desk structure if needed

## Deployment

### Deploy Studio to Sanity

```bash
npm run build
npm run deploy
```

This hosts your Studio at `https://your-project.sanity.studio`

### Deploy GraphQL API (Optional)

```bash
npm run deploy-graphql
```

## API Access

### GROQ Queries

Access your content via Sanity's GROQ API:

```javascript
import {createClient} from '@sanity/client'

const client = createClient({
  projectId: 'your-project-id',
  dataset: 'production',
  apiVersion: '2024-01-01',
  useCdn: true,
})

// Fetch all English pages
const pages = await client.fetch(`
  *[_type == "page" && language == "en"]
`)
```

### Common Queries

**Get page by slug:**
```groq
*[_type == "page" && slug.current == $slug && language == $language][0]
```

**Get all posts:**
```groq
*[_type == "post" && language == $language] | order(publishedAt desc)
```

**Get navigation:**
```groq
*[_type == "navigation" && title == $menuName && language == $language][0]
```

## Environment Variables

For production/staging, set these in your hosting environment:

```env
SANITY_STUDIO_PROJECT_ID=your-project-id
SANITY_STUDIO_DATASET=production
```

For API access in your frontend:

```env
SANITY_PROJECT_ID=your-project-id
SANITY_DATASET=production
SANITY_API_VERSION=2024-01-01
SANITY_TOKEN=your-read-token (optional, for preview)
```

## Troubleshooting

### Can't Access Studio

- Verify project ID is correct in `.env`
- Check you're added as a project member in Sanity dashboard
- Clear browser cache and try again

### Schema Errors

- Run `npm run dev` to see validation errors
- Check all imports are correct
- Ensure all required fields are defined

### Content Not Saving

- Check browser console for errors
- Verify API token permissions (if using tokens)
- Check validation rules aren't too strict

## Resources

- [Sanity Documentation](https://www.sanity.io/docs)
- [GROQ Query Language](https://www.sanity.io/docs/groq)
- [Schema Types](https://www.sanity.io/docs/schema-types)
- [Content Modeling](https://www.sanity.io/docs/content-modelling)

## Support

For questions or issues:
- Check Sanity docs
- Visit [Sanity Slack Community](https://slack.sanity.io)
- Contact your development team
