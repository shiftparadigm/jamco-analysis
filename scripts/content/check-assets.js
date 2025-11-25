import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

async function main() {
  const assets = await client.fetch(
    `*[_type == "sanity.imageAsset" && originalFilename == "maria.png"]{_id, url, originalFilename}`
  )

  console.log('Found assets:', JSON.stringify(assets, null, 2))
}

main()
