import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

async function checkContent() {
  const page = await client.fetch('*[_id == "page-premium-seating"][0]')

  console.log('=== PAGE CONTENT STRUCTURE ===\n')
  console.log('Hero type:', page.hero?._type)
  console.log('\nContent blocks:')

  page.content?.forEach((block, i) => {
    console.log((i + 1) + '. ' + block._type + ' (key: ' + block._key + ')')
    if (block.heading) console.log('   heading: "' + block.heading + '"')
    if (block.label) console.log('   label: "' + block.label + '"')
    if (block.description) console.log('   description: "' + (block.description?.substring(0, 50) || '') + '..."')
  })
}

checkContent().catch(console.error)
