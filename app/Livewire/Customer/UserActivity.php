<?php

namespace App\Livewire\Customer;

use Livewire\Component;

use App\Models\Order;
use App\Models\Consultation;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class UserActivity extends Component
{
    
        public $activeTab = 'orders';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function deleteOrder($orderId)
    {
        Order::where('id', $orderId)
            ->where('customer_id', Auth::id())
            ->where('status', 'pending')
            ->delete();
    }

    public function deleteConsultation($consultationId)
    {
        Consultation::where('_id', $consultationId)
            ->where('customer_id', Auth::id())
            ->where('status', 'pending')
            ->delete();
    }

    public function render()
    {
        return view('livewire.customer.user-activity', [
            'orders' => Order::with('orderItems')->where('customer_id', Auth::id())->get(),
            'consultations' => Consultation::where('customer_id', Auth::id())->get(),
        ]);
    }
}
