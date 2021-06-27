<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ShopCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ShopCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {store as TraitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Shop::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/shop');
        CRUD::setEntityNameStrings('shop', 'shops');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'shop_name',
            'label' => 'Shop Name',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'owner_name',
            'label' => 'Owner Name',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'contact_no',
            'label' => 'Shop Contact No',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'updator',
            'label' => 'Updated By',
            'type' => 'relationship',
            'attribute' => 'name',
        ]);
    }

    /**
     * Define what happens when the Show operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-show
     * @return void
     */
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        
        CRUD::addColumn([
            'name' => 'shop_name',
            'label' => 'Shop Name',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'owner_name',
            'label' => 'Owneer Name',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'address',
            'label' => 'Shop Address',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'email_address',
            'label' => 'Shop Email Address',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'contact_no',
            'label' => 'Shop Contact No',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'website',
            'label' => 'Shop Website',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'updator',
            'label' => 'Updated By',
            'type' => 'relationship',
            'attribute' => 'name',
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ShopRequest::class);

        Crud::addField([
            'name' => 'shop_name',
            'label' => 'Shop Name',
            'type' => 'text',
        ]);
        Crud::addField([
            'name' => 'owner_name',
            'label' => 'Owner Name',
            'type' => 'text',
        ]);
        Crud::addField([
            'name' => 'address',
            'label' => 'Shop Address',
            'type' => 'text',
        ]);
        Crud::addField([
            'name' => 'email_address',
            'label' => 'Shop Email',
            'type' => 'email',
        ]);
        Crud::addField([
            'name' => 'contact_no',
            'label' => 'Shop Phone Number',
            'type' => 'text',
        ]);
        Crud::addField([
            'name' => 'website',
            'label' => 'Shop Website',
            'type' => 'url',
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
        $this->crud->getRequest()->request->add(['updated_by'=> backpack_user()->id]);
        $response = $this->traitStore();
        return $response;
    }
}
