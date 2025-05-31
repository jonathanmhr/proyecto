<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\PerfilUsuarioHistorial;


class ProfileUserProfileForm extends Component
{
    public $fecha_nacimiento;
    public $peso;
    public $altura;
    public $objetivo;
    public $id_nivel;

    protected $rules = [
        'fecha_nacimiento' => 'required|date',
        'peso' => 'required|numeric|min:1|max:300',
        'altura' => 'required|numeric|min:30|max:250',
        'objetivo' => 'required|string|max:255',
        'id_nivel' => 'required|in:1,2,3',
    ];

    public $perfilExiste = false;

    public function mount()
    {
        $perfil = Auth::user()->perfilUsuario;

        if ($perfil) {
            $this->perfilExiste = true;

            $this->fecha_nacimiento = $perfil->fecha_nacimiento;
            $this->peso = $perfil->peso;
            $this->altura = $perfil->altura;
            $this->objetivo = $perfil->objetivo;
            $this->id_nivel = $perfil->id_nivel;
        }
    }

public function save()
{
    $this->validate();

    $perfil = Auth::user()->perfilUsuario;

    if (!$perfil) {
        $perfil = new \App\Models\PerfilUsuario();
        $perfil->id_usuario = Auth::id();
    }

    $perfil->fecha_nacimiento = $this->fecha_nacimiento;
    $perfil->peso = $this->peso;
    $perfil->altura = $this->altura;
    $perfil->objetivo = $this->objetivo;
    $perfil->id_nivel = $this->id_nivel;

    $perfil->save();

    // Guardar historial
    PerfilUsuarioHistorial::create([
        'user_id' => Auth::id(),
        'fecha_nacimiento' => $this->fecha_nacimiento,
        'peso' => $this->peso,
        'altura' => $this->altura,
        'objetivo' => $this->objetivo,
        'id_nivel' => $this->id_nivel,
    ]);

    session()->flash('message', 'Perfil extendido actualizado correctamente.');
}

    public function render()
    {
        return view('livewire.profile-user-profile-form');
    }
}
