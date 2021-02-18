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
        // Diretor
        $current_user = backpack_user(); // Usuário logado atualmente
        $is_admin = backpack_user()->is_admin; // Verificação se o usuário é ADMIN
        $author_id = $this->crud->getCurrentEntry()->user_id; // Autor da doação atual
        $director = $current_user->directors()->where('user_id', $current_user->id)->first(); // Verificação se o usuário é um diretor
        // Se o usuário não for um ADMIN, ele deve possuir restrições de acesso
        if(!$is_admin) {
            if(isset($director)) {
                if($director->user_id != $author_id) {
                    $this->crud->denyAccess('show');
                }
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
        $current_user = backpack_user();
        // Verificação ADMIN
        // Admin: tudo
        // Fiel: só pode ver as doações que ele mesmo cadastrou
        // Diretor: doações cadastradas pelos seus fiés e fiés de seus gerentes
        // Gerente: doações cadastradas pelos seus fiés
        if(!$current_user->is_admin) {
            $director = $current_user->directors()->where('user_id', $current_user->id)->first();
            if(isset($director)) {
                $managers = $director->managers()->pluck('user_id');
                $responsables = $managers;
                $responsables[] = $director->user_id;
                $believers = Responsable::whereIn('responsable_id', json_decode($responsables))->pluck('user_id');
                //dd($responsables, $believers);
                $this->crud->addClause('whereIn', 'user_id', json_decode($believers));
            }
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
            $is_director = Director::where('user_id', $current_user->id)->exists(); // Verificação se é um DIRETOR
            if(!$is_director) {
                $is_manager = Manager::where('user_id', $current_user->id)->exists(); // Verificação se é um GERENTE
                if($is_manager) {
                    $this->crud->denyAccess('create'); // Permissão de CRIAÇÃO NEGADA
                }
            } else {
                $this->crud->denyAccess('create'); // Permissão de CRIAÇÃO NEGADA
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
        $current_user_id = backpack_user()->user_id; // Usuário logado atualmente
        $author_id = $this->crud->getCurrentEntry()->user_id; // Autor da doação atual
        // Verificando se o usuário que está tentanto fazer o update é:
        // O autor
        $is_author = $author_id == $current_user_id;
        // O responsável do autor
        $is_responsable_for_author = Responsable::select('responsable_id')->where('user_id', $author_id)->get();
        dd($is_responsable_for_author);
        // O responsável do responsável do autor
        if($author_id == $current_user_id) {
            CRUD::setValidation(DonateRequest::class);
            CRUD::addField(['name' => 'description', 'type' => 'textarea', 'label' => 'Descrição']);
            CRUD::addField([
                'name' => 'status',
                'type' => 'text',
                'label' => 'Situação',
                'attributes' => ['disabled' => 'disabled']
            ]);
            CRUD::addField([
                'name' => 'donate_type_id',
                'type' => 'relationship',
                'label' => 'Tipo',
            ]);
        }
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

    // Funções customizadas
    public function donateTypeOptions(Request $request) {
        $term = $request->input('term');
        $options = DonateType::where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');
        return $options;
    }

}
