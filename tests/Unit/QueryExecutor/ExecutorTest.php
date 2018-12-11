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
        $executor = new QueryExecutor(['tests']);
        $result = $executor->getResults('users', [
            'select' => [DB::raw('COUNT(*) as count')],
            'where' => [
                [ 'rating', '>', 3]
            ]
        ]);

        $this->assertTrue($result['tests'][0]->count > 0);
    }

    /**
     * @test
     */
    public function getting_result_from_multiple_tables()
    {
        $queryExecutor = new QueryExecutor(['tests', 'tests2']);
        $results = $queryExecutor->getResults('users', [
            'select' => [DB::raw('COUNT(*) as user_count')],
            'where' => [
                ['rating', '>', 3.5]
            ],
            'groupBy' => [ 'rating' ],
            'limit' => 20
        ]);

        foreach ($results as $result) {
            $this->assertTrue(count($result) > 1);
        }
    }
}