<?php

namespace App\Http\Controllers;

use App\Excel\Rows\AssocRow;
use App\Excel\SpreadSheet\Linked;
use App\Excel\Tables\TableWithHeaders;
use App\QueryExecutor;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Ods;

class Excel extends Controller
{
    public function index() {
        return view('Excel.index');
    }

    public function test(Request $request) {
        $queryExecutor = new QueryExecutor(['tests', 'tests2']);
        $result = $queryExecutor->getResults('users', [
            'select' => [DB::raw('COUNT(*) as user_count')],
            'where' => [
                [ 'rating', '>', 3.5]
            ],
            'groupBy' => ['rating'],
            'limit' => 20
        ]);

        $result = Equalizer::equilize($result);

        $spreadSheet = new Spreadsheet();
        $sheet = $spreadSheet->getActiveSheet();

        $odsFile = new Ods($spreadSheet);
        $odsFile->save('excel/hello.ods');
        return response()->download('excel/hello.ods');
    }
}
