<?php

namespace kojit2009\mapper\example;

use kojit2009\mapper\EntityMappedInterface;
use kojit2009\mapper\EntityQuery;
use yii\base\Model;

/**
 * Class AbstractEntity
 *
 * Для произвольного маппинга значений из select в объект
 *
 * @package kojit2009\mapper
 */
abstract class AbstractEntity extends Model implements EntityMappedInterface
{
    /**
     * Entity Query
     *
     * @param array|null $configure - yii create object config
     *
     * @return EntityQuery
     */
    public static function entityMappedQuery(array $configure = null): EntityQuery
    {
        if ($configure === null) {
            $configure = ['class' => static::class];
        }

        return new EntityQuery(['configure' => $configure]);
    }

    /**
     * Populate object
     *
     * @param array $row - row
     *
     * @return void
     */
    public function populate(array $row)
    {
        foreach ($row as $key => $value) {
            if ($this->canSetProperty($key)) {
                $this->{$key} = $value;
            }
        }
    }
}
