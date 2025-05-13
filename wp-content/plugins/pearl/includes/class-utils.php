<?php

namespace Pearl;

if (! defined('ABSPATH')) {
    exit;
}

class Utils
{
    public static function renderProductIframe(array $attributes): string
    {
        $iframeUrl = esc_html(self::getIframeUrl($attributes));
        $blockAttributes = get_block_wrapper_attributes();
        $wigetId = esc_html($attributes['widgetId']);

        $html = <<<HTML
        <div {$blockAttributes}>
            <script src='https://wl.bigspark.link/assets/resize-iframe.js'></script>
            <iframe
                id={$wigetId}
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                class="bs-widget"
                style="border: none"
                src={$iframeUrl}
                width="100%"
                height="750"
            ></iframe>
        HTML;

        return $html;
    }

    public static function getPlatformIdentifier(): string
    {
        return get_option('pearl_platform_identifier', '');
    }

    public static function getIframeUrl(array $attributes): ?string
    {
        if (! empty($attributes['productId']) && ! empty($attributes['offerType']) && ! empty($attributes['widgetId'])) {
            $iframeUrl = 'https://wl.bigspark.link/in-article-widget/' .
                '?productId=' . self::encodeURIComponent($attributes['productId']) .
                '&platformName=' . self::encodeURIComponent(self::getPlatformIdentifier()) .
                '&offerType=' . self::encodeURIComponent($attributes['offerType']) .
                '&showOfferTypeSelector=' . self::encodeURIComponent($attributes['showOfferTypeSelector'] ? 'true' : 'false') .
                '&widgetId=' . self::encodeURIComponent($attributes['widgetId']);
        } else {
            $iframeUrl = null;
        }
        return $iframeUrl;
    }

    /**
     * Mimic the behavior of JavaScript's encodeURIComponent.
     */
    public static function encodeURIComponent(string $str): string
    {
        $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
        return strtr(rawurlencode($str), $revert);
    }
}
