<?php

namespace EvgenyBukharev\Skote\Traits;

/**
 * Для использования статической функции getConstData() и constantLabels()
 * Константы необходимо именовать следующим образом:
 * ТИП_ЗНАЧЕНИЕ=ЗНАЧЕНИЕ_КОНСТАНТЫ
 * Пример:
 * ```
 * const STATUS_INACTIVE = 0;
 * const STATUS_ACTIVE = 1;
 * ```
 * Далее в фунции constantLabels() необходимо указать лейб для данной константы
 * ```
 * [
 * 'STATUS_INACTIVE' => Yii::t('cms/crud', 'Inactive'),
 * 'STATUS_ACTIVE'   => Yii::t('cms/crud', 'Active'),
 * ]
 * ```
 * После чего результатом вызова getConstData('STATUS') будет массив со значениями констант и их лейблами
 * ```
 * [
 *  0=>'Inactive',
 *  1=>'Active',
 * ]
 * ```
 *
 * @package common\components
 */
trait StaticConstDataTrait
{
    /**
     * Метод получения массива с наименование констант и их лейблами
     *
     * @return array
     */
    abstract public static function constantLabels(): array;

    /**
     * Функция вывода массива констатнт с их значениями и лейблами
     * Для лейблов используется статическая функция getConstants
     *
     * @param string $name Наименование константы STATUS_[...] => STATUS
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public static function getConstData($name): array
    {
        $class = new \ReflectionClass(static::class);
        $labels = static::constantLabels();
        $result = [];

        foreach ($class->getConstants() as $const_name => $const_value) {
            if (stripos($const_name, $name . '_') === 0 && isset($labels[$const_name])) {
                $result[$const_value] = $labels[$const_name];
            }
        }

        return $result;
    }

    /**
     * Функция значения константы
     *
     * @param string $name  Наименование константы STATUS_[...] => STATUS
     *
     * @param mixed  $value Значение константы
     *
     * @param null   $default
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public static function getConstDataValue($name, $value = null, $default = null)
    {
        $class = new \ReflectionClass(static::class);
        $labels = static::constantLabels();
        $result = [];

        foreach ($class->getConstants() as $const_name => $const_value) {
            if (stripos($const_name, $name . '_') === 0 && isset($labels[$const_name])) {
                $result[$const_value] = $labels[$const_name];
            }
        }

        return isset($result[$value]) ? $result[$value] : $default;
    }
}
