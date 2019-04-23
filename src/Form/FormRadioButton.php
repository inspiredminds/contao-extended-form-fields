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

use Contao\Input;

class FormRadioButton extends \Contao\FormRadioButton
{
    public function parse($arrAttributes = null)
    {
        if ($this->addCustomOption) {
            $this->strPrefix .= ' widget-radio-custom';
        }

        return parent::parse($arrAttributes);
    }

    public function validate(): void
    {
        if ($this->addCustomOption) {
            $customValue = $this->getPost($this->strName.'_custom'.$this->id);

            if (!empty($customValue)) {
                Input::setPost($this->strName, $customValue);
            }
        }

        parent::validate();
    }

    protected function isValidOption($varInput)
    {
        $customValue = $this->getPost($this->strName.'_custom'.$this->id);

        if (!empty($customValue) && $customValue === $varInput) {
            return true;
        }

        return parent::isValidOption($varInput);
    }

    protected function getOptions()
    {
        if ($this->addCustomOption) {
            $this->arrOptions[] = [
                'value' => 'custom'.$this->id,
                'label' => 'custom'.$this->id,
            ];
        }

        $options = parent::getOptions();

        foreach ($options as &$option) {
            if ($option['value'] === 'custom'.$this->id && $option['label'] === 'custom'.$this->id) {
                $option['type'] = 'custom';
                $option['value'] = $this->isValidOption($this->varValue) ? $options['value'] : $this->varValue;
                $option['checked'] = $this->isValidOption($this->varValue) ? '' : ' checked';
                $option['custom_name'] = $this->strName.'_custom'.$this->id;
                $option['custom_value'] = $this->varValue;
            }
        }

        return $options;
    }
}
