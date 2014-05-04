<?php
namespace Thepsion5\Menuizer;

class MenuizerService
{
    public function __construct(
        HtmlGenerator $htmlGenerator,
        MenuItemFactory $parser,
        MenuRepository $repository
    )
    {
        $this->htmlGenerator = $htmlGenerator;
        $this->parser = $parser;
        $this->repository = $repository;
    }

    public static function create(RouteProviderInterface $routes = null)
    {
        $urlGenerator = new UrlGenerator($routes);
        $itemFactory = new MenuItemFactory($urlGenerator);
        return new static(new HtmlGenerator, $itemFactory, new MenuRepository);
    }

    public function menu($name, array $items)
    {
        return $this->repository->create($name, $items);
    }

    public function render($name, $template = '')
    {
        $menu = $this->repository->get($name);
        if($template) {
            $menu->setItemTemplate($template);
        }
        return $menu->render();
    }
}
