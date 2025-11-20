import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'splitFeatureBlock',
  title: 'Split Feature',
  type: 'object',
  fields: [
    defineField({
      name: 'heading',
      title: 'Heading',
      type: 'string',
      description: 'H2 feature heading (64px)',
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'description',
      title: 'Description',
      type: 'text',
      rows: 4,
      description: 'Main description text (18px)',
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'bulletPoints',
      title: 'Bullet Points',
      type: 'array',
      of: [{type: 'string'}],
      description: 'Feature highlights',
    }),
    defineField({
      name: 'ctaButton',
      title: 'Call to Action',
      type: 'cta',
    }),
    defineField({
      name: 'featureImage',
      title: 'Feature Image',
      type: 'image',
      options: {hotspot: true},
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
      name: 'backgroundImage',
      title: 'Background Image',
      type: 'image',
      description: 'Optional background image for the content side',
      options: {hotspot: true},
      fields: [
        {
          name: 'alt',
          title: 'Alt Text',
          type: 'string',
        },
      ],
    }),
    defineField({
      name: 'imagePosition',
      title: 'Image Position',
      type: 'string',
      options: {
        list: [
          {title: 'Left', value: 'left'},
          {title: 'Right', value: 'right'},
        ],
        layout: 'radio',
      },
      initialValue: 'right',
    }),
  ],
  preview: {
    select: {
      title: 'heading',
      media: 'featureImage',
      position: 'imagePosition',
    },
    prepare({title, media, position}) {
      return {
        title: title,
        subtitle: `Image ${position}`,
        media: media,
      }
    },
  },
})
