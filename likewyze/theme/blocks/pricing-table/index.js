/**
 * Pricing Table Block - Editor
 */

import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

registerBlockType('likewize/pricing-table', {
  edit: ({ attributes, setAttributes }) => {
    const { heading, description, tiers, rows } = attributes;
    const blockProps = useBlockProps();

    return (
      <>
        <InspectorControls>
          <PanelBody title={__('Content', 'likewize')}>
            <p>{__('Edit pricing values in the table below', 'likewize')}</p>
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <div style={{ padding: '3rem 1.5rem', background: '#f8fafc' }}>
            <div style={{ textAlign: 'center', marginBottom: '3rem' }}>
              <TextControl
                value={heading}
                onChange={(v) => setAttributes({ heading: v })}
                style={{ fontSize: '1.875rem', fontWeight: 'bold', marginBottom: '0.5rem' }}
              />
              <TextareaControl
                value={description}
                onChange={(v) => setAttributes({ description: v })}
                rows={2}
              />
            </div>

            <div style={{ background: 'white', borderRadius: '1rem', overflow: 'hidden', border: '1px solid #e2e8f0' }}>
              <div style={{ display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', background: '#003D7C', color: 'white', fontWeight: 'bold', fontSize: '0.875rem' }}>
                <div style={{ padding: '1.5rem' }}>Plan Feature</div>
                {tiers.map((tier, i) => (
                  <div key={i} style={{ padding: '1.5rem', textAlign: 'center', borderLeft: '1px solid rgba(255,255,255,0.2)' }}>
                    {tier.name}<br />
                    <small style={{ fontWeight: 'normal', opacity: 0.7 }}>{tier.subtitle}</small>
                  </div>
                ))}
              </div>

              {rows.map((row, i) => (
                <div key={i} style={{ display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', borderTop: '1px solid #f1f5f9' }}>
                  <div style={{ padding: '1.5rem', fontWeight: 'bold' }}>{row.label}</div>
                  {row.fullWidth ? (
                    <div style={{ padding: '1.5rem', textAlign: 'center', gridColumn: 'span 3' }}>
                      {row.values[0]}
                    </div>
                  ) : (
                    row.values.map((val, j) => (
                      <div key={j} style={{ padding: '1.5rem', textAlign: 'center', background: row.highlight === j ? '#eff6ff' : 'transparent' }}>
                        {val}
                      </div>
                    ))
                  )}
                </div>
              ))}
            </div>
          </div>
        </div>
      </>
    );
  },
  save: () => null,
});
