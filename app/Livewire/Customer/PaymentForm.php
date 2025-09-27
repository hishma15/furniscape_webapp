<?php

namespace App\Livewire\Customer;

use Livewire\Component;

use App\Models\Payment;

class PaymentForm extends Component
{

    public $payment_method;
    public $card_number;
    public $expiry_date;
    public $cvv;
    public $amount;
    public $order_id;

    protected function rules()
    {
        $rules = [
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
            'amount' => 'required|numeric|min:0',
            'order_id' => 'required|exists:orders,id',
        ];

        if ($this->payment_method === 'credit_card') {
            $rules['card_number'] = 'required|digits_between:13,19';
            $rules['expiry_date'] = 'required|string|size:5';
            $rules['cvv'] = 'required|digits_between:3,4';
        }

        return $rules;
    }

    public function mount($order_id, $amount)
    {
        $this->order_id = $order_id;
        $this->amount = $amount;
    }

    public function processPayment()
    {
        $this->validate();

        // Manual expiry_date format validation (MM/YY)
        if ($this->payment_method === 'credit_card') {
            if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $this->expiry_date)) {
                $this->addError('expiry_date', 'Expiry date must be in MM/YY format.');
                return; // stop processing if invalid
            }
        }

        // Simulate payment success (no real processing)
        Payment::create([
            'payment_method' => $this->payment_method,
            'status' => 'completed',
            'amount' => $this->amount,
            'payment_date' => now(),
            'order_id' => $this->order_id,
        ]);

        // Trigger invoice PDF download or redirect
        session()->flash('success', 'Payment completed successfully!');

        return redirect()->route('order-success', ['order' => $this->order_id]);
    }

    public function render()
    {
        return view('livewire.customer.payment-form');
    }
}
