import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'navigation',
  title: 'Navigation',
  type: 'document',
  fields: [
    defineField({
      name: 'title',
      title: 'Menu Title',
      type: 'string',
      description: 'Internal name for this menu (e.g., "Main Navigation", "Footer Menu")',
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'language',
      title: 'Language',
      type: 'string',
      options: {
        list: [
          {title: 'English', value: 'en'},
          {title: 'Japanese', value: 'ja'},
        ],
        layout: 'radio',
      },
      initialValue: 'en',
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'items',
      title: 'Menu Items',
      type: 'array',
      of: [
        {
          type: 'object',
          name: 'navItem',
          fields: [
            {
              name: 'label',
              title: 'Label',
              type: 'string',
              validation: (Rule) => Rule.required(),
            },
            {
              name: 'linkType',
              title: 'Link Type',
              type: 'string',
              options: {
                list: [
                  {title: 'Internal Link', value: 'internal'},
                  {title: 'External URL', value: 'external'},
                ],
                layout: 'radio',
              },
              initialValue: 'internal',
            },
            {
              name: 'internalLink',
              title: 'Internal Link',
              type: 'reference',
              to: [{type: 'page'}, {type: 'post'}],
              hidden: ({parent}) => parent?.linkType !== 'internal',
            },
            {
              name: 'externalUrl',
              title: 'External URL',
              type: 'url',
              hidden: ({parent}) => parent?.linkType !== 'external',
            },
            {
              name: 'children',
              title: 'Sub-menu Items',
              type: 'array',
              of: [
                {
                  type: 'object',
                  fields: [
                    {
                      name: 'label',
                      title: 'Label',
                      type: 'string',
                      validation: (Rule) => Rule.required(),
                    },
                    {
                      name: 'linkType',
                      title: 'Link Type',
                      type: 'string',
                      options: {
                        list: [
                          {title: 'Internal Link', value: 'internal'},
                          {title: 'External URL', value: 'external'},
                        ],
                        layout: 'radio',
                      },
                      initialValue: 'internal',
                    },
                    {
                      name: 'internalLink',
                      title: 'Internal Link',
                      type: 'reference',
                      to: [{type: 'page'}, {type: 'post'}],
                      hidden: ({parent}) => parent?.linkType !== 'internal',
                    },
                    {
                      name: 'externalUrl',
                      title: 'External URL',
                      type: 'url',
                      hidden: ({parent}) => parent?.linkType !== 'external',
                    },
                  ],
                  preview: {
                    select: {
                      title: 'label',
                      linkType: 'linkType',
                    },
                    prepare({title, linkType}) {
                      return {
                        title: title,
                        subtitle: linkType === 'external' ? 'External' : 'Internal',
                      }
                    },
                  },
                },
              ],
            },
          ],
          preview: {
            select: {
              title: 'label',
              hasChildren: 'children',
            },
            prepare({title, hasChildren}) {
              return {
                title: title,
                subtitle: hasChildren?.length > 0 ? `${hasChildren.length} sub-items` : '',
              }
            },
          },
        },
      ],
    }),
  ],
  preview: {
    select: {
      title: 'title',
      language: 'language',
    },
    prepare({title, language}) {
      return {
        title: title,
        subtitle: language === 'ja' ? '🇯🇵 Japanese' : '🇺🇸 English',
      }
    },
  },
})
