
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