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

class FormCheckBox extends \Contao\FormCheckBox
{
    public function parse($arrAttributes = null)
    {
        if ($this->addCustomOption) {
            $this->strPrefix .= ' widget-checkbox-custom';
        }

        return parent::parse($arrAttributes);
    }

    public function validate(): void
    {
        parent::validate();

        if (\is_array($this->varValue) && $this->addCustomOption && $this->getCustomCheckboxValue() === reset($this->getPost($this->strName))) {
            $customValue = $this->getPost($this->getCustomTextName());

            if (!empty($customValue)) {
                foreach ($this->varValue as &$value) {
                    if ($this->getCustomCheckboxValue() === $value) {
                        $value = $customValue;
                        break;
                    }
                }
            } else {
                $this->addError($GLOBALS['TL_LANG']['ERR']['invalid']);
            }
        }
    }

    protected function isValidOption($varInput)
    {
        $prevOptions = $this->arrOptions;

        if (\is_array($varInput) && \in_array($this->getCustomCheckboxValue(), $varInput, false)) {
            $this->arrOptions[] = [
                'value' => $this->getCustomCheckboxValue(),
                'label' => $this->getPost($this->getCustomTextName()),
            ];
        }

        $result = parent::isValidOption($varInput);

        $this->arrOptions = $prevOptions;

        return $result;
    }

    protected function getOptions()
    {
        if ($this->addCustomOption) {
            $this->arrOptions[] = [
                'value' => $this->getCustomCheckboxValue(),
                'label' => $GLOBALS['TL_LANG']['MSC']['formFieldCustomLabel'],
            ];
        }

        $options = parent::getOptions();

        foreach ($options as &$option) {
            if ($option['value'] === $this->getCustomCheckboxValue()) {
                $option['type'] = 'custom';
                $option['checked'] = $this->isValidOption($this->varValue) || !$this->varValue ? '' : ' checked';
                $option['custom_name'] = $this->getCustomTextName();
                $option['custom_value'] = $this->isValidOption($this->varValue) ? '' : $this->varValue;
            }
        }

        return $options;
    }

    protected function getCustomCheckboxValue()
    {
        return 'custom'.$this->id;
    }

    protected function getCustomTextName()
    {
        return $this->strName.'_custom'.$this->id;
    }
}
