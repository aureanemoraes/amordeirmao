<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->crud->query->withCount('donates'); // this will add a tags_count column to the results

        CRUD::addColumn(['name' => 'id', 'type' => 'text', 'label' => 'ID']);
        CRUD::addColumn(['name' => 'is_validated', 'type' => 'boolean', 'label' => 'Usuário validado']);
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'email', 'type' => 'email', 'label' => 'E-mail']);
        CRUD::addColumn(['name' => 'cpf', 'type' => 'text', 'label' => 'CPF']);
        CRUD::addColumn([
            // Select
            'label'     => 'Endereço(s)',
            'type'      => 'text',
            'name'      => 'full_address',
        ]);
        CRUD::addColumn([
            // Select
            'label'     => 'Telefone(s)',
            'type'      => 'select',
            'name'      => 'phones',
            'entity'    => 'phones',
            'attribute' => 'number_of_phone',
        ]);
        CRUD::addColumn([
            'name' => 'quality',
            'type' => 'relationship',
            'label' => 'Qualidade',
            'attribute' => 'name'
        ]);
        CRUD::addColumn([
            'name'      => 'donates_count',
            'type'      => 'text',
            'label'     => 'Doações cadastradas',
            'suffix'    => ' doações',
            'wrapper' => [
                'href' => function($crud, $column, $entry) {
                    return route('donate.index', ['user' => $entry->id]);
                },

            ]
        ]);
        CRUD::addColumn([
            'name'  => 'user_type',
            'label' => 'Tipo de usuário',
            'type'  => 'model_function',
            'function_name' => 'getUserType',
        ]);
    }

    protected function setupListOperation()
    {
        $quality_id = request()->query('quality');
        if(isset($quality_id)) {
            $this->crud->addClause('where', 'quality_id', '=', $quality_id);
        }

        CRUD::addColumn(['name' => 'id', 'type' => 'text', 'label' => 'ID']);
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'cpf', 'type' => 'text', 'label' => 'CPF']);
        CRUD::addColumn([
            'name' => 'quality',
            'type' => 'relationship',
            'label' => 'Qualidade',
            'attribute' => 'name'
        ]);
        CRUD::addColumn(['name' => 'is_validated', 'type' => 'boolean', 'label' => 'Usuário validado']);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);

        CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addField(['name' => 'cpf', 'type' => 'text', 'label' => 'CPF']);
        CRUD::addField(['name' => 'email', 'type' => 'email', 'label' => 'E-mail']);
        CRUD::addField([
            'name' => 'quality_id',
            'type' => 'select',
            'entity' => 'quality',
            'label' => 'Qualidade',
            'attribute' => 'name'
        ]);
        CRUD::addField(['name' => 'password', 'type' => 'password', 'label' => 'Senha']);
        CRUD::addField(['name' => 'is_validated', 'type' => 'boolean', 'label' => 'Usuário validado']);

    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(UserUpdateRequest::class);
        CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addField(['name' => 'cpf', 'type' => 'text', 'label' => 'CPF']);
        CRUD::addField(['name' => 'email', 'type' => 'email', 'label' => 'E-mail']);
        CRUD::addField([
            'name' => 'quality_id',
            'type' => 'select',
            'entity' => 'quality',
            'label' => 'Qualidade',
            'attribute' => 'name'
        ]);
        CRUD::addField(['name' => 'is_validated', 'type' => 'boolean', 'label' => 'Usuário validado']);
    }
}
