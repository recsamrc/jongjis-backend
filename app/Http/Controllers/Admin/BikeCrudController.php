<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BikeRequest;
use App\Models\Image;
use App\Traits\ImageTrait;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Prologue\Alerts\Facades\Alert;

class BikeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ImageTrait;

    public function setup()
    {
        CRUD::setModel(\App\Models\Bike::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/bike');
        CRUD::setEntityNameStrings('bike', 'bikes');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'bike_name',
            'label' => 'Bike Name',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'category',
            'label' => 'Category',
            'type' => 'relationship',
            'attribute' => 'category_name',
        ]);
        CRUD::addColumn([
            'name' => 'shop',
            'label' => 'Shop',
            'type' => 'relationship',
            'attribute' => 'shop_name',
        ]);
        CRUD::addColumn([
            'name' => 'availability',
            'label' => 'Availability',
            'type' => 'boolean',
            'options' => [0 => 'Available', 1 => 'Not Available'],
        ]);
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        CRUD::addColumn([
            'name' => 'bike_name',
            'label' => 'Bike Name',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'category',
            'label' => 'Category',
            'type' => 'relationship',
            'attribute' => 'category_name',
        ]);
        CRUD::addColumn([
            'name' => 'shop',
            'label' => 'Shop',
            'type' => 'relationship',
            'attribute' => 'shop_name',
        ]);
        CRUD::addColumn([
            'name' => 'weight',
            'label' => 'Weight',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'height',
            'label' => 'Height',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'rent_price',
            'label' => 'Rent Price',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'availability',
            'label' => 'Availability',
            'type' => 'boolean',
            'options' => [0 => 'Available', 1 => 'Not Available'],
        ]);
        CRUD::addColumn([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'photo',
            'label' => 'Photo',
            'type' => 'text',
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(BikeRequest::class);

        CRUD::addField([
            'name' => 'bike_name',
            'label' => 'Bike Name',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'availability',
            'label' => 'Is Avalible',
            'type' => 'checkbox',
        ]);
        CRUD::addField([
            'name' => 'bikecatgory',
            'label' => 'Bike Category',
            'type' => 'relationship',
            'label' => "Category",
            'attribute' => 'category_name',
            'entity' => 'category',
            'model' => "App\Models\BikeCategory",
            'placeholder' => "Select a category",
            // 'inline_create' => ['entity' => 'bikecategory'],
        ]);
        CRUD::addField([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'textarea',
        ]);
        CRUD::addField([
            'name' => 'shop',
            'label' => 'Shop',
            'type' => 'relationship',
            'attribute' => 'shop_name',
            // 'inline_create' => ['entity' => 'shop'],
        ]);
        CRUD::addField([
            'name' => 'rent_price',
            'label' => 'Rent Price',
            'type' => 'number',
        ]);
        CRUD::addField([
            'name'  => 'images',
            'label' => 'Images',
            'type'  => 'image_multiple',
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

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        $request = $this->crud->validateRequest();
        $images = $request->get('images');

        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;
        $this->saveMultipleImages($images, $item['id'], Image::TYPE_BIKE);

        Alert::success(trans('backpack::crud.insert_success'))->flash();

        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        $request = $this->crud->validateRequest();
        $images = $request->get('images');

        $item = $this->crud->update(
            $request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest()
        );
        $this->data['entry'] = $this->crud->entry = $item;
        $this->saveMultipleImages($images, $item['id'], Image::TYPE_BIKE);

        Alert::success(trans('backpack::crud.update_success'))->flash();

        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
