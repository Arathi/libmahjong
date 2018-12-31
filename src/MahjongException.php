<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2018/12/31
 * Time: 18:20
 */

namespace Arathi\Mahjong;

use Throwable;

/**
 * 麻将规则异常
 *
 * @package Arathi\Mahjong
 */
class MahjongException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}