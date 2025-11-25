import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

async function main() {
  // Get the raw document with ALL fields
  const doc = await client.getDocument('page-premium-seating')

  // Find the testimonial block
  const testimonialBlock = doc.content.find(block => block._type === 'testimonialBlock')

  console.log('Raw testimonial block:')
  console.log(JSON.stringify(testimonialBlock, null, 2))
}

main()
