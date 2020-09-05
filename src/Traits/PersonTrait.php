<?php

namespace EvgenyBukharev\Skote\Traits;

/**
 * Трейт преминимый к моделям персон
 *
 * @package binn\cms\components
 */
trait PersonTrait
{

    /**
     * Получаем фамилию
     *
     * @return string
     */
    abstract function getLastName(): string;

    /**
     * Получаем имя
     *
     * @return string
     */
    abstract function getFirstName(): string;

    /**
     * Получаем отчество
     *
     * @return string
     */
    abstract function getPatronymicName(): string;

    /**
     * Полное имя пользователя
     *
     * @param string $format
     * @param string $defaultValue
     *
     * @return string
     */
    public function getFullNameByFormat($format = 'F I O', $defaultValue = ''): string
    {
        $f = $this->getLastName();
        $i = $this->getFirstName();
        $o = $this->getPatronymicName();

        return self::getFullNameByFormatStatic($format, $f, $i, $o, $defaultValue);
    }

    /**
     * @param string $format
     * F - Фамилия, f- Ф.
     * I - Имя, i- И.
     * O - Отчество, o- О.
     *
     * @param string $F__zsdASd756sds
     * @param string $I__zsdASd756sds
     * @param string $O__zsdASd756sds
     * @param string $defaultValue
     *
     * @return string
     */
    public static function getFullNameByFormatStatic($format, $F__zsdASd756sds = '', $I__zsdASd756sds = '', $O__zsdASd756sds = '', $defaultValue = ''): string
    {
        $result = \preg_replace('/(F|I|O|f|i|o)/', '$1__zsdASd756sds', $format);

        $f__zsdASd756sds = !empty($F__zsdASd756sds) ? mb_strtoupper(mb_substr($F__zsdASd756sds, 0, 1)) . '.' : '';
        $i__zsdASd756sds = !empty($I__zsdASd756sds) ? mb_strtoupper(mb_substr($I__zsdASd756sds, 0, 1)) . '.' : '';
        $o__zsdASd756sds = !empty($O__zsdASd756sds) ? mb_strtoupper(mb_substr($O__zsdASd756sds, 0, 1)) . '.' : '';

        $arr = ['F__zsdASd756sds', 'I__zsdASd756sds', 'O__zsdASd756sds', 'f__zsdASd756sds', 'i__zsdASd756sds', 'o__zsdASd756sds'];
        for ($x = 0; $x < count($arr); $x++) {
            $arrItem = $arr[$x];
            $result = str_replace($arrItem, $$arrItem, $result);
        }

        $string = \trim(str_replace('  ', ' ', $result));

        return !empty(\trim($string)) ? $string : $defaultValue;
    }
}