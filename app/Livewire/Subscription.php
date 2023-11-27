<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Subscription extends Component
{
    public function getDefaultPaymentMethodProperty()
    {
        return auth()->user()->defaultPaymentMethod();
    }

    public function newSubscription($plan)
    {
        //dd($plan);
        if (! $this->defaultPaymentMethod) {
            //$this->emit('error','¡No tienes un método de pago por defecto!');
            session()->flash('error', 'No tienes un metodo de pago por defecto');
            return;
        }
       
       //suscribirse
        //auth()->user()->newSubscription('Cuso Suscripciones',$plan)->create($this->defaultPaymentMethod->id);

        //capturar error
        try{
            if(auth()->user()->subscribed('parcial')){
                auth()->user()->subscription('parcial')->swap($plan);
                return;
            }
            auth()->user()->newSubscription('parcial',$plan)->create($this->defaultPaymentMethod->id);
            
            auth()->user()->refresh();

            //------------EL PLAN ES FOTOGRAFO--------------//
            if($plan ==='price_1OHAbwIb7vg6dnmcDPJgYEbs'){
                $user = Auth::user();
                $user->update(['rol_id' => 2]);
                $user->roles()->detach();
                $user->syncRoles(2);
            }
            //------------EL PLAN ES ORGANIZADOR--------------//
            if($plan ==='price_1OHAbxIb7vg6dnmckOXDbIBS'){
                $user = Auth::user();
                $user->update(['rol_id' => 1]);
                $user->roles()->detach();
                $user->syncRoles(1);
            }

        }catch (\Exception $e) {    
            session()->flash('error', 'El intento de pago fallo debido a un metodo de pago no valido');
        }
    }

    //canelar subscripcion
    public function cancelSubscription(){
        auth()->user()->subscription('parcial')->cancel();
    }

    //reanudar subscription
    public function resumeSubscription(){
        auth()->user()->subscription('parcial')->resume();
    }
    
    public function render()
    {
        return view('livewire.subscription');
    }
}
