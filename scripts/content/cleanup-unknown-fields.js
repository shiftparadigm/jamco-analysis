import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🧹 Cleaning up unknown fields from blocks...\n')

async function main() {
  try {
    const page = await client.getDocument('page-premium-seating')

    const fieldsToRemove = []

    // Find blocks with unknown fields
    page.content.forEach(block => {
      if (block._type === 'fullWidthImageBlock' && block._key === 'fullWidthImage1') {
        if (block.showNavArrows !== undefined) {
          fieldsToRemove.push(`content[_key == "${block._key}"].showNavArrows`)
          console.log(`❌ Removing: ${block._type}.showNavArrows`)
        }
        if (block.watermark !== undefined) {
          fieldsToRemove.push(`content[_key == "${block._key}"].watermark`)
          console.log(`❌ Removing: ${block._type}.watermark`)
        }
      }

      if (block._type === 'productCarouselBlock' && block._key === 'carousel1') {
        if (block.subtitle !== undefined) {
          fieldsToRemove.push(`content[_key == "${block._key}"].subtitle`)
          console.log(`❌ Removing: ${block._type}.subtitle (duplicate of description)`)
        }
        if (block.title !== undefined) {
          fieldsToRemove.push(`content[_key == "${block._key}"].title`)
          console.log(`❌ Removing: ${block._type}.title (duplicate of heading)`)
        }
      }
    })

    if (fieldsToRemove.length === 0) {
      console.log('✅ No unknown fields found!')
      return
    }

    console.log(`\n🔧 Removing ${fieldsToRemove.length} unknown fields...`)

    await client
      .patch('page-premium-seating')
      .unset(fieldsToRemove)
      .commit()

    console.log('\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
    console.log('✨ Cleanup complete!')
    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
    console.log('\n👉 Refresh Sanity Studio to verify')

  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
