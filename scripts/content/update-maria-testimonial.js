import { createClient } from '@sanity/client'
import { createReadStream } from 'fs'
import { fileURLToPath } from 'url'
import { dirname, join } from 'path'

const __filename = fileURLToPath(import.meta.url)
const __dirname = dirname(__filename)

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🖼️  Uploading Maria testimonial image...\n')

async function main() {
  try {
    // Upload Maria's image
    const imagePath = join(__dirname, '../../exported-images/maria.png')
    console.log('📤 Uploading maria.png...')

    const asset = await client.assets.upload('image', createReadStream(imagePath), {
      filename: 'maria.png'
    })

    console.log(`✅ Uploaded: ${asset._id}`)

    // Find the testimonial block
    const page = await client.fetch(
      `*[_type == "page" && slug.current == "premium-seating"][0]{
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

    // Create/update the testimonial with Maria's data
    await client
      .patch(page._id)
      .set({
        [`content[_key == "${testimonialBlock._key}"].testimonials`]: [
          {
            _type: 'testimonial',
            _key: 'maria-smith',
            quote: '"This isn\'t just a seat. It\'s a mobile office, entertainment center, and personal sanctuary."',
            author: {
              name: 'Maria Smith',
              title: 'CEO, Global Innovations'
            },
            image: {
              _type: 'image',
              asset: {
                _type: 'reference',
                _ref: asset._id
              },
              alt: 'Maria Smith'
            }
          }
        ]
      })
      .commit()

    console.log('\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
    console.log('✨ Maria testimonial image updated!')
    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n')
    console.log('👉 Refresh your browser to see the changes')
    console.log('   http://localhost:4321/premium-seating\n')
  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
