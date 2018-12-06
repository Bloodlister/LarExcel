<?php

namespace Tests\Unit;

use App\QueryExecutor;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExecutorTest extends TestCase {

    /**
     * @test
     */
    public function getting_results()
    {
        $executor = new QueryExecutor();
        $result = $executor->getResults('mysql', 'players', [
            'select' => [DB::raw('COUNT(*) as count')],
            'where' => [
                [ 'level', '>', 30]
            ]
        ], 'get');

        var_dump($result); exit();
    }
}