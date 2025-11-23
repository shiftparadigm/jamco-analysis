// Document types
import page from './documents/page'
import post from './documents/post'
import siteSettings from './documents/siteSettings'
import navigation from './documents/navigation'
import translations from './documents/translations'
import product from './documents/product'
import productCategory from './documents/productCategory'

// Object types
import hero from './objects/hero'
import contentBlock from './objects/contentBlock'
import columnsBlock from './objects/columnsBlock'
import cta from './objects/cta'
import ctaBlock from './objects/ctaBlock'
import imageBlock from './objects/imageBlock'
import fileDownloadBlock from './objects/fileDownloadBlock'
import testimonialBlock from './objects/testimonialBlock'
import contactInfoBlock from './objects/contactInfoBlock'
import marketoFormBlock from './objects/marketoFormBlock'
import portableText from './objects/portableText'
import seo from './objects/seo'
// New design-specific blocks
import sectionIntroBlock from './objects/sectionIntroBlock'
import featureGridBlock from './objects/featureGridBlock'
import splitFeatureBlock from './objects/splitFeatureBlock'
import productCarouselBlock from './objects/productCarouselBlock'
import pricingCardBlock from './objects/pricingCardBlock'
import fullWidthImageBlock from './objects/fullWidthImageBlock'
import featureCallout from './objects/featureCallout'
import seatingDiagramBlock from './objects/seatingDiagramBlock'
import productShowcaseBlock from './objects/productShowcaseBlock'

export const schemaTypes = [
  // Documents
  page,
  post,
  siteSettings,
  navigation,
  translations,
  product,
  productCategory,

  // Objects
  hero,
  contentBlock,
  columnsBlock,
  cta,
  ctaBlock,
  imageBlock,
  fileDownloadBlock,
  testimonialBlock,
  contactInfoBlock,
  marketoFormBlock,
  portableText,
  seo,
  // New blocks
  sectionIntroBlock,
  featureGridBlock,
  splitFeatureBlock,
  productCarouselBlock,
  pricingCardBlock,
  fullWidthImageBlock,
  featureCallout,
  seatingDiagramBlock,
  productShowcaseBlock,
]
