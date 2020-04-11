<?php

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Domain\Entities\User;


$builder = new ClassMetadataBuilder(new ClassMetadataInfo('customer'));
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
