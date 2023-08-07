<?php
namespace APP;

class Router {

        /**
         * @var string
         */

          /**
         * @var AltoRouter
         */

    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();
    }

    public function get(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }

    public function run()
    {
        $match = $this->router->match();
        $views = $match['target'];
        require $this->viewPath . $view . '.php';

        return $this;
    }
}