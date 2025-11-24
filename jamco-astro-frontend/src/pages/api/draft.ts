import type { APIRoute } from 'astro'
import { validatePreviewUrl } from '@sanity/preview-url-secret'
import { client } from '../../lib/sanity'

export const prerender = false

export const GET: APIRoute = async ({ request, cookies, redirect }) => {
  const { isValid, redirectTo = '/' } = await validatePreviewUrl(
    client.withConfig({ token: import.meta.env.SANITY_API_READ_TOKEN }),
    request.url
  )

  if (!isValid) {
    return new Response('Invalid secret', { status: 401 })
  }

  // Set draft mode cookie
  cookies.set('__sanity_draft', 'true', {
    httpOnly: true,
    sameSite: 'none',
    secure: true,
    path: '/',
    maxAge: 60 * 60 // 1 hour
  })

  return redirect(redirectTo, 307)
}
