import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🔧 Fixing content order...\n')

async function fixContentOrder() {
  const page = await client.fetch('*[_id == "page-premium-seating"][0]')

  console.log('Before fix - Content blocks:')
  page.content?.forEach((block, i) => {
    console.log((i + 1) + '. ' + block._type + ' - ' + (block.heading || block._key))
  })

  // Remove the extra splitFeatureBlock with key "secondhero"
  page.content = page.content.filter(block => block._key !== 'secondhero')

  console.log('\nAfter fix - Content blocks:')
  page.content?.forEach((block, i) => {
    console.log((i + 1) + '. ' + block._type + ' - ' + (block.heading || block._key))
  })

  await client.createOrReplace(page)
  console.log('\n✅ Content order fixed!')
  console.log('👉 Refresh: http://localhost:4321/premium-seating\n')
}

fixContentOrder().catch(console.error)
