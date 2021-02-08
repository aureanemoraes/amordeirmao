<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DonateTypeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class DonateTypeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\DonateType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/donatetype');
        CRUD::setEntityNameStrings('donatetype', 'donate_types');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        $this->crud->query->withCount('donates'); // this will add a tags_count column to the results
        $this->crud->addColumn([
            'name'      => 'donates_count', // name of relationship method in the model
            'type'      => 'text',
            'label'     => 'Doações', // Table column heading
            'suffix'    => ' doações', // to show "123 tags" instead of "123"
                          'wrapper' => [
                                  // 'element' => 'span', // OPTIONAL; defaults to "a" (anchor element)
                'href' => function($crud, $column, $entry) {
                    return route('donate.index', ['donate_type' => $entry->id]);
                },
                'class' => function($crud, $column, $entry) {
                    return 'text-danger';
                },
                'target' => '__blank',
            ]
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(DonateTypeRequest::class);
        CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
