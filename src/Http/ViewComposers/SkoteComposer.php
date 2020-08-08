<?php

namespace EvgenyBukharev\Skote\Http\ViewComposers;

use EvgenyBukharev\Skote\Skote;
use Illuminate\View\View;


class SkoteComposer
{
    /**
     * @var Skote
     */
    private $skote;

    public function __construct(Skote $skote) {
        $this->skote = $skote;
    }

    public function compose(View $view)
    {
        $view->with('skote', $this->skote);
    }
}
