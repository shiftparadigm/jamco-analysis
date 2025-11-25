import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🧹 Cleaning testimonial data...\n')

async function main() {
  try {
    const assetId = 'image-908c6d4224815cb982a251a1e4bf8e5ff5f78c8f-120x120-png'

    // Delete the entire testimonials array first, then recreate it clean
    await client
      .patch('page-premium-seating')
      .unset(['content[_key == "testimonial1"].testimonials'])
      .commit()

    console.log('✅ Removed old testimonials array')

    // Now set fresh clean data
    await client
      .patch('page-premium-seating')
      .set({
        'content[_key == "testimonial1"].testimonials': [
          {
            _key: 'maria-smith',
            quote: "This isn't just a seat. It's a mobile office, entertainment center, and personal sanctuary.",
            author: 'Maria Smith',
            title: 'CEO',
            company: 'Global Innovations',
            image: {
              _type: 'image',
              asset: {
                _type: 'reference',
                _ref: assetId
              },
              alt: 'Maria Smith'
            }
          }
        ]
      })
      .commit()

    console.log('✅ Set fresh testimonial data')
    console.log('\n✨ Done! Refresh Sanity Studio')
  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
