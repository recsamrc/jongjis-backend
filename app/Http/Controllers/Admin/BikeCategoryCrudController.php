<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BikeCategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


class BikeCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\BikeCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/bikecategory');
        CRUD::setEntityNameStrings('bike category', 'Bike Categories');
    }

    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(BikeCategoryRequest::class);

        Crud::addField([
            'name' => 'category_name',
            'label' => 'Category Name',
            'type' => 'text',
        ]);
        Crud::addField([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'textarea',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
