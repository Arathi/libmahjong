<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2018/12/31
 * Time: 00:41
 */

require_once __DIR__ . '/../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \Monolog\Logger;
use \Arathi\Mahjong\Models\TileCounter;

final class TileCounterTest extends TestCase
{
    public function testParse()
    {
        // 三色同刻
        $tc = TileCounter::Parse("222m222p222sEEEECC");
        $this->assertEquals(3, $tc[12]);
        $this->assertEquals(3, $tc[22]);
        $this->assertEquals(3, $tc[32]);
        $this->assertEquals(4, $tc[41]);
        $this->assertEquals(2, $tc[53]);
        $this->assertEquals(15, $tc[0]);

        try
        {
            $tc = TileCounter::Parse("55555m");
            $this->assertEquals(true, false);
        }
        catch (\Arathi\Mahjong\MahjongException $ex)
        {

        }

    }

    public function testAdd()
    {
        // 九莲宝灯9面听
        $tc = TileCounter::Parse("1112345678999m");
        // 补一张一万
        $tc->add(11, 1);
        $this->assertEquals(14, $tc[0]);
    }

    public function testDelete()
    {
        $tc = TileCounter::Parse("11m234p567s");
        // 移除雀头一万
        $tc->remove(11, 2);
        $this->assertEquals(6, $tc[0]);
    }

    public function testClone()
    {
        // 国士无双
        $tc = TileCounter::Parse("119m19p19sESWNPFC");
        $tc2 = $tc;
        $tcc = clone $tc;
        $tc->remove(11, 2);
        $tcAmount = $tc[0];
        $this->assertEquals(12, $tcAmount);

        // 检查tc2
        $tc2Amount = $tc2[0];
        $this->assertEquals(12, $tc2Amount);

        // 检查tcc
        $tccAmount = $tcc[0];
        $this->assertEquals(14, $tccAmount);
    }
}