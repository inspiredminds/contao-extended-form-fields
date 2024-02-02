<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Extended Form Fields extension.
 *
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle;

use Contao\CoreBundle\EventListener\Widget\HttpUrlListener;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContaoExtendedFormFieldsBundle extends Bundle
{
    public static function canIntegrateHttpUrlRgxp(): bool
    {
        return !class_exists(HttpUrlListener::class);
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
