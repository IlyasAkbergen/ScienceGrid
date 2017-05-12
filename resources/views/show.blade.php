<?php
use App\User;
use App\Project_and_contributors;
use App\Category;
use Auth\Article as BA;
use App\Http\Controllers\ContributorsController;
?>
@extends('layouts.app')
@if( $project->user_id === Auth::user()->id || Auth::user()->role === 'admin' || ContributorsController::canWrite($project->id, Auth::user()->id) )
@section('settings_contributors')
    <nav class="navbar">
            <div class="container">
                <ul class="nav navbar-nav">
                    <li><a href="settings/{{ $project->id }}" style="padding: 7px;">Settings</a></li>
                    <li><a href="contributors/{{ $project->id }}" style="padding: 7px;">Contributors</a></li>
                </ul>
            </div>
        </nav>
@endsection
@endif

@section('content')
    <div class="container">
        <div class="col-sm-offset-0 col-sm-12">
            <h3>{{ $project->title }}</h3>
           
                @include('common.errors')
            
            <div class="col-sm-1">Contributors:</div>
            <div class="col-sm-11">
                
                 <ul style=" list-style-type: none; margin: 0; padding: 0;">
                    <li>
                        <b style="color: #337AB7;"><?php echo User::getUsername($project->user_id) . "\n"; ?></b><br>
                    </li>
                    <?php  
                      $names = array(); 
                      $names = Project_and_contributors::getContributor($project->id); 
                    foreach ($names as $names) {
                        ?><li style="color: #337AB7;"> <?php echo $names;?> </li><?php 
                    }
                    ?>
                </ul> 
            </div>

            <div class="col-sm-12">Date created: {{ $project->created_at . " | "}} Last updated: {{ $project->updated_at }} </div>
            <div class="col-sm-12">Category: {{ Category::where('id', $project->category)->first()->name }}</div>
            <div class="col-sm-12">Description: {{ $project->description }}</div>

            @if(!empty($files))
                <div class="col-sm-12"></div>
                <?php $i=0; ?>
                @foreach($files as $file)
                    <div class="col-sm-12"> <?php if($i==0){ echo 'Files:'; } $i++;?> <a href="{{ url('download/' . $file->file) }}"><span class="glyphicon glyphicon-paperclip"> </span>{{' '.$file->file}}</a></div>
                @endforeach
            @endif
            
            @if( $project->user_id === Auth::user()->id || Auth::user()->role === 'admin' || ( ContributorsController::canRead($project->id, Auth::user()->id) ||  ContributorsController::canWrite($project->id, Auth::user()->id)) )
                
                <form action="{{ url('uploadFile') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <label for="fileToUpload" class="control-label">Upload file:</label>
                    <input id="fileToUpload" name="uploadFile" type="file" required>
                    <input type="submit" value="Upload" style="margin-top: 20px;" class="btn btn-success col-sm-1">
                </form>
            @endif
        </div>
    </div>
@endsection
