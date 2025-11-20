import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'fileDownloadBlock',
  title: 'File Download Block',
  type: 'object',
  fields: [
    defineField({
      name: 'heading',
      title: 'Heading',
      type: 'string',
      description: 'Optional section heading',
    }),
    defineField({
      name: 'files',
      title: 'Files',
      type: 'array',
      of: [
        {
          type: 'object',
          fields: [
            {
              name: 'title',
              title: 'Title',
              type: 'string',
              validation: (Rule) => Rule.required(),
            },
            {
              name: 'description',
              title: 'Description',
              type: 'text',
              rows: 2,
            },
            {
              name: 'file',
              title: 'File',
              type: 'file',
              validation: (Rule) => Rule.required(),
            },
          ],
          preview: {
            select: {
              title: 'title',
              subtitle: 'description',
            },
          },
        },
      ],
      validation: (Rule) => Rule.required().min(1),
    }),
  ],
  preview: {
    select: {
      heading: 'heading',
      files: 'files',
    },
    prepare({heading, files}) {
      return {
        title: heading || 'File Downloads',
        subtitle: `${files?.length || 0} file${files?.length !== 1 ? 's' : ''}`,
      }
    },
  },
})
