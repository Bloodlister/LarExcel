<?php

namespace App\Http\Controllers;

use App\Helpers\Equalizer;
use App\Helpers\Sort;
use App\QueryExecutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ouzo\Utilities\Comparator;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Ods;

class Excel extends Controller
{
    public function index() {
        return view('Excel.index');
    }

    public function test(Request $request) {
        $queryExecutor = new QueryExecutor(['tests', 'tests2']);
        $results = $queryExecutor->getResults('users', [
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

        $results = Equalizer::equalize($results, ['rating']);
        $results = Sort::sortMultipleArrays($results, [
            Comparator::compareBy('rating'),
        ]);
        
        $spreadSheet = new Spreadsheet();
        $sheet = $spreadSheet->getActiveSheet();

        $column = 1;
        foreach ($results as $result) {
            $cell = $sheet->getCellByColumnAndRow($column, 1);
            $sheet->fromArray($result, 'a', $cell->getCoordinate(), true);
            $column += 3;
        }

        $odsFile = new Ods($spreadSheet);
        $odsFile->save('excel/hello.ods');
        return response()->download('excel/hello.ods');
    }
}
