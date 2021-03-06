<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AddressRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


class AddressCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    public function setup()
    {
        CRUD::setModel(\App\Models\Address::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/address');
        CRUD::setEntityNameStrings('endereço', 'endereços');
    }


    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'zip_code', 'type' => 'text', 'label' => 'CEP']);
        CRUD::addColumn(['name' => 'public_place', 'type' => 'text', 'label' => 'Logradouro']);
        CRUD::addColumn(['name' => 'number', 'type' => 'text', 'label' => 'Número']);
        CRUD::addColumn(['name' => 'neighborhood', 'type' => 'text', 'label' => 'Bairro']);
        CRUD::addColumn(['name' => 'reference_place', 'type' => 'text', 'label' => 'Ponto de referência']);
        CRUD::addColumn(['name' => 'uf', 'type' => 'text', 'label' => 'UF']);
        CRUD::addColumn([
            // Select
            'label'     => 'Usuário',
            'type'      => 'select',
            'name'      => 'users',
            'entity'    => 'users',
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
        CRUD::setValidation(AddressRequest::class);

        CRUD::addField(['name' => 'zip_code', 'type' => 'text', 'label' => 'CEP']);
        CRUD::addField(['name' => 'public_place', 'type' => 'text', 'label' => 'Logradouro']);
        CRUD::addField(['name' => 'number', 'type' => 'text', 'label' => 'Número']);
        CRUD::addField(['name' => 'neighborhood', 'type' => 'text', 'label' => 'Bairro']);
        CRUD::addField(['name' => 'reference_place', 'type' => 'text', 'label' => 'Ponto de referência']);
        CRUD::addField([
            'name' => 'uf',
            'type' => 'select2_from_array',
            'label' => 'UF',
            'options' => [
                'AC' => 'Acre',
                'AL' => 'Alagoas',
                'AP' => 'Amapá',
                'AM' => 'Amazonas',
                'BA' => 'Bahia',
                'CE' => 'Ceará',
                'DF' => 'Distrito Federal',
                'ES' => 'Espirito Santo',
                'GO' => 'Goiás',
                'MA' => 'Maranhão',
                'MS' => 'Mato Grosso do Sul',
                'MT' => 'Mato Grosso',
                'MG' => 'Minas Gerais',
                'PA' => 'Pará',
                'PB' => 'Paraíba',
                'PR' => 'Paraná',
                'PE' => 'Pernambuco',
                'PI' => 'Piauí',
                'RJ' => 'Rio de Janeiro',
                'RN' => 'Rio Grande do Norte',
                'RS' => 'Rio Grande do Sul',
                'RO' => 'Rondônia',
                'RR' => 'Roraima',
                'SC' => 'Santa Catarina',
                'SP' => 'São Paulo',
                'SE' => 'Sergipe',
                'TO' => 'Tocantins',
            ]
        ]);

        CRUD::addField([
            'label'     => "Usuários",
            'type'      => 'select2_multiple',
            'name'      => 'users', // the method that defines the relationship in your Model
            'attribute' => 'name'
        ]);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
