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
        $current_user = backpack_user();
        if($current_user->user_type == 'Padrão' && !$current_user->is_admin) {
            $this->crud->denyAccess(['list', 'create', 'update', 'delete']);
        }
    }

    protected function setupListOperation()
    {
        // PERMISSÕES
        $current_user = backpack_user(); // Usuário logado atualmente
        // Verificação ADMIN
        $is_admin = backpack_user()->is_admin; // Verificação se o usuário é ADMIN
        if(!$is_admin) {
            $this->crud->addClause('whereIn', 'responsable_id', $current_user->valids_ids);
        }

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
        // PERMISSÕES
        $current_user = backpack_user(); // Usuário logado atualmente
        $responsable_id = $this->crud->getCurrentEntry()->responsable_id; // Responsável atual

        // Verificação ADMIN
        $is_admin = backpack_user()->is_admin; // Verificação se o usuário é ADMIN
        if($is_admin) {
            $this->setupCreateOperation();
        } else if(in_array($responsable_id, $current_user->valids_ids)) {
            $this->setupCreateOperation();
        } else {
            $this->crud->denyAccess('update');
        }
    }
}
