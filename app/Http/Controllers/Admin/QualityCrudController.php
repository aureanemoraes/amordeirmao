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
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Quality::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/quality');
        CRUD::setEntityNameStrings('quality', 'qualities');
    }

    protected function setupShowOperation() {
        $this->crud->set('show.setFromDb', false);

        CRUD::addcolumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addcolumn([
            'name'  => 'url_user',
            'label' => 'Usuários', // Table column heading
            'type'  => 'model_function',
            'function_name' => 'getUsersProfilesUrls', // the method in your Model
        ]);
    }

    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(QualityRequest::class);

        CRUD::setFromDb(); // fields
    }


    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
