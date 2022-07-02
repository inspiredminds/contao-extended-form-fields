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

use Contao\Date;

class FormText extends \Contao\FormTextField
{
    protected const HTML5_DATE_FORMAT = 'Y-m-d';

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

        if ('date' === $this->rgxp) {
            $targetFormat = Date::getNumericDateFormat();

            // Check if date format matches the HTML5 standard
            if (self::HTML5_DATE_FORMAT !== $targetFormat && preg_match('~^'.Date::getRegexp(self::HTML5_DATE_FORMAT).'$~i', $value)) {
                // Transform to defined date format
                $date = \DateTimeImmutable::createFromFormat(self::HTML5_DATE_FORMAT, $value);
                $value = $date->format($targetFormat);
            }
        }

        return parent::validator($value);
    }
}
