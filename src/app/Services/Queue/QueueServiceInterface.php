<?php
/**
 * Created by PhpStorm.
 * User: Tanat
 * Date: 27.01.2019
 * Time: 12:21
 */

namespace App\Services\Queue;


interface QueueServiceInterface
{
    public function produce($data, array $params);

    public function consume(callable $fun);
}