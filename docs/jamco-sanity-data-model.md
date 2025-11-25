# Jamco America - Sanity CMS Data Model & Recommendations

## Overview

This document outlines a proposed Sanity CMS data model to rebuild jamco-america.com, with recommendations for Studio customization to facilitate easy content authoring.

**Frontend Stack:** Astro (recommended) or Next.js
- Astro works great with Sanity via `@sanity/astro` and `astro-portabletext`
- Provides excellent static generation with islands architecture for interactive components

---

## Data Model

### Document Types

#### 1. `page`
General pages (Home, About, Products, Capabilities, etc.)

```typescript
// schemas/documents/page.ts
export default {
  name: 'page',
  title: 'Page',
  type: 'document',
  fields: [
    {
      name: 'title',
      title: 'Title',
      type: 'string',
      validation: Rule => Rule.required()
    },
    {
      name: 'slug',
      title: 'Slug',
      type: 'slug',
      options: { source: 'title' },
      validation: Rule => Rule.required()
    },
    {
      name: 'seo',
      title: 'SEO',
      type: 'seo'
    },
    {
      name: 'hero',
      title: 'Hero Section',
      type: 'hero',
      description: 'Optional hero/banner at top of page'
    },
    {
      name: 'content',
      title: 'Page Content',
      type: 'array',
      of: [
        { type: 'contentBlock' },
        { type: 'columnsBlock' },
        { type: 'ctaBlock' },
        { type: 'imageBlock' },
        { type: 'fileDownloadBlock' },
        { type: 'testimonialBlock' },
        { type: 'contactInfoBlock' }
      ]
    }
  ],
  preview: {
    select: {
      title: 'title',
      slug: 'slug.current'
    },
    prepare({ title, slug }) {
      return {
        title,
        subtitle: `/${slug || ''}`
      }
    }
  }
}
```

#### 2. `post`
News/blog posts

```typescript
// schemas/documents/post.ts
export default {
  name: 'post',
  title: 'News Post',
  type: 'document',
  fields: [
    {
      name: 'title',
      title: 'Title',
      type: 'string',
      validation: Rule => Rule.required()
    },
    {
      name: 'slug',
      title: 'Slug',
      type: 'slug',
      options: { source: 'title' },
      validation: Rule => Rule.required()
    },
    {
      name: 'publishedAt',
      title: 'Published Date',
      type: 'datetime',
      validation: Rule => Rule.required()
    },
    {
      name: 'featuredImage',
      title: 'Featured Image',
      type: 'image',
      options: { hotspot: true },
      fields: [
        {
          name: 'alt',
          title: 'Alt Text',
          type: 'string'
        },
        {
          name: 'caption',
          title: 'Caption',
          type: 'string'
        }
      ]
    },
    {
      name: 'excerpt',
      title: 'Excerpt',
      type: 'text',
      rows: 3,
      description: 'Brief summary for listings and SEO'
    },
    {
      name: 'body',
      title: 'Body',
      type: 'portableText'
    },
    {
      name: 'seo',
      title: 'SEO',
      type: 'seo'
    }
  ],
  orderings: [
    {
      title: 'Published Date, New',
      name: 'publishedAtDesc',
      by: [{ field: 'publishedAt', direction: 'desc' }]
    }
  ],
  preview: {
    select: {
      title: 'title',
      date: 'publishedAt',
      media: 'featuredImage'
    },
    prepare({ title, date, media }) {
      return {
        title,
        subtitle: date ? new Date(date).toLocaleDateString() : 'No date',
        media
      }
    }
  }
}
```

#### 3. `siteSettings`
Global site configuration

```typescript
// schemas/documents/siteSettings.ts
export default {
  name: 'siteSettings',
  title: 'Site Settings',
  type: 'document',
  fields: [
    {
      name: 'siteName',
      title: 'Site Name',
      type: 'string'
    },
    {
      name: 'logo',
      title: 'Logo',
      type: 'image'
    },
    {
      name: 'contactInfo',
      title: 'Contact Information',
      type: 'object',
      fields: [
        { name: 'phone', title: 'Phone', type: 'string' },
        { name: 'aogPhone', title: 'AOG Emergency Phone', type: 'string' },
        { name: 'email', title: 'Email', type: 'string' },
        { name: 'address', title: 'Address', type: 'text' }
      ]
    },
    {
      name: 'socialLinks',
      title: 'Social Links',
      type: 'array',
      of: [{
        type: 'object',
        fields: [
          { name: 'platform', title: 'Platform', type: 'string' },
          { name: 'url', title: 'URL', type: 'url' }
        ]
      }]
    },
    {
      name: 'footerText',
      title: 'Footer Text',
      type: 'text'
    }
  ],
  // Singleton - only one instance
  __experimental_actions: ['update', 'publish']
}
```

#### 4. `navigation`
Menu structure

```typescript
// schemas/documents/navigation.ts
export default {
  name: 'navigation',
  title: 'Navigation',
  type: 'document',
  fields: [
    {
      name: 'title',
      title: 'Menu Name',
      type: 'string',
      description: 'e.g., "Main Menu", "Footer Menu"'
    },
    {
      name: 'items',
      title: 'Menu Items',
      type: 'array',
      of: [{
        type: 'object',
        name: 'menuItem',
        fields: [
          {
            name: 'label',
            title: 'Label',
            type: 'string'
          },
          {
            name: 'linkType',
            title: 'Link Type',
            type: 'string',
            options: {
              list: [
                { title: 'Internal Page', value: 'internal' },
                { title: 'External URL', value: 'external' }
              ]
            }
          },
          {
            name: 'internalLink',
            title: 'Internal Link',
            type: 'reference',
            to: [{ type: 'page' }, { type: 'post' }],
            hidden: ({ parent }) => parent?.linkType !== 'internal'
          },
          {
            name: 'externalUrl',
            title: 'External URL',
            type: 'url',
            hidden: ({ parent }) => parent?.linkType !== 'external'
          },
          {
            name: 'children',
            title: 'Submenu Items',
            type: 'array',
            of: [{ type: 'menuItem' }]
          }
        ],
        preview: {
          select: { title: 'label' }
        }
      }]
    }
  ]
}
```

---

### Object Types (Blocks)

#### `hero`
Page hero/banner section

```typescript
// schemas/objects/hero.ts
export default {
  name: 'hero',
  title: 'Hero Section',
  type: 'object',
  fields: [
    {
      name: 'heading',
      title: 'Heading',
      type: 'string'
    },
    {
      name: 'subheading',
      title: 'Subheading',
      type: 'text',
      rows: 2
    },
    {
      name: 'backgroundImage',
      title: 'Background Image',
      type: 'image',
      options: { hotspot: true }
    },
    {
      name: 'overlay',
      title: 'Dark Overlay',
      type: 'boolean',
      initialValue: true
    },
    {
      name: 'cta',
      title: 'Call to Action',
      type: 'cta'
    }
  ],
  preview: {
    select: {
      title: 'heading',
      media: 'backgroundImage'
    }
  }
}
```

#### `contentBlock`
Rich text content

```typescript
// schemas/objects/contentBlock.ts
export default {
  name: 'contentBlock',
  title: 'Content Block',
  type: 'object',
  fields: [
    {
      name: 'content',
      title: 'Content',
      type: 'portableText'
    }
  ],
  preview: {
    select: {
      blocks: 'content'
    },
    prepare({ blocks }) {
      const block = (blocks || []).find(b => b._type === 'block')
      return {
        title: block?.children?.[0]?.text || 'Content Block'
      }
    }
  }
}
```

#### `columnsBlock`
Multi-column layout

```typescript
// schemas/objects/columnsBlock.ts
export default {
  name: 'columnsBlock',
  title: 'Columns',
  type: 'object',
  fields: [
    {
      name: 'columns',
      title: 'Columns',
      type: 'array',
      of: [{
        type: 'object',
        name: 'column',
        fields: [
          {
            name: 'width',
            title: 'Width',
            type: 'string',
            options: {
              list: [
                { title: 'Auto', value: 'auto' },
                { title: '1/4', value: '25' },
                { title: '1/3', value: '33' },
                { title: '1/2', value: '50' },
                { title: '2/3', value: '66' },
                { title: '3/4', value: '75' },
                { title: 'Full', value: '100' }
              ]
            },
            initialValue: 'auto'
          },
          {
            name: 'content',
            title: 'Content',
            type: 'array',
            of: [
              { type: 'contentBlock' },
              { type: 'imageBlock' },
              { type: 'ctaBlock' }
            ]
          }
        ],
        preview: {
          select: { width: 'width' },
          prepare({ width }) {
            return { title: `Column (${width || 'auto'})` }
          }
        }
      }],
      validation: Rule => Rule.max(4)
    },
    {
      name: 'verticalAlign',
      title: 'Vertical Alignment',
      type: 'string',
      options: {
        list: ['top', 'center', 'bottom']
      },
      initialValue: 'top'
    }
  ],
  preview: {
    select: { columns: 'columns' },
    prepare({ columns }) {
      return {
        title: `Columns (${columns?.length || 0})`
      }
    }
  }
}
```

#### `ctaBlock`
Call-to-action button(s)

```typescript
// schemas/objects/ctaBlock.ts
export default {
  name: 'ctaBlock',
  title: 'Call to Action',
  type: 'object',
  fields: [
    {
      name: 'buttons',
      title: 'Buttons',
      type: 'array',
      of: [{ type: 'cta' }]
    },
    {
      name: 'alignment',
      title: 'Alignment',
      type: 'string',
      options: {
        list: ['left', 'center', 'right']
      },
      initialValue: 'center'
    }
  ],
  preview: {
    select: { buttons: 'buttons' },
    prepare({ buttons }) {
      return {
        title: `CTA (${buttons?.length || 0} button${buttons?.length !== 1 ? 's' : ''})`
      }
    }
  }
}
```

#### `cta`
Single button/link

```typescript
// schemas/objects/cta.ts
export default {
  name: 'cta',
  title: 'Button',
  type: 'object',
  fields: [
    {
      name: 'label',
      title: 'Label',
      type: 'string',
      validation: Rule => Rule.required()
    },
    {
      name: 'linkType',
      title: 'Link Type',
      type: 'string',
      options: {
        list: [
          { title: 'Internal Page', value: 'internal' },
          { title: 'External URL', value: 'external' },
          { title: 'File Download', value: 'file' },
          { title: 'Email', value: 'email' },
          { title: 'Phone', value: 'phone' }
        ]
      },
      initialValue: 'internal'
    },
    {
      name: 'internalLink',
      title: 'Internal Link',
      type: 'reference',
      to: [{ type: 'page' }, { type: 'post' }],
      hidden: ({ parent }) => parent?.linkType !== 'internal'
    },
    {
      name: 'externalUrl',
      title: 'External URL',
      type: 'url',
      hidden: ({ parent }) => parent?.linkType !== 'external'
    },
    {
      name: 'file',
      title: 'File',
      type: 'file',
      hidden: ({ parent }) => parent?.linkType !== 'file'
    },
    {
      name: 'email',
      title: 'Email Address',
      type: 'string',
      hidden: ({ parent }) => parent?.linkType !== 'email'
    },
    {
      name: 'phone',
      title: 'Phone Number',
      type: 'string',
      hidden: ({ parent }) => parent?.linkType !== 'phone'
    },
    {
      name: 'style',
      title: 'Button Style',
      type: 'string',
      options: {
        list: [
          { title: 'Primary', value: 'primary' },
          { title: 'Secondary', value: 'secondary' },
          { title: 'Outline', value: 'outline' }
        ]
      },
      initialValue: 'primary'
    },
    {
      name: 'openInNewTab',
      title: 'Open in New Tab',
      type: 'boolean',
      initialValue: false
    }
  ],
  preview: {
    select: { title: 'label', style: 'style' },
    prepare({ title, style }) {
      return {
        title,
        subtitle: style
      }
    }
  }
}
```

#### `imageBlock`
Image with optional lightbox

```typescript
// schemas/objects/imageBlock.ts
export default {
  name: 'imageBlock',
  title: 'Image',
  type: 'object',
  fields: [
    {
      name: 'image',
      title: 'Image',
      type: 'image',
      options: { hotspot: true },
      validation: Rule => Rule.required()
    },
    {
      name: 'alt',
      title: 'Alt Text',
      type: 'string',
      validation: Rule => Rule.required()
    },
    {
      name: 'caption',
      title: 'Caption',
      type: 'string'
    },
    {
      name: 'enableLightbox',
      title: 'Enable Lightbox',
      type: 'boolean',
      initialValue: false
    },
    {
      name: 'size',
      title: 'Size',
      type: 'string',
      options: {
        list: [
          { title: 'Small', value: 'small' },
          { title: 'Medium', value: 'medium' },
          { title: 'Large', value: 'large' },
          { title: 'Full Width', value: 'full' }
        ]
      },
      initialValue: 'large'
    }
  ],
  preview: {
    select: {
      media: 'image',
      title: 'alt'
    }
  }
}
```

#### `fileDownloadBlock`
Document downloads (PDFs, etc.)

```typescript
// schemas/objects/fileDownloadBlock.ts
export default {
  name: 'fileDownloadBlock',
  title: 'File Downloads',
  type: 'object',
  fields: [
    {
      name: 'heading',
      title: 'Section Heading',
      type: 'string'
    },
    {
      name: 'files',
      title: 'Files',
      type: 'array',
      of: [{
        type: 'object',
        fields: [
          {
            name: 'title',
            title: 'Title',
            type: 'string',
            validation: Rule => Rule.required()
          },
          {
            name: 'description',
            title: 'Description',
            type: 'string'
          },
          {
            name: 'file',
            title: 'File',
            type: 'file',
            validation: Rule => Rule.required()
          }
        ],
        preview: {
          select: { title: 'title' }
        }
      }]
    }
  ],
  preview: {
    select: { heading: 'heading', files: 'files' },
    prepare({ heading, files }) {
      return {
        title: heading || 'File Downloads',
        subtitle: `${files?.length || 0} file(s)`
      }
    }
  }
}
```

#### `testimonialBlock`
Testimonial/quote carousel

```typescript
// schemas/objects/testimonialBlock.ts
export default {
  name: 'testimonialBlock',
  title: 'Testimonials',
  type: 'object',
  fields: [
    {
      name: 'heading',
      title: 'Section Heading',
      type: 'string'
    },
    {
      name: 'testimonials',
      title: 'Testimonials',
      type: 'array',
      of: [{
        type: 'object',
        fields: [
          {
            name: 'quote',
            title: 'Quote',
            type: 'text',
            rows: 4,
            validation: Rule => Rule.required()
          },
          {
            name: 'author',
            title: 'Author Name',
            type: 'string'
          },
          {
            name: 'role',
            title: 'Role/Title',
            type: 'string'
          },
          {
            name: 'image',
            title: 'Author Image',
            type: 'image',
            options: { hotspot: true }
          }
        ],
        preview: {
          select: {
            title: 'author',
            subtitle: 'role',
            media: 'image'
          }
        }
      }]
    },
    {
      name: 'displayMode',
      title: 'Display Mode',
      type: 'string',
      options: {
        list: [
          { title: 'Carousel', value: 'carousel' },
          { title: 'Grid', value: 'grid' }
        ]
      },
      initialValue: 'carousel'
    }
  ],
  preview: {
    select: { heading: 'heading', testimonials: 'testimonials' },
    prepare({ heading, testimonials }) {
      return {
        title: heading || 'Testimonials',
        subtitle: `${testimonials?.length || 0} testimonial(s)`
      }
    }
  }
}
```

#### `contactInfoBlock`
Contact information display

```typescript
// schemas/objects/contactInfoBlock.ts
export default {
  name: 'contactInfoBlock',
  title: 'Contact Information',
  type: 'object',
  fields: [
    {
      name: 'heading',
      title: 'Heading',
      type: 'string'
    },
    {
      name: 'contacts',
      title: 'Contact Items',
      type: 'array',
      of: [{
        type: 'object',
        fields: [
          {
            name: 'label',
            title: 'Label',
            type: 'string',
            description: 'e.g., "Customer Service", "AOG Support"'
          },
          {
            name: 'phone',
            title: 'Phone',
            type: 'string'
          },
          {
            name: 'email',
            title: 'Email',
            type: 'string'
          },
          {
            name: 'description',
            title: 'Description',
            type: 'text',
            rows: 2
          }
        ],
        preview: {
          select: { title: 'label' }
        }
      }]
    }
  ],
  preview: {
    select: { heading: 'heading' },
    prepare({ heading }) {
      return {
        title: heading || 'Contact Information'
      }
    }
  }
}
```

#### `portableText`
Rich text field with custom marks and blocks

```typescript
// schemas/objects/portableText.ts
export default {
  name: 'portableText',
  title: 'Rich Text',
  type: 'array',
  of: [
    {
      type: 'block',
      styles: [
        { title: 'Normal', value: 'normal' },
        { title: 'H2', value: 'h2' },
        { title: 'H3', value: 'h3' },
        { title: 'H4', value: 'h4' },
        { title: 'Quote', value: 'blockquote' }
      ],
      marks: {
        decorators: [
          { title: 'Bold', value: 'strong' },
          { title: 'Italic', value: 'em' },
          { title: 'Underline', value: 'underline' }
        ],
        annotations: [
          {
            name: 'link',
            type: 'object',
            title: 'Link',
            fields: [
              {
                name: 'href',
                type: 'url',
                title: 'URL',
                validation: Rule => Rule.uri({
                  scheme: ['http', 'https', 'mailto', 'tel']
                })
              },
              {
                name: 'openInNewTab',
                type: 'boolean',
                title: 'Open in new tab'
              }
            ]
          }
        ]
      }
    },
    {
      type: 'image',
      options: { hotspot: true },
      fields: [
        {
          name: 'alt',
          type: 'string',
          title: 'Alt text'
        },
        {
          name: 'caption',
          type: 'string',
          title: 'Caption'
        }
      ]
    }
  ]
}
```

#### `seo`
SEO metadata

```typescript
// schemas/objects/seo.ts
export default {
  name: 'seo',
  title: 'SEO',
  type: 'object',
  fields: [
    {
      name: 'metaTitle',
      title: 'Meta Title',
      type: 'string',
      description: 'Override the page title for search engines',
      validation: Rule => Rule.max(60)
    },
    {
      name: 'metaDescription',
      title: 'Meta Description',
      type: 'text',
      rows: 3,
      validation: Rule => Rule.max(160)
    },
    {
      name: 'ogImage',
      title: 'Social Share Image',
      type: 'image',
      description: 'Image for social media sharing'
    },
    {
      name: 'noIndex',
      title: 'Hide from Search Engines',
      type: 'boolean',
      initialValue: false
    }
  ],
  options: {
    collapsible: true,
    collapsed: true
  }
}
```

---

## Sanity Studio Customization

### Desk Structure

Organize content for easy navigation:

```typescript
// sanity.config.ts or deskStructure.ts
import { StructureBuilder } from 'sanity/desk'

export const deskStructure = (S: StructureBuilder) =>
  S.list()
    .title('Content')
    .items([
      // Site Settings (singleton)
      S.listItem()
        .title('Site Settings')
        .icon(() => '⚙️')
        .child(
          S.document()
            .schemaType('siteSettings')
            .documentId('siteSettings')
        ),

      S.divider(),

      // Pages
      S.listItem()
        .title('Pages')
        .icon(() => '📄')
        .child(
          S.documentList()
            .title('Pages')
            .filter('_type == "page"')
        ),

      // News
      S.listItem()
        .title('News')
        .icon(() => '📰')
        .child(
          S.documentList()
            .title('News Posts')
            .filter('_type == "post"')
            .defaultOrdering([{ field: 'publishedAt', direction: 'desc' }])
        ),

      S.divider(),

      // Navigation
      S.listItem()
        .title('Navigation')
        .icon(() => '🧭')
        .child(
          S.documentList()
            .title('Menus')
            .filter('_type == "navigation"')
        ),

      S.divider(),

      // All Documents (fallback)
      ...S.documentTypeListItems().filter(
        item => !['siteSettings', 'page', 'post', 'navigation'].includes(item.getId() || '')
      )
    ])
```

### Preview Configuration

Enable live preview for content authors:

```typescript
// sanity.config.ts
import { defineConfig } from 'sanity'
import { deskTool } from 'sanity/desk'
import { visionTool } from '@sanity/vision'

export default defineConfig({
  name: 'jamco-america',
  title: 'Jamco America',
  projectId: 'YOUR_PROJECT_ID',
  dataset: 'production',

  plugins: [
    deskTool({
      structure: deskStructure,
      defaultDocumentNode: (S, { schemaType }) => {
        // Add preview pane for pages and posts
        if (['page', 'post'].includes(schemaType)) {
          return S.document().views([
            S.view.form(),
            S.view.component(IframePreview).title('Preview')
          ])
        }
        return S.document()
      }
    }),
    visionTool() // GROQ query tool
  ],

  schema: {
    types: schemaTypes
  }
})

// Preview component
function IframePreview({ document }) {
  const { displayed } = document
  const slug = displayed?.slug?.current
  const type = displayed?._type

  if (!slug) {
    return <div style={{ padding: 20 }}>Save document to see preview</div>
  }

  const previewUrl = type === 'post'
    ? `/api/preview?type=post&slug=${slug}`
    : `/api/preview?type=page&slug=${slug}`

  return (
    <iframe
      src={previewUrl}
      style={{ width: '100%', height: '100%', border: 0 }}
    />
  )
}
```

### Custom Input Components

Make authoring easier with visual helpers:

```typescript
// components/BlockPreview.tsx
// Visual preview for page builder blocks
import { Card, Stack, Text } from '@sanity/ui'

export function BlockPreview({ value, schemaType }) {
  const blockIcons = {
    contentBlock: '📝',
    columnsBlock: '⬜⬜',
    ctaBlock: '🔘',
    imageBlock: '🖼️',
    fileDownloadBlock: '📎',
    testimonialBlock: '💬',
    contactInfoBlock: '📞'
  }

  return (
    <Card padding={3} radius={2} shadow={1}>
      <Stack space={2}>
        <Text size={1} weight="semibold">
          {blockIcons[value._type] || '📦'} {schemaType.title}
        </Text>
      </Stack>
    </Card>
  )
}
```

---

## Content Author UX Recommendations

### 1. Clear Field Descriptions
Add helpful descriptions to every field:

```typescript
{
  name: 'hero',
  title: 'Hero Section',
  type: 'hero',
  description: 'The large banner at the top of the page. Leave empty for no hero.'
}
```

### 2. Sensible Defaults
Set initial values so authors don't start from scratch:

```typescript
{
  name: 'overlay',
  title: 'Dark Overlay',
  type: 'boolean',
  initialValue: true,
  description: 'Darken the background image to make text more readable'
}
```

### 3. Validation with Helpful Messages

```typescript
{
  name: 'metaDescription',
  title: 'Meta Description',
  type: 'text',
  validation: Rule => Rule.max(160).warning('Descriptions over 160 characters may be truncated in search results')
}
```

### 4. Conditional Fields
Hide irrelevant fields to reduce confusion:

```typescript
{
  name: 'internalLink',
  title: 'Internal Link',
  type: 'reference',
  to: [{ type: 'page' }],
  hidden: ({ parent }) => parent?.linkType !== 'internal'
}
```

### 5. Tooltips for Complex Features
Use fieldsets with descriptions:

```typescript
{
  name: 'seo',
  title: 'SEO Settings',
  type: 'object',
  options: {
    collapsible: true,
    collapsed: true
  },
  description: 'Expand to customize how this page appears in search engines and social media'
}
```

### 6. Preview Configurations
Show meaningful previews in lists:

```typescript
preview: {
  select: {
    title: 'title',
    date: 'publishedAt',
    media: 'featuredImage'
  },
  prepare({ title, date, media }) {
    return {
      title,
      subtitle: date ? new Date(date).toLocaleDateString() : 'Draft',
      media
    }
  }
}
```

---

## Astro Frontend Notes

### Project Setup

```bash
npm create astro@latest jamco-frontend
cd jamco-frontend
npx astro add @sanity/astro
npm install @portabletext/to-html
```

### Sanity Client Configuration

```typescript
// src/lib/sanity.ts
import { createClient } from '@sanity/client'

export const sanityClient = createClient({
  projectId: 'YOUR_PROJECT_ID',
  dataset: 'production',
  useCdn: true,
  apiVersion: '2024-01-01'
})

// For preview mode
export const previewClient = createClient({
  projectId: 'YOUR_PROJECT_ID',
  dataset: 'production',
  useCdn: false,
  apiVersion: '2024-01-01',
  token: process.env.SANITY_PREVIEW_TOKEN
})
```

### Dynamic Page Routing

```astro
---
// src/pages/[...slug].astro
import { sanityClient } from '../lib/sanity'
import PageBuilder from '../components/PageBuilder.astro'

export async function getStaticPaths() {
  const pages = await sanityClient.fetch(`*[_type == "page"]{ "slug": slug.current }`)
  return pages.map(page => ({
    params: { slug: page.slug === 'home' ? undefined : page.slug }
  }))
}

const { slug } = Astro.params
const page = await sanityClient.fetch(
  `*[_type == "page" && slug.current == $slug][0]`,
  { slug: slug || 'home' }
)
---

<Layout title={page.title}>
  {page.hero && <Hero {...page.hero} />}
  <PageBuilder blocks={page.content} />
</Layout>
```

### Block Rendering

```astro
---
// src/components/PageBuilder.astro
import ContentBlock from './blocks/ContentBlock.astro'
import ColumnsBlock from './blocks/ColumnsBlock.astro'
import CtaBlock from './blocks/CtaBlock.astro'
import ImageBlock from './blocks/ImageBlock.astro'

const { blocks = [] } = Astro.props

const blockComponents = {
  contentBlock: ContentBlock,
  columnsBlock: ColumnsBlock,
  ctaBlock: CtaBlock,
  imageBlock: ImageBlock,
  // ... other blocks
}
---

{blocks.map(block => {
  const Component = blockComponents[block._type]
  return Component ? <Component {...block} /> : null
})}
```

---

## Migration Checklist

1. **Set up Sanity project** - Create project at sanity.io/manage
2. **Install schemas** - Copy schema files to your studio
3. **Configure desk structure** - Implement custom desk for easy navigation
4. **Set up preview** - Configure iframe preview for pages/posts
5. **Migrate content** - Use Sanity's import tools or write migration script
6. **Build frontend** - Create Astro components for each block type
7. **Configure preview API** - Enable draft preview in Astro
8. **Test thoroughly** - Verify all blocks render correctly
9. **Train authors** - Create documentation for content team

---

## Resolved Requirements

1. **Image optimization** - Sanity CDN with built-in image pipeline
2. **Search functionality** - Sanity GROQ search
3. **Form handling** - Marketo embeds (block added below)
4. **Multi-language** - English and Japanese (i18n structure below)

---

## Additional Block: Marketo Form Embed

```typescript
// schemas/objects/marketoFormBlock.ts
export default {
  name: 'marketoFormBlock',
  title: 'Marketo Form',
  type: 'object',
  fields: [
    {
      name: 'heading',
      title: 'Section Heading',
      type: 'string'
    },
    {
      name: 'description',
      title: 'Description',
      type: 'text',
      rows: 2,
      description: 'Optional text above the form'
    },
    {
      name: 'formId',
      title: 'Marketo Form ID',
      type: 'string',
      validation: Rule => Rule.required(),
      description: 'The numeric form ID from Marketo'
    },
    {
      name: 'munchkinId',
      title: 'Munchkin Account ID',
      type: 'string',
      description: 'Your Marketo Munchkin ID (e.g., "123-ABC-456"). Can be set globally in site settings.'
    },
    {
      name: 'successMessage',
      title: 'Success Message',
      type: 'text',
      rows: 2,
      description: 'Message shown after successful submission'
    },
    {
      name: 'redirectUrl',
      title: 'Redirect URL',
      type: 'url',
      description: 'Optional URL to redirect to after submission'
    }
  ],
  preview: {
    select: { heading: 'heading', formId: 'formId' },
    prepare({ heading, formId }) {
      return {
        title: heading || 'Marketo Form',
        subtitle: `Form ID: ${formId || 'Not set'}`
      }
    }
  }
}
```

Add to page content array:
```typescript
{
  name: 'content',
  title: 'Page Content',
  type: 'array',
  of: [
    { type: 'contentBlock' },
    { type: 'columnsBlock' },
    { type: 'ctaBlock' },
    { type: 'imageBlock' },
    { type: 'fileDownloadBlock' },
    { type: 'testimonialBlock' },
    { type: 'contactInfoBlock' },
    { type: 'marketoFormBlock' }  // Added
  ]
}
```

### Astro Component for Marketo

```astro
---
// src/components/blocks/MarketoFormBlock.astro
const { heading, description, formId, munchkinId, successMessage } = Astro.props
const accountId = munchkinId || import.meta.env.PUBLIC_MARKETO_MUNCHKIN_ID
---

<section class="marketo-form-block">
  {heading && <h2>{heading}</h2>}
  {description && <p class="description">{description}</p>}

  <form id={`mktoForm_${formId}`}></form>
</section>

<script define:vars={{ formId, accountId, successMessage }}>
  // Load Marketo Forms 2.0
  (function() {
    const script = document.createElement('script')
    script.src = `//${accountId}.mktoresp.com/js/forms2/js/forms2.min.js`
    script.onload = function() {
      MktoForms2.loadForm(`//${accountId}.mktoresp.com`, accountId, formId, function(form) {
        if (successMessage) {
          form.onSuccess(function() {
            // Show success message
            const formEl = form.getFormElem()[0]
            formEl.innerHTML = `<div class="success-message">${successMessage}</div>`
            return false // Prevent default redirect
          })
        }
      })
    }
    document.head.appendChild(script)
  })()
</script>
```

---

## Internationalization (i18n) Setup

For English and Japanese support, use Sanity's document-level translation pattern:

### Option 1: Language Field (Simpler)

Add language field to documents:

```typescript
// Add to page.ts and post.ts
{
  name: 'language',
  title: 'Language',
  type: 'string',
  options: {
    list: [
      { title: 'English', value: 'en' },
      { title: 'Japanese', value: 'ja' }
    ]
  },
  initialValue: 'en',
  validation: Rule => Rule.required()
}
```

Filter in desk structure:

```typescript
S.listItem()
  .title('Pages')
  .child(
    S.list()
      .title('Pages')
      .items([
        S.listItem()
          .title('English')
          .child(
            S.documentList()
              .title('English Pages')
              .filter('_type == "page" && language == "en"')
          ),
        S.listItem()
          .title('Japanese')
          .child(
            S.documentList()
              .title('Japanese Pages')
              .filter('_type == "page" && language == "ja"')
          )
      ])
  )
```

### Option 2: @sanity/document-internationalization Plugin (Recommended)

Better UX with side-by-side translation:

```bash
npm install @sanity/document-internationalization
```

```typescript
// sanity.config.ts
import { documentInternationalization } from '@sanity/document-internationalization'

export default defineConfig({
  // ...
  plugins: [
    documentInternationalization({
      supportedLanguages: [
        { id: 'en', title: 'English' },
        { id: 'ja', title: 'Japanese' }
      ],
      schemaTypes: ['page', 'post', 'siteSettings', 'navigation']
    })
  ]
})
```

This adds:
- Language selector in documents
- "Translate" action to create translations
- References between language versions
- Filtering by language in desk

### Astro i18n Routing

```typescript
// src/pages/[lang]/[...slug].astro
export async function getStaticPaths() {
  const pages = await sanityClient.fetch(`
    *[_type == "page"]{
      "slug": slug.current,
      language
    }
  `)

  return pages.map(page => ({
    params: {
      lang: page.language,
      slug: page.slug === 'home' ? undefined : page.slug
    }
  }))
}
```

### Translated Strings

For UI strings (buttons, labels), create a translation document:

```typescript
// schemas/documents/translations.ts
export default {
  name: 'translations',
  title: 'UI Translations',
  type: 'document',
  fields: [
    {
      name: 'key',
      title: 'Key',
      type: 'string',
      description: 'e.g., "readMore", "contactUs"'
    },
    {
      name: 'en',
      title: 'English',
      type: 'string'
    },
    {
      name: 'ja',
      title: 'Japanese',
      type: 'string'
    }
  ]
}
```

---

## Sanity Image CDN Usage

Use `@sanity/image-url` for optimized images:

```typescript
// src/lib/sanity.ts
import imageUrlBuilder from '@sanity/image-url'

const builder = imageUrlBuilder(sanityClient)

export function urlFor(source) {
  return builder.image(source)
}

// Usage in components:
// urlFor(image).width(800).height(600).format('webp').url()
```

```astro
---
import { urlFor } from '../lib/sanity'
const { image, alt } = Astro.props
---

<img
  src={urlFor(image).width(800).auto('format').url()}
  alt={alt}
  loading="lazy"
/>
```

---

## GROQ Search Implementation

```typescript
// src/lib/search.ts
export async function search(query: string, language: string = 'en') {
  const results = await sanityClient.fetch(`
    *[
      (
        _type == "page" ||
        _type == "post"
      ) &&
      language == $language &&
      (
        title match $query + "*" ||
        pt::text(body) match $query + "*" ||
        pt::text(content[].content) match $query + "*"
      )
    ] {
      _type,
      title,
      "slug": slug.current,
      _type == "post" => {
        excerpt,
        publishedAt
      }
    }[0...20]
  `, { query, language })

  return results
}
```

```astro
---
// src/pages/search.astro
import { search } from '../lib/search'

const query = Astro.url.searchParams.get('q') || ''
const results = query ? await search(query) : []
---

<Layout title="Search Results">
  <h1>Search Results</h1>
  {query && <p>Results for "{query}"</p>}

  {results.length > 0 ? (
    <ul>
      {results.map(result => (
        <li>
          <a href={`/${result.slug}`}>{result.title}</a>
        </li>
      ))}
    </ul>
  ) : query ? (
    <p>No results found</p>
  ) : null}
</Layout>
```
