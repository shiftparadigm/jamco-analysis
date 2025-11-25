import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

async function main() {
  // Check all versions including drafts
  const allVersions = await client.fetch(
    `*[_id in ["page-premium-seating", "drafts.page-premium-seating"]]{
      _id,
      _updatedAt,
      content[_type == "testimonialBlock"][0]{
        _key,
        testimonials
      }
    }`
  )

  console.log(JSON.stringify(allVersions, null, 2))
}

main()
