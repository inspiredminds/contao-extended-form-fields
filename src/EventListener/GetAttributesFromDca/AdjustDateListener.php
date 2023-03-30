<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoExtendedFormFields bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\GetAttributesFromDca;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Date;
use InspiredMinds\ContaoExtendedFormFieldsBundle\Form\FormText;

/**
 * Transforms date values back to the HTML5 standard.
 *
 * @Hook("getAttributesFromDca")
 */
class AdjustDateListener
{
    public function __invoke(array $attributes): array
    {
        if ('date' !== ($attributes['rgxp'] ?? null) || empty($attributes['value'])) {
            return $attributes;
        }

        $sourceFormat = Date::getNumericDateFormat();
        $date = \DateTimeImmutable::createFromFormat($sourceFormat, $attributes['value']);
        $attributes['value'] = $date->format(FormText::HTML5_DATE_FORMAT);

        return $attributes;
    }
}
