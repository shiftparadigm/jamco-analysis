import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

const hotspots = [
  {
    _key: 'hotspot1',
    title: 'Entertainment Display',
    description: 'Immersive HD screen with intuitive controls for movies, music, and flight information.',
    positionX: 48,
    positionY: 22
  },
  {
    _key: 'hotspot2',
    title: 'Ambient Lighting',
    description: 'Customizable mood lighting with reading lamp and do-not-disturb indicators.',
    positionX: 75,
    positionY: 28
  },
  {
    _key: 'hotspot3',
    title: 'Privacy Divider',
    description: 'Sliding partition offers complete privacy from neighboring passengers.',
    positionX: 35,
    positionY: 45
  },
  {
    _key: 'hotspot4',
    title: 'Personal Storage',
    description: 'Dedicated compartments for devices, shoes, and personal belongings.',
    positionX: 28,
    positionY: 62
  },
  {
    _key: 'hotspot5',
    title: 'Ottoman & Footrest',
    description: 'Converts to a guest seat or extends for full lie-flat sleeping position.',
    positionX: 65,
    positionY: 58
  }
]

async function addHotspots() {
  console.log('Adding hotspots to hero carousel...')

  const page = await client.fetch('*[_id == "page-premium-seating"][0]')

  // Add hotspots to each slide in the hero carousel
  if (page.hero && page.hero.slides) {
    page.hero.slides = page.hero.slides.map(slide => ({
      ...slide,
      hotspots: hotspots
    }))
  }

  await client.createOrReplace(page)
  console.log('✅ Hotspots added to hero carousel')
  console.log('👉 Refresh: http://localhost:4321/premium-seating')
}

addHotspots().catch(console.error)
