<?php
use App\User;
use App\Allow;
use App\Category;
?>
@extends('layouts.app')

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


@section('content')
    <div class="container">
        <div class="col-sm-offset-0 col-sm-12">
            <h3>{{ $project->title }}</h3>
           
                @include('common.errors')
            
            <div class="col-sm-1">Contributors:</div>
            <div class="col-sm-11">
                
                 <ul style=" list-style-type: none; margin: 0; padding: 0;">
                    <li><b style="color: blue;"><?php echo User::getUsername($project->email) . "\n"; ?></b><br> </li>
                    <?php  
                      $names = array(); 
                      $names = Allow::getEmail($project->id); 
                    foreach ($names as $names) {
                        ?><li> <?php echo $names;?> </li><?php
                                
                    }
                    ?>
                </ul> 

            </div>

            <div class="col-sm-12">Date created: {{ $project->created_at . " | "}} Last updated: {{ $project->updated_at }} </div>
            <div class="col-sm-12">Category: {{ Category::where('id', $project->category)->first()->name }}</div>
            <div class="col-sm-12">Description: {{ $project->body }}</div>
            <!-- <div class="col-sm-2"> {{ $project->created_at . " | "}} </div> -->
           <!--  <div class="col-sm-2">Last updated:</div>
            <div class="col-sm-2    "> {{ $project->updated_at }} </div> -->
        </div>
    </div>
@endsection
