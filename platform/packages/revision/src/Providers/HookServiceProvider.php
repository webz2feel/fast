<?php

namespace Fast\Revision\Providers;

use Assets;
use Eloquent;
use Illuminate\Support\ServiceProvider;
use Throwable;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        add_filter(BASE_FILTER_REGISTER_CONTENT_TABS, [$this, 'addHistoryTab'], 55, 3);
        add_filter(BASE_FILTER_REGISTER_CONTENT_TAB_INSIDE, [$this, 'addHistoryContent'], 55, 3);
    }

    /**
     * @param $tabs
     * @param $screen
     * @return string
     *
     * @throws Throwable
     * @since 2.0
     */
    public function addHistoryTab($tabs, $screen, $data = null)
    {
        if (!empty($data) && in_array(get_class($data), config('packages.revision.general.supported', []))) {
            Assets::addScriptsDirectly([
                '/vendor/core/packages/revision/js/html-diff.js',
                '/vendor/core/packages/revision/js/revision.js',
            ])
                ->addStylesDirectly('/vendor/core/packages/revision/css/revision.css');

            return $tabs . view('packages/revision::history-tab')->render();
        }
        return $tabs;
    }

    /**
     * @param $tabs
     * @param $screen
     * @param Eloquent $data
     * @return string
     *
     * @throws Throwable
     * @since 2.0
     */
    public function addHistoryContent($tabs, $screen, $data = null)
    {
        if (!empty($data) && in_array(get_class($data), config('packages.revision.general.supported', []))) {
            return $tabs . view('packages/revision::history-content', ['model' => $data])->render();
        }
        return $tabs;
    }
}
