<?php
/**
 * Created by PhpStorm.
 * User: s.buckpesch
 * Date: 05.09.2016
 * Time: 12:49
 */

namespace App\Controllers;


use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;

abstract class AbstractController {

    /** @var  Request */
    protected $request;

    /** @var  Response */
    protected $response;

    /** @var  Container */
    protected $container;

    /** @var  Twig */
    protected $view;

    /** @var  TagAwareAdapter */
    protected $adapter;

    /**
     * AbstractController constructor.
     *
     * @param Request $request
     * @param Response $response
     * @param Container $container
     */
    public function __construct(Request $request, Response $response, Container $container) {
        $this->request   = $request;
        $this->response  = $response;
        $this->container = $container;
        $this->view      = $container['view'];

        // Check if redis configuration is available
        $redisConfig = $container->get('redis');
        if (isset($redisConfig, $redisConfig['host'])) {
            $defaultLifetime = 3600;
            $port            = isset($redisConfig['port']) ? $redisConfig['port'] : 6379;
            $redisConnection = RedisAdapter::createConnection('redis://' . $redisConfig['host'] . ':' . $port);
            $adapter         = new RedisAdapter($redisConnection, 'aa_contest', $defaultLifetime);
            // Convert Cache adapter to Tag aware adapter
            $this->adapter = new TagAwareAdapter($adapter);
        }
    }

}