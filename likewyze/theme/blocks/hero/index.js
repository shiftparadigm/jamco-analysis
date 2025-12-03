/**
 * Hero Block - Editor
 *
 * @package Likewize
 */

import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, ToggleControl, ColorPicker } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

registerBlockType('likewize/hero', {
  edit: ({ attributes, setAttributes }) => {
    const {
      badgeText,
      showBadge,
      heading,
      headingHighlight,
      description,
      primaryCTA,
      secondaryCTA,
      showCard,
      cardData,
      backgroundColor,
    } = attributes;

    const blockProps = useBlockProps({
      className: 'likewize-hero-editor',
      style: { backgroundColor, padding: '4rem 2rem', color: 'white' },
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__('Badge Settings', 'likewize')}>
            <ToggleControl
              label={__('Show Badge', 'likewize')}
              checked={showBadge}
              onChange={(value) => setAttributes({ showBadge: value })}
            />
            {showBadge && (
              <TextControl
                label={__('Badge Text', 'likewize')}
                value={badgeText}
                onChange={(value) => setAttributes({ badgeText: value })}
              />
            )}
          </PanelBody>

          <PanelBody title={__('Call to Action Buttons', 'likewize')}>
            <h4>{__('Primary CTA', 'likewize')}</h4>
            <TextControl
              label={__('Button Text', 'likewize')}
              value={primaryCTA.text}
              onChange={(value) => setAttributes({ primaryCTA: { ...primaryCTA, text: value } })}
            />
            <TextControl
              label={__('Button URL', 'likewize')}
              value={primaryCTA.url}
              onChange={(value) => setAttributes({ primaryCTA: { ...primaryCTA, url: value } })}
            />

            <hr style={{ margin: '20px 0' }} />

            <h4>{__('Secondary CTA', 'likewize')}</h4>
            <TextControl
              label={__('Button Text', 'likewize')}
              value={secondaryCTA.text}
              onChange={(value) => setAttributes({ secondaryCTA: { ...secondaryCTA, text: value } })}
            />
            <TextControl
              label={__('Button URL', 'likewize')}
              value={secondaryCTA.url}
              onChange={(value) => setAttributes({ secondaryCTA: { ...secondaryCTA, url: value } })}
            />
          </PanelBody>

          <PanelBody title={__('Coverage Card', 'likewize')}>
            <ToggleControl
              label={__('Show Card', 'likewize')}
              checked={showCard}
              onChange={(value) => setAttributes({ showCard: value })}
            />
            {showCard && (
              <>
                <TextControl
                  label={__('Status', 'likewize')}
                  value={cardData.status}
                  onChange={(value) => setAttributes({ cardData: { ...cardData, status: value } })}
                />
                <TextControl
                  label={__('Device Name', 'likewize')}
                  value={cardData.deviceName}
                  onChange={(value) => setAttributes({ cardData: { ...cardData, deviceName: value } })}
                />
                <TextControl
                  label={__('Plan Name', 'likewize')}
                  value={cardData.planName}
                  onChange={(value) => setAttributes({ cardData: { ...cardData, planName: value } })}
                />
                <TextControl
                  label={__('Billing Amount', 'likewize')}
                  value={cardData.billingAmount}
                  onChange={(value) => setAttributes({ cardData: { ...cardData, billingAmount: value } })}
                />
                <TextControl
                  label={__('Button Text', 'likewize')}
                  value={cardData.buttonText}
                  onChange={(value) => setAttributes({ cardData: { ...cardData, buttonText: value } })}
                />
              </>
            )}
          </PanelBody>

          <PanelBody title={__('Background Color', 'likewize')}>
            <ColorPicker
              color={backgroundColor}
              onChangeComplete={(value) => setAttributes({ backgroundColor: value.hex })}
            />
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <div style={{ maxWidth: '1200px', margin: '0 auto', display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '3rem', alignItems: 'center' }}>
            <div>
              {showBadge && (
                <div style={{ display: 'inline-flex', alignItems: 'center', background: 'rgba(30,58,138,0.5)', border: '1px solid rgba(59,130,246,0.3)', borderRadius: '9999px', padding: '0.375rem 1rem', fontSize: '0.75rem', marginBottom: '1rem' }}>
                  <span style={{ width: '0.5rem', height: '0.5rem', background: '#4ade80', borderRadius: '50%', marginRight: '0.5rem' }}></span>
                  {badgeText}
                </div>
              )}

              <TextControl
                value={heading}
                onChange={(value) => setAttributes({ heading: value })}
                placeholder={__('Main heading...', 'likewize')}
                style={{ fontSize: '3rem', fontWeight: 'bold', marginBottom: '0.5rem', color: 'white' }}
              />

              <TextControl
                value={headingHighlight}
                onChange={(value) => setAttributes({ headingHighlight: value })}
                placeholder={__('Highlighted text...', 'likewize')}
                style={{ fontSize: '3rem', fontWeight: 'bold', color: '#93c5fd', marginBottom: '1.5rem' }}
              />

              <TextareaControl
                value={description}
                onChange={(value) => setAttributes({ description: value })}
                placeholder={__('Description...', 'likewize')}
                rows={3}
                style={{ fontSize: '1.125rem', color: '#bfdbfe', marginBottom: '1.5rem' }}
              />

              <div style={{ display: 'flex', gap: '1rem', flexWrap: 'wrap' }}>
                {primaryCTA.text && (
                  <div style={{ background: 'white', color: '#003D7C', padding: '0.75rem 2rem', borderRadius: '9999px', fontWeight: 'bold' }}>
                    {primaryCTA.text}
                  </div>
                )}
                {secondaryCTA.text && (
                  <div style={{ border: '2px solid #60a5fa', color: '#bfdbfe', padding: '0.75rem 2rem', borderRadius: '9999px', fontWeight: 'bold' }}>
                    {secondaryCTA.text}
                  </div>
                )}
              </div>
            </div>

            {showCard && (
              <div style={{ background: 'white', color: '#334155', borderRadius: '1rem', padding: '1.5rem', boxShadow: '0 25px 50px -12px rgba(0,0,0,0.25)', borderTop: '4px solid #E63026' }}>
                <div style={{ borderBottom: '1px solid #f1f5f9', paddingBottom: '1rem', marginBottom: '1rem' }}>
                  <strong>Coverage Status</strong>
                  <span style={{ float: 'right', color: '#16a34a', background: '#f0fdf4', padding: '0.25rem 0.75rem', borderRadius: '9999px', fontSize: '0.875rem' }}>
                    {cardData.status}
                  </span>
                </div>
                <div style={{ marginBottom: '1rem' }}>
                  <div style={{ fontWeight: 'bold' }}>{cardData.deviceName}</div>
                  <div style={{ fontSize: '0.75rem', color: '#64748b' }}>{cardData.planName}</div>
                </div>
                <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '1rem', fontSize: '0.875rem' }}>
                  <span style={{ color: '#64748b' }}>Next Bill</span>
                  <strong>{cardData.billingAmount}</strong>
                </div>
                <div style={{ background: '#003D7C', color: 'white', padding: '0.75rem', borderRadius: '0.5rem', textAlign: 'center', fontWeight: 'bold', fontSize: '0.875rem' }}>
                  {cardData.buttonText}
                </div>
              </div>
            )}
          </div>
        </div>
      </>
    );
  },

  save: () => null, // Dynamic block
});
