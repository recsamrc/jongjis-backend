<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BikeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


class BikeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Bike::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/bike');
        CRUD::setEntityNameStrings('bike', 'bikes');
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
        CRUD::setValidation(BikeRequest::class);

        Crud::addField([
            'name' => 'bike_name',
            'label' => 'Bike Name',
            'type' => 'text',
        ]);
        Crud::addField([
            'name' => 'availability',
            'label' => 'Is Avalible',
            'type' => 'checkbox',
        ]);
        Crud::addField([
            'name' => 'category',
            'label' => 'Bike Category',
            'attribute' => 'category_name',
            'type' => 'relationship',
            // 'inline_create' => ['entity' => 'bikecategory'],
        ]);
        Crud::addField([
            'name' => 'specs',
            'label' => 'Specifications',
            'type' => 'textarea',
        ]);
        Crud::addField([
            'name' => 'shop',
            'label' => 'Shop',
            'type' => 'relationship',
            'attribute' => 'shop_name',
            // 'inline_create' => ['entity' => 'shop'],
        ]);
        Crud::addField([
            'name' => 'rent_price',
            'label' => 'Rent Price',
            'type' => 'number',
        ]);
        // Crud::addField([
        //     'name' => 'images',
        //     'label' => 'Images',
        //     'type' => 'relationship',
        //     'inline_create' => ['entity' => 'image'],
        // ]);
        CRUD::addField([   // repeatable
            'name'  => 'photos',
            'label' => 'Images',
            'type'  => 'repeatable',
            'fields' => [
                [
                    'label' => "",
                    'name' => "file_url",
                    'type' => 'image',
                    'crop' => true, // set to true to allow cropping, false to disable
                    'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
                    // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                    // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
                ],
            ],
            'init_rows' => 0,
            'min_rows' => 0,
            'max_rows' => 10,
        ]);
    }

    protected function setupInlineCreateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
