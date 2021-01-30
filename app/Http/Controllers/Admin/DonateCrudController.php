<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DonateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DonateCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
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
        CRUD::setEntityNameStrings('donate', 'donates');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'description', 'type' => 'textarea', 'label' => 'Descrição']);
        // Campo visível para admini/gerente/diretor
        CRUD::addColumn(['name' => 'status', 'type' => 'text', 'label' => 'Situação']);
        CRUD::addColumn([
            'name' => 'user',
            'type' => 'relationship',
            'label' => 'Fiel',
            'attribute' => 'name'

        ]);
        CRUD::addColumn([
            'name' => 'donate_type',
            'type' => 'relationship',
            'label' => 'Tipo',
            'attribute' => 'name'
        ]);

    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(DonateRequest::class);

        CRUD::addField(['name' => 'description', 'type' => 'textarea', 'label' => 'Descrição']);
        // Campo visível para admini/gerente/diretor
        CRUD::addField(['name' => 'status', 'type' => 'text', 'label' => 'Situação (Somente gerentes)']);
        // Campo visível para admini/gerente/diretor
        CRUD::addField([
            'name' => 'donate_type_id',
            'type' => 'relationship',
            'label' => 'Tipo',
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function filteredListOperation($donate_type_id)
    {
        $this->crud->hasAccessOrFail('list');
        $this->crud->addClause('where','donate_type_id',$donate_type_id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = ucfirst($this->crud->entity_name_plural);
        return view($this->crud->getListView(), $this->data);
    }

}
