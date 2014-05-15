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

    public function define($name, array $items, $menuTemplate = '')
    {
        $menuItems = array();
        foreach($items as $item) {
            if($item instanceof MenuItem) {
                $menuItems[] = $item;
            } else {
                $menuItems[] = $this->parser->makeFromRuleString($item);
            }
        }
        $menu = $this->repository->create($name, $menuItems);
        if($menuTemplate) {
            $menu->setMenuTemplate($menuTemplate);
        }
        return $menu;
    }

    public function menu($name, array $items = array(), $menuTemplate = '')
    {
        if(count($items) > 0) {
            return $this->define($name, $items, $menuTemplate);
        } else {
            return $this->repository->get($name);
        }
    }

    public function render($name, array $items = array(), $menuTemplate = '')
    {
        $menu = $this->menu($name, $items, $menuTemplate);
        return $menu->render();
    }
}
