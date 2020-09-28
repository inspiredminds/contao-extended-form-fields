<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoExtendedFormFields bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
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
}
