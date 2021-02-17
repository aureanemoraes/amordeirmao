<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DirectorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


class DirectorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    public function setup()
    {
        CRUD::setModel(\App\Models\Director::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/director');
        CRUD::setEntityNameStrings('diretor', 'diretores');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'user',
            'type' => 'relationship',
            'label' => 'Usuário',
            'attribute' => 'name',
            'wrapper' => [
                'href' => function($crud, $column, $entry) {
                    return route('user.show', $entry->user_id);
                },
            ]
        ]);
        CRUD::addcolumn([
            'name'  => 'believers',
            'label' => 'Fiés',
            'type'  => 'model_function',
            'function_name' => 'getBelieversCount',
            'wrapper' => [
                'href' => function($crud, $column, $entry) {
                    return route('responsable.index', ['responsable' => $entry->user_id]);
                },
            ]
        ]);

        $this->crud->query->withCount('managers');
        $this->crud->addColumn([
            'name'      => 'managers_count',
            'type'      => 'text',
            'label'     => 'Gerentes',
            'suffix'    => ' gerente(s)',
            'wrapper' => [
                'href' => function($crud, $column, $entry) {
                    return route('manager.index', ['director' => $entry->id]);
                }
            ]
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(DirectorRequest::class);

        CRUD::addField([
            'label'     => "Usuário",
            'type'      => 'select',
            'name'      => 'user_id',
            'entity'    => 'User',
            'attribute' => 'name',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
