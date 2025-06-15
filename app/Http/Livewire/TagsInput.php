<?php

// TagsInput.php (Livewire Component)
namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Project;
use App\Models\Product;
use Livewire\WithFileUploads;
use Illuminate\Support\Facade;

class TagsInput extends Component
{
    public $selectedTags = [];
    public $newTag = '';

    public function updatedSelectedTags()
    {
        // Xử lý logic khi người dùng thay đổi các tags đã chọn
    }

    public function addNewTag()
    {
        if (!empty($this->newTag)) {
            $this->selectedTags[] = $this->newTag;
            $this->newTag = '';
        }
    }

    public function render()
    {
        $tags = ['tag1', 'tag2', 'tag3']; // Thay bằng dữ liệu thực tế từ controller hoặc database
        return view('livewire.tags-input', compact('tags'));
    }
}
