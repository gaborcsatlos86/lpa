<?php

declare(strict_types=1);

namespace App\Service;

use Sonata\Exporter\Handler;
use Sonata\Exporter\Writer\XlsxWriter;
use Sonata\Exporter\Source\ArraySourceIterator;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ExcelExporterService implements ExcelExporterServiceInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private ParameterBagInterface $params
    ) {}
    
    public function export(array $dataSource, string $fileName): bool
    {
        $projectDir = $this->params->get('kernel.project_dir') . '/public';
        $filesFolder = $this->params->get('generated-files-folder');
        if (!is_dir($projectDir.$filesFolder)) {
            mkdir($projectDir.$filesFolder, 777, true);
        }
        try {
            $source = new ArraySourceIterator($dataSource);
            $writer = new XlsxWriter($projectDir.$filesFolder.$fileName, false);
            
            $handler = Handler::create($source, $writer);
            $handler->export();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
        return true;
    }
}