<?php

namespace MallardDuck\BladeBoxicons\Generator\Command;

use DOMDocument;
use DOMElement;
use BladeUI\Icons\Console\AbstractGenerateCommand;

class GenerateCommand extends AbstractGenerateCommand
{
    protected static string $npmPackage = 'boxicons';
    protected static array $iconSets = [
        'regular' => 'bx-',
        'logos' => 'bxl-',
        'solid' => 'bxs-',
    ];

    public function normalizeSvgFile(string $tempFilepath, string $iconSet): void
    {
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
    }
}