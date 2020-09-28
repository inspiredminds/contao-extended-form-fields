<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoExtendedFormFields bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

use InspiredMinds\ContaoExtendedFormFieldsBundle\ContaoExtendedFormFieldsBundle;
use InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\FormHookListener;
use InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\HttpUrlListener;
use InspiredMinds\ContaoExtendedFormFieldsBundle\Form\FormRadioButton;

/*
 * Hooks
 */
$GLOBALS['TL_HOOKS']['validateFormField'][] = [FormHookListener::class, 'validateMinMaxOptions'];
$GLOBALS['TL_HOOKS']['validateFormField'][] = [FormHookListener::class, 'validateBlacklistedWords'];
$GLOBALS['TL_HOOKS']['validateFormField'][] = [FormHookListener::class, 'validateWhitelistedValues'];
$GLOBALS['TL_HOOKS']['parseWidget'][] = [FormHookListener::class, 'onParseWidget'];

if (ContaoExtendedFormFieldsBundle::canIntegrateHttpUrlRgxp()) {
    $GLOBALS['TL_HOOKS']['addCustomRegexp'][] = [HttpUrlListener::class, '__invoke'];
}

/*
 * Form fields
 */
$GLOBALS['TL_FFL']['radio'] = FormRadioButton::class;
