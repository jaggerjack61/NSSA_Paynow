<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use withPagination;

    public function render()
    {
        $payments=Payment::orderBy('created_at', 'desc')->paginate(30);
        return view('livewire.dashboard',compact('payments'));
    }
}
