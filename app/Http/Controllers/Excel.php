<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Ods;

class Excel extends Controller
{
    public function index() {
        return view('Excel.index');
    }

    public function test(Request $request) {
        $spreadSheet = new Spreadsheet();
        $sheet = $spreadSheet->getActiveSheet();
        $sheet->getCellByColumnAndRow(1,1)->setValue($request->post('cell_data'));

        $odsFile = new Ods($spreadSheet);
        $odsFile->save('excel/hello.ods');
        return response()->download('excel/hello.ods');
    }
}
