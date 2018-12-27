<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2018/12/26
 * Time: 23:02
 */

namespace Arathi\Mahjong\Rules;

use Arathi\Mahjong\GameContext;
use Arathi\Mahjong\Models\Meld;
use Arathi\Mahjong\Models\Player;
use Arathi\Mahjong\Models\Tile;

abstract class BaseRule
{
    public function checkFanns(
        GameContext $context,
        Player $player,
        Tile $tile,
        $origin)
    {
        //
    }

    /**
     * 比较
     * @param Tile $t0
     * @param Tile $t1
     * @return int
     */
    public static function TileSortRuler($t0, $t1)
    {
        $cateDiff = $t0->category - $t1->category;
        if ($cateDiff != 0) return $cateDiff * 10;

        $valueDiff = $t0->value - $t1->value;
        return $valueDiff;
    }

    public function sortTiles($tiles)
    {
        $sorted = $tiles;
        uasort($sorted, ['BaseRule', 'TileSortRuler']);
        return $sorted;
    }

    // 四面子一雀头牌型

    /**
     * @param array <Tile> $handTiles 手牌
     * @param array <Tile> $melts 0~4组副露
     * @param bool $pairExists
     * @return bool
     */
    public function checkNormalForm($handTiles, $melts, $pairExists = false)
    {
        $counter = [];

        // 检查雀头
        $duiziList = null;
        if ($pairExists == false)
        {
            $duiziList = $this->fetchDuizi($handTiles);
            if (count($duiziList) == 0) return false;

            /**
             * @var Meld duizi
             */
            foreach ($duiziList as $duizi)
            {
                // TODO 移除掉其中一组雀头
                $leftHandTiles = $handTiles;
                $hu = $this->checkNormalForm($leftHandTiles, $melts, true);
                if ($hu) return true;
            }
        }

        return false;
    }

    /**
     * @param $tileIdList
     * @return array <Melt>
     */
    protected function fetchDuizi($tileIdList)
    {
        $duiziList = [];

        return $duiziList;
    }

    protected function fetchShunzi($tileIdList)
    {
        $shunziList = [];
        return $shunziList;
    }

    protected function fetchKezi($tileIdList)
    {
        $keziList = [];
        return $keziList;
    }

    protected function fetchGangzi($tileIdList)
    {
        $gangziList = [];
        return $gangziList;
    }
}