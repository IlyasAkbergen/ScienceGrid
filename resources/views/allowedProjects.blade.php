<?php 
    //use App\library\MyFunctions;
    use App\User;
    use App\Allow;    
?>
<div class="col-sm-offset-0 col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Projects of another users allowed for you.
        </div>

        <div class="panel-body">
            <table class="table table-striped task-table">
                <thead>
                    <th>Title</th>
                    <th>Contributors</th>
                    <th>Modified</th>
                    
                </thead>
                <tbody>
                    <?php 

                        $allows = Allow::getAllowedProjects(Auth::user()->id);

                    ?>

                    @foreach ($allows as $allow)
                        <tr>
                            <td class="table-text">
                                <a href="show/{{ $allow->id }}">
                                    <div>{{ $allow->title }}</div>
                                </a>
                            </td>
                            <td class="table-text">
                                <div>
                                    <?php 
                                        echo User::getUsername($allow->email);
                                     ?>
                                </div>
                            </td>
                            <td class="table-text">
                                <div>
            <!-- modified budet -->
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>         