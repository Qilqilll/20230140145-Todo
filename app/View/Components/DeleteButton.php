<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteButton extends Component
{
    public string $url;
    public string $confirmMessage;

    /**
     * Create a new component instance.
     */
    public function __construct(string $url, string $confirmMessage = 'Are you sure you want to delete this item?')
    {
        $this->url = $url;
        $this->confirmMessage = $confirmMessage;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delete-button');
    }
}
