<?php

namespace App\Livewire;

use Livewire\Component;

class Short extends Component
{
    protected $listeners = ['openModal' => 'open'];
    public $show = false; // Flag per aprire/chiudere il modale
    public $content, $total, $current;
    public function open($content = null, $total = null, $current = null)
    {
        $this->content = $content;
        $this->total = $total;
        $this->current = $current;
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }
    public function render()
    {
        return view('livewire.short');
    }
}
