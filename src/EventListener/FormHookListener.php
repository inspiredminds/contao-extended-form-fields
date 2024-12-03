<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Extended Form Fields extension.
 *
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\Form;
use Contao\StringUtil;
use Contao\Widget;
use Symfony\Component\HttpFoundation\RequestStack;

class FormHookListener
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly ScopeMatcher $scopeMatcher,
    ) {
    }

    public function onParseWidget(string $buffer, Widget $widget): string
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request || !$this->scopeMatcher->isFrontendRequest($request)) {
            return $buffer;
        }

        $data = array_filter(
            [
                'data-min-options' => $widget->minOptions,
                'data-max-options' => $widget->maxOptions,
            ],
            static fn ($v) => $v > 0,
        );

        if ($data) {
            // parse the initial HTML tag
            $buffer = preg_replace_callback(
                '|<([a-zA-Z0-9]+)(\s[^>]*?)?(?<!/)>|',
                static function ($matches) use ($data) {
                    $tag = $matches[1];
                    $attributes = $matches[2] ?? '';

                    // add the data attributes
                    foreach ($data as $key => $value) {
                        $attributes .= ' '.$key.'="'.$value.'"';
                    }

                    return "<{$tag}{$attributes}>";
                },
                $buffer, 1,
            );
        }

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
            $widget->addError(\sprintf($GLOBALS['TL_LANG']['ERR']['formFieldMinOptions'], $widget->minOptions));
        }

        if ($widget->maxOptions > 0 && \count($widget->value) > $widget->maxOptions) {
            $widget->addError(\sprintf($GLOBALS['TL_LANG']['ERR']['formFieldMaxOptions'], $widget->maxOptions));
        }

        return $widget;
    }

    public function validateDisallowedValues(Widget $widget, string $formId, array $formData, Form $form): Widget
    {
        $disallowlist = array_filter(StringUtil::deserialize($widget->disallowedValues, true));

        if ($disallowlist) {
            $hasDisallowed = array_filter((array) $widget->value, static fn ($v): bool => \in_array((string) $v, $disallowlist, true));

            if ($hasDisallowed) {
                $widget->addError(\sprintf($GLOBALS['TL_LANG']['ERR']['formFieldDisallowedValues'], reset($hasDisallowed)));
            }
        }

        return $widget;
    }

    public function validateAllowedValues(Widget $widget, string $formId, array $formData, Form $form): Widget
    {
        if (('' === $widget->value || [] === $widget->value) && !$widget->mandatory) {
            return $widget;
        }

        if (!empty($widget->allowedValues)) {
            $allowlist = array_filter(StringUtil::deserialize($widget->allowedValues, true));

            if ($allowlist) {
                $hasDisallowed = (bool) array_filter((array) $widget->value, static fn ($v): bool => !\in_array($v, $allowlist, true));

                if ($hasDisallowed) {
                    $widget->addError($GLOBALS['TL_LANG']['ERR']['formFieldAllowedValues']);
                }
            }
        }

        return $widget;
    }
}
