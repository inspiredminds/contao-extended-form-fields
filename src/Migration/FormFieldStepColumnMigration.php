<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Extended Form Fields extension.
 *
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoExtendedFormFieldsBundle\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\FloatType;

/**
 * Migrates the previous tl_form_field.step format to the new one.
 */
class FormFieldStepColumnMigration extends AbstractMigration
{
    public function __construct(private readonly Connection $db)
    {
    }

    public function shouldRun(): bool
    {
        $schemaManager = $this->db->createSchemaManager();

        if (!$schemaManager->tablesExist(['tl_form_field'])) {
            return false;
        }

        $columns = $schemaManager->listTableColumns('tl_form_field');

        if (!isset($columns['step'])) {
            return false;
        }

        return $columns['step']->getType() instanceof FloatType;
    }

    public function run(): MigrationResult
    {
        $values = $this->db->fetchAllAssociative('SELECT id, step FROM tl_form_field');

        $this->db->executeQuery('ALTER TABLE tl_form_field DROP step');
        $this->db->executeQuery("ALTER TABLE tl_form_field ADD step varchar(10) NOT NULL default ''");

        foreach ($values as $value) {
            if ((float) $value['step'] > 0) {
                $this->db->update('tl_form_field', ['step' => $value['step']], ['id' => $value['id']]);
            }
        }

        return $this->createResult(true);
    }
}
