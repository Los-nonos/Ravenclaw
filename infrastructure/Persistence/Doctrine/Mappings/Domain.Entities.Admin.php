<?php

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Domain\Entities\User;
use Persistence\Doctrine\CurrentTimestampBuilder;


$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('users');
$builder->createField('id', Type::INTEGER)
    ->makePrimaryKey()
    ->generatedValue()
    ->build();

$builder->addField('role', Type::STRING);

$builder->createOneToOne('companyAdmin', User::class)
    ->cascadePersist()
    ->build();
