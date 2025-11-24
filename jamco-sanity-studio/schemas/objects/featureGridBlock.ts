import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'featureGridBlock',
  title: 'Feature Grid',
  type: 'object',
  fields: [
    defineField({
      name: 'heading',
      title: 'Heading',
      type: 'string',
      description: 'Optional section heading',
    }),
    defineField({
      name: 'description',
      title: 'Description',
      type: 'text',
      rows: 2,
      description: 'Optional section description',
    }),
    defineField({
      name: 'columns',
      title: 'Layout',
      type: 'string',
      options: {
        list: [
          {title: '2 Columns', value: '2-col'},
          {title: '3 Columns', value: '3-col'},
          {title: '4 Columns', value: '4-col'},
        ],
        layout: 'radio',
      },
      initialValue: '3-col',
    }),
    defineField({
      name: 'features',
      title: 'Features',
      type: 'array',
      of: [
        {
          type: 'object',
          fields: [
            {
              name: 'image',
              title: 'Image',
              type: 'image',
              options: {hotspot: true},
              fields: [
                {
                  name: 'alt',
                  title: 'Alt Text',
                  type: 'string',
                },
              ],
              validation: (Rule) => Rule.required(),
            },
            {
              name: 'heading',
              title: 'Heading',
              type: 'string',
              validation: (Rule) => Rule.required(),
            },
            {
              name: 'description',
              title: 'Description',
              type: 'text',
              rows: 2,
            },
          ],
          preview: {
            select: {
              title: 'heading',
              media: 'image',
            },
          },
        },
      ],
      validation: (Rule) => Rule.min(2).max(4),
    }),
  ],
  preview: {
    select: {
      heading: 'heading',
      features: 'features',
      columns: 'columns',
    },
    prepare({heading, features, columns}) {
      return {
        title: heading || 'Feature Grid',
        subtitle: `${columns} - ${features?.length || 0} features`,
      }
    },
  },
})
