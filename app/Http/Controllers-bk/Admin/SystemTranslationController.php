<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload;
use App\Models\Language;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Imports\CSVImport;
use App\Exports\CSVExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\SystemTranslation;
use App\Imports\TranslationImport;
class SystemTranslationController extends Controller
{
    use Upload;

    public function importCSVFile(Request $request)
    {
        
        
        if($request->isMethod('post')){
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 0);
    
            $path = $request->lang_file;
    
        //     $fileCsv =  Excel::toArray( new CSVImport(),$path);
            
        //     $arrayCsv = $fileCsv[0];
    
        //     $processData = [];
    
        //     for ($i=1; $i < sizeof($arrayCsv); $i++){
    
        //         for ($j=1; $j < 18; $j++){
        //             if (!empty($arrayCsv[$i][$j] && sizeof($arrayCsv[$i]) == 18 )){
    
        //                 array_push($processData,array(
        //                     'lang' => trim($arrayCsv[0][$j]),
        //                     'lang_value' =>trim($arrayCsv[$i][$j]),
        //                     'lang_key'=> preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower(trim($arrayCsv[$i][0]))))
        //                 ));
        //             }
        //         }
    
        //     }
    
        //     $collection = collect($processData);   //turn data into collection
        //     $chunks = $collection->chunk(1000); //chunk into smaller pieces
        //    // $chunks->toArray(); //convert chunk to array
    
        //     foreach($chunks as $chunk)
        //     {
        //          foreach($chunk as $item){
    
        //             SystemTranslation::updateOrCreate($item);
        //          }
        //     }
            try {
                $fileCsv =  Excel::import(new TranslationImport, $path);
                $request->session()->flash('message', (trans('SystemTranslation keys has been imported successfully.')));
                return redirect()->back();
            } catch (\Exception $th) {
                $request->session()->flash('error', $th->getMessage());
                return redirect()->back();
            }
            
        }
        
        return view('admin.translation.index');
        
    }



    public function exportCsvFile(){

        $header = [];
        $header[0] = 'DBS';

        for ($i=1; $i<=20; $i++){
            $firstHead = SystemTranslation::where('id',$i)->select('lang')->first();
            if (!in_array($firstHead->lang,$header)){
                array_push($header,$firstHead->lang);
            }
        }


        $all_lang_key = [];

        $firstRecord = SystemTranslation::distinct('lang_key')->select('lang_key') ->get();

        foreach ($firstRecord as $item){
            array_push($all_lang_key,$item->lang_key);
        }


        $full_table = array();

        $tab =  SystemTranslation::get()->toArray();

        foreach ($all_lang_key as $item){
            $count = 1;
            $remainder = 0;
            $onerow = array();
            $onerow[$header[0]] = $item;

            for($i=0; $i<sizeof($tab); $i++){

                if ($item == $tab[$i]['lang_key']){
                    if ($count == 18){
                        $count = 1;
                    }
                    if ($tab[$i]['lang'] == $header[$count]){
                        $onerow[$header[$count]] = $tab[$i]['lang_value'];
                        $remainder++;
                    }else{
                        if ($tab[$i]['lang'] == $header[2] && $remainder == 0){
                            $onerow = array($header[0]=>$item,$header[1]=>'',$header[2]=>$tab[$i]['lang_value']) ;
                        }else{
                            $onerow[$header[$count]] = null;
                        }
                    }
                    $count++;
                }
            }
            array_push($full_table, $onerow);
        }

        return Excel::download(new CSVExport($full_table), 'system_Translation.xlsx');
    }
    
}
