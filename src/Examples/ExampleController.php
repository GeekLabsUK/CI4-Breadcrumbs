<?php

/**
 * --------------------------------------------------------------------
 * CodeIgniter 4 - CI4 Breadcrumbs
 * --------------------------------------------------------------------
 *
 * This is a library for generating breadcrumb trails in CodeIgniter 4. It 
 * supports both Bootstrap and Halfmoon frameworks, and allows users to 
 * either add breadcrumbs manually or generate them automatically based on 
 * the current URL.
 *
 * @package    CI4 Breadcrumbs
 * @author     GeekLabs - Lee Skelding 
 * @license    https://opensource.org/licenses/MIT	MIT License
 * @link       https://github.com/GeekLabsUK/CI4-Breadcrumbs
 * @since      Version 2.0
 */


namespace App\Controllers;

use CodeIgniter\Controller;
use App\Modules\Breadcrumbs\Breadcrumbs;

class Home extends Controller
{
    public $breadcrumb;

    public function __construct()
    {
        $this->breadcrumbs = new Breadcrumbs();
    }

    public function index()
    {
        // Add breadcrumbs for Home, Dashboard, and Customer pages
        $this->breadcrumbs->add('Home', '/');
        $this->breadcrumbs->add('Dashboard', '/dashboard');
        $this->breadcrumbs->add('Customer', '/dashboard/customer');

        // Render the breadcrumbs and pass them to the view
        $data['breadcrumbs'] = $this->breadcrumbs->render();

        // Load the view and pass the data
        return view('home', $data);
    }
}
