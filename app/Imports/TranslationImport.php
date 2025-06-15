<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\SystemTranslation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class TranslationImport implements ToModel , WithBatchInserts, WithChunkReading, WithHeadingRow
{
    private $count = 0;
    public function model(array $row)
    {
        $lang_key = '';
        $item_insert = array();
        foreach ($row as $key => $value) {
            // check 
            if($key == 'dbs' && $row[$key]) {
                $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower(trim($row[$key]))));
            }
            else {
                
                $item_insert = array(
                    'lang' => trim($key),
                    'lang_value' =>trim($value),
                    'lang_key'=> $lang_key
                );
            }
            
            if(count($item_insert)) {
               SystemTranslation::updateOrCreate($item_insert);
            }
        }

        ++$this->count;
    }
    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
}
