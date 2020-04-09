<?php

namespace Persistence\Doctrine;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class CurrentTimestampBuilder
{

    /**
     * @param $builder ClassMetadataBuilder
     *
     * @return ClassMetadataBuilder
     */
    public static function addTimestamps(ClassMetadataBuilder $builder)
    {
        $builder->addField(
            'createdAt',
            Type::DATETIME,
            [
                'nullable' => false,
                'options' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ]
            ]
        );

        $builder->addField(
            'updatedAt',
            Type::DATETIME,
            [
                'nullable' => false,
                'options' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ]
            ]
        );

        return $builder;
    }
}