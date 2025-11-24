import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'fullWidthImageBlock',
  title: 'Full Width Image',
  type: 'object',
  fields: [
    defineField({
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
    }),
    defineField({
      name: 'caption',
      title: 'Caption',
      type: 'string',
      description: 'Optional image caption',
    }),
    defineField({
      name: 'height',
      title: 'Height',
      type: 'string',
      options: {
        list: [
          {title: 'Auto (Natural)', value: 'auto'},
          {title: 'Tall (800px)', value: 'tall'},
          {title: 'Medium (600px)', value: 'medium'},
          {title: 'Short (400px)', value: 'short'},
        ],
        layout: 'radio',
      },
      initialValue: 'auto',
    }),
  ],
  preview: {
    select: {
      media: 'image',
      caption: 'caption',
    },
    prepare({media, caption}) {
      return {
        title: 'Full Width Image',
        subtitle: caption || 'No caption',
        media: media,
      }
    },
  },
})
