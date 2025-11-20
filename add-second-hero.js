import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('➕ Adding second Premium Seating section...\n')

async function addSecondHero() {
  const page = await client.fetch('*[_id == "page-premium-seating"][0]')

  // Create the second hero section (blue background with white text)
  const secondHero = {
    _type: 'splitFeatureBlock',
    _key: 'secondhero',
    heading: 'Premium Seating',
    description: 'Elevate every aspect of your journey',
    imagePosition: 'right',
    backgroundColor: 'blue',
    featureImage: {
      _type: 'image',
      asset: { _type: 'reference', _ref: 'image-b855847923d53de537f11924c06fdb7dbd9e588c-731x576-jpg' }
    }
  }

  // Insert as first content block (right after hero)
  page.content.unshift(secondHero)

  await client.createOrReplace(page)
  console.log('✅ Added second Premium Seating section\n')
  console.log('👉 Refresh: http://localhost:4321/premium-seating\n')
}

async function main() {
  try {
    await addSecondHero()
  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
