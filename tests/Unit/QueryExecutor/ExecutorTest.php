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
        $result = $executor->getResults('tests', 'users', [
            'select' => [DB::raw('COUNT(*) as count')],
            'where' => [
                [ 'rating', '>', 3.5]
            ]
        ], 'first');

        $this->assertTrue($result->count > 0);
    }
}