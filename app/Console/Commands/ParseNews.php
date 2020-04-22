<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ParseNewsJob;

class ParseNews extends Command {

    protected $name = 'parse:news';

    public function handle()
    {
        dispatch(new ParseNewsJob);
    }
}
