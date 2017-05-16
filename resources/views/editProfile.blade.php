@extends('layouts.app')

@section('content')
<?php 
    use App\User;
    use App\Project_and_contributors; 
    use App\Category;   
    use App\Project;
?>
<body data-spy="scroll" data-target=".scrollspy">
    <div class="osf-nav-wrapper">
        <div class="osf-search" data-bind="fadeVisible: showSearch" style="display: none">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form class="input-group" data-bind="submit: submit">
                            <input id="searchPageFullBar" name="search-placeholder" type="text" class="osf-search-input form-control" placeholder="Search" data-bind="value: query, hasFocus: true">
                            <label id="searchBarLabel" class="search-label-placeholder" for="search-placeholder">Search</label>
                            <span class="input-group-btn">
                                <button type="button" class="btn osf-search-btn" data-bind="click: submit"><i class="fa fa-circle-arrow-right fa-lg"></i></button>
                                <button type="button" class="btn osf-search-btn" data-toggle="modal" data-target="#search-help-modal"><i class="fa fa-question fa-lg"></i></button>
                                <button type="button" class="btn osf-search-btn" data-bind="visible: showClose, click : toggleSearch"><i class="fa fa-times fa-lg"></i></button>
                            </span>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="search-help-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span>×</button>
                        <h3 class="modal-title">Search help</h3>
                    </div>
                    <div class="modal-body">
                        <h4>Queries</h4>
                        <p>Search uses the <a href="http://extensions.xwiki.org/xwiki/bin/view/Extension/Search+Application+Query+Syntax">Lucene search syntax</a>.This gives you many options, but can be very simple as well. Examples of valid searches include:</p>
                        <ul>
                            <li><a href="/search/?q=repro*">repro*</a></li>
                            <li><a href="/search/?q=brian+AND+title%3Amany">brian AND title:many</a></li>
                            <li><a href="/search/?q=tags%3A%28psychology%29">tags:(psychology)</a></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="watermarked">
        <div class="container">
            <h2 class="page-header">Settings
            <div class="pull-right">
                <a href="{{url('profile' . '/' . Auth::user()->id) }}" class="btn btn-link"><i class="fa fa-user m-r-sm"></i>View your profile </a>
            </div>
            </h2>


            <div id="profileSettings" class="row">

            <div class="col-sm-3 affix-parent">
                <div class="osf-affix profile-affix panel panel-default affix-top" data-spy="affix" data-offset-top="70" data-offset-bottom="268" style="width: 263px; display: block;">
                  <ul class="nav nav-stacked nav-pills">
                      <li class="active">
                        <a href="#">Profile information</a></li>
                  </ul>
                </div>
             </div>

    <div class="col-sm-9 col-md-7">

        <div id="userProfile">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#names" data-toggle="tab" aria-expanded="true">Name</a></li>
                <li class=""><a href="#jobs" data-toggle="tab" aria-expanded="false">Employment</a></li>
                <li class=""><a href="#schools" data-toggle="tab" aria-expanded="false">Education</a></li>
            </ul>

            <div class="tab-content" id="containDrag">
                <div class="m-t-md tab-pane active" id="names">
                    <div data-bind="template: {name: 'profileName'}">

                        <form role="form" method="post" action="{{url('updateProfile')}}"> 
                            {{ csrf_field() }}
                            <div class="form-group">
                                <br>
                                <label>Full name</label>
                                <input class="form-control" name="fullName" required-autoload><span class="validationMessage" style="display: none;"></span>
                                <br>
                                <label>Address</label>
                                <input class="form-control" name="address"><span class="validationMessage" style="display: none;"></span>
                            </div>

                            <hr>

                            <div class="p-t-lg p-b-lg">
                                <button data-bind="disable: saving(), text: saving() ? 'Saving' : 'Save'" type="submit" class="btn btn-success">Save</button>
                            </div>

                             <!-- Flashed Messages -->
                            <div class="help-block">
                                <p data-bind="html: message, attr: {class: messageClass}"></p>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="m-t-md tab-pane" id="jobs">
                    <div >

                    <div >
                    
                    <div data-bind="ifnot: contents().length" class="col-sm-6 dropdown">
                    @if(empty($employments))
                        <div class="well well-sm">Not provided</div>
                    @else
                        <?php $i = 0; ?>
                        @foreach($employments as $emp)
                        <div class="well well-sm">
                            {{ $emp->employer}}
                            <a href="{{ url('deleteEmployment') . '/' . $emp->employment_id }}"><button class="btn btn-danger btn-sm" style="float: right;"><span class="glyphicon glyphicon-remove"></span></button></a>
                            <?php 
                                if($emp->ongoing === 1){
                                    $endDate = 'ongoing'; 
                                }else{
                                    $endDate = $emp->endDate;
                                } 
                            ?>
                            <p><i><small>{{ $emp->startDate  . ' - ' . $endDate}}</small></i></p>
                           
                            <button class="button" onclick="$('#target{{$i}}').toggle();">
                                <span class="caret"></span>
                            </button>
                            <div id="target{{$i}}" style="display: none">
                                @if(!empty($emp->department))
                                    <b>Department: </b>{{ $emp->department }}
                                    {{ "\n" }}
                                @endif
                                <p></p>
                                @if(!empty($emp->jobTitle))
                                    <b>Job title: </b>{{ "\n" . $emp->jobTitle }}
                                @endif
                             
                            </div>    

                        </div>
                        
                        <?php $i++; ?>
                        @endforeach
                    @endif
                    </div>

<!-- START MODAL  -->
        <p></p>
        <button type="button" class="btn btn-success btn-sm m-l-md" data-toggle="modal" data-target="#myModal" >
            <span class="glyphicon glyphicon-plus"></span> Add new
        </button>
        
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Add new employment information</b></h4>
              </div>
              <!-- MODAL BODY MODAL BODY -->

              <div class="modal-body">

                <!-- Whom to add -->
                <div data-bind="if: page() == 'whom'">
                    <!-- Find contributors -->
                    <form role="form" method="post" action="{{url('updateEmployment')}}">
    
                        <div>
                                <div>

                                <br>
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Institution / Employer</label>
                                    <input class="form-control" name="employer" placeholder="Required" required autofocus>
                                    <div  class="text-danger" style="display: none;">
                                        <p data-bind="validationMessage: institution" style="display: none;"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Department / Institute</label>
                                    <input class="form-control" name="department">
                                </div>

                                <div class="form-group">
                                    <label>Job title</label>
                                    <input class="form-control" name="jobTitle">
                                </div>

                                <div class="form-group">
                                    <label>Start date</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select required autofocus name="startmonth">
                                                <option value="">-- Month --</option><option value="January">January</option><option value="February">February</option><option value="March">March</option><option value="April">April</option><option value="May">May</option><option value="June">June</option><option value="July">July</option><option value="August">August</option><option value="September">September</option><option value="October">October</option><option value="November">November</option><option value="December">December</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" placeholder="Year" name="startyear" required autofocus>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" data-bind="ifnot: ongoing">
                                    <label>End date</label>
                                        <div class="row">
                                        <div class="col-md-3">
                                            <select required autofocus name="endmonth">
                                                <option value="">-- Month --</option><option value="January">January</option><option value="February">February</option><option value="March">March</option><option value="April">April</option><option value="May">May</option><option value="June">June</option><option value="July">July</option><option value="August">August</option><option value="September">September</option><option value="October">October</option><option value="November">November</option><option value="December">December</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" placeholder="Year" name="endyear" required autofocus>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label>Ongoing</label>
                                    <input type="checkbox" name="ongoing">
                                </div>

                                <div data-bind="visible: $parent.showMessages, css:'text-danger'" class="text-danger" style="display: none;">
                                    <p data-bind="validationMessage: start" style="display: none;"></p>
                                    <p data-bind="validationMessage: end" style="display: none;"></p>
                                    <p data-bind="validationMessage: startYear" style="display: none;"></p>
                                    <p data-bind="validationMessage: endYear" style="display: none;"></p>
                                </div>

                            <hr data-bind="visible: $index() != ($parent.contents().length - 1)" style="display: none;">

                             </div>
                        </div>

                        <div class="p-t-lg p-b-lg">

                            <button  type="reset" class="btn btn-default" >Discard changes</button>

                            <button data-bind="disable: saving(), text: saving() ? 'Saving' : 'Save'" type="submit" class="btn btn-success">Save</button>

                        </div>
                        <br>

                        </form>



                    <!-- Choose which to add -->
                   
                </div>
                <!-- Component selection page -->
                

                <!-- Invite user page -->
                <div data-bind="if:page() === &quot;invite&quot;"></div><!-- end invite user page -->

            </div>

            <!-- END MODAL BODY MODAL BODY  -->
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

<!-- END MODAL -->
                        
                    </div>

                    <div data-bind="if: mode() === 'view'"></div>

                    </div>
                </div>

                <div class="m-t-md tab-pane" id="schools">
                    <div data-bind="template: {name: 'profileSchools'}">

            <div data-bind="if: mode() === 'edit'">

            <div data-bind="ifnot: contents().length" class="dropdown col-sm-6">
                            @if(empty($educations))
                                <div class="well well-sm">Not provided</div>
                            @else
                                <?php $j=0; ?>
                                @foreach($educations as $edu)
                                <div class="well well-sm">
                                    {{ $edu->universityName}}
                                     <a href="{{ url('deleteEducation'). '/' . $edu->education_id }}"><button class="btn btn-danger btn-sm" style="float: right;"><span class="glyphicon glyphicon-remove"></span> </button></a>
                                    <?php 
                                        if($edu->ongoing === 1){
                                            $endDate = 'ongoing'; 
                                        }else{
                                            $endDate = $edu->endDate;
                                        } 
                                    ?>
                                    <p><i><small>{{ $edu->startDate  . ' - ' . $endDate}}</small></i></p>
                                    
                                    <button class="button" onclick="$('#{{$j}}target').toggle();">
                                        <span class="caret"></span>
                                    </button>
                                    <div id="{{$j}}target" style="display: none">
                                        @if(!empty($edu->department))
                                            <b>Department: </b>{{ $edu->department }}
                                        @endif
                                        
                                        <p></p>
                                        @if(!empty($edu->degree))
                                            <b>Degree: </b>{{ $edu->degree }}
                                        @endif
                                     
                                    </div>
                                </div>
                                <?php $j++; ?>
                                @endforeach
                            @endif
                        </div>    

            <p></p>
            <button type="button" class="btn btn-success btn-sm m-l-md" data-toggle="modal" data-target="#myModal2" >
                <span class="glyphicon glyphicon-plus"></span> Add new
            </button>
            
            <div id="myModal2" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Add new education information</b></h4>
                  </div>
                  <!-- MODAL BODY MODAL BODY -->

                  <div class="modal-body">

                    <!-- Whom to add -->
                    <div data-bind="if: page() == 'whom'">
                        <!-- Find contributors -->    

                <form role="form" method="post" action="{{url('updateEducation')}}">
    
                        <div>
                                <div>

                                <br>
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Institution</label>
                                    <input class="form-control" name="institution" placeholder="Required" required autofocus>
                                    <div  class="text-danger" style="display: none;">
                                        <p data-bind="validationMessage: institution" style="display: none;"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Department</label>
                                    <input class="form-control" name="department">
                                </div>

                                <div class="form-group">
                                    <label>Degree</label>
                                    <input class="form-control" name="degree">
                                </div>

                                <div class="form-group">
                                    <label>Start date</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select required autofocus name="startmonth">
                                                <option value="">-- Month --</option><option value="January">January</option><option value="February">February</option><option value="March">March</option><option value="April">April</option><option value="May">May</option><option value="June">June</option><option value="July">July</option><option value="August">August</option><option value="September">September</option><option value="October">October</option><option value="November">November</option><option value="December">December</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" placeholder="Year" name="startyear" required autofocus>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" data-bind="ifnot: ongoing">
                                    <label>End date</label>
                                        <div class="row">
                                        <div class="col-md-3">
                                            <select required autofocus name="endmonth">
                                                <option value="">-- Month --</option><option value="January">January</option><option value="February">February</option><option value="March">March</option><option value="April">April</option><option value="May">May</option><option value="June">June</option><option value="July">July</option><option value="August">August</option><option value="September">September</option><option value="October">October</option><option value="November">November</option><option value="December">December</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" placeholder="Year" name="endyear" required autofocus>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label>Ongoing</label>
                                    <input type="checkbox" name="ongoing">
                                </div>

                                <div data-bind="visible: $parent.showMessages, css:'text-danger'" class="text-danger" style="display: none;">
                                    <p data-bind="validationMessage: start" style="display: none;"></p>
                                    <p data-bind="validationMessage: end" style="display: none;"></p>
                                    <p data-bind="validationMessage: startYear" style="display: none;"></p>
                                    <p data-bind="validationMessage: endYear" style="display: none;"></p>
                                </div>

                            <hr data-bind="visible: $index() != ($parent.contents().length - 1)" style="display: none;">

                             </div>
                        </div>

                        <div class="p-t-lg p-b-lg">

                            <button  type="reset" class="btn btn-default" >Discard changes</button>

                            <button data-bind="disable: saving(), text: saving() ? 'Saving' : 'Save'" type="submit" class="btn btn-success">Save</button>

                        </div>
                        <br>

                        </form>
                         <!-- Choose which to add -->
                   
                </div>
                <!-- Component selection page -->
                

                <!-- Invite user page -->
                <div data-bind="if:page() === &quot;invite&quot;"></div><!-- end invite user page -->

            </div>

            <!-- END MODAL BODY MODAL BODY  -->
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

            </div>

            <div data-bind="if: mode() === 'view'"></div>

        </div>
        </div>
    </div>

</div>

</div>

</div>



<script>
iconName = function(name) {
    var nameToHtml = {
        "ORCID": "<i class='ai ai-orcid-square ai-2x' />",
        "ResearcherID": "<img src='http://tguillerme.github.io/images/logo-RID.png' class='icon-image'>",
        "Twitter": "<i class='fa fa-twitter-square fa-2x' />",
        "GitHub": "<i class='fa fa-github-square fa-2x' />",
        "LinkedIn": "<i class='fa fa-linkedin-square fa-2x' />",
        "ImpactStory": "<i class='ai ai-impactstory-square ai-2x' />",
        "Google Scholar": "<i class='ai ai-google-scholar-square ai-2x' />",
        "ResearchGate": "<i class='ai ai-researchgate-square ai-2x' />",
        "Academia": "<i class='ai ai-academia-square ai-2x' />",
        "Baidu Scholar": "<img src='http://www.baidu.com/favicon.ico' class='icon-image'>",
        "SSRN": "<img src='https://www.google.com/s2/favicons?domain=http://www.ssrn.com/' class='icon-image'>"
    };
    return nameToHtml[name];
}
</script>




        </div><!-- end container -->
    </div><!-- end watermarked -->




    


    
</div><!-- end container copyright -->

            <script>
            var _prum = [['id', "526076f6abe53d9e35000000"],
                            ['mark', 'firstbyte', (new Date()).getTime()]];
            (function() {
                var s = document.getElementsByTagName('script')[0]
                    , p = document.createElement('script');
                p.async = 'async';
                p.src = '//rum-static.pingdom.net/prum.min.js';
                s.parentNode.insertBefore(p, s);
            })();
            </script>

        

        

            <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', "UA-26813616-1", 'auto', {'allowLinker': true});
            ga('require', 'linker');
            ga('linker:autoLink', ['centerforopenscience.org', 'cos.io'] );
            ga('set', 'dimension1', "99c65e61b37df5b8df5b742ce8b0676d");
            ga('set', 'dimension2', "2017-04-03 14:57:33.612807");
            ga('send', 'pageview');
            </script>


        <script>
            // Mako variables accessible globally
            window.contextVars = $.extend(true, {}, window.contextVars, {
                waterbutlerURL: "https://files.osf.io/",
                // Whether or not this page is loaded under osf.io or another domain IE: institutions
                isOnRootDomain: "https://osf.io/" === window.location.origin + '/',
                cookieName: "osf",
                apiV2Prefix: "https://api.osf.io/v2/",
                registerUrl: "/api/v1/register/",
                currentUser: {
                    id: "83akk",
                    locale: "ru",
                    timezone: "Asia/Almaty",
                    entryPoint: "osf",
                    institutions: [],
                    emailsToAdd: [],
                    anon: {"country": "SE", "continent": "EU"},
                },
                popular: "57tnq",
                newAndNoteworthy: "z3sg2",
                maintenance: null,
                analyticsMeta: {},
            });
        </script>

            <script>
                window.contextVars = $.extend(true, {}, window.contextVars, {
                    keen: {
                        public: {
                            projectId: "5797b58fbcb79c2c0fa1a705",
                            writeKey: "40b0559c81c37757442b7fdeec4d384c0b2878ca9758ce561c1daa7b4c5cb77b0c9f80c562f313aa23ebef2c97cd70b2cf2af41716dc8fdb682ffaa52ff23441598432e81995e4899df55b6caa32edd3d208a05fd6367f0ac9fdcd2c4023c290",
                        },
                        private: {
                            projectId: "5797b5a3709a395e9e29c11d",
                            writeKey: "73357414691a69448b9b967b7c56a16602e02ebe3d21f348acd7e717cef40275536f302143758330dfabea49355753dd05ab3865aa675ef2d803c2baa9b591b825689d96e4492c181be6a6631c0328ee9eeb24704ee7beb6c90f9bd5f06cfcb2",
                        },
                    },
                });
            </script>


        
<script type="text/javascript">
    window.contextVars = window.contextVars || {};
    window.contextVars.nameUrls = {
        crud: "/api/v1/settings/names/",
        impute: "/api/v1/settings/names/impute/"
    };
    window.contextVars.socialUrls = {
        crud: "/api/v1/settings/social/"
    };
    window.contextVars.jobsUrls = {
        crud: "/api/v1/settings/jobs/"
    };
    window.contextVars.schoolsUrls = {
        crud: "/api/v1/settings/schools/"
    };
</script>
<script src="/static/public/js/profile-settings-page.d7f528fa6cf525529377.js"></script>

</body>
@endsection