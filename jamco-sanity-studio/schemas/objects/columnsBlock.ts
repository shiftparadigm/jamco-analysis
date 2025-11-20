import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'columnsBlock',
  title: 'Columns Block',
  type: 'object',
  fields: [
    defineField({
      name: 'layout',
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
      initialValue: '2-col',
    }),
    defineField({
      name: 'columns',
      title: 'Columns',
      type: 'array',
      of: [
        {
          type: 'object',
          fields: [
            {
              name: 'image',
              title: 'Image',
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
            {
              name: 'heading',
              title: 'Heading',
              type: 'string',
            },
            {
              name: 'content',
              title: 'Content',
              type: 'portableText',
            },
          ],
          preview: {
            select: {
              title: 'heading',
              media: 'image',
            },
            prepare({title, media}) {
              return {
                title: title || 'Column',
                media: media,
              }
            },
          },
        },
      ],
      validation: (Rule) => Rule.min(2).max(4),
    }),
  ],
  preview: {
    select: {
      layout: 'layout',
      columns: 'columns',
    },
    prepare({layout, columns}) {
      return {
        title: `Columns Block`,
        subtitle: `${layout} - ${columns?.length || 0} columns`,
      }
    },
  },
})
