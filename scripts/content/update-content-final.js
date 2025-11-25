import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🎨 Updating content with proper styling...\n')

async function updateContent() {
  const page = await client.fetch('*[_id == "page-premium-seating"][0]')

  // Update split features with background colors
  page.content[3].backgroundColor = 'white' // Control & Comfort
  page.content[4].backgroundColor = 'light-blue' // Private by Design
  page.content[6].backgroundColor = 'white' // Work and Entertain
  page.content[7].backgroundColor = 'white' // Spatial Freedom

  // Add CTA block before product carousel
  const ctaBlock = {
    _type: 'ctaBlock',
    _key: 'cta1',
    heading: 'Ready to talk?',
    subheading: 'Our team is ready to meet your needs.',
    backgroundColor: 'dark-blue',
    ctaButton: {
      _type: 'cta',
      text: 'Contact Us',
      linkType: 'external',
      externalUrl: '#contact',
      style: 'primary'
    }
  }

  // Insert CTA block after product carousel
  page.content.push(ctaBlock)

  await client.createOrReplace(page)
  console.log('✅ Content updated with proper styling\n')
  console.log('👉 Refresh: http://localhost:4321/premium-seating\n')
}

async function main() {
  try {
    await updateContent()
  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
