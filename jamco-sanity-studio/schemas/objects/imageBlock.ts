import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'imageBlock',
  title: 'Image Block',
  type: 'object',
  fields: [
    defineField({
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
          validation: (Rule) => Rule.required(),
        },
      ],
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'caption',
      title: 'Caption',
      type: 'string',
    }),
    defineField({
      name: 'size',
      title: 'Size',
      type: 'string',
      options: {
        list: [
          {title: 'Small (400px)', value: 'small'},
          {title: 'Medium (600px)', value: 'medium'},
          {title: 'Large (800px)', value: 'large'},
          {title: 'Full Width', value: 'full'},
        ],
        layout: 'radio',
      },
      initialValue: 'large',
    }),
  ],
  preview: {
    select: {
      media: 'image',
      caption: 'caption',
    },
    prepare({media, caption}) {
      return {
        title: 'Image',
        subtitle: caption,
        media: media,
      }
    },
  },
})
