<?php

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Domain\Entities\User;


$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('customers');
$builder->createField('id', Type::INTEGER)
    ->makePrimaryKey()
    ->generatedValue()
    ->build();

$builder->addField('domain', Type::STRING);

$builder->addField('organization_name', Type::STRING);

//$builder->createOneToOne('user_id', User::class)
//    ->cascadePersist()
//    ->build();
