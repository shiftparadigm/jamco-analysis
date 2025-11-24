import type { APIRoute } from 'astro'

export const prerender = false

export const GET: APIRoute = async ({ cookies, redirect, request }) => {
  // Clear draft mode cookie
  cookies.delete('__sanity_draft', {
    path: '/',
  })

  // Redirect to the page they came from, or home
  const referer = request.headers.get('referer')
  const redirectTo = referer ? new URL(referer).pathname : '/'

  return redirect(redirectTo, 307)
}
