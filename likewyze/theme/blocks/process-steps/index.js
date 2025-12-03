/**
 * Process Steps Block - Editor
 */

import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

registerBlockType('likewize/process-steps', {
  edit: ({ attributes, setAttributes }) => {
    const { heading, description, steps, timeline } = attributes;
    const blockProps = useBlockProps();

    return (
      <>
        <InspectorControls>
          <PanelBody title={__('Content', 'likewize')}>
            <p>{__('Edit content in the preview below', 'likewize')}</p>
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <div style={{ padding: '3rem 1.5rem', background: '#F4F4F4' }}>
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '3rem', alignItems: 'start' }}>
              {/* Left: Steps */}
              <div>
                <TextControl
                  value={heading}
                  onChange={(v) => setAttributes({ heading: v })}
                  style={{ fontSize: '1.875rem', fontWeight: 'bold', marginBottom: '1.5rem' }}
                />
                <TextareaControl
                  value={description}
                  onChange={(v) => setAttributes({ description: v })}
                  rows={2}
                  style={{ marginBottom: '2rem' }}
                />

                <div style={{ display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
                  {steps.map((step, i) => (
                    <div key={i} style={{ display: 'flex', gap: '1rem' }}>
                      <div style={{ width: '2rem', height: '2rem', borderRadius: '50%', background: step.color, color: 'white', display: 'flex', alignItems: 'center', justifyContent: 'center', fontWeight: 'bold', flexShrink: 0 }}>
                        {i + 1}
                      </div>
                      <div>
                        <div style={{ fontWeight: 'bold', marginBottom: '0.25rem' }}>{step.title}</div>
                        <div style={{ fontSize: '0.875rem', color: '#64748b' }}>{step.description}</div>
                      </div>
                    </div>
                  ))}
                </div>
              </div>

              {/* Right: Timeline */}
              <div style={{ background: 'white', padding: '2rem', borderRadius: '1rem', boxShadow: '0 20px 25px -5px rgba(0,0,0,0.1)' }}>
                <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '1.5rem' }}>
                  <strong>Claim Status</strong>
                  <span style={{ fontSize: '0.75rem', color: '#94a3b8' }}>#CLM-88291</span>
                </div>

                <div style={{ display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
                  {timeline.map((item, i) => {
                    const statusColors = {
                      completed: '#22c55e',
                      active: '#3b82f6',
                      pending: '#e2e8f0'
                    };
                    return (
                      <div key={i} style={{ display: 'flex', alignItems: 'center', opacity: item.status === 'pending' ? 0.5 : 1 }}>
                        <div style={{ width: '1.75rem', height: '1.75rem', borderRadius: '50%', background: statusColors[item.status], color: 'white', display: 'flex', alignItems: 'center', justifyContent: 'center', border: '4px solid white', flexShrink: 0 }}>
                          <i data-lucide={item.icon} style={{ width: '0.75rem', height: '0.75rem' }}></i>
                        </div>
                        <div style={{ marginLeft: '1rem' }}>
                          <div style={{ fontSize: '0.875rem', fontWeight: 'bold' }}>{item.label}</div>
                          {item.sublabel && <div style={{ fontSize: '0.75rem', color: '#94a3b8' }}>{item.sublabel}</div>}
                        </div>
                      </div>
                    );
                  })}
                </div>

                <div style={{ marginTop: '2rem', paddingTop: '1.5rem', borderTop: '1px solid #f1f5f9' }}>
                  <div style={{ padding: '0.5rem', background: '#eff6ff', color: '#2563eb', textAlign: 'center', borderRadius: '0.375rem', fontWeight: 'bold', fontSize: '0.875rem' }}>
                    Track Another Claim
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </>
    );
  },
  save: () => null,
});
