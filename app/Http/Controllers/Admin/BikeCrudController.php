<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BikeRequest;
use App\Models\Image;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as ImageManager;
use Prologue\Alerts\Facades\Alert;

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
        Crud::addField([
            'name' => 'description',
            'label' => 'Description',
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
        // CRUD::addField([   // repeatable
        //     'name'  => 'photos',
        //     'label' => 'Images',
        //     'type'  => 'repeatable',
        //     'fields' => [
        //         [
        //             'label' => "",
        //             'name' => "image",
        //             'type' => 'image',
        //             'crop' => true, // set to true to allow cropping, false to disable
        //             'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
        //             // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
        //             // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        //         ],
        //         [
        //             'name' => 'is_featured',
        //             'label' => 'Feature Image?',
        //             'type' => 'checkbox',
        //         ]
        //     ],
        //     'init_rows' => 0,
        //     'min_rows' => 0,
        //     'max_rows' => 10,
        // ]);
        CRUD::addField([   // repeatable
            'name'  => 'photos',
            'label' => 'Images',
            'type'  => 'image_multiple',
            'fields' => [
                [
                    'label' => "",
                    'name' => "image",
                    'type' => 'image',
                    'crop' => true, // set to true to allow cropping, false to disable
                    'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
                    // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                    // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
                ],
                [
                    'name' => 'is_featured',
                    'label' => 'Feature Image?',
                    'type' => 'checkbox',
                ]
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

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        $request = $this->crud->validateRequest();

        $images = $request->get('photos');

        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        foreach ($images as $image) {
            $filePath = $this->storeImage($image['image']);
            if ($filePath == '')
                continue;
            Image::create([
                'image_type' => Image::TYPE_BIKE,
                'is_featured' => $image['is_featured'],
                'file' => $filePath,
                'related_id' => $item['id'],
            ]);
        }

        Alert::success(trans('backpack::crud.insert_success'))->flash();

        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    protected function storeImage($newImage = '', $oldImagePath = '', $dir = '/uploads', $disk = 'public')
    {
        if ($newImage == '') {
            Storage::disk($disk)->delete($oldImagePath);
            return '';
        }

        if (!Str::startsWith($newImage, 'data:image'))
            return '';

        $image = ImageManager::make($newImage)->encode('jpg', 90);
        $filename = md5($image . time()) . '.jpg';

        Storage::disk($disk)->put($dir . '/' . $filename, $image->stream());

        Storage::disk($disk)->delete($oldImagePath);

        // 4. Save the public path to the database
        // but first, remove "public/" from the path, since we're pointing to it 
        // from the root folder; that way, what gets saved in the db
        // is the public URL (everything that comes after the domain name)
        $public_destination_path = Str::replaceFirst('public/', '', $dir);
        return $public_destination_path . '/' . $filename;
    }
}
