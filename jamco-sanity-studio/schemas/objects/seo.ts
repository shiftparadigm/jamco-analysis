import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'seo',
  title: 'SEO',
  type: 'object',
  fields: [
    defineField({
      name: 'metaTitle',
      title: 'Meta Title',
      type: 'string',
      description: 'Override the page title for search engines (max 60 characters)',
      validation: (Rule) => Rule.max(60).warning('Titles over 60 characters may be truncated'),
    }),
    defineField({
      name: 'metaDescription',
      title: 'Meta Description',
      type: 'text',
      rows: 3,
      description: 'Description for search engines (max 160 characters)',
      validation: (Rule) => Rule.max(160).warning('Descriptions over 160 characters may be truncated'),
    }),
    defineField({
      name: 'ogImage',
      title: 'Social Share Image',
      type: 'image',
      description: 'Image for social media sharing (recommended: 1200x630px)',
      options: {
        hotspot: true,
      },
    }),
    defineField({
      name: 'noIndex',
      title: 'Hide from Search Engines',
      type: 'boolean',
      initialValue: false,
      description: 'Prevent this page from appearing in search results',
    }),
  ],
  options: {
    collapsible: true,
    collapsed: true,
  },
})
