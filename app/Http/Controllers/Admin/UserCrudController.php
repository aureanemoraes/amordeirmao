<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
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
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'email', 'type' => 'email', 'label' => 'E-mail']);
        CRUD::addColumn(['name' => 'cpf', 'type' => 'text', 'label' => 'CPF']);
        CRUD::addColumn([
            'name' => 'quality',
            'type' => 'relationship',
            'label' => 'Qualidade',
            'attribute' => 'name'
        ]);
        CRUD::addColumn([
            'name'      => 'donates_count', // name of relationship method in the model
            'type'      => 'text',
            'label'     => 'Doações cadastradas', // Table column heading
            'suffix'    => ' doações', // to show "123 tags" instead of "123"
            'wrapper' => [
                // 'element' => 'span', // OPTIONAL; defaults to "a" (anchor element)
                'href' => function($crud, $column, $entry) {
                    return route('donate.index', ['user' => $entry->id]);
                },
                'class' => function($crud, $column, $entry) {
                    return 'text-primary';
                },
                'target' => '__blank',
            ]
        ]);
        CRUD::addColumn(['name' => 'is_validated', 'type' => 'boolean', 'label' => 'Usuário validado']);
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
            'name' => 'quality',
            'type' => 'relationship',
            'label' => 'Qualidade',
            'attribute' => 'name'
        ]);
        CRUD::addField(['name' => 'password', 'type' => 'password', 'label' => 'Senha']);
        CRUD::addField(['name' => 'is_validated', 'type' => 'boolean', 'label' => 'Usuário validado']);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
