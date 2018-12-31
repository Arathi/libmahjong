<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2018/12/30
 * Time: 11:54
 */

namespace Arathi\Mahjong\Models;

class TileCounter implements \ArrayAccess
{
    protected $characters;  // 万
    protected $dots;        // 筒
    protected $bamboo;      // 索
    protected $winds;       // 风
    protected $dragons;     // 箭

    // protected $counter;

    public function __construct()
    {
        $this->characters = [];
        $this->dots = [];
        $this->bamboo = [];
        $this->winds = [];
        $this->dragons = [];

        // $this->counter = [];
    }

    /**
     * @param string $tileStr
     * @return TileCounter
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
        $cat = intval($offset / 10);
        $value = intval($offset % 10);

        if ($cat >= 1 && $cat <= 3 && $value >= 0 && $value <= 9) return true;
        if ($cat == 4 && $value >= 1 && $value <= 4) return true;
        if ($cat == 5 && $value >= 1 && $value <= 3) return true;

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

        if ($offset == 0)
        {
            $amount = $this[10] + $this[20] + $this[30]
                + $this[41] + $this[42] + $this[43] + $this[44]
                + $this[51] + $this[52] + $this[53];
        }

        if ($cat == 1)
        {
            if ($value >= 1 && $value <= 9)
            {
                if (isset($this->characters[$value]))
                    $amount = $this->characters[$value];
            }
            if ($value == 0)
            {
                foreach ($this->characters as $tileValue => $tileAmount)
                {
                    $amount += $tileAmount;
                }
            }
        }

        if ($cat == 2)
        {
            if ($value >= 1 && $value <= 9)
            {
                if (isset($this->dots[$value]))
                    $amount = $this->dots[$value];
            }
            if ($value == 0)
            {
                $amount = 0;
                foreach ($this->dots as $tileValue => $tileAmount)
                {
                    $amount += $tileAmount;
                }
            }
        }

        if ($cat == 3)
        {
            if ($value >= 1 && $value <= 9)
            {
                if (isset($this->bamboo[$value]))
                    $amount = $this->bamboo[$value];
            }
            if ($value == 0)
            {
                $amount = 0;
                foreach ($this->bamboo as $tileValue => $tileAmount)
                {
                    $amount += $tileAmount;
                }
            }
        }

        if ($cat == 4)
        {
            if ($value >= 1 && $value <= 4 && isset($this->winds[$value]))
                return $this->winds[$value];
        }

        if ($cat == 5)
        {
            if ($value >= 1 && $value <= 3 && isset($this->dragons[$value]))
                return $this->dragons[$value];
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
        $cat = intval($offset / 10);
        $value = intval($offset % 10);

        if ($cat == 1 && $value >= 1 && $value <= 9)
        {
            $this->characters[$value] = $amount;
        }
        if ($cat == 2 && $value >= 1 && $value <= 9)
        {
            $this->dots[$value] = $amount;
        }
        if ($cat == 3 && $value >= 1 && $value <= 9)
        {
            $this->bamboo[$value] = $amount;
        }

        if ($cat == 4 && $value >= 1 && $value <= 4)
        {
            $this->winds[$value] = $amount;
        }
        if ($cat == 5 && $value >= 1 && $value <= 3)
        {
            $this->dragons[$value] = $amount;
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
        // TODO
        $cat = intval($offset / 10);
        $value = intval($offset % 10);
    }

    public function add($tileTypeId, $amount)
    {
        if (isset($this[$tileTypeId])) $this[$tileTypeId] += $amount;
        else $this[$tileTypeId] = $amount;
    }

    public function remove($tileTypeId, $amount)
    {
        if (isset($this[$tileTypeId]))
        {
            $this[$tileTypeId] -= $amount;
            if ($this[$tileTypeId] < 0) $this[$tileTypeId] = 0;
        }
    }
}