<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QualityRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class QualityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class QualityCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Quality::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/quality');
        CRUD::setEntityNameStrings('quality', 'qualities');
    }

    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        $this->crud->query->withCount('users'); // this will add a tags_count column to the results
        $this->crud->addColumn([
            'name'      => 'users_count', // name of relationship method in the model
            'type'      => 'text',
            'label'     => 'Usuários', // Table column heading
            'suffix'    => ' usuários', // to show "123 tags" instead of "123"
            'wrapper' => [
                // 'element' => 'span', // OPTIONAL; defaults to "a" (anchor element)
                'href' => function($crud, $column, $entry) {
                    return route('user.index', ['quality' => $entry->id]);
                },
                'class' => function($crud, $column, $entry) {
                    return 'text-danger';
                },
                'target' => '__blank',
            ]
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(QualityRequest::class);
        CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
    }


    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
