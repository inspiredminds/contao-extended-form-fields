<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Extended Form Fields extension.
 *
 * (c) INSPIRED MINDS
 */

use InspiredMinds\ContaoExtendedFormFieldsBundle\ContaoExtendedFormFieldsBundle;
use InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\FormFieldVisibilityListener;
use InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\FormHookListener;
use InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\HttpUrlListener;
use InspiredMinds\ContaoExtendedFormFieldsBundle\Form\FormCheckBox;
use InspiredMinds\ContaoExtendedFormFieldsBundle\Form\FormRadioButton;
use InspiredMinds\ContaoExtendedFormFieldsBundle\Form\FormSelect;
use InspiredMinds\ContaoExtendedFormFieldsBundle\Form\FormText;

/*
 * Hooks
 */
$GLOBALS['TL_HOOKS']['validateFormField'][] = [FormHookListener::class, 'validateMinMaxOptions'];
$GLOBALS['TL_HOOKS']['validateFormField'][] = [FormHookListener::class, 'validateDisallowedValues'];
$GLOBALS['TL_HOOKS']['validateFormField'][] = [FormHookListener::class, 'validateAllowedValues'];
$GLOBALS['TL_HOOKS']['parseWidget'][] = [FormHookListener::class, 'onParseWidget'];

if (ContaoExtendedFormFieldsBundle::canIntegrateHttpUrlRgxp()) {
    $GLOBALS['TL_HOOKS']['addCustomRegexp'][] = [HttpUrlListener::class, '__invoke'];
}

/*
 * Form fields
 */
$GLOBALS['TL_FFL']['radio'] = FormRadioButton::class;
$GLOBALS['TL_FFL']['checkbox'] = FormCheckBox::class;
$GLOBALS['TL_FFL']['text'] = FormText::class;
$GLOBALS['TL_FFL']['select'] = FormSelect::class;

/*
 * Isotope Hooks
 */
$GLOBALS['ISO_HOOKS']['orderConditions'][] = [FormFieldVisibilityListener::class, 'onOrderConditions'];
