![code score](https://api.codiga.io/project/16386/score/svg) ![code grade](https://api.codiga.io/project/16386/status/svg)

# CI4-Breadcrumbs
Simple breadcrumb library for Codeigniter 4

## V2.0 Released
You now have the options of either manually building your breadcrumbs or using the auto builder. The auto builder takes your URI string and breaks it down into a bootstrap breadcrumb.

### Install Via Composer

```
composer require geeklabs/ci4-breadcrumbs
```

load into controller 

```
use \Geeklabs\Breadcrumbs\Breadcrumb;
```

### Manual Install

To install simply copy the Breadcrumbs.php file to your App\Libraries folder. By default CI4-Breadcrumbs uses the namespace Geeklabs\Breadcrumbs for composer installs.
If you are manually installing please change the name space at teh top of the Breadcrumbs.php file to

```
App\Libraries
```

### Usage

Out of the box breadcrumbs are set up using Bootstrap styles ie.

```html
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Library</li>
  </ol>
</nav>
```

If you want to overide these styles, add additional classes etc you can do that in the __construct function of Breadcrumbs.php

To use the library first load it into your controller

```
use App\libraries\Breadcrumb;
```
Create an instance

```
$this->breadcrumb = new Breadcrumb();
```
## Auto Build

If you want simple breadcrumbs to auto build the breadcrumbs for you based on your URL you can do so by calling

```
$data['breadcrumbs'] = $this->breadcrumb->buildAuto();
```
Then simply echo it out in your view
```
 <?php echo $breadcrumbs; ?> 
 ```
 
 ### Done! That simple.
 
 Well almost. Now your breadcrumbs are being generated automatically based on your URI you need to make some extra conciderations when you are building out your routes. For example if you have a route like 
 
```
 $routes->add('admin/customers/profile', 'Controller::index')
```
 your breadcrumb will be
 
 ```
 Admin / Customer / Profile
 ```
 So admin and customer must also have a route set for them.
 
 If you want your breadcrumbs to remain readable you can add a - in your URI segement to force a space ie
 
 ```
 edit-customer = Edit Customer
 ```
 
 ## Manual Build
 
 If you want a little bit more control over your breadcrumbs you can still build them manually.

Build your breadcrumbs

```php
 $this->breadcrumb->add('Home', '/');
 $this->breadcrumb->add('Dashboard', '/dashboard');  
 $this->breadcrumb->add('Customers', '/customers');  
```
 
 ensure to include the / before your url
 
 Build the breadcrumbs using
 
 ```
 $data['breadcrumbs'] = $this->breadcrumb->render();
 ```
 
 Pass the data to your view and then 
 
 ```
 <?php echo $breadcrumbs; ?>
 ```
 
 Example controller :
 
 ```php
 namespace App\Controllers;

use CodeIgniter\Controller;
use App\libraries\Breadcrumb;

class Home extends Controller{

    public $breadcrumb;

    public function __construct()
    {        
        $this->breadcrumb = new Breadcrumb();
    }

    public function index(){

        $this->breadcrumb->add('Home', '/');
        $this->breadcrumb->add('Dashboard', '/dashboard');
        $this->breadcrumb->add('Customer', '/dashboard/customer');

        $data['breadcrumbs'] = $this->breadcrumb->render();

        return view('home', $data);

    }

}
```
 
 

