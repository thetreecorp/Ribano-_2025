<!-- livewire/tags-input.blade.php (View) -->

<div>
    <select wire:model="selectedTags" multiple>
        @foreach ($tags as $index => $tag)
        <input type="text" value="{{ $tag }}" wire:key="tag-{{ $index }}">
        @endforeach
    </select>
    <input type="text" wire:model="newTag" @keydown.enter="addNewTag">
</div>

<script>
    document.addEventListener('livewire:load', function () {
        $('.select2').select2();
        
        Livewire.hook('message.processed', (message, component) => {
            $('.select2').select2();
        });
    });
</script>