import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'productCarouselBlock',
  title: 'Product Carousel',
  type: 'object',
  fields: [
    defineField({
      name: 'heading',
      title: 'Heading',
      type: 'string',
      description: 'H3 section heading (52px)',
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'description',
      title: 'Description',
      type: 'text',
      rows: 2,
      description: 'Supporting text (18px)',
    }),
    defineField({
      name: 'label',
      title: 'Label',
      type: 'string',
      description: 'Small label above heading (e.g., "Related Products")',
      initialValue: 'Related Products',
    }),
    defineField({
      name: 'products',
      title: 'Products',
      type: 'array',
      of: [{type: 'reference', to: [{type: 'product'}]}],
      validation: (Rule) => Rule.required().min(1),
    }),
    defineField({
      name: 'showPagination',
      title: 'Show Pagination',
      type: 'boolean',
      description: 'Display "01 / 04" style pagination',
      initialValue: true,
    }),
  ],
  preview: {
    select: {
      title: 'heading',
      products: 'products',
    },
    prepare({title, products}) {
      return {
        title: title,
        subtitle: `${products?.length || 0} products`,
      }
    },
  },
})
