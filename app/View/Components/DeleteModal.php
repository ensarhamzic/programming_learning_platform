<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DeleteModal extends Component
{
    public $title;
    public $content;
    public $buttonContent;
    public $modalId;
    public $formId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $content, $buttonContent, $modalId = 'deleteModal', $formId = 'deleteForm')
    {
        $this->title = $title;
        $this->content = $content;
        $this->buttonContent = $buttonContent;
        $this->modalId = $modalId;
        $this->formId = $formId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.delete-modal');
    }
}
