<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2018/12/26
 * Time: 22:53
 */

namespace Arathi\Mahjong\Models;

class Player
{
    public $hands;

    public $discards;

    /**
     */
    public $wind;

    /**
     * 分数
     * @var int
     */
    public $score;

    /**
     * 门前清标记
     *
     * 初始值true，鸣牌后设置为false
     *
     * @var bool
     */
    public $closedFlag;

    /**
     * 立直巡数【日麻】
     *
     * 初始值0，宣告立直成功后设置为当前巡数
     *
     * @var int
     */
    public $richiRound;
}