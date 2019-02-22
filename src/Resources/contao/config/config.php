<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoExtendedFormFields bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

$GLOBALS['TL_HOOKS']['validateFormField'][] = ['inspiredminds.contaocheckboxselectfield.listener.formhook', 'onValidateFormField'];
$GLOBALS['TL_HOOKS']['parseWidget'][] = ['inspiredminds.contaocheckboxselectfield.listener.formhook', 'onParseWidget'];
