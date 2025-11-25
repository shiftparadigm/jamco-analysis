import { createClient } from '@sanity/client'
import { promises as fs } from 'fs'
import path from 'path'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN,
  useCdn: false,
  apiVersion: '2024-01-01'
})

async function uploadImage(filePath, filename) {
  const imageBuffer = await fs.readFile(filePath)
  const asset = await client.assets.upload('image', imageBuffer, {
    filename
  })
  console.log(`Uploaded ${filename}: ${asset._id}`)
  return asset
}

async function fixPage() {
  console.log('Starting fixes...')

  // 1. Upload the seating diagram image
  console.log('\n1. Uploading seating diagram image...')
  const seatViewPath = path.join(process.cwd(), 'exported-images', 'seat-view.jpg')
  const diagramAsset = await uploadImage(seatViewPath, 'seat-view.jpg')

  // 2. Get current page content
  console.log('\n2. Getting current page content...')
  const page = await client.fetch('*[_id == "page-premium-seating"][0]')

  if (!page) {
    console.error('Page not found!')
    return
  }

  console.log('Current content blocks:', page.content?.map(b => b._type))

  // 3. Create the seating diagram block
  const seatingDiagramBlock = {
    _type: 'seatingDiagramBlock',
    _key: 'seating-diagram-001',
    diagramImage: {
      _type: 'image',
      asset: {
        _type: 'reference',
        _ref: diagramAsset._id
      },
      alt: 'Aircraft cabin seating layout diagram'
    },
    brandLogos: [
      {
        _key: 'venture-logo',
        name: 'Venture'
      },
      {
        _key: 'quest-logo',
        name: 'Quest for Elegance',
        tagline: 'Produced by Jamco'
      }
    ],
    backgroundColor: 'white'
  }

  // 4. Update split feature buttons to use 'secondary' style
  console.log('\n3. Updating split feature button styles...')
  const updatedContent = page.content.map(block => {
    if (block._type === 'splitFeatureBlock' && block.ctaButton) {
      return {
        ...block,
        ctaButton: {
          ...block.ctaButton,
          style: 'secondary'
        }
      }
    }
    return block
  })

  // 5. Find the right position for seating diagram (after productShowcaseBlock)
  const showcaseIndex = updatedContent.findIndex(b => b._type === 'productShowcaseBlock')

  // Check if seating diagram already exists
  const hasSeatingDiagram = updatedContent.some(b => b._type === 'seatingDiagramBlock')

  let finalContent = [...updatedContent]

  // Insert seating diagram after showcase block
  if (!hasSeatingDiagram) {
    if (showcaseIndex !== -1) {
      finalContent.splice(showcaseIndex + 1, 0, seatingDiagramBlock)
      console.log('Inserted seating diagram after productShowcaseBlock')
    } else {
      // Put it at position 1 if no showcase block
      finalContent.splice(1, 0, seatingDiagramBlock)
      console.log('Inserted seating diagram at position 1')
    }
  }

  // 6. Update the product carousel title to "Complete your travel ecosystem"
  console.log('\n4. Updating product carousel title...')
  finalContent = finalContent.map(block => {
    if (block._type === 'productCarouselBlock') {
      return {
        ...block,
        title: 'Complete your travel ecosystem',
        subtitle: 'Elevate every aspect of your journey.'
      }
    }
    return block
  })

  // 7. Save the updated content
  console.log('\n5. Saving updated content...')
  await client
    .patch('page-premium-seating')
    .set({ content: finalContent })
    .commit()

  console.log('\nAll fixes applied successfully!')
  console.log('Final content blocks:', finalContent.map(b => b._type))
}

fixPage().catch(console.error)
