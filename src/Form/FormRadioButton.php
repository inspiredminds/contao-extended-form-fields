<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Extended Form Fields extension.
 *
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle\Form;

if (class_exists(\Contao\FormRadioButton::class)) {
    class FormRadioButtonBaseClass extends \Contao\FormRadioButton
    {
    }
} else {
    class FormRadioButtonBaseClass extends \Contao\FormRadio
    {
    }
}

class FormRadioButton extends FormRadioButtonBaseClass
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
        parent::validate();

        if ($this->addCustomOption && $this->getCustomRadioValue() === $this->getPost($this->strName)) {
            $customValue = $this->getPost($this->getCustomTextName());

            if (!empty($customValue)) {
                $this->varValue = $customValue;
            } else {
                $this->addError($GLOBALS['TL_LANG']['ERR']['invalid']);
            }
        }
    }

    protected function isValidOption($varInput)
    {
        if ($varInput === $this->getCustomRadioValue()) {
            return true;
        }

        return parent::isValidOption($varInput);
    }

    protected function getOptions()
    {
        if ($this->addCustomOption) {
            $this->arrOptions[] = [
                'value' => $this->getCustomRadioValue(),
                'label' => $GLOBALS['TL_LANG']['MSC']['formFieldCustomLabel'],
            ];
        }

        $options = parent::getOptions();

        foreach ($options as &$option) {
            if ($option['value'] === $this->getCustomRadioValue()) {
                $option['type'] = 'custom';
                $option['checked'] = $this->isValidOption($this->varValue) || !$this->varValue ? '' : ' checked';
                $option['custom_name'] = $this->getCustomTextName();
                $option['custom_value'] = $this->isValidOption($this->varValue) ? '' : $this->varValue;
            }
        }

        return $options;
    }

    protected function getCustomRadioValue()
    {
        return 'custom'.$this->id;
    }

    protected function getCustomTextName()
    {
        return $this->strName.'_custom'.$this->id;
    }
}
