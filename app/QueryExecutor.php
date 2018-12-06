<?php

namespace App;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class QueryExecutor
{

    public function getResults(string $mysqlConnection, string $table, array $query, string $returnFunction) {
        $table = DB::connection($mysqlConnection)->table($table);
        foreach ($query as $action => $params) {
            $method = "action" . strtoupper($action);
            $this->$method($table, $params);
        }

        return $table->$returnFunction();
    }

    private function actionSelect(Builder $table, $params) {
        $table->select(...$params);
    }

    private function actionJoin(Builder $table, $params) {
        $table->join($params['table'], $params['first'], $params['compare'], $params['second']);
    }

    private function actionWhere(Builder $table, $params) {
        if (isset($params['first'])) {
            $table->where($params['first'], $params['compare'], $params['second']);
        } else if(array_keys($params)[0] == 0) {
            $table->where($params);
        }
    }

    private function actionOrWhere(Builder $table, $params) {
        if (isset($params['first'])) {
            $table->orWhere($params['first'], $params['compare'], $params['second']);
        } else if(array_keys($params)[0] == 0) {
            $table->orWhere($params);
        }
    }

    private function actionGroupBy(Builder $table, $params) {
        $table->groupBy(...$params);
    }

    private function count(Builder $table, $params) {
        $table->count($params);
    }
}
