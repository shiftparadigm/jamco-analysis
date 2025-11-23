import { createClient } from '@sanity/client'
import imageUrlBuilder from '@sanity/image-url'

export const sanityClient = createClient({
  projectId: 'c94x8u55',
  dataset: 'production',
  useCdn: true,
  apiVersion: '2024-01-01'
})

const builder = imageUrlBuilder(sanityClient)

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
          "image": images[0]
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
