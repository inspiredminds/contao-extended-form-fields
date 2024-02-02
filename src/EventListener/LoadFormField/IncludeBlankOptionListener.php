<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Extended Form Fields extension.
 *
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\LoadFormField;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Form;
use Contao\Widget;

/**
 * @Hook("loadFormField")
 */
class IncludeBlankOptionListener
{
    public function __invoke(Widget $widget, string $formId, array $data, Form $form): Widget
    {
        if (!$widget->includeBlankOption || 'select' !== $widget->type) {
            return $widget;
        }

        $options = $widget->options;

        array_unshift($options, [
            'label' => '',
            'value' => '',
        ]);

        $widget->options = $options;

        return $widget;
    }
}
