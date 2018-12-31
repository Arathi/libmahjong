<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2018/12/31
 * Time: 15:27
 */

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Arathi\Mahjong\Rules\RichiMahjong;
use Arathi\Mahjong\Models\TileCounter;

final class BaseRuleTest extends TestCase
{
    public function testCheckNormalForm()
    {
        $rule = new RichiMahjong();

        // 役牌：白
        $tiles1 = TileCounter::Parse("22567m334455pPPP");
        $hu = $rule->checkNormalForm($tiles1, [], false);
        $this->assertEquals(true, $hu);

        // 没有断幺九的情况
        $tiles2 = TileCounter::Parse("22789m555777p123s");
        $hu = $rule->checkNormalForm($tiles2, [], false);
        $this->assertEquals(true, $hu);

        // 不能和牌，没有雀头
        $tiles3 = TileCounter::Parse("1367m2356p579sEPC");
        $hu = $rule->checkNormalForm($tiles3, [], false);
        $this->assertEquals(false, $hu);

        // 已有面子但不能和牌的情况
        $tiles4 = TileCounter::Parse("55m56sEEEW");
        $melds4 = [];

    }
}