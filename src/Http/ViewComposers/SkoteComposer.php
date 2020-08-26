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

    /**
     * SkoteComposer constructor.
     *
     * @param Skote $skote
     */
    public function __construct(Skote $skote) {
        $this->skote = $skote;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('skote', $this->skote);
    }
}
