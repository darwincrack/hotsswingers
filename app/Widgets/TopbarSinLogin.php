<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class TopbarSinLogin extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //
        \App::setLocale(session('lang'));
        return view("widgets.topbarsinlogin", [
            'config' => $this->config,
        ]);
    }
}