@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Ответ провайдера</div>
                <div class="panel-body" >

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2">
                                <h4 class="text-center">Первый провайдер</h4>
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">Правильные данные</td>
                            <td>
                                <a href="/payments/test1?a=1&b=77.00&md5=9ba1616fd302e5aedcbc5c80c93f806c">
                                    /payments/test1?a=1&b=77.00&md5=9ba1616fd302e5aedcbc5c80c93f806c
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Неправильные данные</td>
                            <td>
                                <a href="/payments/test1?a=1&b=77.00&md5=WrongHash">
                                    /payments/test1?a=1&b=77.00&md5=WrongHash
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <h4 class="text-center">Второй провайдер</h4>
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">Правильные данные</td>
                            <td>
                                <a href="/payments/asdgOasds?x=1&y=88.10&md5=1cb2bfba781ef5a904812a8e3812afb2">
                                    /payments/asdgOasds?x=1&y=88.10&md5=1cb2bfba781ef5a904812a8e3812afb2
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Неправильные данные</td>
                            <td>
                                <a href="/payments/asdgOasds?x=1&y=88.10&md5=WrongHash">
                                    /payments/asdgOasds?x=1&y=88.10&md5=WrongHash
                                </a>
                            </td>
                        </tr>
                    </table>

                    <hr>

                    @if ($response)
                        <div class="row">
                            <div class="col-sm-6">
                                <h4>Статус ответа сервера</h4>
                            </div>
                            <div class="col-sm-6">
                                <h4>{{ $response->getStatusCode() }}</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Полученные провайдером данные:</h4>
                                <pre>
                                <h5>{{ $response->getBody() }}</h5>
                            </pre>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
