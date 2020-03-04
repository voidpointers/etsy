<?php

namespace Api\Etsy\V1\Controllers;

use Api\Controller;

class CategoriesController extends Controller
{
    public function index()
    {
        $top = \Etsy::findAllTopCategory();

        return $top;
    }
}
