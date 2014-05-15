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

    public function define($name, array $items)
    {
        $menuItems = array();
        foreach($items as $item) {
            if($item instanceof MenuItem) {
                $menuItems[] = $item;
            } else {
                $menuItems[] = $this->parser->makeFromRuleString($item);
            }
        }
        return $this->repository->create($name, $menuItems);
    }

    public function menu($name, array $items = array())
    {
        if(count($items) > 0) {
            return $this->define($name, $items);
        } else {
            return $this->repository->get($name);
        }
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
