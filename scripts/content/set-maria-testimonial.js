import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('📝 Setting Maria testimonial with existing image...\n')

async function main() {
  try {
    // Get the existing Maria image asset
    const assetId = 'image-908c6d4224815cb982a251a1e4bf8e5ff5f78c8f-120x120-png'

    // Find the testimonial block in PUBLISHED document
    const page = await client.fetch(
      `*[_type == "page" && slug.current == "premium-seating" && !(_id in path('drafts.**'))][0]{
        _id,
        content[_type == "testimonialBlock"]{
          _key,
          testimonials
        }
      }`
    )

    if (!page || !page.content || page.content.length === 0) {
      console.log('❌ No testimonial block found')
      return
    }

    const testimonialBlock = page.content[0]
    console.log(`📝 Found testimonial block with key: ${testimonialBlock._key}`)

    const testimonialData = {
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

    // Update published document
    await client
      .patch(page._id)
      .set({
        [`content[_key == "${testimonialBlock._key}"].testimonials`]: [testimonialData]
      })
      .unset([
        `content[_key == "${testimonialBlock._key}"].testimonials[0].authorName`,
        `content[_key == "${testimonialBlock._key}"].testimonials[0].authorTitle`
      ])
      .commit()

    console.log(`✅ Updated published: ${page._id}`)

    console.log('\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
    console.log('✨ Maria testimonial set successfully!')
    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n')
    console.log('👉 Refresh your browser to see the changes')
    console.log('   https://jamco.nyc/premium-seating\n')
  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
