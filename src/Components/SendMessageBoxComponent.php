<?php

namespace Messagebox\Components;

use Illuminate\View\Component;

class SendMessageBoxComponent extends Component
{
    public function render()
    {
        return view('message-box::send-message-box');
    }
}