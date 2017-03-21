@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-0 col-sm-12">
            <h1>{{ $project->title }}</h1>
           
                <!-- Display Validation Errors -->
                @include('common.errors')
            <!-- 
                <textarea class="form-control" rows="15" id="comment" name="body"> 
                    {{ $project->body }}
                </textarea> -->
        
            <form action="{{ url('edit') }}" method="POST">
                {{ csrf_field() }}
                <br>
                
                <textarea class="form-control" rows="15" name="body"> 
                    {{ $project->body }}
                </textarea>

                <input type="hidden" name="id" value="{{ $project->id }}">

                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-btn fa-trash"></i>Edit
                </button>
            </form>

        </div>
    </div>
@endsection