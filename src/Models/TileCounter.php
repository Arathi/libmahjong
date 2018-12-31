<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2018/12/30
 * Time: 11:54
 */

namespace Arathi\Mahjong\Models;

use Arathi\Mahjong\MahjongException;

class TileCounter implements \ArrayAccess
{
    protected $counter;

    public function __construct()
    {
        $this->counter = [];
    }

    /**
     * @param string $tileStr
     * @return TileCounter
     * @throws MahjongException
     */
    public static function Parse($tileStr)
    {
        $tc = new TileCounter();
        // TODO 解析
        $numbers = [];
        for ($index = 0; $index < strlen($tileStr); $index++)
        {
            $ch = $tileStr[$index];
            if ($ch >= '1' && $ch <= '9') $numbers[] = (int) $ch;
            else if ($ch == 'E') $tc->add(41, 1);
            else if ($ch == 'S') $tc->add(42, 1);
            else if ($ch == 'W') $tc->add(43, 1);
            else if ($ch == 'N') $tc->add(44, 1);
            else if ($ch == 'P') $tc->add(51, 1);
            else if ($ch == 'F') $tc->add(52, 1);
            else if ($ch == 'C') $tc->add(53, 1);
            else if ($ch == 'm')
            {
                foreach ($numbers as $n) $tc->add(10 + $n, 1);
                $numbers = [];
            }
            else if ($ch == 'p')
            {
                foreach ($numbers as $n) $tc->add(20 + $n, 1);
                $numbers = [];
            }
            else if ($ch == 's')
            {
                foreach ($numbers as $n) $tc->add(30 + $n, 1);
                $numbers = [];
            }
        }
        return $tc;
    }

    /**
     * Whether a offset exists
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        if ( $this->offsetWriteable($offset) )
        {
            return isset($this->counter[$offset]);
        }

        return false;
    }

    protected function offsetWriteable($offset)
    {
        $cat = intval($offset / 10);
        $value = intval($offset % 10);

        if ( ($cat >= 1 && $cat <= 3 && $value >= 1 && $value <= 9)
            || ($offset >= 41 && $offset <= 44)
            || ($offset >= 51 && $offset <= 53) )
        {
            return true;
        }

        return false;
    }

    /**
     * Offset to retrieve
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        $cat = intval($offset / 10);
        $value = intval($offset % 10);
        $amount = 0;

        if (isset($this[$offset]))
        {
            $amount = $this->counter[$offset];
        }

        if ($cat > 0 && $value == 0)
        {
            if ($cat >= 1 && $cat <= 3)
            {
                for ($v = 1; $v <= 9; $v++)
                    $amount += $this[$cat * 10 + $v];
            }
            if ($cat == 4)
            {
                $amount = $this[41] + $this[42] + $this[43] + $this[44];
            }
            if ($cat == 5)
            {
                $amount = $this[51] + $this[52] + $this[53];
            }
        }

        if ($offset == 0)
        {
            $amount = $this[10] + $this[20] + $this[30] + $this[40] + $this[50];
        }

        return $amount;
    }

    /**
     * Offset to set
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $amount)
    {
        if ($this->offsetWriteable($offset))
        {
            $this->counter[$offset] = $amount;
        }
    }

    /**
     * Offset to unset
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetWriteable($offset))
        {
            unset($this->counter[$offset]);
        }
    }

    /**
     * @param $tileTypeId
     * @param $amount
     * @throws MahjongException
     */
    public function add($tileTypeId, $amount)
    {
        if (isset($this[$tileTypeId]))
        {
            $this[$tileTypeId] += $amount;
            if ($this[$tileTypeId] > 4)
                throw new MahjongException("$tileTypeId 超过4枚", 1);
        }
        else $this[$tileTypeId] = $amount;
    }

    /**
     * @param $tileTypeId
     * @param $amount
     * @throws MahjongException
     */
    public function remove($tileTypeId, $amount)
    {
        if (isset($this[$tileTypeId]))
        {
            $this[$tileTypeId] -= $amount;
            if ($this[$tileTypeId] == 0)
                $this->offsetUnset($tileTypeId);
            if ($this[$tileTypeId] < 0)
                throw new MahjongException("$tileTypeId 低于0枚", 1);
        }
    }

    /**
     * 获取超过一定数量的相同牌（对子、刻子与杠子）
     * @return array
     */
    public function fetchSameTiles($limit)
    {
        $pairs = [];
        foreach ($this->counter as $typeId => $amount)
        {
            if ($amount >= $limit) $pairs[] = $typeId;
        }
        return $pairs;
    }

    /**
     * 获取顺子
     * @return array
     */
    public function fetchSequences()
    {
        $sequences = [];
        foreach ($this->counter as $typeId => $amount)
        {
            if ($typeId % 10 > 8) continue;
            if ($typeId <= 10 || $typeId >= 40) continue;
            if ($this[$typeId] > 0 && $this[$typeId+1] > 0 && $this[$typeId+2] > 0)
                $sequences[] = $typeId;
        }
        return $sequences;
    }
}