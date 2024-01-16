<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoExtendedFormFields bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener\DataContainer;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\DataContainer;

/**
 * @Callback(table="tl_form_field", target="config.onload", priority=-100)
 */
class AdjustFormFieldPalettesListener
{
    public function __invoke(DataContainer $dc): void
    {
        $table = $dc->table;

        foreach ($GLOBALS['TL_DCA'][$table]['palettes'] as $type => &$palette) {
            if (!\is_string($palette) || 'default' === $type) {
                continue;
            }

            // Add custom error msg
            if (false !== strpos($palette, 'mandatory')) {
                PaletteManipulator::create()
                    ->addField('errorMsg', 'fconfig_legend', PaletteManipulator::POSITION_APPEND)
                    ->applyToPalette($type, $table)
                ;
            }

            // Protected
            PaletteManipulator::create()
                ->addLegend('protected_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE, true)
                ->addField('protected', 'protected_legend', PaletteManipulator::POSITION_APPEND)
                ->applyToPalette($type, $table)
            ;

            // Load default from request
            if (false !== strpos($palette, ',value') || 'select' === $type) {
                PaletteManipulator::create()
                    ->addLegend('expert_legend', 'template_legend', PaletteManipulator::POSITION_BEFORE, true)
                    ->addField('defaultFromRequest', 'expert_legend', PaletteManipulator::POSITION_APPEND)
                    ->applyToPalette($type, $table)
                ;
            }
        }
    }
}
