<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoExtendedFormFields bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

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

$GLOBALS['TL_DCA']['tl_form_field']['fields']['errorMsg'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['errorMsg'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['decodeEntities' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

\Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addField('minOptions', 'fconfig_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->addField('maxOptions', 'fconfig_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('checkbox', 'tl_form_field')
    ->applyToSubPalette('multiple', 'tl_form_field')
;

foreach ($GLOBALS['TL_DCA']['tl_form_field']['palettes'] as $type => &$palette) {
    if ('__selector__' !== $type && 'default' !== $type) {
        \Contao\CoreBundle\DataContainer\PaletteManipulator::create()
            ->addField('errorMsg', 'fconfig_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
            ->applyToPalette($type, 'tl_form_field')
        ;
    }
}
