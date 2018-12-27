<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2018/12/26
 * Time: 23:02
 */

namespace Arathi\Mahjong;


class GameContext
{
    /**
     * @var array
     */
    public $players;

    /**
     * @var int 场风
     */
    public $matchWind;

    /**
     * @var int 局
     */
    public $round;

    /**
     * @var int 连庄本场
     */
    public $extraRound;

    /**
     * @var int 巡
     */
    public $hand;
}