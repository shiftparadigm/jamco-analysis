import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'featureCallout',
  title: 'Feature Callout',
  type: 'object',
  fields: [
    defineField({
      name: 'label',
      title: 'Label',
      type: 'string',
      description: 'Feature label (e.g., "Spatial Freedom")',
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'description',
      title: 'Description',
      type: 'text',
      rows: 2,
      description: 'Short feature description',
    }),
    defineField({
      name: 'image',
      title: 'Icon/Image',
      type: 'image',
      description: 'Optional small icon or image',
      options: {hotspot: true},
    }),
    defineField({
      name: 'position',
      title: 'Position',
      type: 'string',
      description: 'Where to position this callout on the hero',
      options: {
        list: [
          {title: 'Top Right', value: 'top-right'},
          {title: 'Top Left', value: 'top-left'},
          {title: 'Bottom Right', value: 'bottom-right'},
          {title: 'Bottom Left', value: 'bottom-left'},
        ],
        layout: 'radio',
      },
      initialValue: 'top-right',
    }),
  ],
  preview: {
    select: {
      title: 'label',
      subtitle: 'description',
      media: 'image',
    },
  },
})
