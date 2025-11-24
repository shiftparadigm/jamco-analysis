import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'testimonialBlock',
  title: 'Testimonial Block',
  type: 'object',
  fields: [
    defineField({
      name: 'heading',
      title: 'Heading',
      type: 'string',
      description: 'Optional section heading',
    }),
    defineField({
      name: 'testimonials',
      title: 'Testimonials',
      type: 'array',
      of: [
        {
          type: 'object',
          fields: [
            {
              name: 'quote',
              title: 'Quote',
              type: 'text',
              rows: 4,
              validation: (Rule) => Rule.required(),
            },
            {
              name: 'author',
              title: 'Author',
              type: 'string',
              validation: (Rule) => Rule.required(),
            },
            {
              name: 'title',
              title: 'Job Title',
              type: 'string',
            },
            {
              name: 'company',
              title: 'Company',
              type: 'string',
            },
            {
              name: 'image',
              title: 'Photo',
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
          preview: {
            select: {
              title: 'author',
              subtitle: 'company',
              media: 'image',
            },
          },
        },
      ],
      validation: (Rule) => Rule.max(3),
    }),
    defineField({
      name: 'quoteSize',
      title: 'Quote Size',
      type: 'string',
      description: 'Text size for large quote display',
      options: {
        list: [
          {title: 'Large (48px)', value: 'large'},
          {title: 'Medium (32px)', value: 'medium'},
          {title: 'Small (24px)', value: 'small'},
        ],
        layout: 'radio',
      },
      initialValue: 'large',
    }),
    defineField({
      name: 'showDivider',
      title: 'Show Divider',
      type: 'boolean',
      description: 'Display horizontal line separator',
      initialValue: false,
    }),
    defineField({
      name: 'layout',
      title: 'Layout',
      type: 'string',
      options: {
        list: [
          {title: 'Centered', value: 'centered'},
          {title: 'Left Aligned', value: 'left-aligned'},
        ],
        layout: 'radio',
      },
      initialValue: 'centered',
    }),
    defineField({
      name: 'backgroundImage',
      title: 'Background Image',
      type: 'image',
      description: 'Optional background image (will show through blue overlay)',
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
  ],
  preview: {
    select: {
      heading: 'heading',
      testimonials: 'testimonials',
    },
    prepare({heading, testimonials}) {
      return {
        title: heading || 'Testimonials',
        subtitle: `${testimonials?.length || 0} testimonial${testimonials?.length !== 1 ? 's' : ''}`,
      }
    },
  },
})
