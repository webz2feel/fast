<?php

namespace Fast\SeoHelper\Entities;

use Fast\SeoHelper\Contracts\Entities\MiscTagsContract;

class MiscTags implements MiscTagsContract
{

    /**
     * Current URL.
     *
     * @var string
     */
    protected $currentUrl = '';

    /**
     * Meta collection.
     *
     * @var \Fast\SeoHelper\Contracts\Entities\MetaCollectionContract
     */
    protected $meta;

    /**
     * Make MiscTags instance.
     */
    public function __construct()
    {
        $this->meta = new MetaCollection;
        $this->addCanonical();
        $this->addMany(config('packages.seo-helper.general.misc.default', []));
    }

    /**
     * Get the current URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->currentUrl;
    }

    /**
     * Set the current URL.
     *
     * @param  string $url
     *
     * @return \Fast\SeoHelper\Entities\MiscTags
     */
    public function setUrl($url)
    {
        $this->currentUrl = $url;
        $this->addCanonical();

        return $this;
    }

    /**
     * Make MiscTags instance.
     *
     * @param  array $defaults
     *
     * @return \Fast\SeoHelper\Entities\MiscTags
     */
    public static function make(array $defaults = [])
    {
        return new self();
    }

    /**
     * Add a meta tag.
     *
     * @param  string $name
     * @param  string $content
     *
     * @return \Fast\SeoHelper\Entities\MiscTags
     */
    public function add($name, $content)
    {
        $this->meta->add(compact('name', 'content'));

        return $this;
    }

    /**
     * Add many meta tags.
     *
     * @param  array $meta
     *
     * @return \Fast\SeoHelper\Entities\MiscTags
     */
    public function addMany(array $meta)
    {
        $this->meta->addMany($meta);

        return $this;
    }

    /**
     * Remove a meta from the meta collection by key.
     *
     * @param  array|string $names
     *
     * @return \Fast\SeoHelper\Entities\MiscTags
     */
    public function remove($names)
    {
        $this->meta->remove($names);

        return $this;
    }

    /**
     * Reset the meta collection.
     *
     * @return \Fast\SeoHelper\Entities\MiscTags
     */
    public function reset()
    {
        $this->meta->reset();

        return $this;
    }

    /**
     * Render the tag.
     *
     * @return string
     */
    public function render()
    {
        return $this->meta->render();
    }

    /**
     * Render the tag.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Check if has the current URL.
     *
     * @return bool
     */
    protected function hasUrl()
    {
        return !empty($this->getUrl());
    }

    /**
     * Add the canonical link.
     *
     * @return \Fast\SeoHelper\Entities\MiscTags
     */
    protected function addCanonical()
    {
        if ($this->hasUrl()) {
            $this->add('canonical', $this->currentUrl);
        }

        return $this;
    }
}
