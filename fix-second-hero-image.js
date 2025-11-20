import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🖼️  Updating second section image...\n')

async function fixImage() {
  const page = await client.fetch('*[_id == "page-premium-seating"][0]')

  // Update first content block (second hero) to use Placeholder Image.jpg
  page.content[0].featureImage = {
    _type: 'image',
    asset: {
      _type: 'reference',
      _ref: 'image-94dee5be4f3beebda76aa0da5c33a2a3c37f0ae8-707x507-jpg'
    }
  }

  await client.createOrReplace(page)
  console.log('✅ Updated second section to use Placeholder Image.jpg\n')
  console.log('👉 Refresh: http://localhost:4321/premium-seating\n')
}

async function main() {
  try {
    await fixImage()
  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
