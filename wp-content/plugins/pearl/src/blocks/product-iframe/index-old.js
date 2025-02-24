setTimeout(() => {
    (function(blocks, element, blockEditor, components) {
        console.log('Product Iframe block loaded');
        var el = element.createElement;
        var TextControl = components.TextControl;
        var useBlockProps = blockEditor.useBlockProps;
        var InspectorControls = blockEditor.InspectorControls;
        var pearlSettings = {platformIdentifier: 'kaas'};
    
        blocks.registerBlockType('pearl/product-iframe', {
            // Definieer de attributen (hier hebben we een productId als string).
            attributes: {
                productId: {
                    type: 'string'
                },
            },
    
            edit: function(props) {
                var productId = props.attributes.productId;
                var blockProps = useBlockProps();
    
                // Handler om de waarde van productId bij te werken.
                function onChangeProductId(newValue) {
                    props.setAttributes({ productId: newValue });
                }
                const iframeUrl = 'http://localhost:3000/in-article-widget' +
                    '?productId=' + encodeURIComponent(productId || '') +
                    '&platformName=' + encodeURIComponent(pearlSettings.platformIdentifier);
    
    
                return el('div', blockProps,
                    // Tekstveld voor invoer van productId.
                    el(InspectorControls, null,
                        el(TextControl, {
                            label: 'Product ID',
                            value: productId,
                            onChange: onChangeProductId,
                            placeholder: 'Voer product ID in...'
                        })
                    ),
                    // Toon een preview als er een productId is ingevuld.
                    productId && el('div', { style: { marginTop: '1em' } },
                        el('p', null, 'Preview:'),
                        el('iframe', {
                            src: iframeUrl,
                            width: '100%',
                            height: '200',
                            frameBorder: '0'
                        })
                    )
                );
            },
    
            save: function(props) {
                var productId = props.attributes.productId;
                const iframeUrl = 'http://localhost:3000/in-article-widget' +
                    '?productId=' + encodeURIComponent(productId || '') +
                    '&platformName=' + encodeURIComponent(pearlSettings.platformIdentifier);
    
                // In de frontend renderen we direct het iframe met de productId als query parameter.
                return el('iframe', {
                    src: iframeUrl,
                    width: '100%',
                    height: '400',
                    frameBorder: '0',
                    allowFullScreen: true
                });
            }
        });
    })(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components);
    
}, 2000);
  