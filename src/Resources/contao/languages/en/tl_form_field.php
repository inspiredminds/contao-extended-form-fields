<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoExtendedFormFields bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

use Contao\System;

System::loadLanguageFile('tl_content');

$GLOBALS['TL_LANG']['tl_form_field']['minOptions'] = ['Minimum amount of options', 'The minimum amount of options that have to be checked/selected.'];
$GLOBALS['TL_LANG']['tl_form_field']['maxOptions'] = ['Maximum amount of options', 'The maximum amount of options that can to be checked/selected.'];
$GLOBALS['TL_LANG']['tl_form_field']['errorMsg'] = ['Custom error message', 'This error message will be shown on invalid input.'];
$GLOBALS['TL_LANG']['tl_form_field']['addCustomOption'] = ['Allow custom option', 'This adds a text field where the user can add a custom option.'];
$GLOBALS['TL_LANG']['tl_form_field']['blacklistedWords'] = ['Blacklisted words', 'These words will create a validation error on submit.'];
$GLOBALS['TL_LANG']['tl_form_field']['whitelistedValues'] = ['Whitelisted values', 'Only these words or values will be allowed.'];
$GLOBALS['TL_LANG']['tl_form_field']['httpurl'] = ['Absolute URL', 'Checks whether the input is a valid absolute URL.'];
$GLOBALS['TL_LANG']['tl_form_field']['protected_legend'] = &$GLOBALS['TL_LANG']['tl_content']['protected_legend'];
