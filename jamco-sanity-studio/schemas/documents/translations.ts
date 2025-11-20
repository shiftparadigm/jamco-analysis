import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'translations',
  title: 'UI Translations',
  type: 'document',
  fields: [
    defineField({
      name: 'key',
      title: 'Key',
      type: 'string',
      description: 'Unique identifier for this translation (e.g., "nav.home", "button.submit")',
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'en',
      title: 'English',
      type: 'string',
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'ja',
      title: 'Japanese',
      type: 'string',
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'description',
      title: 'Description',
      type: 'text',
      rows: 2,
      description: 'Optional context about where this translation is used',
    }),
  ],
  preview: {
    select: {
      title: 'key',
      en: 'en',
      ja: 'ja',
    },
    prepare({title, en, ja}) {
      return {
        title: title,
        subtitle: `EN: ${en} | JA: ${ja}`,
      }
    },
  },
})
