# Website Component Analysis Prompt

Use this prompt to analyze any website and generate a comprehensive component inventory for rebuilding in a new CMS.

---

## Prompt

```
Analyze the website at [URL] to identify all components needed to rebuild it in a new CMS (e.g., Drupal, Optimizely, or similar).

## Methodology

1. **Discover all pages:**
   - Fetch sitemap.xml and all child sitemaps
   - Extract navigation menu structure including all subnav items
   - Probe common URL patterns to find unlisted pages

2. **Crawl representative pages from each section:**
   - Homepage, product pages, blog posts, landing pages, archives
   - Analyze HTML/CSS for block patterns (look for wp-block-*, custom prefixes, ACF blocks)

3. **For each block/component identified, capture:**
   - Block name/class
   - Description of purpose
   - Estimated occurrences (Low/Medium/High)
   - Complexity rating (Low/Medium/High/Very High)
   - Properties (wrapper classes, child elements, data attributes, CSS dependencies)
   - Rebuild considerations for target CMS platforms

## Output Structure (JSON)

Organize findings into these categories:

### 1. Blocks (CMS content blocks)
- Custom blocks (site-specific namespace)
- Core CMS blocks (WordPress core, etc.)
- E-commerce blocks (WooCommerce, etc.)

### 2. Custom Applications
Standalone tools that are NOT CMS blocks - require separate development:
- Calculators, configurators, 3D tools
- Locators/finders
- Interactive product selectors
- Custom e-commerce flows

### 3. Theme Components
Global templates and page-level components:
- Header (navigation, mobile menu, search trigger)
- Footer (links, social, legal)
- 404 page
- Search dialog/modal
- Search results page
- Generic embed handler

### 4. Third-party Integrations
- Form builders
- Analytics
- Chat widgets
- Other SaaS integrations

## Summary Requirements

Provide a rebuild_summary with:
- Total component count
- Breakdown by category
- Priority order for implementation
- Effort estimates per category

For each component, include rebuild_considerations noting how it might map to:
- Drupal (Paragraphs, Layout Builder, Views, etc.)
- Optimizely (Visual Builder components)
- Generic approach

## Key Distinctions

Clearly separate:
- **Blocks** = Content components editors use to build pages
- **Custom apps** = Standalone functionality requiring custom development
- **Theme components** = Global page templates and structural elements

The goal is a comprehensive inventory that a development team could use to scope and plan a site rebuild.
```

---

## Example Output Structure

```json
{
  "metadata": {
    "site": "https://example.com",
    "analysis_date": "YYYY-MM-DD",
    "total_pages_discovered": 0,
    "pages_analyzed": 0,
    "cms_platform": "WordPress",
    "theme": "Theme Name",
    "custom_block_namespace": "prefix"
  },
  "blocks": {
    "custom_blocks": {},
    "core_blocks": {},
    "ecommerce_blocks": {}
  },
  "custom_applications": {
    "description": "Standalone tools requiring separate development",
    "tools": {}
  },
  "theme_components": {
    "description": "Global templates and page-level components",
    "components": {}
  },
  "third_party_integrations": {},
  "rebuild_summary": {
    "total_components": 0,
    "breakdown": {},
    "estimated_effort": {}
  }
}
```

---

## Usage Notes

1. Start with sitemap discovery to understand site scope
2. Crawl diverse page types to capture all block patterns
3. Distinguish between blocks (CMS components) and custom apps (standalone tools)
4. Include theme-level components that aren't content blocks
5. Prioritize by frequency and complexity for rebuild planning
