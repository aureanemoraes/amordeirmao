<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DonateRequest;
use App\Http\Requests\DonateUpdateRequest;
use App\Models\DonateType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Arr;

class DonateCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Donate::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/donate');
        CRUD::setEntityNameStrings('doação', 'doações');
    }

    protected function setupShowOperation() {
        $this->crud->set('show.setFromDb', false);
        CRUD::addColumn(['name' => 'description', 'type' => 'textarea', 'label' => 'Descrição']);
        // Campo visível para admini/gerente/diretor
        CRUD::addColumn(['name' => 'status', 'type' => 'text', 'label' => 'Situação']);
        CRUD::addColumn([
            'label'     => 'Tipo',
            'type'      => 'relationship',
            'name'      => 'donate_type',
            'attribute' => 'name',
        ]);
        CRUD::addColumn([
            'label'     => 'Criado por',
            'type'      => 'relationship',
            'name'      => 'user',
            'attribute' => 'name',
        ]);
        CRUD::addColumn(['name' => 'created_at', 'type' => 'datetime', 'label' => 'Criado em']);

    }

    protected function setupListOperation()
    {
        // PERMISSÕES
        $current_user = backpack_user();
        // Diretor: doações cadastradas pelos seus fiés e fiés de seus gerentes
        $director = $current_user->directors()->where('user_id', $current_user->id)->first();
        if(isset($director)) {
            $managers = $director->managers()->pluck('user_id');
            $managers[]= $director->user_id;
            $this->crud->addClause('whereIn', 'user_id', json_decode($managers));

        }
        // FILTROS URL
        // Tipo de doação
        $donate_type_id = request()->query('donate_type');
        if(isset($donate_type_id)) {
            $this->crud->addClause('where', 'donate_type_id', '=', $donate_type_id);
        }
        // Usuário
        $user_id = request()->query('user');
        if(isset($user_id)) {
            $this->crud->addClause('where', 'user_id', '=', $user_id);
        }
        // FILTROS GERAIS
        // Situação
        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'select2_multiple',
            'label' => 'Situação'
        ], function() {
            return [
                'Pendente' => 'Pendente',
                'Concluída' => 'Concluída',
            ];
        }, function($values) { // if the filter is active
            $this->crud->addClause('whereIn', 'status', json_decode($values));
        });

        // Tipo de doação
        $this->crud->addFilter([
            'name'  => 'donate_type_id',
            'type'  => 'select2_multiple',
            'label' => 'Tipo de doação'
        ], function() {
            return DonateType::all()->pluck('name', 'id')->toArray();
        }, function($values) { // if the filter is active
            $this->crud->addClause('whereIn', 'donate_type_id', json_decode($values));
        });

        CRUD::addColumn(['name' => 'description', 'type' => 'textarea', 'label' => 'Descrição']);
        CRUD::addColumn([
            'label'     => 'Tipo',
            'type'      => 'relationship',
            'name'      => 'donate_type',
            'attribute' => 'name'
        ]);
        CRUD::addColumn([
            // Select
            'label'     => 'Fiel',
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
        // Campo visível para admini/gerente/diretor
        CRUD::addColumn(['name' => 'status', 'type' => 'text', 'label' => 'Situação']);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(DonateRequest::class);

        CRUD::addField(['name' => 'description', 'type' => 'textarea', 'label' => 'Descrição']);
        // Campo visível para admini/gerente/diretor
        CRUD::addField(['name' => 'status', 'type' => 'hidden', 'value' => 'Pendente', 'label' => 'Situação']);
        // Campo visível para admini/gerente/diretor
        CRUD::addField([
            'name' => 'donate_type_id',
            'type' => 'relationship',
            'label' => 'Tipo',
        ]);
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(DonateUpdateRequest::class);
        CRUD::addField([
            'name' => 'description',
            'type' => 'textarea',
            'label' => 'Descrição',
            'attributes' => ['disabled' => 'disabled']
        ]);
        CRUD::addField([
            'label'     => 'Criado por',
            'type'      => 'relationship',
            'name'      => 'user',
            'attribute' => 'name',
            'attributes' => ['disabled' => 'disabled']

        ]);
        // Campo visível para admini/gerente/diretor
        CRUD::addField([
            'name' => 'status',
            'type' => 'select2_from_array',
            'options' => ['Pendente' => 'Pendente', 'Concluída' => 'Concluída'],
            'label' => 'Situação'
        ]);
    }

    // Funções customizadas
    public function donateTypeOptions(Request $request) {
        $term = $request->input('term');
        $options = DonateType::where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');
        return $options;
    }

}
