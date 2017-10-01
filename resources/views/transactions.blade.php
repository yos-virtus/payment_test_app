@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">История транзакций пользователя</div>
                <div class="panel-body" >
                    <form action="/transactions" method="get" class="form-horizontal">
                        <!-- <div class="row"> -->
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label control-label-sm">Пользователь: </label>      
                                <div class="col-sm-4">                  
                                    <input type="text" name="name"  value="{{ $user->name ?? '' }}" class="form-control input-sm">
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-sm btn-block btn-primary">Найти</button>
                                </div>
                            </div>
                        <!-- </div> -->
                        <br>
                        <div class="row">                            
                            <div class="col-sm-12">
                                @if($user)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td>Время</td>
                                            <td>Зачислено</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($user->transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->created_at }}</td>
                                                <td>{{ $transaction->amount }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center">
                                                    <em>Пользователь {{ $user->name }} не проводил каких либо операций</em>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                @else
                                    <p class="text-center"><em>Пользователя с таким именем не существует</em></p>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
