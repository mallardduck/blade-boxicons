<?php

namespace MallardDuck\BladeBoxicons\Generator\Command;

use DOMDocument;
use DOMElement;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    private static string $baseDir;

    const SVG_SOURCE_BASE = '/node_modules/boxicons/svg';
    const TMP_DEST_BASE = '/build';
    const SVG_DEST_BASE = '/resources/svg';

    const TYPES = [
        '/logos',
        '/regular',
        '/solid',
    ];

    const TYPE_MAP = [
        'logos' => 'l',
        'regular' => null,
        'solid' => 's',
    ];

    protected static $defaultName = "generate";

    public function __construct(string $name = null)
    {
        self::$baseDir = dirname(__DIR__, 2);
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!is_dir(self::$baseDir . self::SVG_SOURCE_BASE)) {
            $output->writeln("The node_modules folder doesn't exist");
            return Command::FAILURE;
        }

        $output->writeln("Starting to discover source SVGs...");

        foreach (self::TYPES as $type) {
            $output->writeln("Processing SVGs for {$type} type svgs.");
            // Setup build dir for type
            $this->ensureDirExists(self::$baseDir . self::TMP_DEST_BASE . $type);

            $fileTransformationList = $this->getDirectoryFileList(self::$baseDir . self::SVG_SOURCE_BASE . $type);
            $this->updateSvgs($type, $fileTransformationList);
            $output->writeln("Completed processing for {$type} svgs.");
        }

        return Command::SUCCESS;
    }

    private function ensureDirExists(string $dirPath)
    {
        if (!is_dir($dirPath)) {
            if (!mkdir($dirPath) && !is_dir($dirPath)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
            }
        }
    }

    private function getDirectoryFileList(string $dirPath): array
    {
        $prefix = sprintf("bx%s-", self::TYPE_MAP[Str::afterLast($dirPath, DIRECTORY_SEPARATOR)]);
        // Scan for files...
        $filesList = scandir($dirPath);
        // Shift out the "." and ".." items.
        array_shift($filesList);
        array_shift($filesList);

        // modify things to a tuple:
        $filesList = collect($filesList)
            ->map(static fn($value) => [$value, Str::after($value, $prefix)]);

        return $filesList->toArray();
    }

    private function updateSvgs(string $type, array $fileTransformations): void
    {
        $typeTempDir = self::$baseDir . self::TMP_DEST_BASE . $type;

        foreach ($fileTransformations as $fileTransformation) {
            [$orgFile, $newFile] = $fileTransformation;
            // Set path variables...
            $sourceFile = self::$baseDir . self::SVG_SOURCE_BASE . $type . '/' . $orgFile;
            $tempFile = $typeTempDir . '/' . $newFile;
            $finalFile = self::$baseDir . self::SVG_DEST_BASE . $type . '/' . $newFile;

            // Copy file to temp...
            copy($sourceFile, $tempFile); // Stage 1
            $this->normalizeSvgFile($tempFile); // Stage 2
            // Start stage 3
            $svgLine = trim(file($tempFile)[1]);
            file_put_contents($tempFile, $svgLine);
            // Final stage...
            copy($tempFile, $finalFile);
        }
    }

    private function normalizeSvgFile(string $tempFile)
    {
        $doc = new DOMDocument();
        $doc->load($tempFile);
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
        $doc->save($tempFile);
    }
}