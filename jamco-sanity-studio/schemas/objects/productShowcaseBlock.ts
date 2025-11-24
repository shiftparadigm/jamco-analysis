import { defineType, defineField } from 'sanity'

export default defineType({
  name: 'productShowcaseBlock',
  title: 'Product Showcase',
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
      type: 'string',
    }),
    defineField({
      name: 'productImage',
      title: 'Product Image',
      type: 'image',
      description: 'Single product image (legacy support)',
      options: {
        hotspot: true,
      },
    }),
    defineField({
      name: 'productImages',
      title: 'Product Images',
      type: 'array',
      description: 'Multiple images for carousel (use this for slideshows)',
      of: [
        {
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
        },
      ],
    }),
    defineField({
      name: 'brandName',
      title: 'Brand Name',
      type: 'string',
      initialValue: 'Venture',
    }),
    defineField({
      name: 'brandDescription',
      title: 'Brand Description',
      type: 'text',
      rows: 3,
    }),
    defineField({
      name: 'backgroundColor',
      title: 'Background Color',
      type: 'string',
      options: {
        list: [
          { title: 'Primary Blue', value: 'primary' },
          { title: 'Light Blue', value: 'light-blue' },
          { title: 'Dark Blue', value: 'dark-blue' },
          { title: 'White', value: 'white' },
        ],
        layout: 'radio',
      },
      initialValue: 'light-blue',
    }),
  ],
  preview: {
    select: {
      title: 'heading',
      media: 'productImage',
    },
    prepare({ title, media }) {
      return {
        title: title || 'Product Showcase',
        subtitle: 'Blue showcase section',
        media,
      }
    },
  },
})
