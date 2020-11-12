<?php 

namespace App\libraries;

class Breadcrumb {

    private $breadcrumbs = array();
    private $tags;

    public function __construct(){

        // create our bootstrap html elements

        $this->tags['navopen']  = "<nav aria-label=\"breadcrumb\">";
        $this->tags['navclose'] = "</nav>";
        $this->tags['olopen']   = "<ol class=\"breadcrumb\">";
        $this->tags['olclose']  = "</ol>";
        $this->tags['liopen']   = "<li class=\"breadcrumb-item\">";
        $this->tags['liclose']  = "</li>";
       
    }

    public function add($crumb, $href){

        if(!$crumb OR !$href) return; // if the title or Href not set return 

        $this->breadcrumbs[] = array(
            'crumb' => $crumb,
            'href' => $href,
        );

    }
   

    public function render()
    {

        $output  = $this->tags['navopen'];
        $output .= $this->tags['olopen'];

        $count = count($this->breadcrumbs) - 1;

        foreach ($this->breadcrumbs as $index => $breadcrumb) {

            if ($index == $count) {
                $output .= $this->tags['liopen'];
                $output .= $breadcrumb['crumb'];
                $output .= $this->tags['liclose'];
            } else {
                $output .= $this->tags['liopen'];
                $output .= '<a href="' . base_url() . $breadcrumb['href'] . '">';
                $output .= $breadcrumb['crumb'];
                $output .= '</a>';
                $output .= $this->tags['liclose'];
            }
        }

        $output .= $this->tags['olclose'];
        $output .= $this->tags['navclose'];

        return $output;
    }

    
        
    

}