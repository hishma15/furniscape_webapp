<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Models\Category;  

class Header extends Component
{

    public $categories;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Fecth all categories to be shown un dropdown
        $this->categories = Category::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header');
    }
}
