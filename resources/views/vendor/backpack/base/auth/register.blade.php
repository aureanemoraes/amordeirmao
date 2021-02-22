@extends(backpack_view('layouts.plain'))

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container w-50 p-3">
        <h3>{{ trans('backpack::base.register') }}</h3>
        <div class="card">
            <div class="card-body">
                <form  role="form" method="POST" action="{{ route('backpack.auth.register') }}">
                    {!! csrf_field() !!}

                    <section>
                        <p><strong>Dados pessoais</strong></p>
                        <div class="form-group">
                            <label class="control-label" for="name">{{ trans('backpack::base.name') }}</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="{{ backpack_authentication_column() }}">{{ config('backpack.base.authentication_column_name') }}</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has(backpack_authentication_column()) ? ' is-invalid' : '' }}" name="{{ backpack_authentication_column() }}" id="{{ backpack_authentication_column() }}" value="{{ old(backpack_authentication_column()) }}">

                                @if ($errors->has(backpack_authentication_column()))
                                    <span class="invalid-feedback">
                                <strong>{{ $errors->first(backpack_authentication_column()) }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="email">E-mail</label>

                            <div>
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="quality_id">Qualidade</label>

                            <div>
                                <select class="form-control{{ $errors->has('quality_id') ? ' is-invalid' : '' }}" name="quality_id" id="quality_id" value="{{ old('quality_id') }}">
                                    <option disabled selected>Selecione...</option>
                                    @foreach($qualities as $quality_id)
                                        <option value="{{$quality_id->id}}">{{$quality_id->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('quality_id'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('quality_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </section>

                    <section>
                        <p><strong>Endereço</strong></p>
                        <div class="form-group">
                            <label class="control-label" for="zip_code">CEP</label>
                            <div>
                                <input type="text" class="form-control{{ $errors->has('zip_code') ? ' is-invalid' : '' }}" name="zip_code" id="zip_code" value="{{ old('zip_code') }}">
                                <button style="margin-top: 4px;" type="button" class="btn btn-sm btn-secondary" id="search_address">Pesquisar</button>
                                @if ($errors->has('zip_code'))
                                    <span class="invalid-feedback">
                                <strong>{{ $errors->first('zip_code') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="public_place">Logradouro</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has('public_place') ? ' is-invalid' : '' }}" name="public_place" id="public_place" value="{{ old('public_place') }}">

                                @if ($errors->has('public_place'))
                                    <span class="invalid-feedback">
                                <strong>{{ $errors->first('public_place') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="number">Número</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" name="number" id="number" value="{{ old('number') }}">

                                @if ($errors->has('number'))
                                    <span class="invalid-feedback">
                                <strong>{{ $errors->first('number') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="neighborhood">Bairro</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has('neighborhood') ? ' is-invalid' : '' }}" name="neighborhood" id="neighborhood" value="{{ old('neighborhood') }}">

                                @if ($errors->has('neighborhood'))
                                    <span class="invalid-feedback">
                                <strong>{{ $errors->first('neighborhood') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="uf">Estado</label>

                            <div>
                                <select class="form-control{{ $errors->has('uf') ? ' is-invalid' : '' }}" name="uf" id="uf" value="{{ old('uf') }}">
                                    <option disabled selected>Selecione...</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>

                                @if ($errors->has('uf'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('uf') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="reference_place">Referência</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has('reference_place') ? ' is-invalid' : '' }}" name="reference_place" id="reference_place" value="{{ old('reference_place') }}">

                                @if ($errors->has('reference_place'))
                                    <span class="invalid-feedback">
                                <strong>{{ $errors->first('reference_place') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                    </section>

                    <section>
                        <p><strong>Contato</strong></p>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="control-label" for="number_of_phone">Telefone</label>

                                    <div>
                                        <input type="text" class="form-control{{ $errors->has('number_of_phone') ? ' is-invalid' : '' }}" name="number_of_phone" id="number_of_phone" value="{{ old('number_of_phone') }}">

                                        @if ($errors->has('number_of_phone'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('number_of_phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="control-label" for="type_of_phone">Tipo</label>

                                    <div>
                                        <input type="text" class="form-control{{ $errors->has('type_of_phone') ? ' is-invalid' : '' }}" name="type_of_phone" id="type_of_phone" value="{{ old('type_of_phone') }}" placeholder="Ex.: Principal, Recado">

                                        @if ($errors->has('type_of_phone'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('type_of_phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-ghost-info"><i class='nav-icon la la-plus'></i> Adicionar</button>
                    </section>

                    <section>
                        <p><strong>Responsável</strong></p>
                        <div class="form-group">
                            <div>
                                <select class="form-control{{ $errors->has('responsable_id') ? ' is-invalid' : '' }}" name="responsable_id" id="responsable_id" value="{{ old('responsable_id') }}">
                                    <option disabled selected>Selecione...</option>
                                    @foreach($responsables as $responsable)
                                        <option value="{{$responsable->id}}">{{$responsable->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('responsable_id'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('responsable_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </section>

                    <section>
                        <p><strong>Segurança</strong></p>
                        <div class="form-group">
                            <label class="control-label" for="password">{{ trans('backpack::base.password') }}</label>

                            <div>
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="password_confirmation">{{ trans('backpack::base.confirm_password') }}</label>

                            <div>
                                <input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" id="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                    </section>

                    <div class="form-group">
                        <div>
                            <button type="submit" class="btn btn-block btn-primary">
                                {{ trans('backpack::base.register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if (backpack_users_have_email() && config('backpack.base.setup_password_recovery_routes', true))
            <div class="text-center"><a href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a></div>
        @endif
        <div class="text-center"><a href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a></div>
    </div>
@endsection

@section('before_scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous"></script>

    <script>

        $("#search_address").click(function (e) {
            e.preventDefault();
            let data = {
                "_token": "{{ csrf_token() }}",
                'zip_code' : $('#zip_code').val(),
            };
            $.ajax({
                type: 'POST',
                url: '/cep',
                data: data,
                dataType: 'json',
                success: function (data) {
                    $('#public_place').val(data.logradouro);
                    $('#neighborhood').val(data.bairro);
                    $('#uf').val(data.uf);
                    console.log(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        $("#cpf").mask("000.000.000-00");
        $("#zip_code").mask("00000-000");
        //$("#phone_1").mask("(00) 00000-0000");
    </script>
@endsection
