<?php

namespace kojit2009\mapper;

interface EntityMappedInterface
{
    /**
     * Populate object
     *
     * @param array $row - row
     *
     * @return void
     */
    public function populate(array $row);

    /**
     * Entity Query
     *
     * @param array|null $configure - yii create object config
     *
     * @return \kojit2009\mapper\EntityQuery
     */
    public static function entityMappedQuery(array $configure = null): EntityQuery;
}
