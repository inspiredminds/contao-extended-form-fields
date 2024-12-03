<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Extended Form Fields extension.
 *
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle\EventListener;

use Contao\Controller;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\FormFieldModel;
use Haste\Form\Form;
use Isotope\Module\Checkout;

class FormFieldVisibilityListener
{
    /**
     * @Hook("compileFormFields")
     */
    public function onCompileFormFields(array $fields): array
    {
        $return = [];

        /** @var FormFieldModel $field */
        foreach ($fields as $field) {
            if (Controller::isVisibleElement($field)) {
                $return[] = $field;
            }
        }

        return $return;
    }

    /**
     * @param Form|\Codefog\HasteBundle\Form\Form $form
     */
    public function onOrderConditions($form, Checkout $module): void
    {
        $fields = FormFieldModel::findPublishedByPid($module->iso_order_conditions);

        if (null === $fields) {
            return;
        }

        /** @var FormFieldModel $field */
        foreach ($fields as $field) {
            if (!Controller::isVisibleElement($field)) {
                $form->removeFormField($field->name);
            }
        }
    }
}
