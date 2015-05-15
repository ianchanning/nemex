<?php

namespace Controllers;

use Vanda\Controller;

class PagesController extends Controller
{

    public function index()
    {
        $welcome = __('Welcome to Vanda PHP');
        $this->set(compact('welcome'));
    }
}
