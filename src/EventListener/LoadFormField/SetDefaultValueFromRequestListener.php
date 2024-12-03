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
use Contao\StringUtil;
use Contao\Widget;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Sets a form field's default value according to the defaultFromRequest setting and the current GET request.
 *
 * @Hook("loadFormField")
 */
class SetDefaultValueFromRequestListener
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function __invoke(Widget $widget, string $formId, array $formData, Form $form): Widget
    {
        if (!$widget->defaultFromRequest || !empty($widget->value)) {
            return $widget;
        }

        $request = $this->requestStack->getCurrentRequest();

        if (Request::METHOD_GET !== $request->getMethod() || !$request->query->has($widget->name)) {
            return $widget;
        }

        $value = $request->query->get($widget->name);

        if (!\is_string($value)) {
            return $widget;
        }

        $widget->value = StringUtil::specialcharsAttribute($value, true, true);

        return $widget;
    }
}
