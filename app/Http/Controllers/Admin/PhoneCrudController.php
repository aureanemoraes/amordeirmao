<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PhoneRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class PhoneCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Phone::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/phone');
        CRUD::setEntityNameStrings('phone', 'phones');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'number_of_phone', 'type' => 'text', 'label' => 'Número']);
        CRUD::addColumn(['name' => 'type_of_phone', 'type' => 'text', 'label' => 'Tipo']);
        CRUD::addColumn(['name' => 'user', 'type' => 'relationship', 'label' => 'Usuário']); 

    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(PhoneRequest::class);
        CRUD::addField(['name' => 'number_of_phone', 'type' => 'text', 'label' => 'Número']);
        CRUD::addField(['name' => 'type_of_phone', 'type' => 'text', 'label' => 'Tipo']);
        CRUD::addField([  
            'label'     => "Usuário",
            'type'      => 'select',
            'name'      => 'user_id', 
            'entity'    => 'User', 
            'attribute' => 'name', 
        ]); 

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
