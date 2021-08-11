<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RentalRequest;
use App\Models\Client;
use App\Models\Rental;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class RentalCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RentalCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
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
        CRUD::setModel(\App\Models\Rental::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/rental');
        CRUD::setEntityNameStrings('rental', 'rentals');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */

        CRUD::addColumn([
            'name' => 'shop_name',
            'label' => 'Shop',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'bike',
            'label' => 'Bike',
            'type' => 'relationship',
            'attribute' => 'bike_name',
        ]);
        CRUD::addColumn([
            'name' => 'client',
            'label' => 'Client',
            'type' => 'relationship',
            'attribute' => 'client_name',
        ]);
        CRUD::addColumn([
            'name' => 'payment_status',
            'label' => 'Payment Stutus',
            'type' => 'boolean',
            'options' => [1 => 'Payed', 0 => 'Not Yet Payed'],
        ]);


        CRUD::addButtonFromView('line', 'payment', 'payment', 'beginning');
        CRUD::addFilter([
            'type' => 'select2_ajax',
            'name' => 'client_id',
            'label' => 'Client',
            'placeholder' => 'Find client'
        ], url('rental/ajax-client-options'), function($value) {
            CRUD::addClause('where', 'client_id', $value);
        });
        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'from_to',
            'label' => 'Date range'
          ],
          false,
          function ($value) { // if the filter is active, apply these constraints
            $dates = json_decode($value);
            $this->crud->addClause('where', 'created_at', '>=', $dates->from);
            $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
          });
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RentalRequest::class);

        CRUD::setFromDb(); // fields

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function clientOptions(Request $request) {
        $client_name = $request->input('client_name');
        $options = Client::where('client_name', 'like', '%'.$client_name.'%')->get()->pluck('client_name', 'id');
        return $options;
    }

    public function updatePaymentStatus($crud)
    {
        try {
            $rental = Rental::find($crud);
            $rental->payment_status = true;
            $rental->save();
            return $rental;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
