<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MpesaPayment extends Component
{
    public $phone;
    public $amount;
    public function render()
    {
        
        return view('livewire.mpesa-payment');
    }

    public function processpayment(){
        dd('12324');

    }
}
