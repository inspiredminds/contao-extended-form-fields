<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoExtendedFormFields bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

use Contao\Controller;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use InspiredMinds\ContaoExtendedFormFieldsBundle\ContaoExtendedFormFieldsBundle;
use InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\HttpUrlListener;

// Add minOptions and maxOptions for checkbox fields
$GLOBALS['TL_DCA']['tl_form_field']['fields']['minOptions'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50', 'rgxp' => 'natural'],
    'sql' => "int(10) NOT NULL DEFAULT '0'",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['maxOptions'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50', 'rgxp' => 'natural'],
    'sql' => "int(10) NOT NULL DEFAULT '0'",
];

PaletteManipulator::create()
    ->addField('minOptions', 'fconfig_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('maxOptions', 'fconfig_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('checkbox', 'tl_form_field')
    ->applyToSubPalette('multiple', 'tl_form_field')
;

// Add custom option for radio/checkbox button field
$GLOBALS['TL_DCA']['tl_form_field']['fields']['addCustomOption'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

PaletteManipulator::create()
    ->addField('addCustomOption', 'options_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('radio', 'tl_form_field')
    ->applyToPalette('checkbox', 'tl_form_field')
;

// Add disallowed values
$GLOBALS['TL_DCA']['tl_form_field']['fields']['disallowedValues'] = [
    'exclude' => true,
    'inputType' => 'listWizard',
    'eval' => ['tl_class' => 'w50 clr'],
    'sql' => 'blob NULL',
];

PaletteManipulator::create()
    ->addField('disallowedValues', 'fconfig_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('text', 'tl_form_field')
    ->applyToPalette('textarea', 'tl_form_field')
;

// Add allowed values
$GLOBALS['TL_DCA']['tl_form_field']['fields']['allowedValues'] = [
    'exclude' => true,
    'inputType' => 'listWizard',
    'eval' => ['tl_class' => 'w50 clr'],
    'sql' => 'blob NULL',
];

PaletteManipulator::create()
    ->addField('allowedValues', 'fconfig_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('text', 'tl_form_field')
;

// Add custom errorMsg
$GLOBALS['TL_DCA']['tl_form_field']['fields']['errorMsg'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['decodeEntities' => true, 'maxlength' => 255, 'tl_class' => 'clr w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

// Add httpurl rgxp
if (ContaoExtendedFormFieldsBundle::canIntegrateHttpUrlRgxp()) {
    $GLOBALS['TL_DCA']['tl_form_field']['fields']['rgxp']['options'][] = HttpUrlListener::RGXP_NAME;
}

// Protected
Controller::loadDataContainer('tl_content');
$GLOBALS['TL_DCA']['tl_form_field']['fields']['protected'] = $GLOBALS['TL_DCA']['tl_content']['fields']['protected'];
$GLOBALS['TL_DCA']['tl_form_field']['fields']['groups'] = $GLOBALS['TL_DCA']['tl_content']['fields']['groups'];
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'][] = 'protected';
$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['protected'] = 'groups';

// Add message countdown
$GLOBALS['TL_DCA']['tl_form_field']['fields']['showCharacterCount'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

PaletteManipulator::create()
    ->addField('showCharacterCount', 'expert_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('textarea', 'tl_form_field')
;

// Load default from request
$GLOBALS['TL_DCA']['tl_form_field']['fields']['defaultFromRequest'] = [
    'inputType' => 'checkbox',
    'exclude' => true,
    'eval' => ['tl_class' => 'clr w50'],
    'sql' => ['type' => 'boolean', 'default' => false],
];
