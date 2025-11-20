import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🔧 Fixing image references...\n')

async function fixImages() {
  // Get the current page
  const page = await client.fetch('*[_id == "page-premium-seating"][0]')

  // Image asset IDs from the upload
  const images = {
    hero: 'image-d349e4151f38ce7f24d31fab42463c4450413f3d-1440x658-jpg',
    floatingHero: 'image-b855847923d53de537f11924c06fdb7dbd9e588c-731x576-jpg',
    feature1: 'image-94dee5be4f3beebda76aa0da5c33a2a3c37f0ae8-707x507-jpg',
    feature2: 'image-b224ecd1eb47b809d5c935e25ed0f0af24167b98-432x432-jpg',
    feature3: 'image-8cce85d610ee5d1c9a06f8ef16eaae1d672a01e2-432x432-jpg',
    splitControl: 'image-ed1f190541aa222f6cc19137680e71fc14e917a2-432x432-jpg',
    splitPrivate: 'image-e7af2956eb1f5e5512f98124b4884eac43c0904f-666x590-jpg',
    splitWork: 'image-f26f12bbdfeb56a5705e509a15fdc2a6c6acfe8d-666x590-jpg',
    splitSpatial: 'image-e579ad72c4685efe50aafc49062c91fa164aa5fa-666x590-jpg',
    product1: 'image-352642a545ed8a58fd1599f2c4bc811d32606825-432x534-jpg',
    product2: 'image-ecf7b12588cb1ed90db689fff7aa20b5321e4f66-432x534-jpg',
    product3: 'image-131962e243ef7eb3c49dacc2a7dc3037012e903a-433x535-jpg',
    product4: 'image-8aa68fdbfdd9ad07cdc9a3c9322646de501dd4e1-53x534-jpg',
    product5: 'image-a847d82dd2af281c9b97e4f179906a297ea4e539-666x590-jpg',
    pricingBg1: 'image-693bed54af13363d7338602a343c37ac394acb4a-1323x771-jpg',
    pricingBg2: 'image-cb7f6823a80109867a53ab07f452601489ff2b36-117x771-jpg'
  }

  // Update hero
  page.hero.backgroundImage = {
    _type: 'image',
    asset: { _type: 'reference', _ref: images.hero }
  }
  page.hero.floatingImage = {
    _type: 'image',
    asset: { _type: 'reference', _ref: images.floatingHero }
  }

  // Update feature grid - add images to features
  page.content[1].features[0].image = {
    _type: 'image',
    asset: { _type: 'reference', _ref: images.feature1 }
  }
  page.content[1].features[1].image = {
    _type: 'image',
    asset: { _type: 'reference', _ref: images.feature2 }
  }
  page.content[1].features[2].image = {
    _type: 'image',
    asset: { _type: 'reference', _ref: images.feature3 }
  }

  // Update split features
  page.content[3].featureImage = {
    _type: 'image',
    asset: { _type: 'reference', _ref: images.splitControl }
  }
  page.content[4].featureImage = {
    _type: 'image',
    asset: { _type: 'reference', _ref: images.splitPrivate }
  }
  page.content[5].featureImage = {
    _type: 'image',
    asset: { _type: 'reference', _ref: images.splitWork }
  }
  page.content[6].featureImage = {
    _type: 'image',
    asset: { _type: 'reference', _ref: images.splitSpatial }
  }

  // Update pricing cards
  page.content[8].cards[0].backgroundImage = {
    _type: 'image',
    asset: { _type: 'reference', _ref: images.pricingBg1 }
  }
  page.content[8].cards[1].backgroundImage = {
    _type: 'image',
    asset: { _type: 'reference', _ref: images.pricingBg2 }
  }

  // Replace the entire document
  await client.createOrReplace(page)
  console.log('✅ Updated page with all images')

  // Update products
  const productUpdates = [
    { id: 'product-flight-deck-doors', image: images.product1 },
    { id: 'product-dividers-partitions', image: images.product2 },
    { id: 'product-closets-stowage', image: images.product3 },
    { id: 'product-lavatories', image: images.product4 },
    { id: 'product-comfort-module', image: images.product5 }
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

  console.log('✅ Updated all product images')

  console.log('\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
  console.log('✨ All images fixed!')
  console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n')
  console.log('👉 Refresh: http://localhost:4321/premium-seating\n')
}

async function main() {
  try {
    await fixImages()
  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
