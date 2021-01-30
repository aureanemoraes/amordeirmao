<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ResponsableRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\User;

class ResponsableCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Responsable::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/responsable');
        CRUD::setEntityNameStrings('responsable', 'responsables');
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        CRUD::addcolumn([
            'name'  => 'url_user',
            'label' => 'Usuário', // Table column heading
            'type'  => 'model_function',
            'function_name' => 'getUserProfileUrl', // the method in your Model
        ]);

        CRUD::addcolumn([
            'name'  => 'url_responsable_person',
            'label' => 'Responsável', // Table column heading
            'type'  => 'model_function',
            'function_name' => 'getResponsablePersonProfileUrl', // the method in your Model
        ]);
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
            'name' => 'responsable_person',
            'type' => 'relationship',
            'label' => 'Responsável',
            'attribute' => 'name'

        ]);
    }


    protected function setupCreateOperation()
    {
        CRUD::setValidation(ResponsableRequest::class);
        CRUD::addField([
            'label'     => "Fiel",
            'type'      => 'select',
            'name'      => 'user_id',
            'entity'    => 'User',
            'attribute' => 'name',
        ]);
        CRUD::addField([   // select2_grouped
            'label'     => 'Responsáveis',
            'type'      => 'select_from_array', //https://github.com/Laravel-Backpack/CRUD/issues/502
            'name'      => 'responsable_id',
            'options' => User::has('directors')->orHas('managers')->get()->pluck('name','id')->toArray(),
        ]);

    }


    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
