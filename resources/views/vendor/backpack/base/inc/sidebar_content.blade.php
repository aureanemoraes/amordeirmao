<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i style="color: white" class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('donate') }}'><i style="color: white" class='nav-icon la la-hand-holding-heart'></i> Doações</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('responsable') }}'><i style="color: white" class='nav-icon la la-user-friends'></i> Responsáveis</a></li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i style="color: white" class="nav-icon la la-users"></i> Administração</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i style="color: white" class='nav-icon la la-user'></i> Usuários</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('director') }}'><i style="color: white" class='nav-icon la la-user-tie'></i> Diretores</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('manager') }}'><i style="color: white" class='nav-icon la la-user-tie'></i> Gerentes</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('address') }}'><i style="color: white" class='nav-icon la la-map-marker'></i> Endereços</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('phone') }}'><i style="color: white" class='nav-icon la la-mobile-alt'></i> Telefones</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('quality') }}'><i style="color: white" class='nav-icon la la-square'></i> Qualidades</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('donatetype') }}'><i style="color: white" class='nav-icon la la-heart'></i> Tipos de doações</a></li>

    </ul>
</li>


