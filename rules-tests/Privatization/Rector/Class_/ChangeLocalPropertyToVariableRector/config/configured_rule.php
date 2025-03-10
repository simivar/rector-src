<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Privatization\Rector\Class_\ChangeLocalPropertyToVariableRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(ChangeLocalPropertyToVariableRector::class);
};
