import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🔧 Applying design fixes...\n')

async function applyDesignFixes() {
  const page = await client.fetch('*[_id == "page-premium-seating"][0]')

  // Fix 1: Update hero CTA button text to match reference
  if (page.hero && page.hero.cta) {
    page.hero.cta.text = 'View Premium Seating Suite'
    console.log('✅ Fixed hero button text to "View Premium Seating Suite"')
  }

  // Fix 2: Add ProductShowcase block after hero
  // Get the existing hero image for the showcase
  const showcaseImage = page.hero?.slides?.[0]?.floatingImage || page.hero?.floatingImage

  const productShowcaseBlock = {
    _type: 'productShowcaseBlock',
    _key: 'showcase1',
    heading: 'Premium Seating',
    subheading: 'Showcase every aspect of your journey.',
    productImage: showcaseImage,
    brandName: 'Venture',
    brandDescription: 'Direct aisle access, premium density, and curated surfaces for a calm, private environment—ready to scale across your fleet.'
  }

  // Insert ProductShowcase at the beginning of content (after hero)
  if (!page.content.find(b => b._type === 'productShowcaseBlock')) {
    page.content.unshift(productShowcaseBlock)
    console.log('✅ Added ProductShowcase (Venture) section')
  } else {
    console.log('ℹ️ ProductShowcase already exists')
  }

  await client.createOrReplace(page)
  console.log('\n✅ All design fixes applied\n')
  console.log('👉 Refresh: http://localhost:4321/premium-seating\n')
}

async function main() {
  try {
    await applyDesignFixes()
  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
