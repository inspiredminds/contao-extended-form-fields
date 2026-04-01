<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Extended Form Fields extension.
 *
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\GetAttributesFromDca;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\DataContainer;
use Contao\Date;
use InspiredMinds\ContaoExtendedFormFieldsBundle\Form\FormText;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Transforms date values back to the HTML5 standard for the front end.
 */
#[AsHook('getAttributesFromDca')]
class AdjustDateListener
{
    public function __construct(
        private readonly ScopeMatcher $scopeMatcher,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function __invoke(array $attributes, $context = null): array
    {
        if ('date' !== ($attributes['rgxp'] ?? null) || empty($attributes['value']) || $context instanceof DataContainer) {
            return $attributes;
        }

        // Make sure to only execute this in the front end (https://github.com/inspiredminds/contao-extended-form-fields/issues/8)
        if (!($request = $this->requestStack->getCurrentRequest()) || !$this->scopeMatcher->isFrontendRequest($request)) {
            return $attributes;
        }

        $sourceFormat = Date::getNumericDateFormat();
        $date = \DateTimeImmutable::createFromFormat($sourceFormat, $attributes['value']);
        $attributes['value'] = $date->format(FormText::HTML5_DATE_FORMAT);

        return $attributes;
    }
}
