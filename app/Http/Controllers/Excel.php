<?php

namespace App\Http\Controllers;

use App\Helpers\Equalizer;
use App\Helpers\Sort;
use App\QueryExecutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ouzo\Utilities\Comparator;

class Excel extends Controller
{
    public function index() {
        return view('Excel.index');
    }

    public function test(Request $request) {
        $queryExecutor = new QueryExecutor(['tests', 'tests2']);
        $result = $queryExecutor->getResults('users', [
            'select' => [
                'rating',
                DB::raw('COUNT(*) as user_count')
            ],
            'where' => [
                [ 'rating', '>', 3.5]
            ],
            'groupBy' => ['rating'],
            'limit' => 20
        ]);

        $result = Equalizer::equalize($result, ['rating']);
        $result = Sort::sortMultipleArrays($result, [
            Comparator::compareBy('rating'),
        ]);
        var_dump($result); exit();
        
//        $spreadSheet = new Spreadsheet();
//        $sheet = $spreadSheet->getActiveSheet();
//
//        $odsFile = new Ods($spreadSheet);
//        $odsFile->save('excel/hello.ods');
//        return response()->download('excel/hello.ods');
    }
}
