<?php

namespace App;

class Breadcrumbs {

	public $breadcrumbs = array();

	public function __construct($title = false, $route = false) {

        $this->breadcrumbs[] = array(
            'title' => __('Strona główna'),
            'url' => url('/'),
        );
        $this->breadcrumbs[] = array(
            'title' => __('Tournaments'),
            'url' => route('tournaments'),
        );        		

        $this->add($title, $route);

	}

	public function add($title, $route) {

        $this->breadcrumbs[] = array(
            'title' => $title,
            'url' => $route,
        );		

	}

	public function get() : array {

		return $this->breadcrumbs;

	}


}