<?php
// This function should mimic the behavior of Javascript encodeURIComponent()
function encodeURIComponent($str) {
    $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
    return strtr(rawurlencode($str), $revert);
}

if (! empty($attributes['productId']) && ! empty($attributes['offerType']) && ! empty($attributes['widgetId'])) {
    $iframeUrl = 'https://starfish.production.bigspark.it/in-article-widget' +
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
    <script src='https://wl.bigspark.link/assets/resize-iframe.js'></script>
    <iframe
        id=<?php echo esc_html($attributes['widgetId']); ?>
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        class="bs-widget"
        style='border: "none";'
        src=<?php echo esc_html($iframeUrl); ?>
        width="100%"
        height="750"
    />
</div>