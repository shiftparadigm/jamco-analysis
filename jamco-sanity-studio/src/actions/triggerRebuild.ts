import {useDocumentOperation} from 'sanity'
import {useEffect, useState} from 'react'
import {DocumentActionComponent} from 'sanity'

async function triggerGitHubRebuild() {
  try {
    const response = await fetch('https://jamco-webhook-relay.tony-mishler.workers.dev', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({source: 'sanity-publish-action'})
    })
    return response.ok
  } catch (error) {
    console.error('Failed to trigger rebuild:', error)
    return false
  }
}

export const triggerRebuildAction: DocumentActionComponent = (props) => {
  const {publish} = useDocumentOperation(props.id, props.type)
  const [isPublishing, setIsPublishing] = useState(false)

  useEffect(() => {
    // Reset publishing state when operation completes
    if (isPublishing && !publish.disabled) {
      setIsPublishing(false)
    }
  }, [publish.disabled, isPublishing])

  return {
    disabled: publish.disabled,
    label: isPublishing ? 'Publishing & triggering rebuild...' : 'Publish',
    onHandle: async () => {
      setIsPublishing(true)

      // Execute the default publish action
      publish.execute()

      // Trigger rebuild in the background
      triggerGitHubRebuild().then((success) => {
        if (success) {
          console.log('✓ Rebuild triggered successfully')
        } else {
          console.warn('✗ Failed to trigger rebuild')
        }
      })

      props.onComplete()
    },
  }
}
