import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🎠 Updating hero to carousel format...\n')

async function updateHero() {
  const page = await client.fetch('*[_id == "page-premium-seating"][0]')

  // Get the existing hero image
  const heroImage = page.hero.floatingImage
  const featureCallout = page.hero.featureCallout

  // Create slides array with the existing image
  page.hero.slides = [
    {
      _key: 'slide1',
      floatingImage: heroImage,
      featureCallout: featureCallout
    },
    {
      _key: 'slide2',
      floatingImage: heroImage, // Using same image for now until you get more assets
      featureCallout: {
        _type: 'featureCallout',
        label: 'Premium Comfort',
        description: 'Experience luxury and functionality in perfect harmony',
        position: 'bottom-right'
      }
    }
  ]

  // Keep other hero properties
  page.hero._type = 'heroCarousel'

  await client.createOrReplace(page)
  console.log('✅ Hero updated to carousel format\n')
  console.log('👉 Refresh: http://localhost:4321/premium-seating\n')
}

async function main() {
  try {
    await updateHero()
  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
