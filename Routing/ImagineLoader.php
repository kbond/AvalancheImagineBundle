<?php

namespace Avalanche\Bundle\ImagineBundle\Routing;

use Symfony\Component\Routing\Route;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\Loader\Loader;

class ImagineLoader extends Loader
{
    private $cachePrefix;
    private $filters;

    public function __construct($cachePrefix, array $filters = array())
    {
        $this->cachePrefix = $cachePrefix;
        $this->filters     = $filters;
    }

    public function supports($resource, $type = null)
    {
        return $type === 'imagine';
    }

    public function load($resource, $type = null)
    {
        $requirements = array('filter' => '[A-z0-9_\-]*', 'path' => '.+');
        $defaults     = array('_controller' => 'imagine.controller:filter');
        $routes       = new RouteCollection();

        if (count($this->filters) > 0) {
            foreach ($this->filters as $filter => $options) {
                if (isset($options['path'])) {
                    $path = '/'.trim($options['path'], '/').'/{path}';
                } else {
                    $path = '/'.trim($this->cachePrefix, '/').'/{filter}/{path}';
                }

                $routes->add('_imagine_'.$filter, new Route(
                    $path,
                    array_merge( $defaults, array('filter' => $filter)),
                    $requirements,
                    array(),
                    '',
                    array(),
                    array('GET')
                ));
            }
        }

        return $routes;
    }
}
