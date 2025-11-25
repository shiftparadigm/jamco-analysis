import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🖼️  Updating testimonial background image...\n')

async function main() {
  try {
    // First, find an existing image asset we can use
    console.log('🔍 Finding available image assets...')
    const images = await client.fetch(
      `*[_type == "sanity.imageAsset"] | order(_createdAt desc) [0...10] {
        _id,
        originalFilename,
        url
      }`
    )

    console.log(`\nFound ${images.length} images:`)
    images.forEach((img, i) => {
      console.log(`  ${i + 1}. ${img.originalFilename} (${img._id})`)
    })

    // Use the first suitable image (or you can choose manually)
    const selectedImage = images[0]
    console.log(`\n✅ Using: ${selectedImage.originalFilename}`)

    // Find the testimonial block
    const page = await client.fetch(
      `*[_type == "page" && slug.current == "premium-seating"][0]{
        _id,
        content[_type == "testimonialBlock"]{
          _key,
          ...
        }
      }`
    )

    if (!page || !page.content || page.content.length === 0) {
      console.log('❌ No testimonial block found')
      return
    }

    const testimonialBlock = page.content[0]
    console.log(`📝 Found testimonial block with key: ${testimonialBlock._key}`)

    // Update the testimonial block with the background image
    console.log('📝 Updating testimonial block...')

    await client
      .patch(page._id)
      .set({
        [`content[_key == "${testimonialBlock._key}"].backgroundImage`]: {
          _type: 'image',
          asset: {
            _type: 'reference',
            _ref: selectedImage._id
          }
        }
      })
      .commit()

    console.log('\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
    console.log('✨ Testimonial background updated!')
    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n')
    console.log('👉 Refresh your browser to see the changes')
    console.log('   http://localhost:4321/premium-seating\n')
  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
