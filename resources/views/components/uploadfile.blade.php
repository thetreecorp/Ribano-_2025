<div class="row2" io-image-input="true">
    {{ Form::label('Image', trans('Image').':', ['class' => 'form-label']) }}
    
    @if($photos)
        <input type="hidden" name="photos" wire:model="photos" value=""/>
        <img class="w-20" src="{{ Storage::disk('s3')->temporaryUrl($photos, '+5 minutes') }}" />
    @endif

    @if ($photo)
        
       
            <img class="w-20" src="{{ $photo->temporaryUrl() }}">
       
    @endif

           
    @error('photo') <span class="error">{{ $message }}</span> @enderror

    <div
        x-data="{ isUploading: false, progress: 0 }"
        x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false"
        x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
    >
        <!-- File Input -->
        <input type="file" wire:model="photo">
    
        <!-- Progress Bar -->
        <div x-show="isUploading">
            <progress max="100" x-bind:value="progress"></progress>
        </div>
    </div>

</div>