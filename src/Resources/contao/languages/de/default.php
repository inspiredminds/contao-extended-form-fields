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

$GLOBALS['TL_LANG']['ERR']['formFieldMinOptions'] = 'Es müssen mindestens %s Optionen ausgewählt werden.';
$GLOBALS['TL_LANG']['ERR']['formFieldMaxOptions'] = 'Es können maximal %s Optionen ausgewählt werden.';
$GLOBALS['TL_LANG']['ERR']['formFieldDisallowedValues'] = 'Das Wort "%s" is nicht erlaubt.';
$GLOBALS['TL_LANG']['ERR']['formFieldAllowedValues'] = 'Ungültige Eingabe.';

if (ContaoExtendedFormFieldsBundle::canIntegrateHttpUrlRgxp()) {
    $GLOBALS['TL_LANG']['ERR']['invalidHttpUrl'] = 'Bitte eine gültige URL eingeben, die mit http:// oder https:// beginnt!';
}

$GLOBALS['TL_LANG']['MSC']['formFieldCustomLabel'] = 'Eigener Wert';
