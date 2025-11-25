import { createClient } from '@sanity/client'
import { writeFileSync } from 'fs'

const client = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  token: process.env.SANITY_TOKEN || '',
  useCdn: false,
  apiVersion: '2024-01-01'
})

console.log('🔍 Fetching all documents...\n')

async function main() {
  try {
    // Get all document types
    const types = await client.fetch(`array::unique(*[]._type)`)
    console.log(`Found ${types.length} document types:`, types.join(', '))

    // Get sample of each type
    const allDocs = await client.fetch(`
      *[!(_id in path('drafts.**'))]{
        _id,
        _type,
        _updatedAt,
        ...
      }
    `)

    console.log(`\nFetched ${allDocs.length} documents total\n`)

    // Group by type and show samples
    const byType = {}
    allDocs.forEach(doc => {
      if (!byType[doc._type]) byType[doc._type] = []
      byType[doc._type].push(doc)
    })

    // Look for common schema issues across all docs
    const issues = []

    for (const [type, docs] of Object.entries(byType)) {
      console.log(`\n📦 ${type} (${docs.length} documents)`)

      if (type === 'page') {
        for (const doc of docs) {
          const pageIssues = []

          if (doc.content) {
            for (const block of doc.content) {
              // Check for testimonialBlock issues
              if (block._type === 'testimonialBlock') {
                if (block.authorName || block.authorTitle || (block.quote && !block.testimonials?.length)) {
                  pageIssues.push({
                    blockType: 'testimonialBlock',
                    blockKey: block._key,
                    issues: [
                      block.authorName && 'authorName',
                      block.authorTitle && 'authorTitle',
                      (block.quote && !block.testimonials?.length) && 'quote (not in array)'
                    ].filter(Boolean)
                  })
                }

                if (block.testimonials) {
                  block.testimonials.forEach((t, idx) => {
                    if (t._type === 'testimonial') {
                      pageIssues.push({
                        blockType: 'testimonialBlock',
                        blockKey: block._key,
                        issues: [`testimonial[${idx}] has _type "testimonial" (should be inline object)`]
                      })
                    }
                    if (t.author && typeof t.author === 'object') {
                      pageIssues.push({
                        blockType: 'testimonialBlock',
                        blockKey: block._key,
                        issues: [`testimonial[${idx}].author is object (should be string)`]
                      })
                    }
                  })
                }
              }

              // Check for other block types with common issues
              // Look for fields that don't start with _ and aren't in common lists
            }
          }

          if (pageIssues.length > 0) {
            console.log(`   ⚠️  ${doc.title || doc._id}:`)
            pageIssues.forEach(issue => {
              console.log(`      - ${issue.blockType} [${issue.blockKey}]: ${issue.issues.join(', ')}`)
            })
            issues.push({
              docId: doc._id,
              docType: type,
              title: doc.title,
              slug: doc.slug?.current,
              issues: pageIssues
            })
          } else {
            console.log(`   ✅ ${doc.title || doc._id}`)
          }
        }
      } else {
        // Just list other document types
        docs.slice(0, 3).forEach(doc => {
          console.log(`   - ${doc._id}`)
        })
        if (docs.length > 3) console.log(`   ... and ${docs.length - 3} more`)
      }
    }

    console.log('\n\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━')
    console.log(`📊 SUMMARY: Found ${issues.length} documents with schema issues`)
    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n')

    if (issues.length > 0) {
      console.log('Documents with issues:')
      issues.forEach(issue => {
        console.log(`\n${issue.docType}: ${issue.title || issue.docId} ${issue.slug ? `(/${issue.slug})` : ''}`)
        issue.issues.forEach(blockIssue => {
          console.log(`  - ${blockIssue.blockType}: ${blockIssue.issues.join(', ')}`)
        })
      })

      // Save detailed report
      writeFileSync(
        'schema-issues-report.json',
        JSON.stringify(issues, null, 2)
      )
      console.log('\n💾 Detailed report saved to: schema-issues-report.json')
    }

  } catch (error) {
    console.error('❌ Error:', error)
    process.exit(1)
  }
}

main()
