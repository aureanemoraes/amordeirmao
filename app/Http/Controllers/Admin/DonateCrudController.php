<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DonateRequest;
use App\Http\Requests\DonateUpdateRequest;
use App\Models\Director;
use App\Models\DonateType;
use App\Models\Manager;
use App\Models\Responsable;
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
        // PERMISSÕES
        $current_user = backpack_user(); // Usuário logado atualmente
        // Verificação ADMIN
        $is_admin = backpack_user()->is_admin; // Verificação se o usuário é ADMIN

        if(!$is_admin) {
            $author_id = $this->crud->getCurrentEntry()->user_id; // Autor da doação atual
            if(!in_array($author_id, $current_user->valids_ids)) {
                $this->crud->denyAccess('show');
            }
        }

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
        $current_user = backpack_user(); // Usuário logado atualmente
        // Verificação ADMIN
        $is_admin = backpack_user()->is_admin; // Verificação se o usuário é ADMIN
        if(!$is_admin) {
            $this->crud->addClause('whereIn', 'user_id', $current_user->valids_ids);
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
        // DIRETORES e GERENTES não podem cadastrar doações
        $current_user = backpack_user();
        // Verificação se ADMIN
        if(!$current_user->is_admin) {
            switch($current_user->current_user_type) {
                case 'diretor':
                case 'gerente';
                    $this->crud->denyAccess('create');
                    break;
            }
        }

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
        // Verificando o STATUS atual da doação - Se a doação estiver CONCLUÍDA, ela não pode mais ser alterada
        $status = $this->crud->getCurrentEntry()->status;
        if($status == 'Concluída') {
            $this->crud->denyAccess('update');
        }
        // A doação pode ser alterada:
        // Verificando se o usuário que está tentanto fazer o update é:
        // O admin: pode alterar
        // O autor: pode alterar
        // O responsável do autor
        // O responsável do responsável do autor
        $current_user = backpack_user(); // Usuário logado atualmente
        $is_admin = $current_user->is_admin;
        $author_id = $this->crud->getCurrentEntry()->user_id; // Autor da doação atual
        if($is_admin) {
            CRUD::setValidation(DonateRequest::class);
            CRUD::addField(['name' => 'description', 'type' => 'textarea', 'label' => 'Descrição']);
            CRUD::addField([
                'name' => 'donate_type_id',
                'type' => 'relationship',
                'label' => 'Tipo',
            ]);
            // Campo visível para admini/gerente/diretor
            CRUD::addField([
                'name' => 'status',
                'type' => 'select2_from_array',
                'options' => ['Pendente' => 'Pendente', 'Concluída' => 'Concluída'],
                'label' => 'Situação'
            ]);
        } else if($author_id == $current_user->id) {
            CRUD::setValidation(DonateRequest::class);
            CRUD::addField(['name' => 'description', 'type' => 'textarea', 'label' => 'Descrição']);
            CRUD::addField([
                'name' => 'donate_type_id',
                'type' => 'relationship',
                'label' => 'Tipo',
            ]);
            CRUD::addField([
                'name' => 'status',
                'type' => 'hidden',
                'label' => 'Situação',
            ]);

        } else {
            $valids_users = $current_user->valids_ids;
            $author_index = array_search($author_id,  $valids_users);
            unset($valids_users[$author_index]);
            $valids_users = array_values($valids_users);
            if(in_array($current_user->id, $valids_users)) {
                // Somente o responsável pelo fiel e/ou o responsável pelo responsável pode alterar o campo STATUS
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
        }




    }

    protected function setupDeleteOperation() {
        if($this->crud->getCurrentEntry()->status == 'Concluída') {
            $this->crud->denyAccess('delete');
            $this->crud->removeButton('delete');
        }
    }
}
