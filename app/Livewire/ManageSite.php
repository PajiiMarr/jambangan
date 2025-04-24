<?php

namespace App\Livewire;

use Livewire\Component;

class ManageSite extends Component
{
    public $tab = 'default'; // Set a default tab or leave it blank based on your logic

    public $siteTitle;
    public $tagline;
    public $theme;
    public $menuItems;

    public function mount()
    {
        // You can initialize the properties or fetch data from the database.
        $this->siteTitle = 'My Site Title';
        $this->tagline = 'A great tagline';
        $this->theme = 'Light';
        $this->menuItems = ['Home', 'About', 'Contact'];
    }

    public function render()
    {
        return view('livewire.manage-site');
    }
}
