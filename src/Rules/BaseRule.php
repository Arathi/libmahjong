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
use Arathi\Mahjong\Models\TileCounter;

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
     * @param TileCounter $handTiles 手牌
     * @param array <Meld> $melts 0~4组副露
     * @param bool $pairExists
     * @return bool
     */
    public function checkNormalForm($handTiles, $melds, $pairExists = false)
    {
        $counter = [];

        // 检查雀头
        $duiziList = null;
        if ($pairExists == false)
        {
            $duiziList = $handTiles->fetchSameTiles(2);
            if (count($duiziList) == 0) return false;

            /**
             * @var Meld duizi
             */
            foreach ($duiziList as $duizi)
            {
                $leftHandTiles = clone $handTiles;
                $nextMelds = $melds; // TODO
                $leftHandTiles->remove($duizi, 2);
                $nextMelds[] = new Meld(Meld::TYPE_QUETOU, $duizi);
                $hu = $this->checkNormalForm($leftHandTiles, $nextMelds, true);
                if ($hu) return true;
            }
        }
        else
        {
            if (count($melds) == 5)
            {
                $quetou = 0;
                $mianzi = 0;

                /**
                 * @var Meld $meld
                 */
                foreach ($melds as $meld)
                {
                    if ($meld->type == Meld::TYPE_QUETOU) $quetou++;
                    else $mianzi++;
                }

                if ($quetou == 1 && $mianzi == 4) return true;
                return false;
            }

            // 检查数量，是否能被3整除，去掉雀头以后某种类型不能整除的直接pass
            $typeIds = [10, 20, 30, 41, 42, 43, 44, 51, 52, 53];
            foreach ($typeIds as $typeId)
            {
                $amount = $handTiles[$typeId];
                if ($amount % 3 != 0) return false;
            }

            // 检查刻子
            $keziList = $handTiles->fetchSameTiles(3);
            foreach ($keziList as $kezi)
            {
                $leftHandTiles = clone $handTiles;
                $nextMelds = $melds; // TODO
                $leftHandTiles->remove($kezi, 3);
                $nextMelds[] = new Meld(Meld::TYPE_KEZI, $kezi);
                $hu = $this->checkNormalForm($leftHandTiles, $nextMelds, true);
                if ($hu) return true;
            }

            // 检查顺子
            $shunziList = $handTiles->fetchSequences();
            foreach ($shunziList as $shunzi)
            {
                $leftHandTiles = clone $handTiles;
                $nextMelds = $melds; // TODO
                $leftHandTiles->remove($shunzi, 1);
                $leftHandTiles->remove($shunzi+1, 1);
                $leftHandTiles->remove($shunzi+2, 1);
                $nextMelds[] = new Meld(Meld::TYPE_SHUNZI, $shunzi);
                $hu = $this->checkNormalForm($leftHandTiles, $nextMelds, true);
                if ($hu) return true;
            }
        }

        return false;
    }

    /**
     * @param TileCounter $tileCounter
     * @return array
     */
    protected function fetchDuizi(TileCounter $tileCounter)
    {
        $duiziList = [];

        return $duiziList;
    }

    protected function fetchShunzi(TileCounter $tileCounter)
    {
        $shunziList = [];
        return $shunziList;
    }

    protected function fetchKezi(TileCounter $tileCounter)
    {
        $keziList = [];
        return $keziList;
    }

    protected function fetchGangzi(TileCounter $tileCounter)
    {
        $gangziList = [];
        return $gangziList;
    }
}