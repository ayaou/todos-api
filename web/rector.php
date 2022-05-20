<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\Configuration\Option;
use Rector\Symfony\Set\SymfonySetList;

return static function (RectorConfig $rectorConfig): void {
    $parameters = $rectorConfig->parameters();
    $parameters->set(
      Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER,
      __DIR__.'/var/cache/dev/App_KernelDevDebugContainer.xml'
    );

    $rectorConfig->sets([
      SymfonySetList::SYMFONY_54,
      SymfonySetList::SYMFONY_CODE_QUALITY,
      SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
    ]);
};
