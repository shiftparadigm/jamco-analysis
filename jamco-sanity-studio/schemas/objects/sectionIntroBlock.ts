import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'sectionIntroBlock',
  title: 'Section Intro',
  type: 'object',
  fields: [
    defineField({
      name: 'heading',
      title: 'Heading',
      type: 'string',
      description: 'H4 section heading (48px)',
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'description',
      title: 'Description',
      type: 'text',
      rows: 3,
      description: 'Supporting text (18px)',
    }),
    defineField({
      name: 'showDivider',
      title: 'Show Horizontal Divider',
      type: 'boolean',
      initialValue: false,
      description: 'Display a horizontal line below the section',
    }),
  ],
  preview: {
    select: {
      title: 'heading',
      subtitle: 'description',
    },
  },
})
