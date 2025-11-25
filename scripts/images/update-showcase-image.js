import { createClient } from '@sanity/client'
import { createReadStream } from 'fs'
import path from 'path'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

async function updateShowcaseImage() {
  console.log('📷 Uploading Placeholder Image.jpg...')

  // Upload the image
  const imagePath = path.join(process.cwd(), 'exported-images', 'Placeholder Image.jpg')
  const imageAsset = await client.assets.upload('image', createReadStream(imagePath), {
    filename: 'placeholder-image.jpg'
  })

  console.log('✅ Image uploaded:', imageAsset._id)

  // Get the page and update the ProductShowcase
  const page = await client.fetch('*[_id == "page-premium-seating"][0]')

  // Find the productShowcaseBlock and update its image
  page.content = page.content.map(block => {
    if (block._type === 'productShowcaseBlock') {
      block.productImage = {
        _type: 'image',
        asset: {
          _type: 'reference',
          _ref: imageAsset._id
        }
      }
      console.log('✅ Updated ProductShowcase image')
    }
    return block
  })

  await client.createOrReplace(page)
  console.log('✅ Page saved')
  console.log('👉 Refresh: http://localhost:4321/premium-seating')
}

updateShowcaseImage().catch(console.error)
