import { createClient } from '@sanity/client'
import imageUrlBuilder from '@sanity/image-url'

const projectId = 'c94x8u55'
const dataset = 'production'
const apiVersion = '2024-01-01'

export const client = createClient({
  projectId,
  dataset,
  useCdn: true, // Enable CDN for static builds
  apiVersion,
})

// Aliased export for backwards compatibility
export const sanityClient = client

const builder = imageUrlBuilder(client)

export function urlFor(source: any) {
  return builder.image(source)
}

export const queries = {
  pageBySlug: `*[_type == "page" && slug.current == $slug && language == $language][0]{
    title,
    "slug": slug.current,
    language,
    seo,
    hero,
    content[]{
      ...,
      _type == "productCarouselBlock" => {
        ...,
        products[]-> {
          _id,
          name,
          "slug": slug.current,
          shortDescription,
          images
        }
      }
    }
  }`,

  allPages: `*[_type == "page"]{ "slug": slug.current, language }`,

  product: `*[_type == "product" && slug.current == $slug][0]{
    _id,
    name,
    "slug": slug.current,
    shortDescription,
    description,
    images,
    price,
    tierLabel,
    features,
    relatedProducts[]-> {
      _id,
      name,
      "slug": slug.current,
      shortDescription,
      "image": images[0]
    }
  }`,

  allProducts: `*[_type == "product"] | order(name asc) {
    _id,
    name,
    "slug": slug.current,
    shortDescription,
    "image": images[0],
    tierLabel,
    category-> { name, "slug": slug.current }
  }`,

  allProductSlugs: `*[_type == "product"]{ "slug": slug.current }`,
}
