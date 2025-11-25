import {defineConfig} from 'sanity'
import {structureTool} from 'sanity/structure'
import {presentationTool} from 'sanity/presentation'
import {documentInternationalization} from '@sanity/document-internationalization'
import {schemaTypes} from './schemas'
import {deskStructure} from './deskStructure'
import {triggerRebuildAction} from './src/actions/triggerRebuild'

// Preview URL - use localhost in dev, production URL otherwise
const PREVIEW_URL = process.env.SANITY_STUDIO_PREVIEW_URL || 'http://localhost:4321'

export default defineConfig({
  name: 'default',
  title: 'Jamco America',

  projectId: process.env.SANITY_STUDIO_PROJECT_ID || 'c94x8u55',
  dataset: process.env.SANITY_STUDIO_DATASET || 'production',

  plugins: [
    structureTool({
      structure: deskStructure,
    }),
    presentationTool({
      previewUrl: PREVIEW_URL,
      resolve: {
        mainDocuments: [
          {
            route: '/:slug',
            filter: '_type == "page" && slug.current == $slug',
          },
        ],
        locations: {
          page: (doc) => ({
            locations: [
              {
                title: doc?.title || 'Page',
                href: `/${doc?.slug?.current || ''}`,
              },
            ],
          }),
          post: (doc) => ({
            locations: [
              {
                title: doc?.title || 'Post',
                href: `/blog/${doc?.slug?.current || ''}`,
              },
            ],
          }),
          product: (doc) => ({
            locations: [
              {
                title: doc?.name || 'Product',
                href: `/products/${doc?.slug?.current || ''}`,
              },
            ],
          }),
        },
      },
    }),
    documentInternationalization({
      supportedLanguages: [
        {id: 'en', title: 'English'},
        {id: 'ja', title: 'Japanese'},
      ],
      schemaTypes: ['page', 'post'],
    }),
  ],

  schema: {
    types: schemaTypes,
  },

  document: {
    actions: (prev, context) => {
      // Replace the default publish action with our custom one
      return prev.map((originalAction) =>
        originalAction.action === 'publish' ? triggerRebuildAction : originalAction
      )
    },
  },
})
