<?php
// This function should mimic the behavior of Javascript encodeURIComponent()
function encodeURIComponent($str) {
    $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
    return strtr(rawurlencode($str), $revert);
}

if (! empty($attributes['productId']) && ! empty($attributes['offerType']) && ! empty($attributes['widgetId'])) {
    $iframeUrl = 'http://localhost:3000/in-article-widget' +
        '?productId=' + encodeURIComponent($attributes['productId']) +
        '&platformName=' + encodeURIComponent(get_option('pearl_platform_identifier', '')) +
        '&offerType=' + encodeURIComponent($attributes['offerType']) +
        '&showOfferTypeSelector=' + encodeURIComponent($attributes['showOfferTypeSelector'] ? 'true' : 'false') +
        '&widgetId=' + encodeURIComponent($attributes['widgetId']);
} else {
    // ?
}
?>

<div <?php echo get_block_wrapper_attributes(); ?>>
    <iframe 
        src=<?php echo esc_html( $iframeUrl ); ?>
        width="100%"
        height="1200"
    />
</div>