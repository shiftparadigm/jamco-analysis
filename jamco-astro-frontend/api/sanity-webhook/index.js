// Azure Function to receive Sanity webhook and trigger GitHub Actions
module.exports = async function (context, req) {
  const GITHUB_TOKEN = process.env.GITHUB_TOKEN

  if (!GITHUB_TOKEN) {
    context.res = {
      status: 500,
      body: { error: 'GITHUB_TOKEN not configured' }
    }
    return
  }

  try {
    // Trigger GitHub repository_dispatch
    const response = await fetch('https://api.github.com/repos/shiftparadigm/jamco-analysis/dispatches', {
      method: 'POST',
      headers: {
        'Authorization': `token ${GITHUB_TOKEN}`,
        'Accept': 'application/vnd.github.v3+json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        event_type: 'sanity-publish'
      })
    })

    if (response.status === 204) {
      context.res = {
        status: 200,
        body: { success: true, message: 'GitHub Actions triggered' }
      }
    } else {
      const errorText = await response.text()
      context.res = {
        status: response.status,
        body: { error: 'GitHub API error', details: errorText }
      }
    }
  } catch (error) {
    context.res = {
      status: 500,
      body: { error: error.message }
    }
  }
}
