<?php

namespace App\Handler\Book;


use Illuminate\Support\Facades\Log;

class Printer extends AbstractHandler
{
    public function handle($request)
    {
        Log::info($request);
        parent::handle($request);
    }
}