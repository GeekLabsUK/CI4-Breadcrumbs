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


namespace Geeklabs\Breadcrumbs;

class Breadcrumbs
{

    private $breadcrumbs = array();
    private $tags;

    /**
     * Constructor function to initialize breadcrumb tags based on the given framework.
     */
    public function __construct()
    {
        // ADDED SUPPORT FOR HALFMOON FRAME WORK
        //
        // You now have the option to either use bootstrap braedcrumbs
        // or halfmoon framework breadcrumbs
        // set to either 'bootstrap' or 'halfmoon'

        $framework = 'halfmoon';

        $this->URI = service('uri');

        // SHOULD THE LAST BREADCRUMB BE A CLICKABLE LINK? If SO SET TO TRUE
        $this->clickable = true;

        if ($framework == 'bootstrap') {
            // create our bootstrap html elements
            $this->tags['navopen']  = "<nav aria-label='breadcrumb'>";
            $this->tags['navclose'] = "</nav>";
            $this->tags['olopen']   = "<ol class='breadcrumb'>";
            $this->tags['olclose']  = "</ol>";
            $this->tags['liopen']   = "<li class='breadcrumb-item'>";
            $this->tags['liclose']  = "</li>";
        }

        if ($framework == 'halfmoon') {
            // create our bootstrap html elements
            $this->tags['navopen']  = "<nav aria-label='breadcrumb'>";
            $this->tags['navclose'] = "</nav>";
            $this->tags['olopen']   = "<ul class='breadcrumb m-0'>";
            $this->tags['olclose']  = "</ul>";
            $this->tags['liopen']   = "<li class='breadcrumb-item  font-size-10'>";
            $this->tags['liclose']  = "</li>";
        }
    }


    /**
     * Adds a breadcrumb to the list of breadcrumbs.
     *
     * @param string $crumb The text for the breadcrumb.
     * @param string $href The URL for the breadcrumb.
     */
    public function add(string $crumb, string $href)
    {
        if (!$crumb || !$href) {
            // If either the title or href is not set, return without adding the breadcrumb.
            return;
        }

        $this->breadcrumbs[] = [
            'crumb' => $crumb,
            'href' => $href,
        ];
    }


    public function render()
    {
        // Initialize the output with the opening tags for the navigation and list elements
        $output  = $this->tags['navopen'];
        $output .= $this->tags['olopen'];

        // Determine the number of breadcrumbs in the array
        $count = count($this->breadcrumbs) - 1;

        // Iterate through each breadcrumb and add it to the output
        foreach ($this->breadcrumbs as $index => $breadcrumb) {
            // If this is the last breadcrumb in the array, don't include a link
            if ($index == $count) {
                $output .= $this->tags['liopen'];
                $output .= $breadcrumb['crumb'];
                $output .= $this->tags['liclose'];
            }
            // For all other breadcrumbs, include a link
            else {
                $output .= $this->tags['liopen'];
                // Use the site_url() function instead of base_url() for better security
                $output .= '<a href="' . site_url($breadcrumb['href']) . '">';
                $output .= $breadcrumb['crumb'];
                $output .= '</a>';
                $output .= $this->tags['liclose'];
            }
        }

        // Close the list and navigation elements
        $output .= $this->tags['olclose'];
        $output .= $this->tags['navclose'];

        return $output;
    }

    /**
     * Builds the breadcrumb automatically based on the current URI.
     *
     * @return string The HTML for the breadcrumb.
     */
    public function buildAuto()
    {
        $urisegments = $this->URI->getSegments();

        $output  = $this->tags['navopen'];
        $output .= $this->tags['olopen'];

        $crumbs = array_filter($urisegments);

        $result = array();
        $path = '';

        // SUBTRACT 1 FROM COUNT IF THE LAST LINK IS TO NOT BE A LINK
        $count = count($crumbs);

        if (!$this->clickable) {
            $count--;
        }

        foreach ($crumbs as $k => $crumb) {
            $path .= '/' . $crumb;
            $name = ucwords(str_replace(array(".php", "_"), array("", " "), $crumb));
            $name = ucwords(str_replace('-', ' ', $name));

            if ($k !== $count) {
                $result[] = $this->tags['liopen'] . '<a href="' . $path . '">' . $name . '</a>' . $this->tags['liclose'];
            } else {
                $result[] = $this->tags['liopen'] . $name . $this->tags['liclose'];
            }
        }

        $output .= implode($result);
        $output .= $this->tags['olclose'];
        $output .= $this->tags['navclose'];

        return $output;
    }
}
