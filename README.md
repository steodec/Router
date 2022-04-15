# Router

A simple anotation router for PHP8.

## Installation

Use the package manager [composer](https://getcomposer.org/) to install Router.

```bash
composer require Steodec\Router
```

## Usage

`index.php`

```php
namespace Steodec\App;

use Steodec\Router

/**
* @params string namespace
 */
RouterConfig::run("Steodec\Controllers");

```
---
`controller.php`

```php
namespace Steodec\Controllers;

use Steodec\Router

class Home {
   
    #[Routes(method:'GET', path: "/")]
    public function index() {
        echo "Hello World";
    }
}
```
## Documentation

The Route attribute can take several parameters

>`method`: `"GET" | "PUT" | "POST" | "DELETE"`

> path: it is a string "/" it can take parameters ": parameter"
>> Example: `"/user/:id"`

> is_granted: Takes a string as a parameter, work if you have roles system

## License

[MIT]()