<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2018/12/26
 * Time: 22:08
 */

namespace Arathi\Mahjong\Models;

class Tile
{
    const CATEGORY_MAN    = 1;
    const CATEGORY_PIN    = 2;
    const CATEGORY_SOU    = 3;
    const CATEGORY_KAZE   = 4;
    const CATEGORY_SANGEN = 5;
    // TODO 补充花牌

    const VALUE_KAZE_DON = 1;
    const VALUE_KAZE_NAN = 2;
    const VALUE_KAZE_SYA = 3;
    const VALUE_KAZE_BE  = 4;

    const VALUE_SANGEN_HAKU  = 1;
    const VALUE_SANGEN_HATSU = 2;
    const VALUE_SANGEN_CHUN  = 3;

    const STATUS_NONE    = 0;
    const STATUS_HIDE    = 1;
    const STATUS_SHOW    = 2;
    const STATUS_DISCARD = 3;

    const ORIGIN_SELF_DRAW    = 1;   // 自摸
    const ORIGIN_HAITEI       = 2;   // 海底
    const ORIGIN_RINSHAN      = 3;   // 岭上
    const ORIGIN_CHI          = 10;  // 吃
    const ORIGIN_PON_LEFT     = 11;  // 碰（上家）
    const ORIGIN_PON_OPPOSITE = 12;  // 碰（对家）
    const ORIGIN_PON_RIGHT    = 13;  // 碰（下家）
    const ORIGIN_KAN_LEFT     = 21;  // 杠（上家）
    const ORIGIN_KAN_OPPOSITE = 22;  // 杠（对家）
    const ORIGIN_KAN_RIGHT    = 23;  // 杠（下家）
    const ORIGIN_KAN          = 24;  // 杠（用于抢杠）
    const ORIGIN_ANKAN        = 25;  // 暗杠（用于国士无双抢暗杠）

    /**
     * 分类（花色）
     *
     * 1 万子 manzu characters
     * 2 筒子 pinzu dots
     * 3 索子 souzu bamboo
     * 4 风牌 kazehai winds
     * 5 箭牌/三元牌 sangenpai dragons
     *
     * @var int
     */
    public $category;

    /**
     * 数值
     *
     * 万筒索 1-9
     * 四喜
     *  1 东 ton east
     *  2 南 nan south
     *  3 西 sya west
     *  4 北 be north
     * 三元
     *  1 白 haku write pi
     *  2 发 hatsu green fa
     *  3 中 chun red chung
     *
     * @var int
     */
    public $value;

    /**
     * 序号
     *
     * 取值 0~3
     *
     * @var int
     */
    public $index;

    /**
     * 状态
     *
     * @var int
     */
    public $status;

    /**
     * 来源
     *
     * @var int
     */
    public $origin;

    /**
     * @return string
     */
    public function toString()
    {
        $sn = '';

        if ($this->category >= 1 && $this->category <=3)
        {
            $sn = $this->value;
            if ($this->category == 1) $sn .= 'm';
            if ($this->category == 2) $sn .= 'p';
            if ($this->category == 3) $sn .= 's';
        }

        if ($this->category == 4)
        {
            if ($this->value == 1) $sn = 'E';
            if ($this->value == 2) $sn = 'S';
            if ($this->value == 3) $sn = 'W';
            if ($this->value == 4) $sn = 'N';
        }

        if ($this->category == 5)
        {
            if ($this->value == 1) $sn = 'P';
            if ($this->value == 2) $sn = 'F';
            if ($this->value == 3) $sn = 'C';
        }

        return $sn;
    }

    public function getTypeId()
    {
        return $this->category * 10 + $this->value;
    }

    public function getTileId()
    {
        return $this->getTypeId() * 10 + $this->index;
    }
}