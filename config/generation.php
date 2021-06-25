<?php

$svgNormalization = static function (string $tempFilepath, array $iconSet) {
    $doc = new DOMDocument();
    $doc->load($tempFilepath);
    $svgElement = $doc->getElementsByTagName('svg')[0];
    $svgElement->removeAttribute('width');
    $svgElement->removeAttribute('height');
    $svgElement->removeAttribute('viewBox');
    $svgElement->setAttribute('fill', 'currentColor');
    $svgElement->setAttribute('stroke', 'none');
    $svgElement->setAttribute('viewBox', '0 0 24 24');
    $doc->save($tempFilepath);

    $svgLine = trim(file($tempFilepath)[1]);
    file_put_contents($tempFilepath, $svgLine);
};

return [
    [
        'source' => __DIR__.'/../node_modules/boxicons/svg/regular',
        'destination' => __DIR__.'/../resources/svg/regular',
        'input-prefix' => 'bx-',
        'after' => $svgNormalization,
        'safe' => true,
    ],
    [
        'source' => __DIR__.'/../node_modules/boxicons/svg/logos',
        'destination' => __DIR__.'/../resources/svg/logos',
        'input-prefix' => 'bxl-',
        'after' => $svgNormalization,
        'safe' => true,
    ],
    [
        'source' => __DIR__.'/../node_modules/boxicons/svg/solid',
        'destination' => __DIR__.'/../resources/svg/solid',
        'input-prefix' => 'bxs-',
        'after' => $svgNormalization,
        'safe' => true,
    ],
];