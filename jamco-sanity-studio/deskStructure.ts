import {StructureBuilder} from 'sanity/structure'

export const deskStructure = (S: StructureBuilder) =>
  S.list()
    .title('Content')
    .items([
      // Pages by language
      S.listItem()
        .title('Pages')
        .child(
          S.list()
            .title('Pages by Language')
            .items([
              S.listItem()
                .title('English Pages')
                .child(
                  S.documentList()
                    .title('English Pages')
                    .filter('_type == "page" && language == "en"')
                    .defaultOrdering([{field: 'title', direction: 'asc'}])
                ),
              S.listItem()
                .title('Japanese Pages')
                .child(
                  S.documentList()
                    .title('Japanese Pages')
                    .filter('_type == "page" && language == "ja"')
                    .defaultOrdering([{field: 'title', direction: 'asc'}])
                ),
              S.divider(),
              S.listItem()
                .title('All Pages')
                .child(
                  S.documentList()
                    .title('All Pages')
                    .filter('_type == "page"')
                    .defaultOrdering([{field: 'title', direction: 'asc'}])
                ),
            ])
        ),

      S.divider(),

      // News/Posts by language
      S.listItem()
        .title('News')
        .child(
          S.list()
            .title('News by Language')
            .items([
              S.listItem()
                .title('English News')
                .child(
                  S.documentList()
                    .title('English News')
                    .filter('_type == "post" && language == "en"')
                    .defaultOrdering([{field: 'publishedAt', direction: 'desc'}])
                ),
              S.listItem()
                .title('Japanese News')
                .child(
                  S.documentList()
                    .title('Japanese News')
                    .filter('_type == "post" && language == "ja"')
                    .defaultOrdering([{field: 'publishedAt', direction: 'desc'}])
                ),
              S.divider(),
              S.listItem()
                .title('All News')
                .child(
                  S.documentList()
                    .title('All News')
                    .filter('_type == "post"')
                    .defaultOrdering([{field: 'publishedAt', direction: 'desc'}])
                ),
            ])
        ),

      S.divider(),

      // Navigation by language
      S.listItem()
        .title('Navigation')
        .child(
          S.list()
            .title('Navigation by Language')
            .items([
              S.listItem()
                .title('English Navigation')
                .child(
                  S.documentList()
                    .title('English Navigation')
                    .filter('_type == "navigation" && language == "en"')
                ),
              S.listItem()
                .title('Japanese Navigation')
                .child(
                  S.documentList()
                    .title('Japanese Navigation')
                    .filter('_type == "navigation" && language == "ja"')
                ),
              S.divider(),
              S.listItem()
                .title('All Navigation')
                .child(
                  S.documentList()
                    .title('All Navigation')
                    .filter('_type == "navigation"')
                ),
            ])
        ),

      S.divider(),

      // Products
      S.listItem()
        .title('Products')
        .child(
          S.documentList()
            .title('Products')
            .filter('_type == "product"')
            .defaultOrdering([{field: 'name', direction: 'asc'}])
        ),

      // Product Categories
      S.listItem()
        .title('Product Categories')
        .child(
          S.documentList()
            .title('Product Categories')
            .filter('_type == "productCategory"')
            .defaultOrdering([{field: 'name', direction: 'asc'}])
        ),

      S.divider(),

      // Translations
      S.listItem()
        .title('Translations')
        .child(
          S.documentList()
            .title('UI Translations')
            .filter('_type == "translations"')
        ),

      S.divider(),

      // Site Settings (singleton)
      S.listItem()
        .title('Site Settings')
        .child(
          S.document()
            .schemaType('siteSettings')
            .documentId('siteSettings')
        ),
    ])
