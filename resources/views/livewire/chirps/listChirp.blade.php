<?php

use App\Models\Chirp; 
use Illuminate\Database\Eloquent\Collection; 
use Livewire\Attributes\On; 
use Livewire\Volt\Component;

new class extends Component {
    public Collection $chirps; 

    public ?Chirp $editing = null; 
 
    public function mount(): void
    {
        $this->getChirps(); 
    } 
    #[On('chirp-created')]
    public function getChirps(): void
    {
        $this->chirps = Chirp::with('user')
            ->latest()
            ->get();
    }

     public function edit(Chirp $chirp): void
    {
        $this->editing = $chirp;
 
        $this->getChirps();
    }
    #[On('chirp-edit-canceled')]
    #[On('chirp-updated')] 
    public function disableEditing(): void
    {
        $this->editing = null;
 
        $this->getChirps();
    } 

    public function delete(Chirp $chirp): void
    {
        $this->authorize('delete', $chirp);
 
        $chirp->delete();
 
        $this->getChirps();
    } 
}; ?>


<div class="m-5 bg-white shadow-sm rounded-lg divide-y-4"> 
    @foreach ($chirps->take(15) as $chirp)
    
        <div class="p-3 flex space-x-2" wire:key="{{ $chirp->id }}">
            <img class="rounded-full h-10 w-10" src="{{ asset('storage/' . $chirp->user->avatar) }}">
            <div class="flex-1">
                <div class="flex justify-between items-center mt-1 ml-2">
                    <div>
                        <strong><span class="text-gray-800">{{ $chirp->user->name }}</span></strong>
                        <small class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                        @unless ($chirp->created_at->eq($chirp->updated_at))
                            <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                        @endunless
                    </div>
                     @if ($chirp->user->is(auth()->user()))
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link wire:click="edit({{ $chirp->id }})">
                                    {{ __('Edit') }}
                                </x-dropdown-link>
                                <x-dropdown-link wire:click="delete({{ $chirp->id }})" wire:confirm="Are you sure to delete this chirp?"> 
                                    {{ __('Delete') }}
                                </x-dropdown-link> 
                            </x-slot>
                        </x-dropdown>
                    @endif
                </div>
                @if ($chirp->is($editing)) 
                    <livewire:chirps.edit :chirp="$chirp" :key="$chirp->id" />
                @else
                    <p class="pb-1 mb-1 pr-5 mt-2 text-lg text-gray-900 text-justify">{{ $chirp->message }}</p>
                @endif
            </div>
        </div>
    @endforeach 
</div>
