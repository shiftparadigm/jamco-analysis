import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '', // You'll need to set this
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🚀 Starting content population...\n')

// Step 1: Create Product Category
async function createProductCategory() {
  console.log('📁 Creating Product Category...')

  const category = {
    _type: 'productCategory',
    _id: 'category-premium-seating',
    name: 'Premium Seating',
    slug: { current: 'premium-seating' },
    description: 'Premium aircraft seating solutions'
  }

  await client.createOrReplace(category)
  console.log('✅ Created: Premium Seating category\n')
}

// Step 2: Create Products
async function createProducts() {
  console.log('📦 Creating Products...')

  const products = [
    {
      _id: 'product-flight-deck-doors',
      name: 'Flight Deck Doors and Linings',
      slug: { current: 'flight-deck-doors-linings' },
      shortDescription: 'Secure and certified flight deck access solutions'
    },
    {
      _id: 'product-dividers-partitions',
      name: 'Dividers & Partitions',
      slug: { current: 'dividers-partitions' },
      shortDescription: 'Flexible cabin divider systems'
    },
    {
      _id: 'product-closets-stowage',
      name: 'Closets & Stowage',
      slug: { current: 'closets-stowage' },
      shortDescription: 'Optimized storage solutions for cabin crew'
    },
    {
      _id: 'product-lavatories',
      name: 'Lavatories',
      slug: { current: 'lavatories' },
      shortDescription: 'Modern lavatory systems'
    },
    {
      _id: 'product-comfort-module',
      name: 'Comfort module',
      slug: { current: 'comfort-module' },
      shortDescription: 'Enhanced passenger comfort features'
    }
  ]

  for (const product of products) {
    const doc = {
      _type: 'product',
      ...product,
      category: { _type: 'reference', _ref: 'category-premium-seating' },
      description: [
        {
          _type: 'block',
          _key: 'block1',
          style: 'normal',
          children: [{ _type: 'span', text: product.shortDescription, marks: [] }]
        }
      ],
      images: [], // Would need actual images
    }

    await client.createOrReplace(doc)
    console.log(`✅ Created: ${product.name}`)
  }
  console.log('')
}

// Step 3: Create Premium Seating Page
async function createPremiumSeatingPage() {
  console.log('📄 Creating Premium Seating Page...\n')

  const page = {
    _type: 'page',
    _id: 'page-premium-seating',
    title: 'Premium Seating',
    slug: { current: 'premium-seating' },
    language: 'en',

    hero: {
      _type: 'hero',
      heading: 'Jamco Premium Seating',
      subheading: 'Premium-density seats with direct aisle access, optimized living space, and intuitive passenger control.',
      overlayOpacity: 50,
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
        position: 'top-right'
      }
    },

    content: [
      // 1. Section Intro
      {
        _type: 'sectionIntroBlock',
        _key: 'intro1',
        heading: 'Premium Seating',
        description: 'Direct aisle access, premium density, and curated surfaces for a calm, private environment—ready to scale across your fleet.'
      },

      // 2. Feature Grid
      {
        _type: 'featureGridBlock',
        _key: 'grid1',
        columns: '3-col',
        features: [
          {
            _key: 'f1',
            heading: 'Direct aisle access for every passenger',
            description: 'Every seat provides unobstructed access to the aisle'
          },
          {
            _key: 'f2',
            heading: 'Premium density without the compromise',
            description: 'Maximize capacity while maintaining passenger comfort'
          },
          {
            _key: 'f3',
            heading: 'Optimized living space with smart storage',
            description: 'Thoughtful design keeps belongings organized and accessible'
          }
        ]
      },

      // 3. Section Intro
      {
        _type: 'sectionIntroBlock',
        _key: 'intro2',
        heading: 'Our Premium Seating features',
        description: 'Deliver the passenger experience your brand promises, without sacrificing density or service efficiency.',
        showDivider: true
      },

      // 4. Split Feature - Control & Comfort
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
        ctaButton: {
          _type: 'cta',
          text: 'Contact Us',
          linkType: 'external',
          externalUrl: '#contact',
          style: 'primary'
        }
      },

      // 5. Split Feature - Private by Design
      {
        _type: 'splitFeatureBlock',
        _key: 'split2',
        heading: 'Private by Design',
        description: 'Sliding dividers provides privacy from zero to full as needed. Shielding and geometry help reduce distractions while maintaining an open, airy feel.',
        bulletPoints: [
          'On-demand privacy divider',
          'Shielded sightlines and calm surfaces'
        ],
        imagePosition: 'left',
        ctaButton: {
          _type: 'cta',
          text: 'Contact Us',
          linkType: 'external',
          externalUrl: '#contact',
          style: 'primary'
        }
      },

      // 6. Split Feature - Work and Entertain
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
        ctaButton: {
          _type: 'cta',
          text: 'Contact Us',
          linkType: 'external',
          externalUrl: '#contact',
          style: 'primary'
        }
      },

      // 7. Split Feature - Spatial Freedom
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
        ctaButton: {
          _type: 'cta',
          text: 'Contact Us',
          linkType: 'external',
          externalUrl: '#contact',
          style: 'primary'
        }
      },

      // 8. Product Carousel
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
          { _type: 'reference', _ref: 'product-closets-stowage' },
          { _type: 'reference', _ref: 'product-lavatories' },
          { _type: 'reference', _ref: 'product-comfort-module' }
        ]
      },

      // 9. Pricing Cards
      {
        _type: 'pricingCardBlock',
        _key: 'pricing1',
        layout: '2-col',
        cards: [
          {
            _key: 'card1',
            tierName: 'Essential',
            price: 89,
            pricePrefix: '$',
            highlightCard: false
          },
          {
            _key: 'card2',
            tierName: 'Pro',
            heading: 'Performance upgrade',
            price: 159,
            pricePrefix: '$',
            highlightCard: true
          }
        ]
      }
    ],

    seo: {
      metaTitle: 'Premium Seating - Jamco America',
      metaDescription: 'Premium-density seats with direct aisle access, optimized living space, and intuitive passenger control.'
    }
  }

  await client.createOrReplace(page)
  console.log('✅ Created: Premium Seating page with full content\n')
}

// Step 4: Update Site Settings
async function updateSiteSettings() {
  console.log('⚙️  Updating Site Settings...')

  const settings = {
    _type: 'siteSettings',
    _id: 'siteSettings',
    siteName: 'Jamco America',
    contactEmail: 'info@jamco-america.com',
    contactPhone: '425-347-4735',
    footerText: 'Premium aircraft interior solutions'
  }

  await client.createOrReplace(settings)
  console.log('✅ Updated: Site Settings\n')
}

// Run all steps
async function main() {
  try {
    await createProductCategory()
    await createProducts()
    await createPremiumSeatingPage()
    await updateSiteSettings()

    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
    console.log('🎉 Content population complete!')
    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
    console.log('\nℹ️  Note: Images are not included (would need actual files)')
    console.log('   You can add images manually in Sanity Studio\n')
    console.log('👉 View in Sanity Studio: http://localhost:3333')
    console.log('👉 View page: premium-seating\n')

  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
