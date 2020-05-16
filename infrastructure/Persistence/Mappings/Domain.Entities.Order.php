<?php

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Domain\Entities\Customer;

$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('orders');
$builder->createField('id', Type::INTEGER)
    ->makePrimaryKey()
    ->generatedValue()
    ->build();

$builder->addField('amount', Type::FLOAT);

$builder->addField('date', Type::DATETIME);

$builder->addField('charged', Type::BOOLEAN);

$builder->createOneToOne('customerId', Customer::class)
    ->cascadePersist()
    ->build();
