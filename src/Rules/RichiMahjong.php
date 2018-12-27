<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2018/12/26
 * Time: 23:03
 */

namespace Arathi\Mahjong\Rules;

use Arathi\Mahjong\GameContext;
use Arathi\Mahjong\Models\Faan as Yaku;
use Arathi\Mahjong\Models\Player;
use Arathi\Mahjong\Models\Tile;

/**
 * 日本立直麻雀规则
 * @package Arathi\Mahjong\Rules
 */
class RichiMahjong extends BaseRule
{
    /**
     * @param GameContext $context
     * @param Player $player
     * @param Tile $tile
     * @param $origin
     * @return array
     */
    public function checkFanns(
        GameContext $context,
        Player $player,
        Tile $tile,
        $origin)
    {
        $yakus = [];

        return $yakus;
    }

    /**
     * 检查役满役
     * @return array
     */
    public function checkYakumans()
    {
        //
    }

    // 国士无双（~十三面听）

    // 四暗刻（~单骑）

    // 大三元

    // 四喜和（小四喜/大四喜）

    // 字一色

    // 绿一色

    // 清老头

    // 九莲宝灯（纯正~）

    // 四杠子

    // 天和

    // 地和

    /**
     * 检查非役满役
     * @return array
     */
    public function checkYakus()
    {
        $yakus = [];

        return $yakus;
    }

    // 清一色 6 -> 5
    public function checkChinitsu($tiles)
    {
        //
    }

    // 混一色 3 -> 2
    public function checkHonitsu($tiles)
    {
        //
    }

    // 纯全带幺九 3 -> 2
    public function checkJunChan($tiles)
    {
        //
    }

    // 二杯口 3 门前役
    public function checkRyanPeiKou($tiles)
    {
        //
    }

    // 三色同顺 2 -> 1

    // 一气贯通 2 -> 1

    // 混全带幺九 2 -> 1
    public function checkChanta($tiles)
    {
        //
    }

    // 七对子 2 门前役
    public function checkChitoitsu($tiles)
    {
        $counter = [];

        /**
         * @var Tile $tile
         */
        foreach ($tiles as $tile)
        {
            $type = $tile->toString();
            if (isset($counter[$type])) $counter[$type]++;
            else $counter[$type] = 1;
        }

        if (count($counter) != 7) return false;
        foreach ($counter as $c)
        {
            if ($c != 2) return false;
        }
        return true;
    }

    // 对对和 2

    // 三暗刻 2

    // 三杠子 2

    // 三色同刻 2

    // 混老头 2

    // 小三元 2

    // 双立直 2 门前役
    public function checkWRichi(Player $player)
    {
        return $player->richiRound == 1;
    }

    // 立直 1 门前役
    public function checkRichi(Player $player)
    {
        return $player->richiRound > 1;
    }

    // 一发

    // 门前清自摸和

    // 平和

    // 断幺九
    public function checkTanyao($tiles)
    {
        /**
         * @var Tile $tile
         */
        foreach ($tiles as $tile)
        {
            // 持有字牌
            if ($tile->category == 4 || $tile->category == 5)
                return false;

            // 持有幺九
            if ($tile->category <= 3 && ($tile->value == 1 || $tile->value == 9))
                return false;
        }

        return true;
    }

    // 一杯口 1

    // 役牌 1
    public function checkYakuhai($tiles, $yakuhaiType)
    {
        $counter = 0;

        /**
         * @var Tile $tile
         */
        foreach ($tiles as $tile)
        {
            $type = $tile->toString();
            if ($type == $yakuhaiType) $counter++;
        }

        return $counter >= 3;
    }

    // 岭上开花 1

    // 抢杠 1

    // 海底摸月 1

    // 河底捞鱼 1


}