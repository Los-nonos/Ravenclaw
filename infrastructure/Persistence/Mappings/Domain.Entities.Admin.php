<?php

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Domain\Entities\User;
use Persistence\CurrentTimestampBuilder;


$builder = new ClassMetadataBuilder(new ClassMetadataInfo('admin'));
$builder->setTable('admins');
$builder->createField('id', Type::INTEGER)
    ->makePrimaryKey()
    ->generatedValue()
    ->build();

$builder->addField('role', Type::STRING);
