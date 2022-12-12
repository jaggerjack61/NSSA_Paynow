<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Livewire\Component;

class Reports extends Component
{
    public $start;
    public $end;

    public function render()
    {
        $payments=Payment::whereBetween('created_at',[$this->start,$this->end])->where('status','paid')->get();
        $total=0;
        foreach($payments as $pay){
            $total+=(float)$pay->amount;
        }
        return view('livewire.reports',compact('total'));
    }
}
