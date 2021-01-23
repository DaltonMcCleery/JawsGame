<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Profile extends Component
{
    public $user;

    protected $rules = [
        'user.name' => 'required|string|min:3',
        'user.username' => 'required|alpha_dash|min:6',
        'user.email' => 'required|email'
    ];

    public function mount() {
        $this->user = Auth::user();
    }

    public function save() {
        // Validate Request
        $this->validate();

        $this->user->save();

        session()->flash('message', 'Profile successfully updated!');
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
