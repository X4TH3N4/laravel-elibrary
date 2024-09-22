<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */

    public function render()
    {
        $breadcrumbs = collect(request()->segments())->map(function ($segment, $index) {
            $url = url(implode('/', array_slice(request()->segments(), 0, $index + 1)));
            $name = $this->formatSegmentName($segment);
            return (object)['url' => $url, 'name' => $name];
        });

        return view('components.breadcrumb', ['breadcrumbs' => $breadcrumbs]);
    }
    private function formatSegmentName($segment)
    {
        return ucwords(preg_replace('/(?<=\\w)([A-Z])/', ' $1', $segment));
    }

}
