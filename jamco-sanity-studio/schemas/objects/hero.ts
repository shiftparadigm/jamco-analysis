import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'hero',
  title: 'Hero Section',
  type: 'object',
  fields: [
    defineField({
      name: 'heading',
      title: 'Heading',
      type: 'string',
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'subheading',
      title: 'Subheading',
      type: 'text',
      rows: 2,
    }),
    defineField({
      name: 'backgroundImage',
      title: 'Background Image',
      type: 'image',
      options: {
        hotspot: true,
      },
      fields: [
        {
          name: 'alt',
          title: 'Alt Text',
          type: 'string',
        },
      ],
    }),
    defineField({
      name: 'overlayOpacity',
      title: 'Overlay Opacity',
      type: 'number',
      description: 'Darkness of overlay (0-100). Higher values make text more readable.',
      initialValue: 50,
      validation: (Rule) => Rule.min(0).max(100),
    }),
    defineField({
      name: 'cta',
      title: 'Primary Call to Action',
      type: 'cta',
    }),
    defineField({
      name: 'secondaryCta',
      title: 'Secondary Call to Action',
      type: 'cta',
      description: 'Optional second CTA button',
    }),
    defineField({
      name: 'floatingImage',
      title: 'Floating Product Image',
      type: 'image',
      description: 'Optional product image overlay on hero',
      options: {hotspot: true},
      fields: [
        {
          name: 'alt',
          title: 'Alt Text',
          type: 'string',
        },
      ],
    }),
    defineField({
      name: 'featureCallout',
      title: 'Feature Callout',
      type: 'featureCallout',
      description: 'Optional floating feature label',
    }),
    defineField({
      name: 'carouselIndicator',
      title: 'Carousel Indicator',
      type: 'string',
      description: 'e.g., "01 / 02" for carousel pagination',
      placeholder: '01 / 02',
    }),
  ],
  preview: {
    select: {
      title: 'heading',
      media: 'backgroundImage',
    },
  },
})
