import { createClient } from '@sanity/client'
import { createReadStream } from 'fs'
import { readdir } from 'fs/promises'
import { join } from 'path'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🖼️  Starting image upload...\n')

async function uploadImages() {
  const imagesDir = './exported-images'
  const files = await readdir(imagesDir)
  const imageFiles = files.filter(f => f.endsWith('.jpg'))

  const uploadedImages = {}

  for (const file of imageFiles) {
    console.log(`📤 Uploading ${file}...`)

    const filePath = join(imagesDir, file)
    const asset = await client.assets.upload('image', createReadStream(filePath), {
      filename: file
    })

    uploadedImages[file] = asset._id
    console.log(`✅ Uploaded: ${file} (${asset._id})`)
  }

  console.log('\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
  console.log('🎉 All images uploaded!')
  console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n')

  return uploadedImages
}

async function updatePageContent(images) {
  console.log('📝 Updating page content with images...\n')

  // Map images to their purposes based on Figma analysis
  const imageMap = {
    hero: images['Screenshot 2025-11-06 at 12.30.25 PM 1.jpg'],
    floatingHero: images['Screenshot 2025-11-05 at 9.52 1.jpg'],
    feature1: images['Placeholder Image.jpg'],
    feature2: images['Placeholder Image-1.jpg'],
    feature3: images['Placeholder Image-2.jpg'],
    splitControl: images['Placeholder Image-3.jpg'],
    splitPrivate: images['Placeholder Image-4.jpg'],
    splitWork: images['Placeholder Image-5.jpg'],
    splitSpatial: images['Placeholder Image-6.jpg'],
    product1: images['Placeholder Image copy.jpg'],
    product2: images['Placeholder Image-1 copy.jpg'],
    product3: images['Placeholder Image-2 copy.jpg'],
    product4: images['Placeholder Image-3 copy.jpg'],
    product5: images['Placeholder Image-7.jpg'],
    pricingBg1: images['Rectangle 5.jpg'],
    pricingBg2: images['Rectangle 6.jpg']
  }

  // Update hero
  await client
    .patch('page-premium-seating')
    .set({
      'hero.backgroundImage': {
        _type: 'image',
        asset: { _type: 'reference', _ref: imageMap.hero }
      },
      'hero.floatingImage': {
        _type: 'image',
        asset: { _type: 'reference', _ref: imageMap.floatingHero }
      }
    })
    .commit()

  console.log('✅ Updated hero images')

  // Update feature grid
  await client
    .patch('page-premium-seating')
    .set({
      'content[1].features[0].image': {
        _type: 'image',
        asset: { _type: 'reference', _ref: imageMap.feature1 }
      },
      'content[1].features[1].image': {
        _type: 'image',
        asset: { _type: 'reference', _ref: imageMap.feature2 }
      },
      'content[1].features[2].image': {
        _type: 'image',
        asset: { _type: 'reference', _ref: imageMap.feature3 }
      }
    })
    .commit()

  console.log('✅ Updated feature grid images')

  // Update split features
  await client
    .patch('page-premium-seating')
    .set({
      'content[3].featureImage': {
        _type: 'image',
        asset: { _type: 'reference', _ref: imageMap.splitControl }
      },
      'content[4].featureImage': {
        _type: 'image',
        asset: { _type: 'reference', _ref: imageMap.splitPrivate }
      },
      'content[5].featureImage': {
        _type: 'image',
        asset: { _type: 'reference', _ref: imageMap.splitWork }
      },
      'content[6].featureImage': {
        _type: 'image',
        asset: { _type: 'reference', _ref: imageMap.splitSpatial }
      }
    })
    .commit()

  console.log('✅ Updated split feature images')

  // Update products
  const productUpdates = [
    { id: 'product-flight-deck-doors', image: imageMap.product1 },
    { id: 'product-dividers-partitions', image: imageMap.product2 },
    { id: 'product-closets-stowage', image: imageMap.product3 },
    { id: 'product-lavatories', image: imageMap.product4 },
    { id: 'product-comfort-module', image: imageMap.product5 }
  ]

  for (const prod of productUpdates) {
    await client
      .patch(prod.id)
      .set({
        images: [{
          _type: 'image',
          asset: { _type: 'reference', _ref: prod.image }
        }]
      })
      .commit()
  }

  console.log('✅ Updated product images')

  // Update pricing cards
  await client
    .patch('page-premium-seating')
    .set({
      'content[8].cards[0].backgroundImage': {
        _type: 'image',
        asset: { _type: 'reference', _ref: imageMap.pricingBg1 }
      },
      'content[8].cards[1].backgroundImage': {
        _type: 'image',
        asset: { _type: 'reference', _ref: imageMap.pricingBg2 }
      }
    })
    .commit()

  console.log('✅ Updated pricing card images')

  console.log('\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
  console.log('✨ All content updated with images!')
  console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n')
  console.log('👉 Refresh your browser to see the images')
  console.log('   http://localhost:4321/premium-seating\n')
}

async function main() {
  try {
    const images = await uploadImages()
    await updatePageContent(images)
  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
