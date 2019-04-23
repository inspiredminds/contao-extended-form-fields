<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoExtendedFormFields bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

/*
 * Hooks
 */
$GLOBALS['TL_HOOKS']['validateFormField'][] = ['inspiredminds.contaocheckboxselectfield.listener.formhook', 'validateMinMaxOptions'];
$GLOBALS['TL_HOOKS']['validateFormField'][] = ['inspiredminds.contaocheckboxselectfield.listener.formhook', 'validateBlacklistedWords'];
$GLOBALS['TL_HOOKS']['parseWidget'][] = ['inspiredminds.contaocheckboxselectfield.listener.formhook', 'onParseWidget'];

/*
 * Form fields
 */
$GLOBALS['TL_FFL']['radio'] = \InspiredMinds\ContaoExtendedFormFieldsBundle\Form\FormRadioButton::class;
