<?php

namespace OpenCFP\Provider;

use OpenCFP\Domain\Services\ProfileImageProcessor;
use Pimple\Container;
use Silex\Application;
use Pimple\ServiceProviderInterface;

class ImageProcessorProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['profile_image_processor'] = function ($app) {
            return new ProfileImageProcessor($app->uploadPath(), $app['security.random']);
        };
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}
