<div>
    <x-filament::modal wire:model="open">
        <x-slot name="title">
            Post Details
        </x-slot>

        <x-slot name="content">
            <p><strong>Title:</strong> {{ $post->title }}</p>
            <p><strong>Slug:</strong> {{ $post->slug }}</p>
            <p><strong>Category:</strong> {{ $post->category->name }}</p>
            <p><strong>Author:</strong> {{ $post->author->name }}</p>
            <p><strong>Status:</strong> {{ $post->status }}</p>
            <p><strong>Published At:</strong> {{ $post->published_at->toDateString() }}</p>
            <p><strong>Tags:</strong> {{ $post->tags->pluck('name')->implode(', ') }}</p>
            <p><strong>Content:</strong> {!! $post->content !!}</p>
        </x-slot>

        <x-slot name="footer">
            <x-filament::button wire:click="$set('open', false)" color="secondary">
                Close
            </x-filament::button>
        </x-slot>
    </x-filament::modal>
</div>
