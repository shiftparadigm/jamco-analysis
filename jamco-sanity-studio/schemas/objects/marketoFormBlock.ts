import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'marketoFormBlock',
  title: 'Marketo Form Block',
  type: 'object',
  fields: [
    defineField({
      name: 'heading',
      title: 'Heading',
      type: 'string',
    }),
    defineField({
      name: 'description',
      title: 'Description',
      type: 'text',
      rows: 3,
      description: 'Text shown above the form',
    }),
    defineField({
      name: 'formId',
      title: 'Marketo Form ID',
      type: 'string',
      description: 'The numeric form ID from Marketo (e.g., "1234")',
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'munchkinId',
      title: 'Munchkin ID',
      type: 'string',
      description: 'Your Marketo Munchkin account ID (e.g., "000-AAA-000")',
      initialValue: '000-AAA-000',
    }),
    defineField({
      name: 'successMessage',
      title: 'Success Message',
      type: 'text',
      rows: 2,
      description: 'Message shown after successful submission',
      initialValue: 'Thank you for your submission!',
    }),
  ],
  preview: {
    select: {
      heading: 'heading',
      formId: 'formId',
    },
    prepare({heading, formId}) {
      return {
        title: heading || 'Marketo Form',
        subtitle: `Form ID: ${formId}`,
      }
    },
  },
})
