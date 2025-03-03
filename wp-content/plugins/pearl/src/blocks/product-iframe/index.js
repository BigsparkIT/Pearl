import { useState, useEffect } from 'react';
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl, RadioControl, SelectControl, Button } from '@wordpress/components';
import metadata from './block.json';

// Generated outside the edit function to avoid infinite change triggered looping.
const generatedId = `bs-${Date.now() + Math.floor(Math.random() * 1000)}`;

async function retrieveProducts(category, search) {
    const apiUrl = 'https://orca.production.bigspark.it/api/graphql-hub';
    const query = `{productSearch(query:"${search}",category:"${category}",limit:10){id,brand,name}}`;

    const { data } = await fetch(apiUrl + '?query=' + query).then(result => result.json());

    return data.productSearch;
}

function buildIframeUrl(productId, offerType, showOfferTypeSelector, widgetId) {
    const platformName = pearlSettings.platformName; // This is injected on the server side through wp_add_inline_script().

    const iframeUrl = 'https://starfish.production.bigspark.it/in-article-widget' +
        '?productId=' + encodeURIComponent(productId || '') +
        '&platformName=' + encodeURIComponent(platformName) +
        '&offerType=' + encodeURIComponent(offerType) +
        '&showOfferTypeSelector=' + encodeURIComponent(showOfferTypeSelector) +
        '&widgetId=' + encodeURIComponent(widgetId);

    return iframeUrl;
}

registerBlockType(metadata.name, {
    edit: function Edit({ attributes, setAttributes }) {
        const { productId, offerType, showOfferTypeSelector, widgetId } = attributes;
        setAttributes({ widgetId: generatedId });

        const [category, setCategory] = useState('Smartphones');
        const [search, setSearch] = useState('');
        const [loading, setLoading] = useState(false);
        const [isOpen, setIsOpen] = useState(false);
        const [products, setProducts] = useState([]);
        const [selectedProduct, setSelectedProduct] = useState(undefined);

        useEffect(() => {
            (async () => {
                if (! search) {
                    return;
                }
                setLoading(true);
                const data = await retrieveProducts(category, search);
                setProducts(data);
                setIsOpen(true);
                setLoading(false);
            })();
        }, [search, category]);

        useEffect(() => {
            if (selectedProduct) {
                setAttributes({ productId: selectedProduct.id });
            }
        }, [selectedProduct]);

        const iframeUrl = buildIframeUrl(productId, offerType, showOfferTypeSelector, widgetId);
    
        return (
            <>
                <InspectorControls>
                    <PanelBody title={ __('Settings', 'pearl') }>
                        { selectedProduct && (
                            <>
                                <p>{ __('Geselecteerd product:', 'pearl') }</p>
                                <p style={ { fontWeight: 'bold', fontSize: 'large' } }>{ selectedProduct.brand } { selectedProduct.name }</p>
                            </>
                        ) }
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
                                setProducts([]);
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
                            label={ __('Zoek naar product', 'pearl') }
                            value={ search }
                            onChange={ (value) => setSearch(value) }
                        />
                        { isOpen && (
                            <ul>
                                { loading && (<li>Producten laden</li>) }
                                { !loading && (
                                    products.map((product) =>
                                        <li key={ product.id }>
                                            <Button
                                                __next40pxDefaultSize
                                                variant='secondary'
                                                style={ { width: '100%', textAlign: 'left' } }
                                                onClick={ () => {
                                                    setSelectedProduct(product);
                                                    setIsOpen(false);
                                                } }
                                            >{ product.brand } { product.name }</Button>
                                        </li>
                                    )
                                ) }
                            </ul>
                        ) }
                    </PanelBody>
                </InspectorControls>
    
                { !productId && (
                    <p { ...useBlockProps() }>{ __('Zoek en selecteer een product om een preview te zien', 'pearl') }</p>
                ) }
                { productId && (
                    <div { ...useBlockProps() }>
                        <p>{ __('Preview:', 'pearl') }</p>
                        <script src='https://wl.bigspark.link/assets/resize-iframe.js'></script>
                        <iframe
                            id={ widgetId }
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="bs-widget"
                            style={ { border: "none" } }
                            src={ iframeUrl }
                            width="100%"
                            height="750"
                        />
                    </div>
                ) }
            </>
        );
    },

    // The save function stores the HTML in the database as backup. The primary way the content is shown is through render.php.
    save: function Edit({ attributes }) {
        const { productId, offerType, showOfferTypeSelector, widgetId } = attributes;

        const iframeUrl = buildIframeUrl(productId, offerType, showOfferTypeSelector, widgetId);

        return (
            <div { ...useBlockProps.save() }>
                <script src='https://wl.bigspark.link/assets/resize-iframe.js'></script>
                <iframe
                    id={ widgetId }
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="bs-widget"
                    style={ { border: "none" } }
                    src={ iframeUrl }
                    width="100%"
                    height="750"
                />
            </div>
        );
    },
} );