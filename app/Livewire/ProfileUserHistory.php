<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\PerfilUsuarioHistorial;

class ProfileUserHistory extends Component
{
    public $historial = [];

    public function mount()
    {
        $this->historial = PerfilUsuarioHistorial::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.profile-user-history');
    }
}
