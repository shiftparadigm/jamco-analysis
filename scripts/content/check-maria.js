import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

async function main() {
  // Check both draft and published
  const pages = await client.fetch(
    `*[_type == "page" && slug.current == "premium-seating"]{
      _id,
      content[_type == "testimonialBlock"]{
        _key,
        testimonials
      }
    }`
  )

  console.log(JSON.stringify(pages, null, 2))
}

main()
