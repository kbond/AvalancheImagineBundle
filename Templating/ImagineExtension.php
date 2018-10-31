<?php

namespace Avalanche\Bundle\ImagineBundle\Templating;

use Avalanche\Bundle\ImagineBundle\Imagine\CachePathResolver;

class ImagineExtension extends \Twig_Extension
{
    /**
     * @var CachePathResolver
     */
    private $cachePathResolver;

    /**
     * Constructs by setting $cachePathResolver
     *
     * @param CachePathResolver $cachePathResolver
     */
    public function __construct(CachePathResolver $cachePathResolver)
    {
        $this->cachePathResolver = $cachePathResolver;
    }

    /**
     * (non-PHPdoc)
     * @see Twig_Extension::getFilters()
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFunction('apply_filter', [$this, 'applyFilter']),
        );
    }

    /**
     * Gets cache path of an image to be filtered
     *
     * @param string $path
     * @param string $filter
     * @param boolean $absolute
     *
     * @return string
     */
    public function applyFilter($path, $filter, $absolute = false)
    {
        return $this->cachePathResolver->getBrowserPath($path, $filter, $absolute);
    }
}
