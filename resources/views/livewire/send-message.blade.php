@livewireStyles
<div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- Display messages list -->
    <div class="messages-list">
        @foreach($messages as $message)
            <div class="message">
                <strong>{{ $message->user->name }}:</strong>
                <p>{{ $message->content }}</p>
                <small>{{ $message->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>
    <!-- Add message form -->
    <form wire:submit.prevent="send">
        
        <div class="form-group">
            <label for="message">Message</label>
            <textarea wire:model="message" class="form-control" id="message" rows="4"></textarea>
            @error('message') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
</div>
@livewireScripts