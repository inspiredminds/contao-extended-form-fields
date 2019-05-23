<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoExtendedFormFields bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

/*
 * Hooks
 */
$GLOBALS['TL_HOOKS']['validateFormField'][] = [\InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\FormHookListener::class, 'validateMinMaxOptions'];
$GLOBALS['TL_HOOKS']['validateFormField'][] = [\InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\FormHookListener::class, 'validateBlacklistedWords'];
$GLOBALS['TL_HOOKS']['validateFormField'][] = [\InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\FormHookListener::class, 'validateWhitelistedValues'];
$GLOBALS['TL_HOOKS']['parseWidget'][] = [\InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\FormHookListener::class, 'onParseWidget'];

/*
 * Form fields
 */
$GLOBALS['TL_FFL']['radio'] = \InspiredMinds\ContaoExtendedFormFieldsBundle\Form\FormRadioButton::class;
$GLOBALS['TL_FFL']['range'] = \InspiredMinds\ContaoExtendedFormFieldsBundle\Form\FormRange::class;
