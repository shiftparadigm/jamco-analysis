import { createClient } from '@sanity/client'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🔍 Auditing all documents for schema issues...\n')

async function main() {
  try {
    // Get all pages with their full content
    const pages = await client.fetch(`
      *[_type == "page" && !(_id in path('drafts.**'))]{
        _id,
        title,
        "slug": slug.current,
        content[]{
          _type,
          _key,
          ...
        }
      }
    `)

    const issues = []

    for (const page of pages) {
      console.log(`\n📄 Checking: ${page.title} (${page.slug})`)

      if (!page.content || page.content.length === 0) {
        console.log('   ✅ No content blocks')
        continue
      }

      for (const block of page.content) {
        const blockIssues = []

        // Check for common schema issues
        if (block._type === 'testimonialBlock') {
          // Check for old flat structure fields
          if (block.authorName) blockIssues.push('authorName (should be in testimonials array)')
          if (block.authorTitle) blockIssues.push('authorTitle (should be in testimonials array)')
          if (block.quote && !block.testimonials?.length) blockIssues.push('quote (should be in testimonials array)')

          // Check testimonials array structure
          if (block.testimonials) {
            for (const t of block.testimonials) {
              if (t._type === 'testimonial') blockIssues.push('testimonial item has _type "testimonial" (should be inline object)')
              if (t.author && typeof t.author === 'object') blockIssues.push('author is object (should be string)')
            }
          }
        }

        if (block._type === 'hero') {
          // Check for any unexpected fields
          const validHeroFields = ['_key', '_type', 'heading', 'subheading', 'backgroundImage', 'ctaButtons', 'layout', 'showOverlay']
          for (const key of Object.keys(block)) {
            if (!validHeroFields.includes(key) && !key.startsWith('_')) {
              blockIssues.push(`${key} (unexpected field)`)
            }
          }
        }

        if (blockIssues.length > 0) {
          console.log(`   ⚠️  ${block._type} [${block._key}]:`)
          blockIssues.forEach(issue => console.log(`      - ${issue}`))
          issues.push({
            page: page.slug,
            pageId: page._id,
            blockType: block._type,
            blockKey: block._key,
            issues: blockIssues,
            blockData: block
          })
        } else {
          console.log(`   ✅ ${block._type}`)
        }
      }
    }

    console.log('\n\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
    console.log(`📊 SUMMARY: Found ${issues.length} blocks with schema issues`)
    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n')

    if (issues.length > 0) {
      console.log('Issues by page:')
      const byPage = {}
      issues.forEach(issue => {
        if (!byPage[issue.page]) byPage[issue.page] = []
        byPage[issue.page].push(issue)
      })

      for (const [page, pageIssues] of Object.entries(byPage)) {
        console.log(`\n/${page}: ${pageIssues.length} issue(s)`)
        pageIssues.forEach(issue => {
          console.log(`  - ${issue.blockType}: ${issue.issues.join(', ')}`)
        })
      }
    }

    return issues
  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
