<?php

namespace kojit2009\mapper;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\Query;

class EntityQuery extends Query
{
    /**
     * Конфигурация объекта
     *
     * @var array|string|null
     */
    public $configure;

    /**
     * {@inheritdoc}
     *
     * @throws \yii\base\InvalidConfigException
     *
     * @return void
     */
    public function init()
    {
        if ($this->configure === null) {
            throw new InvalidConfigException('Invalid populatedModel property');
        }

        if (is_string($this->configure)) {
            $this->configure = ['class' => $this->configure];
        }

        if (!is_array($this->configure)) {
            throw new InvalidConfigException('Invalid populatedModel property');
        }

        parent::init();
    }

    /**
     * Populate
     *
     * @param array $rows - rows
     *
     * @return array
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function populate($rows): array
    {
        if (empty($rows)) {
            return [];
        }

        return $this->createModels($rows);
    }

    /**
     * Converts found rows into model instances
     *
     * @param array $rows - rows
     *
     * @return array
     *
     * @throws \yii\base\InvalidConfigException
     */
    private function createModels($rows): array
    {
        $models = [];

        foreach ($rows as $row) {
            $model = Yii::createObject($this->configure);
            $model->populate($row);

            if ($this->indexBy === null) {
                $models[] = $model;
            } else {
                if (is_string($this->indexBy)) {
                    $key = $model->{$this->indexBy};
                } else {
                    $key = call_user_func($this->indexBy, $model);
                }

                $models[$key] = $model;
            }
        }

        return $models;
    }
}
