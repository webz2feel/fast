<?php

namespace Fast\Gallery\Listeners;

use SiteMapManager;
use Fast\Gallery\Repositories\Interfaces\GalleryInterface;

class RenderingSiteMapListener
{
    /**
     * @var GalleryInterface
     */
    protected $galleryRepository;

    /**
     * RenderingSiteMapListener constructor.
     * @param GalleryInterface $galleryRepository
     */
    public function __construct(GalleryInterface $galleryRepository)
    {
        $this->galleryRepository = $galleryRepository;
    }

    /**
     * Handle the event.
     *
     * @return void
     * @author Imran Ali
     */
    public function handle()
    {
        SiteMapManager::add(route('public.galleries'), '2016-10-10 00:00', '0.8', 'weekly');

        $galleries = $this->galleryRepository->getDataSiteMap();

        foreach ($galleries as $gallery) {
            SiteMapManager::add(route('public.gallery', $gallery->slug), $gallery->updated_at, '0.8', 'daily');
        }
    }
}
