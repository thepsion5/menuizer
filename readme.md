# Menuizer

![Build Status](https://travis-ci.org/thepsion5/menuizer.svg?branch=master)


* [Installation](#installation)
* [Getting Started](#getting-started)
* [Basic Usage](#basic-usage)
* [Available Menu Rules](#available-menu-rules)
* [Rule Shortcuts](#rule-shortcuts)
* [Advanced Usage](#advanced-usage)
* [Todo](#todo)

<a name="installation"></a>
## Installation

Add `thepsion5/menuizer` as a requirement to your `composer.json`:

````json
{
    "require": {
        "thepsion5/menuizer" : "dev-master"
    }
}
````
Then run `composer update` or `composer install`

<a name="getting-started"></a>
##Getting Started

###Vanilla PHP

Menuizer provides a convenient factory method to create a new instance of the service
````php
$menuizer = Thepsion5\Menuizer\MenuizerService::create();
````
<a name="getting-started-laravel"></a>
###Laravel
First, add Menuizer's service provider to the array of providers in `app/config/app.php`:

````php
    'providers' => array(

    // ...

    'Thepsion5\Menuizer\Support\Laravel\MenuizerServiceProvider',

    );
````
Next, add the Menuizer facade to the array of aliases in the same file:
````php
    'aliases' => array(

        // ...

        'Menuizer' => 'Thepsion5\Menuizer\Support\Laravel\Facade'
    );
````
You may now access any of the Menuizer service's functions via the facade:
````php
Menuizer::render('foo');
````

<a name="basic-usage"></a>
## Basic Usage

###Creating Menus
Menu attributes and behavior is defined using arrays of strings with a simple, easy-to-read syntax:
````php
$menuizer->define('primary', array(
    'url:/|label:Home',
    'url:/news|label:News|attributes:class=highlight,id=news',
    'url:/about|label:About Us',
    'url:/staff|label:Our Team',
    'url:/projects|label:Major Projects'
));
````
The `define()` function accepts a menu name as the first argument and an array of attributes as the second argument.

To render the defined menu, use the `render()` method:
````php
<ul class="navbar navbar-nav">
    <?= $menuizer->render('primary'); ?>
</ul>
````
By default, this will generate the following html:
````html
<ul class="nav navbar-nav">
    <li><a href="/" >Home</a></li>
    <li><a href="/news" class="highlight" id="news">News</a></li>
    <li><a href="/about" >About Us</a></li>
    <li><a href="/staff" >Our Team</a></li>
    <li><a href="/projects" >Major Projects</a></li>
</ul>
````
You can also define and render a menu with a single function call if desired:
````php
<ul class="navbar navbar-nav"> <?= $menuizer->render('primary', array(
    'url:/|label:Home',
    'url:/news|label:News|attributes:class=highlight,id=news',
    'url:/about|label:About Us',
    'url:/staff|label:Our Team',
    'url:/projects|label:Major Projects'
)); ?>
</ul>
````

<a name="available-menu-rules"></a>
##Available Menu Rules

###Url
Generates a url - this rule or one of it's equivalent [shortcuts](#rule-shortcuts) is required for a menu item to be considered valid

| Example String                               | Generated Html                                          |
| :------------------------------------------- | :------------------------------------------------------ |
| `url:/`                                      | `<a href="/"></a>`                                      |
| `url:/about-us`                              | `<a href="/about-us"></a>`                              |
| `url:#contact-form`                          | `<a href="#contact-form"></a>`                          |
| `url:/reports,category=sales,period=current` | `<a href="/reports?category=sales&period=current"></a>` |

###Route
Uses a [Route Provider](#named-route-providers) to generate a URL

| Example String                | Equivalent Function Call
| :---------------------------- | :-----------------------
| `route:home`                  | `RouteProviderInterface::getNamedRoute('home');`
| `route:reports,sales,current` | `RouteProviderInterface::getNamedRoute('reports', array('sales', 'current'));`

###Label
Used to specify the text to display for the menu item

| Example String | Generated Html        |
| :------------- | :-------------------- |
| `label:Foo`    | `<a href="/">Foo</a>` |

###Attributes
Defines any attributes other than the href on the anchor tag

| Example String                | Generated Html                           |
| :---------------------------- | :--------------------------------------- |
| `attributes:class=foo,id=bar` | `<a href="/" class="foo", id="bar"></a>` |
| `attributes:disabled`         | `<a href="/" disabled></a>`              |

<a name="rule-shortcuts"></a>
##Rule Shortcuts

In addition to the basic syntax, there are also several shortcuts that allow you to define rules more concisely

* Any rule that starts with `#`, `/`, or `?` will be interpreted as a URL rule
* The `class` and `id` will be converted to the equivalent attributes rule
* Any other rule will be interpreted as a route (if a route provider is available)

| Shortcut                | Equivalent Rule               |
| :----------             | :---------------------------- |
| `/home`                 | `url:/home`                   |
| `#contact-us`           | `url:#contact-us`             |
| `?period=current`       | `url:?period=current`         |
| `class:foo`             | `attributes:class=foo`        |
| `id:bar`                | `attributes:id=bar`           |
| `reports:sales,current` | `route:reports,sales,current` |

##Advanced Usage

<a name="named-route-providers"></a>
###Named Route Providers

Some frameworks provide for named routing functionality, where a particular url pattern is given an alias to a name
to make the organization of routes easier. Menuizer can provides a means of integrating this functionality into its
url generation.

When using this package with [Laravel](#getting-started-laravel), this functionality is provided automatically. You
can also enable this functionality by creating your own implementation of [RouteProviderInterface.php](/src/RouteProviderInterface.php).

You may then pass an instance of your implementation into the `MenuizerService::create()` function:
````php
    $menuizer = Thepsion5\Menuizer\MenuizerService::create(new FooRouteProvider);
````

##Creating Menus and Menu Item Objects
You may bypass the menuizer service class entirely to create menu instances using a more traditional OOP syntax:
````php
use Thepsion5\Menuizer\Menu;
use Thepsion5\Menuizer\MenuItem;

$items = array(
    new Menu('/', 'Home', array('class' => 'nav', 'id' => 'home')),
    new Menu('/about', 'About Us', array('class' => 'nav')),
    new Menu('contact', 'Contact Us', array('class' => 'nav')
);
$menu = new Menu('foo', $items);
````
You can also save menu instances created outside the service class via the `getRepository()` method:
````php
$menuizer->getRepository()->save($menu);
````
<a name="todo"></a>

## Todo
* Implement a better default configuration system instead of using class variables
* More features
* More documentation
