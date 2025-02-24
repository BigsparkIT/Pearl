import { useState } from 'react';
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl, RadioControl, SelectControl } from '@wordpress/components';
import metadata from './block.json';

registerBlockType(metadata.name, {
    edit: function Edit({ attributes, setAttributes }) {
        const { productId, offerType, showOfferTypeSelector } = attributes;
        const platformName = pearlSettings.platformName; // This is injected on the server side through wp_add_inline_script().
        const widgetId = `bs-${Date.now() + Math.floor(Math.random() * 1000)}`;
        setAttributes({ productId: 19299 });

        const [ category, setCategory ] = useState('Smartphones');
    
        // const iframeUrl = 'https://starfish.staging.bigspark.it/in-article-widget' +
        const iframeUrl = 'http://localhost:3000/in-article-widget' +
            '?productId=' + encodeURIComponent(productId || '') +
            '&platformName=' + encodeURIComponent(platformName) +
            '&offerType=' + encodeURIComponent(offerType) +
            '&showOfferTypeSelector=' + encodeURIComponent(showOfferTypeSelector) +
            '&widgetId=' + encodeURIComponent(widgetId);
    
        return (
            <>
                <InspectorControls>
                    <PanelBody title={ __('Settings', 'pearl') }>
                        <SelectControl
                            __nextHasNoMarginBottom
                            __next40pxDefaultSize
                            label={ __('Categorie', 'pearl') }
                            value={ category }
                            options={ [
                                { label: 'Smartphones', value: 'Smartphones' },
                                { label: 'Smartwatches', value: 'Smartwatches' },
                                { label: 'PCs', value: 'PCs' },
                                { label: 'Laptops', value: 'Laptops' },
                                { label: 'Mediaspelers', value: 'Mediaspelers' },
                                { label: 'Mp3', value: 'Mp3' },
                                { label: 'Oordopjes', value: 'Oordopjes' },
                                { label: 'Tablets', value: 'Tablets' },
                            ] }
                            onChange={ function(value) {
                                setCategory(value);
                                if (value !== 'Smartphones') {
                                    setAttributes({ offerType: 'product' })
                                }
                            } }
                        />
                        { category === 'Smartphones' && (
                            <>
                                <RadioControl
                                    __nextHasNoMarginBottom
                                    __next40pxDefaultSize
                                    label={ __('Offer type', 'pearl') }
                                    selected={ offerType }
                                    options={ [
                                        { label: 'Product', value: 'product' },
                                        { label: 'Package', value: 'package' },
                                    ] }
                                    onChange={ (value) => setAttributes({ offerType: value }) }
                                />
                                <ToggleControl
                                    __nextHasNoMarginBottom
                                    __next40pxDefaultSize
                                    checked={ !!showOfferTypeSelector }
                                    label={ __('Maak het mogelijk om te switchen van offer type?', 'pearl') }
                                    onChange={ () => setAttributes({ showOfferTypeSelector: !showOfferTypeSelector })
                                    }
                                />
                            </>
                        ) }
                        <TextControl
                            __nextHasNoMarginBottom
                            __next40pxDefaultSize
                            label={ __('Product ID', 'pearl') }
                            value={ productId || '' }
                            placeholder={ __('Voer product ID in...', 'pearl') }
                            onChange={ (value) => setAttributes({ productId: value }) }
                        />
                    </PanelBody>
                </InspectorControls>
    
                { !productId && (
                    <p { ...useBlockProps() }>{ __('Fill in a product ID to see a preview', 'pearl') }</p>
                ) }
                { productId && (
                    <div { ...useBlockProps() }>
                        <p>{ __('Preview:', 'pearl') + iframeUrl }</p>
                        <iframe 
                            src={ iframeUrl }
                            width="100%"
                            height="1200"
                        />
                    </div>
                ) }
            </>
        );
    },
} );