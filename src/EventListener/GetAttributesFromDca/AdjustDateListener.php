<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Extended Form Fields extension.
 *
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\GetAttributesFromDca;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\DataContainer;
use Contao\Date;
use InspiredMinds\ContaoExtendedFormFieldsBundle\Form\FormText;

/**
 * Transforms date values back to the HTML5 standard for the front end.
 *
 * @Hook("getAttributesFromDca")
 */
class AdjustDateListener
{
    public function __invoke(array $attributes, $context = null): array
    {
        if ('date' !== ($attributes['rgxp'] ?? null) || empty($attributes['value']) || $context instanceof DataContainer) {
            return $attributes;
        }

        $sourceFormat = Date::getNumericDateFormat();
        $date = \DateTimeImmutable::createFromFormat($sourceFormat, $attributes['value']);
        $attributes['value'] = $date->format(FormText::HTML5_DATE_FORMAT);

        return $attributes;
    }
}
