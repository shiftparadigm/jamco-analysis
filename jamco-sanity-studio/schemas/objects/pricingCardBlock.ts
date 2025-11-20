import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'pricingCardBlock',
  title: 'Pricing Cards',
  type: 'object',
  fields: [
    defineField({
      name: 'layout',
      title: 'Layout',
      type: 'string',
      options: {
        list: [
          {title: '2 Cards', value: '2-col'},
          {title: '3 Cards', value: '3-col'},
        ],
        layout: 'radio',
      },
      initialValue: '2-col',
    }),
    defineField({
      name: 'cards',
      title: 'Pricing Cards',
      type: 'array',
      of: [
        {
          type: 'object',
          fields: [
            {
              name: 'tierName',
              title: 'Tier Name',
              type: 'string',
              description: 'e.g., "Essential", "Pro", "Enterprise"',
              validation: (Rule) => Rule.required(),
            },
            {
              name: 'heading',
              title: 'Heading',
              type: 'string',
              description: 'Optional tagline (e.g., "Performance upgrade")',
            },
            {
              name: 'price',
              title: 'Price',
              type: 'number',
              description: 'Numeric price value',
              validation: (Rule) => Rule.required().positive(),
            },
            {
              name: 'pricePrefix',
              title: 'Price Prefix',
              type: 'string',
              description: 'Currency symbol or text before price',
              initialValue: '$',
            },
            {
              name: 'priceSuffix',
              title: 'Price Suffix',
              type: 'string',
              description: 'Text after price (e.g., "/month")',
            },
            {
              name: 'features',
              title: 'Features',
              type: 'array',
              of: [{type: 'string'}],
              description: 'List of included features',
            },
            {
              name: 'backgroundImage',
              title: 'Background Image',
              type: 'image',
              description: 'Optional background image for this card',
              options: {hotspot: true},
            },
            {
              name: 'highlightCard',
              title: 'Highlight This Card',
              type: 'boolean',
              description: 'Make this card stand out visually',
              initialValue: false,
            },
          ],
          preview: {
            select: {
              tierName: 'tierName',
              price: 'price',
              prefix: 'pricePrefix',
            },
            prepare({tierName, price, prefix}) {
              return {
                title: tierName,
                subtitle: `${prefix || '$'}${price}`,
              }
            },
          },
        },
      ],
      validation: (Rule) => Rule.min(2).max(3),
    }),
  ],
  preview: {
    select: {
      cards: 'cards',
      layout: 'layout',
    },
    prepare({cards, layout}) {
      return {
        title: 'Pricing Cards',
        subtitle: `${layout} - ${cards?.length || 0} cards`,
      }
    },
  },
})
