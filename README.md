
![code score](https://api.codiga.io/project/16386/score/svg) ![code grade](https://api.codiga.io/project/16386/status/svg)

# CI4-Breadcrumbs
Simple breadcrumb library for Codeigniter 4

## V3.0 Coming Soon
With support for generating breadcrumbs for the major css frame works.

## V2.0.3 Released
Version 2.0.3 has had a few major changes. Mainly on how you install the library. The entire library has been re-packaged and now has support to publish the core file to your application.

The publishing command will create a new directly called 'modules' within your app folder. Why 'modules' ? Because we plan on releasing several easy to install modules that can be installed and keeps your application structure neat and organised.

You now have the options of either manually building your breadcrumbs or using the auto builder. The auto builder takes your URI string and breaks it down into a bootstrap breadcrumb.

We have also added the option to build your breadcrumbs using the awesome HalfMoon CSS framework. More CSS frameworks will be added in V3.0

### Install Via Composer

```
composer require geeklabs/ci4-breadcrumbs
```
Then run

```
php spark breadcrumbs:publish
```
You will then be asked what css frame work you are using. Please make your selection and hit enter

At the moment you have the option of Bootstrap or the awesome HalfMoon framework. More frameworks will be added in V3.0

```
What css framework are you using?:
  [0]  Bootstrap
  [1]  Halfmoon

```
Load into controller 

```
use  App\Modules\Breadcrumbs\Breadcrumbs;
```
If you dont want to publish to your project and would prefer to keep the library in your 'vendors' folder you can omit the 'php spark breadcrumbs:publish' command and use the namespace :

```
use  Geeklabs\Breadcrumbs\Core\Breadcrumbs;
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

If you want to override these styles, add additional classes etc you can do that in the __construct function of Breadcrumbs.php

More CSS framework support is being added in v3.0. If you have a specific framework you want added please submit an issue and we will add it.

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
use App\Modules\Breadcrumbs\Breadcrumbs;

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
