<?php
/**
 * Created by PhpStorm.
 * User: MaiBenBen
 * Date: 2018/12/27
 * Time: 16:28
 */

namespace Arathi\Mahjong\Models;

class Meld
{
    const TYPE_KEZI = 1;    // 刻子
    const TYPE_SHUNZI = 2;  // 顺子
    const TYPE_GANGZI = 3;  // 杠子
    const TYPE_QUETOU = 4;  // 雀头

    /**
     * 面子类型
     *
     * @var int
     */
    public $type;

    /**
     * @var array
     */
    public $tiles;

    /**
     * 花色
     *
     * 能组成面子的肯定是同一种花色
     *
     * @var int
     */
    public $tileCategory;

    /**
     * 开始值
     *
     * @var int
     */
    public $startValue;

    /**
     * @var bool
     */
    public $shownFlag;
}