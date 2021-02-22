<!doctype html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AMOR DE IRMÃO - Usuário não autorizado</title>
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css" crossorigin="anonymous">
    <style>
        .container {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card text-center">
            <div class="card-header">
                AMOR DE IRMÃO
            </div>
            <div class="card-body">
                <h5 class="card-title">Usuário não verificado!</h5>
                <p class="card-text">
                    O administrador do sistema precisa validar o seu perfil e permitir o acesso. Por favor, aguarde!
                </p>
                <a href="{{backpack_url('logout')}}" class="btn btn-primary">Sair</a>
            </div>
        </div>
    </div>
</body>
</html>
