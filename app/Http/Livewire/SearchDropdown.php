<?php

namespace App\Http\Livewire;

use App\Models\Film;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SearchDropdown extends Component
{
    public $search = '';

    public function render()
    {
        $searchResults = [];
        if (strlen($this->search) >= 2) {
            $searchResults = Film::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('original_name', 'like', '%' . $this->search . '%')
                ->orderBy('imdb', 'desc')
                ->orderBy('views', 'desc')
                ->get();
        }
        return view('livewire.search-dropdown', [
            'searchResults' => collect($searchResults)->take(7),
        ]);
    }
}
