<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2018/12/26
 * Time: 23:02
 */

namespace Arathi\Mahjong\Rules;

use Arathi\Mahjong\GameContext;
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
}