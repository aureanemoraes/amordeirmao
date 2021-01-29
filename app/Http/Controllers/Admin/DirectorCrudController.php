<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DirectorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


class DirectorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    public function setup()
    {
        CRUD::setModel(\App\Models\Director::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/director');
        CRUD::setEntityNameStrings('director', 'directors');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'user', 'type' => 'relationship', 'label' => 'Usuário', 'attribute' => 'name']); 
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(DirectorRequest::class);

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
