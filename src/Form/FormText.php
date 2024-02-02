<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Extended Form Fields extension.
 *
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle\Form;

use Contao\Date;
use Contao\FormText as ContaoFormText;
use Contao\FormTextField;

if (class_exists(ContaoFormText::class)) {
    class FormTextBaseClass extends ContaoFormText
    {
    }
} else {
    class FormTextBaseClass extends FormTextField
    {
    }
}

class FormText extends FormTextBaseClass
{
    public const HTML5_DATE_FORMAT = 'Y-m-d';

    public function __get($key)
    {
        if ('type' === $key && 'date' === $this->rgxp) {
            return 'date';
        }

        return parent::__get($key);
    }

    protected function validator($value)
    {
        if (\is_array($value)) {
            return parent::validator($value);
        }

        if ($value && 'date' === $this->rgxp) {
            $targetFormat = Date::getNumericDateFormat();

            // Check if date format matches the HTML5 standard
            if (self::HTML5_DATE_FORMAT !== $targetFormat && preg_match('~^'.Date::getRegexp(self::HTML5_DATE_FORMAT).'$~i', $value ?? '')) {
                // Transform to defined date format
                $date = \DateTimeImmutable::createFromFormat(self::HTML5_DATE_FORMAT, $value);
                $value = $date->format($targetFormat);
            }
        }

        return parent::validator($value);
    }
}
