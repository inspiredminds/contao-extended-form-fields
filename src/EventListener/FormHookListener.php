<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoExtendedFormFields bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener;

use Contao\Form;
use Contao\StringUtil;
use Contao\Widget;

class FormHookListener
{
    public function onParseWidget(string $buffer, Widget $widget): string
    {
        $data = \array_filter([
            'data-min-options' => $widget->minOptions,
            'data-max-options' => $widget->maxOptions,
        ], function ($v) { return $v > 0; });

        // parse the initial HTML tag
        $buffer = \preg_replace_callback(
            '|<([a-zA-Z0-9]+)(\s[^>]*?)?(?<!/)>|',
            function ($matches) use ($data) {
                $tag = $matches[1];
                $attributes = $matches[2];

                // add the data attributes
                foreach ($data as $key => $value) {
                    $attributes .= ' '.$key.'="'.$value.'"';
                }

                return "<{$tag}{$attributes}>";
            },
            $buffer, 1
        );

        if ($widget->errorMsg && $widget->hasErrors()) {
            foreach ($widget->getErrors() as $error) {
                $buffer = str_replace($error, $widget->errorMsg, $buffer);
            }
        }

        return $buffer;
    }

    public function validateMinMaxOptions(Widget $widget, string $formId, array $formData, Form $form): Widget
    {
        if (!\in_array($widget->type, ['checkbox', 'select'], true)) {
            return $widget;
        }

        if ('select' === $widget->type && !$widget->multiple) {
            return $widget;
        }

        if (!\is_array($widget->value)) {
            return $widget;
        }

        if ($widget->minOptions > 0 && \count($widget->value) < $widget->minOptions) {
            $widget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['formFieldMinOptions'], $widget->minOptions));
        }

        if ($widget->maxOptions > 0 && \count($widget->value) > $widget->maxOptions) {
            $widget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['formFieldMaxOptions'], $widget->maxOptions));
        }

        return $widget;
    }

    public function validateBlacklistedWords(Widget $widget, string $formId, array $formData, Form $form): Widget
    {
        if (!empty($widget->blacklistedWords)) {
            $blacklist = array_filter(StringUtil::deserialize($widget->blacklistedWords, true));

            foreach ($blacklist as $word) {
                if (false !== stripos($widget->value, $word)) {
                    $widget->addError(sprintf($GLOBALS['TL_LANG']['ERR']['formFieldBlacklistedWords'], $word));
                }
            }
        }

        return $widget;
    }

    public function validateWhitelistedValues(Widget $widget, string $formId, array $formData, Form $form): Widget
    {
        if (!empty($widget->whitelistedValues)) {
            $whitelist = array_filter(StringUtil::deserialize($widget->whitelistedValues, true));

            foreach ($whitelist as $value) {
                if ((string) $widget->value === (string) $value) {
                    return $widget;
                }
            }

            $widget->addError($GLOBALS['TL_LANG']['ERR']['formFieldWhitelistedValues']);
        }

        return $widget;
    }
}
