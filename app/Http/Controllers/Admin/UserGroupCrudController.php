<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserGroupRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class UserGroupCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\UserGroup::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/usergroup');
        CRUD::setEntityNameStrings('user group', 'User Groups');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'group_name',
            'label' => 'Group Name',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'allow_add',
            'label' => 'Allow Add',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'allow_edit',
            'label' => 'Allow Edit',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'allow_import',
            'label' => 'Allow Import',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'allow_export',
            'label' => 'Allow Export',
            'type' => 'boolean',
        ]);
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        
        CRUD::addColumn([
            'name' => 'group_name',
            'label' => 'Group Name',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'allow_add',
            'label' => 'Allow Add',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'allow_edit',
            'label' => 'Allow Edit',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'allow_delete',
            'label' => 'Allow Delete',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'allow_print',
            'label' => 'Allow Print',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'allow_import',
            'label' => 'Allow Import',
            'type' => 'boolean',
        ]);
        CRUD::addColumn([
            'name' => 'allow_export',
            'label' => 'Allow Export',
            'type' => 'boolean',
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserGroupRequest::class);

        CRUD::addField([
            'name' => 'group_name',
            'label' => 'Group Name',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'description',
            'label' => 'Descripton',
            'type' => 'textarea',
        ]);
        CRUD::addField([
            'name' => 'allow_add',
            'label' => 'Allow Add',
            'type' => 'checkbox',
        ]);
        CRUD::addField([
            'name' => 'allow_edit',
            'label' => 'Allow Edit',
            'type' => 'checkbox',
        ]);
        CRUD::addField([
            'name' => 'allow_delete',
            'label' => 'Allow Delete',
            'type' => 'checkbox',
        ]);
        CRUD::addField([
            'name' => 'allow_print',
            'label' => 'Allow Print',
            'type' => 'checkbox',
        ]);
        CRUD::addField([
            'name' => 'allow_import',
            'label' => 'Allow Import',
            'type' => 'checkbox',
        ]);
        CRUD::addField([
            'name' => 'allow_export',
            'label' => 'Allow Export',
            'type' => 'checkbox',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
