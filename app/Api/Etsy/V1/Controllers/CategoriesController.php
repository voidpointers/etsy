<?php

namespace Api\Etsy\V1\Controllers;

use Api\Controller;

class CategoriesController extends Controller
{
    public function index()
    {
        return [
            'top' => \Etsy::findAllTopCategory(),
            'sub' => \Etsy::findAllTopCategoryChildren(),
            'third' => \Etsy::findAllSubCategoryChildren()
        ];
    }
}
