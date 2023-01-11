<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoExtendedFormFields bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle\Form;

use Contao\FormSelect as ContaoFormSelect;
use Contao\FormSelectMenu;

if (!class_exists(FormSelectMenu::class)) {
    class_alias(ContaoFormSelect::class, FormSelectMenu::class);
}

class FormSelect extends FormSelectMenu
{
    protected function getOptions()
    {
        if ($this->placeholder && $this->arrOptions[0]['label'] !== $this->placeholder) {
            $this->arrOptions = array_merge([['value' => '', 'label' => $this->placeholder]], $this->arrOptions);
        }

        return parent::getOptions();
    }
}
