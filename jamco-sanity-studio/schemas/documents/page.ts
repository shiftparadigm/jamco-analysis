import {defineType, defineField} from 'sanity'

export default defineType({
  name: 'page',
  title: 'Page',
  type: 'document',
  fields: [
    defineField({
      name: 'title',
      title: 'Title',
      type: 'string',
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: 'slug',
      title: 'Slug',
      type: 'slug',
      options: {
        source: 'title',
        maxLength: 96,
      },
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
      name: 'hero',
      title: 'Hero Section',
      type: 'hero',
      description: 'Large banner section at the top of the page',
    }),
    defineField({
      name: 'content',
      title: 'Page Content',
      type: 'array',
      of: [
        {type: 'contentBlock'},
        {type: 'columnsBlock'},
        {type: 'ctaBlock'},
        {type: 'imageBlock'},
        {type: 'fileDownloadBlock'},
        {type: 'testimonialBlock'},
        {type: 'contactInfoBlock'},
        {type: 'marketoFormBlock'},
        // New design-specific blocks
        {type: 'sectionIntroBlock'},
        {type: 'featureGridBlock'},
        {type: 'splitFeatureBlock'},
        {type: 'productCarouselBlock'},
        {type: 'pricingCardBlock'},
        {type: 'fullWidthImageBlock'},
        {type: 'seatingDiagramBlock'},
      ],
    }),
    defineField({
      name: 'seo',
      title: 'SEO',
      type: 'seo',
    }),
  ],
  preview: {
    select: {
      title: 'title',
      language: 'language',
      slug: 'slug.current',
    },
    prepare({title, language, slug}) {
      return {
        title: title,
        subtitle: `${language === 'ja' ? '🇯🇵' : '🇺🇸'} /${slug || ''}`,
      }
    },
  },
})
