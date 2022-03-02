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

$GLOBALS['TL_LANG']['ERR']['formFieldMinOptions'] = 'You have to select at least %s options.';
$GLOBALS['TL_LANG']['ERR']['formFieldMaxOptions'] = 'You can only select a maximum of %s options.';
$GLOBALS['TL_LANG']['ERR']['formFieldDisallowedValues'] = 'The word "%s" is not allowed.';
$GLOBALS['TL_LANG']['ERR']['formFieldAllowedValues'] = 'Invalid input.';

if (ContaoExtendedFormFieldsBundle::canIntegrateHttpUrlRgxp()) {
    $GLOBALS['TL_LANG']['ERR']['invalidHttpUrl'] = 'Please enter a valid URL starting with either http:// or https://!';
}

$GLOBALS['TL_LANG']['MSC']['formFieldCustomLabel'] = 'Custom value';
