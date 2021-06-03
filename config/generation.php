<?php

use BladeUI\Icons\Generation\IconGenerator;
use BladeUI\Icons\Generation\IconSetConfig;

return IconGenerator::create('blade-boxicons')
    ->fromNPM('boxicons') // Optionally specify an `npm` package to load from
    ->directory('/svg') // Specify a directory, if an npm package isn't set, this can be anywhere
    ->withIconSets([
        IconSetConfig::create('regular')
            ->setInputFilePrefix('bx-'),
        IconSetConfig::create('logos')
            ->setInputFilePrefix('bxl-'),
        IconSetConfig::create('solid')
            ->setInputFilePrefix('bxs-'),
    ])
    ->withSvgNormalisation(function (string $tempFilepath, IconSetConfig $iconSet) {
        $doc = new DOMDocument();
        $doc->load($tempFilepath);
        /**
         * @var DOMElement $svgElement
         */
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
    });