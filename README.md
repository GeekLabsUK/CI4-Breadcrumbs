# CI4-Breadcrumbs
Simple breadcrumb library for Codeigniter 4

To install simply copy the Breadcrumbs.php file to your App\Libraries folder

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

use App\libraries\Breadcrumb;

$this->breadcrumb = new Breadcrumb();

Build your breadcrumbs

 $this->breadcrumb->add('Home', '/');
 $this->breadcrumb->add('Dashboard', '/dashboard');  
 $this->breadcrumb->add('Customers', '/customers');  
 
 ensure to include the / before your url
 
 Build the breadcrumbs using
 
 $data['breadcrumbs'] = $this->breadcrumb->render();
 
 Pass the data to your view and then 
 
 <?php echo $breadcrumbs; ?>
 
 

