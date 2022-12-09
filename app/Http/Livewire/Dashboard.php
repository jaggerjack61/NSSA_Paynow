<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $payments=Payment::paginate(30);
        return view('livewire.dashboard',compact('payments'));
    }
}
