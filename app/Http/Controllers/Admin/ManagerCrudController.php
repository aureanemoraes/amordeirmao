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
    //use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Manager::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/manager');
        CRUD::setEntityNameStrings('gerente', 'gerentes');
    }

    protected function setupListOperation()
    {
        $director_id = request()->query('director');
        if(isset($director_id)) {
            $this->crud->addClause('where', 'director_id', '=', $director_id);
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
            'label'     => 'Diretor',
            'type'      => 'select',
            'name'      => 'director_id',
            'entity'    => 'director.user',
            'attribute' => 'name',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return route('user.show',$related_key);
                },

            ],
        ]);

        CRUD::addcolumn([
            'name'  => 'believers',
            'label' => 'Fiés',
            'type'  => 'model_function',
            'function_name' => 'getBelieversCount',
            'wrapper' => [
                'href' => function($crud, $column, $entry) {
                    return route('responsable.index', ['responsable' => $entry->user_id]);
                }
            ]
        ]);

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
