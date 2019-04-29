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

use Contao\Widget;

/**
 * @property string $value
 * @property string $type
 * @property int    $min
 * @property int    $max
 * @property int    $step
 */
class FormRange extends Widget
{
    /**
     * Submit user input.
     *
     * @var bool
     */
    protected $blnSubmitInput = true;

    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'form_range';

    /**
     * Error message.
     *
     * @var string
     */
    protected $strError = '';

    /**
     * The CSS class prefix.
     *
     * @var string
     */
    protected $strPrefix = 'widget widget-range';

    /**
     * Add specific attributes.
     *
     * @param string $strKey   The attribute key
     * @param mixed  $varValue The attribute value
     */
    public function __set($strKey, $varValue): void
    {
        switch ($strKey) {
            // Treat minlength/minval as min
            case 'minlength':
            case 'minval':
                $this->min = $varValue;
                break;

            // Treat maxlength/maxval as max
            case 'maxlength':
            case 'maxval':
                $this->max = $varValue;
                break;

            case 'mandatory':
                if ($varValue) {
                    $this->arrAttributes['required'] = 'required';
                } else {
                    unset($this->arrAttributes['required']);
                }
                parent::__set($strKey, $varValue);
                break;

            case 'min':
            case 'max':
                if ($varValue > 0) {
                    $this->arrAttributes[$strKey] = $varValue;
                    $this->arrConfiguration[$strKey.'val'] = $varValue;
                } else {
                    unset($this->arrAttributes[$strKey], $this->arrConfiguration[$strKey.'val']);
                }
                unset($this->arrAttributes[$strKey.'length']);
                break;

            case 'step':
                if ($varValue > 0) {
                    $this->arrAttributes[$strKey] = $varValue;
                } else {
                    unset($this->arrAttributes[$strKey]);
                }
                break;

            default:
                parent::__set($strKey, $varValue);
                break;
        }
    }

    /**
     * Return a parameter.
     *
     * @param string $strKey The parameter key
     *
     * @return mixed The parameter value
     */
    public function __get($strKey)
    {
        switch ($strKey) {
            case 'type':
                return 'range';
                break;

            default:
                return parent::__get($strKey);
                break;
        }
    }

    /**
     * Generate the widget and return it as string.
     *
     * @return string The widget markup
     */
    public function generate()
    {
        return sprintf('<input type="%s" name="%s" id="ctrl_%s" class="range%s%s" value="%s"%s%s',
                        $this->type,
                        $this->strName,
                        $this->strId,
                        ($this->hideInput ? ' password' : ''),
                        (('' !== $this->strClass) ? ' '.$this->strClass : ''),
                        StringUtil::specialchars($this->value),
                        $this->getAttributes(),
                        $this->strTagEnding);
    }
}
