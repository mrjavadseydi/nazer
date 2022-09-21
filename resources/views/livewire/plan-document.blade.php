<div class="text-center">
    <p class="text-2xl"><strong>{{ $image->document->title }}</strong></p>
    <div class="position-relative">
        <img src="{{ url('/uploads/' . $image->url) }}" alt="" onclick="this.requestFullscreen()">
        <span wire:key="document-{{ $image->document->id }}" wire:click="alertConfirm({{ $image->document->id }})" style="width: 24px; height: 24px; position: absolute; top: -12px; left: -12px" class="rounded-full d-flex justify-content-center align-items-center bg-danger">
            <i class="fas fa-times text-white"></i>
        </span>
    </div>
</div>

