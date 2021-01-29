<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ManagerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ManagerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Manager::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/manager');
        CRUD::setEntityNameStrings('manager', 'managers');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'user', 
            'type' => 'relationship', 
            'label' => 'Usuário',
            'attribute' => 'name'
        ]); 
        CRUD::addColumn([
            'name' => 'director_id', 
            'type' => 'select', 
            'entity' => 'director.user',
            'label' => 'Diretor',
            'attribute' => 'name'

        ]); 
        //CRUD::addColumn(['name' => 'status', 'type' => 'boolean', 'label' => 'Ativo']); 
    
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ManagerRequest::class);
        CRUD::addField([  
            'label'     => "Usuário",
            'type'      => 'select',
            'name'      => 'user_id', 
            'entity'    => 'User', 
            'attribute' => 'name', 
        ]); 
        CRUD::addField([  
            'label'     => "Diretor",
            'type'      => 'select',
            'name'      => 'director_id', 
            'entity'    => 'Director', 
            'attribute' => 'user_id',
                
        ]); 
        //CRUD::addField(['name' => 'status', 'type' => 'boolean', 'label' => 'Ativo']); 
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
