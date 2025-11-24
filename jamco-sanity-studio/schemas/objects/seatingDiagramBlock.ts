import { defineType, defineField } from 'sanity'

export default defineType({
  name: 'seatingDiagramBlock',
  title: 'Seating Diagram',
  type: 'object',
  fields: [
    defineField({
      name: 'diagramImage',
      title: 'Diagram Image',
      type: 'image',
      description: 'Aircraft seating layout blueprint/diagram',
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
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'brandLogos',
      title: 'Brand Logos',
      type: 'array',
      of: [
        {
          type: 'object',
          fields: [
            defineField({
              name: 'name',
              title: 'Brand Name',
              type: 'string',
            }),
            defineField({
              name: 'logo',
              title: 'Logo Image',
              type: 'image',
            }),
            defineField({
              name: 'tagline',
              title: 'Tagline',
              type: 'string',
              description: 'e.g., "Quest for Elegance"',
            }),
          ],
        },
      ],
    }),
    defineField({
      name: 'backgroundColor',
      title: 'Background Color',
      type: 'string',
      options: {
        list: [
          { title: 'White', value: 'white' },
          { title: 'Light Blue', value: 'light-blue' },
        ],
      },
      initialValue: 'white',
    }),
  ],
  preview: {
    select: {
      media: 'diagramImage',
    },
    prepare({ media }) {
      return {
        title: 'Seating Diagram',
        subtitle: 'Aircraft layout blueprint',
        media,
      }
    },
  },
})
