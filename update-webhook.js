const SANITY_TOKEN = 'sk4k43Hp3BRKL4cwsWtMrqK52lKaJZgC1jwnredxnqm2PBEEPxPhFDhjgNLEa0PCzGxNnP0dNQKMXIb2gwtEwoYSvu8ygOauUdDsPBUE7oKKYEyCiii0Eum4EoOnWq1j9GcTdResRCGXD69TyOg505ICVWGiZrViiq6lGY4BwpjY0S9J71kf'

async function updateWebhook() {
  const response = await fetch('https://api.sanity.io/v2021-06-07/hooks/projects/c94x8u55/NKrcawC84Lp0Blrz', {
    method: 'PATCH',
    headers: {
      'Authorization': `Bearer ${SANITY_TOKEN}`,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      url: 'https://jamco-webhook-relay.tony-mishler.workers.dev'
    })
  })

  const result = await response.json()
  console.log('Updated webhook:', JSON.stringify(result, null, 2))
}

updateWebhook()
