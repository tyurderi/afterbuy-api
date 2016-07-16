<?php

namespace TY\Afterbuy;

class Template
{

    protected $loader = null;

    protected $twig   = null;

    public function __construct($path)
    {
        $this->loader = new \Twig_Loader_Filesystem($path);
        $this->twig   = new \Twig_Environment($this->loader, array(
            'autoescape'    => false
        ));
    }

    public function render($name, $variables)
    {
        return $this->twig->render($name, $variables);
    }

    public function exists($name)
    {
        return $this->loader->exists($name);
    }

}