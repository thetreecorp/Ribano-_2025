<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class Uploadfile extends Component
{
    use WithFileUploads;
    public $photo ;
    public $photos;
   
    public function mount($photos){
        if($photos != ''){
            $this->photos = $photos;
        }
    }
    public function updatedPhoto($photo){

       $this->photos = $photo->getRealPath();
    }
    public function render(){ 
        return view('components.uploadfile');
    }
}