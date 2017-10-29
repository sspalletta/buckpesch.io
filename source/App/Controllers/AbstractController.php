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
    }

}