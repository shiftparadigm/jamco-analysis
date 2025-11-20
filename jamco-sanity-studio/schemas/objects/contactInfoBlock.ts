import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'contactInfoBlock',
  title: 'Contact Info Block',
  type: 'object',
  fields: [
    defineField({
      name: 'heading',
      title: 'Heading',
      type: 'string',
      description: 'Optional section heading',
    }),
    defineField({
      name: 'address',
      title: 'Address',
      type: 'text',
      rows: 3,
    }),
    defineField({
      name: 'phone',
      title: 'Phone',
      type: 'string',
    }),
    defineField({
      name: 'email',
      title: 'Email',
      type: 'string',
    }),
    defineField({
      name: 'hours',
      title: 'Business Hours',
      type: 'text',
      rows: 3,
    }),
    defineField({
      name: 'showMap',
      title: 'Show Map',
      type: 'boolean',
      initialValue: false,
    }),
    defineField({
      name: 'mapEmbedUrl',
      title: 'Google Maps Embed URL',
      type: 'url',
      description: 'Get from Google Maps → Share → Embed a map → Copy iframe src URL',
      hidden: ({parent}) => !parent?.showMap,
    }),
  ],
  preview: {
    select: {
      heading: 'heading',
      phone: 'phone',
      email: 'email',
    },
    prepare({heading, phone, email}) {
      return {
        title: heading || 'Contact Information',
        subtitle: [phone, email].filter(Boolean).join(' • '),
      }
    },
  },
})
