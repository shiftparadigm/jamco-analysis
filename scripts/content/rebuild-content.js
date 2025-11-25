import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🔨 Rebuilding content to match reference images...\n')

async function rebuildContent() {
  // Get existing image assets
  const images = {
    heroFloating: 'image-b855847923d53de537f11924c06fdb7dbd9e588c-731x576-jpg',
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
  }

  const page = {
    _type: 'page',
    _id: 'page-premium-seating',
    title: 'Premium Seating',
    slug: { current: 'premium-seating' },
    language: 'en',

    hero: {
      _type: 'hero',
      heading: 'Jamco Premium  Seating',
      subheading: 'Premium-density seats with direct aisle access, optimized living space, and intuitive passenger control.',
      floatingImage: {
        _type: 'image',
        asset: { _type: 'reference', _ref: images.heroFloating }
      },
      cta: {
        _type: 'cta',
        text: 'Contact Us',
        linkType: 'external',
        externalUrl: '#contact',
        style: 'primary'
      },
      secondaryCta: {
        _type: 'cta',
        text: 'Download the Brochure',
        linkType: 'external',
        externalUrl: '#brochure',
        style: 'outline'
      },
      carouselIndicator: '01 / 02',
      featureCallout: {
        _type: 'featureCallout',
        label: 'Spatial Freedom',
        description: 'Configurable rests ensure passengers have the room they need',
        position: 'bottom-right'
      }
    },

    content: [
      // Section Intro
      {
        _type: 'sectionIntroBlock',
        _key: 'intro1',
        heading: 'Our Premium Seating features',
        description: 'Deliver the passenger experience your brand promises, without sacrificing density or service efficiency.'
      },

      // Feature Grid
      {
        _type: 'featureGridBlock',
        _key: 'grid1',
        columns: '3-col',
        features: [
          {
            _key: 'f1',
            heading: 'Direct aisle access for every passenger',
            description: 'Every seat provides unobstructed access to the aisle',
            image: {
              _type: 'image',
              asset: { _type: 'reference', _ref: images.feature1 }
            }
          },
          {
            _key: 'f2',
            heading: 'Premium density without the compromise',
            description: 'Maximize capacity while maintaining passenger comfort',
            image: {
              _type: 'image',
              asset: { _type: 'reference', _ref: images.feature2 }
            }
          },
          {
            _key: 'f3',
            heading: 'Optimized living space with smart storage',
            description: 'Thoughtful design keeps belongings organized and accessible',
            image: {
              _type: 'image',
              asset: { _type: 'reference', _ref: images.feature3 }
            }
          }
        ]
      },

      // Passenger Features Section Intro
      {
        _type: 'sectionIntroBlock',
        _key: 'intro2',
        heading: 'Passenger Features',
        description: 'Thoughtful design puts your passengers\' comfortable, productive experience at the center of every detail.'
      },

      // Control & Comfort
      {
        _type: 'splitFeatureBlock',
        _key: 'split1',
        heading: 'Control & Comfort',
        description: 'A unified control center uses capacitive touch input with LED lighting for clear, intuitive operation. Lighting, power, and entertainment are positioned where they are easy to use.',
        bulletPoints: [
          'One-touch lighting',
          'Power at hand for devices',
          'Clear labeling for low-light use'
        ],
        imagePosition: 'right',
        featureImage: {
          _type: 'image',
          asset: { _type: 'reference', _ref: images.splitControl }
        },
        ctaButton: {
          _type: 'cta',
          text: 'Contact Us',
          linkType: 'external',
          externalUrl: '#contact',
          style: 'primary'
        }
      },

      // Private by Design
      {
        _type: 'splitFeatureBlock',
        _key: 'split2',
        heading: 'Private by Design',
        description: 'Sliding dividers provide privacy from zero to full as needed. Shielding and geometry help reduce distractions while maintaining an open, airy feel.',
        bulletPoints: [
          'On-demand privacy divider',
          'Shielded sightlines and calm surfaces'
        ],
        imagePosition: 'left',
        featureImage: {
          _type: 'image',
          asset: { _type: 'reference', _ref: images.splitPrivate }
        },
        ctaButton: {
          _type: 'cta',
          text: 'Contact Us',
          linkType: 'external',
          externalUrl: '#contact',
          style: 'primary'
        }
      },

      // Testimonial
      {
        _type: 'testimonialBlock',
        _key: 'testimonial1',
        quote: 'This isn\'t just a seat. It\'s a mobile office, entertainment center, and personal sanctuary.',
        authorName: 'Maria Smith',
        authorTitle: 'CEO, Global Innovations',
        quoteSize: 'large',
        layout: 'centered'
      },

      // Work and Entertain
      {
        _type: 'splitFeatureBlock',
        _key: 'split3',
        heading: 'Work and Entertain On-Demand',
        description: 'An immersive HD display and spacious tray surface supports both work and relaxation. Content is accessible quickly without disrupting the passenger\'s setup.',
        bulletPoints: [
          'Immersive HD display options',
          'Fast access to entertainment and information',
          'Work surface/tray for devices and notes'
        ],
        imagePosition: 'right',
        featureImage: {
          _type: 'image',
          asset: { _type: 'reference', _ref: images.splitWork }
        },
        ctaButton: {
          _type: 'cta',
          text: 'Contact Us',
          linkType: 'external',
          externalUrl: '#contact',
          style: 'primary'
        }
      },

      // Spatial Freedom
      {
        _type: 'splitFeatureBlock',
        _key: 'split4',
        heading: 'Spatial Freedom',
        description: 'Ample space for passenger comfort and curated storage locations keep personal items tidy from taxi to touchdown.',
        bulletPoints: [
          'Generous passenger space',
          'Dedicated stowage for devices and small bags'
        ],
        imagePosition: 'left',
        featureImage: {
          _type: 'image',
          asset: { _type: 'reference', _ref: images.splitSpatial }
        },
        ctaButton: {
          _type: 'cta',
          text: 'Contact Us',
          linkType: 'external',
          externalUrl: '#contact',
          style: 'primary'
        }
      },

      // Product Carousel
      {
        _type: 'productCarouselBlock',
        _key: 'carousel1',
        heading: 'Complete your travel ecosystem',
        description: 'Elevate every aspect of your journey.',
        label: 'Related Products',
        showPagination: true,
        products: [
          { _type: 'reference', _ref: 'product-flight-deck-doors' },
          { _type: 'reference', _ref: 'product-dividers-partitions' },
          { _type: 'reference', _ref: 'product-closets-stowage' }
        ]
      }
    ],

    seo: {
      metaTitle: 'Premium Seating - Jamco America',
      metaDescription: 'Premium-density seats with direct aisle access, optimized living space, and intuitive passenger control.'
    }
  }

  await client.createOrReplace(page)
  console.log('✅ Page content rebuilt to match reference images\n')
  console.log('👉 Refresh: http://localhost:4321/premium-seating\n')
}

async function main() {
  try {
    await rebuildContent()
  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
