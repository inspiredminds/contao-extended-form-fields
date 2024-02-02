<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Extended Form Fields extension.
 *
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\ParseWidget;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Template;
use Contao\Widget;

/**
 * @Hook("parseWidget")
 */
class AddCharacterCountScriptListener
{
    public function __invoke(string $buffer, Widget $widget): string
    {
        if (!$widget->showCharacterCount) {
            return $buffer;
        }

        $GLOBALS['TL_BODY']['bundles/contaoextendedformfields/charactercount.js'] = Template::generateScriptTag('bundles/contaoextendedformfields/charactercount.js', true, null);

        return str_replace('<textarea ', '<textarea data-add-counter ', $buffer);
    }
}
