<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoExtendedFormFields bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

// Add minOptions and maxOptions for checkbox fields
$GLOBALS['TL_DCA']['tl_form_field']['fields']['minOptions'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['minOptions'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50', 'rgxp' => 'natural'],
    'sql' => "int(10) NOT NULL DEFAULT '0'",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['maxOptions'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['maxOptions'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50', 'rgxp' => 'natural'],
    'sql' => "int(10) NOT NULL DEFAULT '0'",
];

\Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addField('minOptions', 'fconfig_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->addField('maxOptions', 'fconfig_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('checkbox', 'tl_form_field')
    ->applyToSubPalette('multiple', 'tl_form_field')
;

// Add custom option for radio button field
$GLOBALS['TL_DCA']['tl_form_field']['fields']['addCustomOption'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['addCustomOption'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

\Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addField('addCustomOption', 'options_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('radio', 'tl_form_field')
;

// Add range field
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['range'] = $GLOBALS['TL_DCA']['tl_form_field']['palettes']['text'];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['step'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['step'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'digit', 'tl_class' => 'w50'],
    'sql' => ['type' => 'float', 'scale' => 2, 'notnull' => false]
];

$GLOBALS['TL_DCA']['tl_form_field']['palettes']['range'] = str_replace([',rgxp', ',placeholder'], '', $GLOBALS['TL_DCA']['tl_form_field']['palettes']['range']);

\Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    //->removeField('rgxp')
    //->removeField('placeholder')
    ->addField('step', 'maxlength')
    ->applyToPalette('range', 'tl_form_field')
;

// Add black listed words
$GLOBALS['TL_DCA']['tl_form_field']['fields']['blacklistedWords'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['blacklistedWords'],
    'exclude' => true,
    'inputType' => 'listWizard',
    'eval' => ['tl_class' => 'w50 clr'],
    'sql' => 'blob NULL',
];

\Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addField('blacklistedWords', 'fconfig_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('text', 'tl_form_field')
    ->applyToPalette('textarea', 'tl_form_field')
;

// Add white listed values
$GLOBALS['TL_DCA']['tl_form_field']['fields']['whitelistedValues'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['whitelistedValues'],
    'exclude' => true,
    'inputType' => 'listWizard',
    'eval' => ['tl_class' => 'w50 clr'],
    'sql' => 'blob NULL',
];

\Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addField('whitelistedValues', 'fconfig_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('text', 'tl_form_field')
;

// Add custom errorMsg
$GLOBALS['TL_DCA']['tl_form_field']['fields']['errorMsg'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['errorMsg'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['decodeEntities' => true, 'maxlength' => 255, 'tl_class' => 'clr w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

foreach ($GLOBALS['TL_DCA']['tl_form_field']['palettes'] as $type => &$palette) {
    if ('__selector__' !== $type && 'default' !== $type) {
        \Contao\CoreBundle\DataContainer\PaletteManipulator::create()
            ->addField('errorMsg', 'fconfig_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
            ->applyToPalette($type, 'tl_form_field')
        ;
    }
}
