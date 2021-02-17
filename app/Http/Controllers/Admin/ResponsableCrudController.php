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
    //use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Responsable::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/responsable');
        CRUD::setEntityNameStrings('responsável', 'responsáveis');
    }

    protected function setupListOperation()
    {
        $responsable_id = request()->query('responsable');
        if(isset($responsable_id)) {
            $this->crud->addClause('where', 'responsable_id', '=', $responsable_id);
        }

        CRUD::addColumn([
            // Select
            'label'     => 'Usuário',
            'type'      => 'select',
            'name'      => 'user_id',
            'entity'    => 'user',
            'attribute' => 'name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return route('user.show',$related_key);
                },
            ],
        ]);
        CRUD::addColumn([
            // Select
            'label'     => 'Responsável',
            'type'      => 'select',
            'name'      => 'responsable_id',
            'entity'    => 'responsable_person',
            'attribute' => 'name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return route('user.show',$related_key);
                },

            ],
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
