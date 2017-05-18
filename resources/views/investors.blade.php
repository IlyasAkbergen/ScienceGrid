@extends('layouts.app')
@section('content')
<?php 
    use App\User;
    use App\Project_and_contributors; 
    use App\Category;   
?>
    <div class="container">
        @if (count($investors) > 0)
        <div class="panel panel-default" style="margin-top: 10px;">
            <div class="panel-body">
                <div class="table-responsive">
                <table class="table table-striped task-table" cellspacing="0" id="example">
                    <thead>
                        <tr>
                            <th class="col-sm-3">Name</th>
                            <th class="col-sm-3">E-mail</th>
                            <th class ="col-sm-3">Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($investors as $investor)
                        <tr>
                            <td class="table-text">
                                <a href="profile/{{ $investor->id }}">
                                    <div>{{ $investor->fullName }}</div>
                                </a>
                            </td>
                            
                            <td class="table-text">
                                <div class="col-sm-4 col-sm-offset-0">
                                    {{ $investor->email }}
                                </div>
                            </td>
                        
                            <td class="table-text">
                                {{ $investor->address }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

