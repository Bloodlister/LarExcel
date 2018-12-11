<?php

namespace App;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class QueryExecutor
{
    private $connections = [];

    public function __construct(array $connections) {
        $this->connections = $connections;
    }

    public function getResults(string $tableName, array $query) {
        $results = [];
        foreach ($this->connections as $connection) {
            $table = DB::connection($connection)->table($tableName);
            foreach ($query as $action => $params) {
                $method = "action" . strtoupper($action);
                $this->$method($table, $params);
            }
            $results[$connection] = $table->get()->toArray();
        }

        return $results;
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

    private function actionCount(Builder $table, $params) {
        $table->count($params);
    }

    private function actionLimit(Builder $table, $params) {
        $table->limit($params);
    }
}
