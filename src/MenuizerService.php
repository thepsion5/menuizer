<?php
namespace Thepsion5\Menuizer;

use Thepsion5\Menuizer\ConfigRepository\ConfigRepository,
    Thepsion5\Menuizer\ConfigRepository\ConfigRepositoryInterface,
    Thepsion5\Menuizer\MenuRepository\MenuRepository,
    Thepsion5\Menuizer\MenuRepository\MenuRepositoryInterface;

class MenuizerService
{
    public function __construct(
        ConfigRepositoryInterface $config,
        HtmlGenerator $htmlGenerator,
        MenuItemFactory $parser,
        MenuRepositoryInterface $repository
    )
    {
        $this->setConfig($config);
        $this->htmlGenerator = $htmlGenerator;
        $this->parser = $parser;
        $this->setRepository($repository);
    }

    /**
     * @param RouteProviderInterface $routes
     * @return static
     */
    public static function create(RouteProviderInterface $routes = null)
    {
        $urlGenerator = new UrlGenerator($routes);
        $itemFactory = new MenuItemFactory($urlGenerator);
        return new static(new ConfigRepository, new HtmlGenerator, $itemFactory, new MenuRepository);
    }

    /**
     * Sets a configuration value if $value is not null, or retrieves the current value
     * @param string $category  The category of the configuration field to set or retrieve
     * @param string $key       The field to set or retrieve
     * @param mixed|null $value The value to set, if supplied
     * @return mixed
     */
    public function config($category, $key, $value = null)
    {
        if($value) {
            $this->config->set($category, $key, $value);
        } else {
            $value = $this->config->get($category, $key);
        }
        return $value;
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

    public function getRepository()
    {
        return $this->repository;
    }

    public function setRepository(MenuRepositoryInterface $repo)
    {
        $this->repository = $repo;
    }

    public function setConfig(ConfigRepositoryInterface $config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }
}
