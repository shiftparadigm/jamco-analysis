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
                    .apiVersion('2024-01-01')
                    .defaultOrdering([{field: 'title', direction: 'asc'}])
                ),
              S.listItem()
                .title('Japanese Pages')
                .child(
                  S.documentList()
                    .title('Japanese Pages')
                    .filter('_type == "page" && language == "ja"')
                    .apiVersion('2024-01-01')
                    .defaultOrdering([{field: 'title', direction: 'asc'}])
                ),
              S.divider(),
              S.listItem()
                .title('All Pages')
                .child(
                  S.documentList()
                    .title('All Pages')
                    .filter('_type == "page"')
                    .apiVersion('2024-01-01')
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
                    .apiVersion('2024-01-01')
                    .defaultOrdering([{field: 'publishedAt', direction: 'desc'}])
                ),
              S.listItem()
                .title('Japanese News')
                .child(
                  S.documentList()
                    .title('Japanese News')
                    .filter('_type == "post" && language == "ja"')
                    .apiVersion('2024-01-01')
                    .defaultOrdering([{field: 'publishedAt', direction: 'desc'}])
                ),
              S.divider(),
              S.listItem()
                .title('All News')
                .child(
                  S.documentList()
                    .title('All News')
                    .filter('_type == "post"')
                    .apiVersion('2024-01-01')
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
                    .apiVersion('2024-01-01')
                ),
              S.listItem()
                .title('Japanese Navigation')
                .child(
                  S.documentList()
                    .title('Japanese Navigation')
                    .filter('_type == "navigation" && language == "ja"')
                    .apiVersion('2024-01-01')
                ),
              S.divider(),
              S.listItem()
                .title('All Navigation')
                .child(
                  S.documentList()
                    .title('All Navigation')
                    .filter('_type == "navigation"')
                    .apiVersion('2024-01-01')
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
            .apiVersion('2024-01-01')
            .defaultOrdering([{field: 'name', direction: 'asc'}])
        ),

      // Product Categories
      S.listItem()
        .title('Product Categories')
        .child(
          S.documentList()
            .title('Product Categories')
            .filter('_type == "productCategory"')
            .apiVersion('2024-01-01')
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
            .apiVersion('2024-01-01')
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
