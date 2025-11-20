import {defineConfig} from 'sanity'
import {structureTool} from 'sanity/structure'
import {documentInternationalization} from '@sanity/document-internationalization'
import {schemaTypes} from './schemas'
import {deskStructure} from './deskStructure'

export default defineConfig({
  name: 'default',
  title: 'Jamco America',

  projectId: process.env.SANITY_STUDIO_PROJECT_ID || 'c94x8u55',
  dataset: process.env.SANITY_STUDIO_DATASET || 'production',

  plugins: [
    structureTool({
      structure: deskStructure,
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
})
