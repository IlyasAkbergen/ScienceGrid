@extends('layouts.app')

@section('content')
<?php 
    use App\User;
    use App\Allow;    
?>
    <div class="container">
       <h1 class="col-sm-6" style="margin: 5px 0 5px 100px">Dashboard</h1>
       <a href="addProject" class="btn btn-info col-sm-3" role="button" style="margin: 10px;">Create new project</a>
    <div class="col-sm-offset-0 col-sm-12">
    
    @if (count($projects) > 0)
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-striped task-table">
                <thead>
                    <th class="col-sm-3">Title</th>
                    <th class="col-sm-3">Contributors</th>
                    <th class ="col-sm-3">Modified</th> 
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td class="table-text">
                                <a href="show/{{ $project->id }}">
                                    <div>{{ $project->title }}</div>
                                </a>
                            </td>
                            
                            <td class="table-text">
                                <div class="col-sm-4 col-sm-offset-0">
                                    <?php 
                                        ?><b style="color: blue;"><?php echo User::getUsername($project->email) . "\n"; ?></b><br><?php
                                        $emails = array(); 
                                        $emails = Allow::getEmail($project->id); 
                                        
                                        foreach ($emails as $email) {
                                            echo $email . "\n";
                                            ?> <br> <?php
                                        }
                                    ?>
                                </div>
                            </td>

                            <td class="table-text">
                                
                                {{ $project->updated_at }}

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

@endsection

