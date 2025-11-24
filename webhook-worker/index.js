// Cloudflare Worker to relay Sanity webhooks to GitHub Actions
export default {
  async fetch(request, env) {
    // CORS headers
    const corsHeaders = {
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Methods': 'POST, OPTIONS',
      'Access-Control-Allow-Headers': 'Content-Type',
    };

    // Handle preflight OPTIONS request
    if (request.method === 'OPTIONS') {
      return new Response(null, {
        headers: corsHeaders
      });
    }

    // Only accept POST requests
    if (request.method !== 'POST') {
      return new Response('Method not allowed', {
        status: 405,
        headers: corsHeaders
      });
    }

    try {
      // Trigger GitHub repository_dispatch
      const response = await fetch(
        'https://api.github.com/repos/shiftparadigm/jamco-analysis/dispatches',
        {
          method: 'POST',
          headers: {
            'Authorization': `token ${env.GITHUB_TOKEN}`,
            'Accept': 'application/vnd.github.v3+json',
            'Content-Type': 'application/json',
            'User-Agent': 'Sanity-Webhook-Worker'
          },
          body: JSON.stringify({
            event_type: 'sanity-publish'
          })
        }
      );

      if (response.status === 204) {
        return new Response(JSON.stringify({
          success: true,
          message: 'GitHub Actions triggered'
        }), {
          status: 200,
          headers: {
            'Content-Type': 'application/json',
            ...corsHeaders
          }
        });
      } else {
        const errorText = await response.text();
        return new Response(JSON.stringify({
          error: 'GitHub API error',
          status: response.status,
          details: errorText
        }), {
          status: response.status,
          headers: {
            'Content-Type': 'application/json',
            ...corsHeaders
          }
        });
      }
    } catch (error) {
      return new Response(JSON.stringify({
        error: error.message
      }), {
        status: 500,
        headers: {
          'Content-Type': 'application/json',
          ...corsHeaders
        }
      });
    }
  }
};
