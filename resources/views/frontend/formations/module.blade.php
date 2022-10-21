@extends('frontend.layouts.app')

@push('after-styles')
    {{--<link rel="stylesheet" href="{{asset('plugins/YouTube-iFrame-API-Wrapper/css/main.css')}}">--}}
    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.3/plyr.css"/>
    <link href="{{asset('plugins/touchpdf-master/jquery.touchPDF.css')}}" rel="stylesheet">

    <style>
        .test-form {
            color: #333333;
        }

        .formation-details-category ul li {
            width: 100%;
        }

        .sidebar.is_stuck {
            top: 15% !important;
        }

        .formation-timeline-list {
            max-height: 300px;
            overflow: scroll;
        }

        .options-list li {
            list-style-type: none;
        }

        .options-list li.correct {
            color: green;

        }

        .options-list li.incorrect {
            color: red;

        }

        .options-list li.correct:before {
            content: "\f058"; /* FontAwesome Unicode */
            font-family: 'Font Awesome\ 5 Free';
            display: inline-block;
            color: green;
            margin-left: -1.3em; /* same as padding-left set on li */
            width: 1.3em; /* same as padding-left set on li */
        }

        .options-list li.incorrect:before {
            content: "\f057"; /* FontAwesome Unicode */
            font-family: 'Font Awesome\ 5 Free';
            display: inline-block;
            color: red;
            margin-left: -1.3em; /* same as padding-left set on li */
            width: 1.3em; /* same as padding-left set on li */
        }

        .options-list li:before {
            content: "\f111"; /* FontAwesome Unicode */
            font-family: 'Font Awesome\ 5 Free';
            display: inline-block;
            color: black;
            margin-left: -1.3em; /* same as padding-left set on li */
            width: 1.3em; /* same as padding-left set on li */
        }

        .touchPDF {
            border: 1px solid #e3e3e3;
        }

        .touchPDF > .pdf-outerdiv > .pdf-toolbar {
            height: 0;
            color: black;
            padding: 5px 0;
            text-align: right;
        }

        .pdf-tabs {
            width: 100% !important;
        }

        .pdf-outerdiv {
            width: 100% !important;
            left: 0 !important;
            padding: 0px !important;
            transform: scale(1) !important;
        }

        .pdf-viewer {
            left: 0px;
            width: 100% !important;
        }

        .pdf-drag {
            width: 100% !important;
        }

        .pdf-outerdiv {
            left: 0px !important;
        }

        .pdf-outerdiv {
            padding-left: 0px !important;
            left: 0px;
        }

        .pdf-toolbar {
            left: 0px !important;
            width: 99% !important;
            height: 30px;
        }

        .pdf-viewer {
            box-sizing: border-box;
            left: 0 !important;
            margin-top: 10px;
        }

        .pdf-title {
            display: none !important;
        }

        @media screen  and  (max-width: 768px) {

        }

    </style>
@endpush

@section('content')



    <!-- Start of formation details section
        ============================================= -->
    <section id="formation-details" class="formation-details-section">
        <div class="container ">
            <div class="row main-content">
                <div class="col-md-9">
                    @if(session()->has('success'))
                        <div class="alert alert-dismissable alert-success fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{session('success')}}
                        </div>
                    @endif
                    @include('includes.partials.messages')

                    <div class="formation-details-item border-bottom-0 mb-0">
                        @if($module->module_image != "")
                            <div class="formation-single-pic mb30">
                                <img src="{{asset('storage/uploads/'.$module->module_image)}}"
                                     alt="">
                            </div>
                        @endif


                        @if ($test_exists)
                            <div class="formation-single-text">
                                <div class="formation-title mt10 headline relative-position">
                                    <h3>
                                        <b>@lang('labels.frontend.formation.test')
                                            : {{$module->title}}</b>
                                    </h3>
                                </div>
                                <div class="formation-details-content">
                                    <p> {!! $module->full_text !!} </p>
                                </div>
                            </div>
                            <hr/>
                            @if (!is_null($test_result))
                                <div class="alert alert-info">@lang('labels.frontend.formation.your_test_score')
                                    : {{ $test_result->test_result }}</div>
                                @if(config('retest'))
                                    <form action="{{route('modules.retest',[$test_result->test->slug])}}" method="post">
                                        @csrf
                                        <input type="hidden" name="result_id" value="{{$test_result->id}}">
                                        <button type="submit" class="btn gradient-bg font-weight-bold text-white"
                                                href="">
                                            @lang('labels.frontend.formation.give_test_again')
                                        </button>
                                    </form>
                                @endif
                                @if(count($module->questions) > 0  )
                                    <hr>

                                    @foreach ($module->questions as $question)

                                        <h4 class="mb-0">{{ $loop->iteration }}
                                            . {!! $question->question !!}   @if(!$question->isAttempted($test_result->id))
                                                <small class="badge badge-danger"> @lang('labels.frontend.formation.not_attempted')</small> @endif
                                        </h4>
                                        <br/>
                                        <ul class="options-list pl-4">
                                            @foreach ($question->options as $option)

                                                <li class="@if(($option->answered($test_result->id) != null && $option->answered($test_result->id) == 1) || ($option->correct == true)) correct @elseif($option->answered($test_result->id) != null && $option->answered($test_result->id) == 2) incorrect  @endif"> {{ $option->option_text }}

                                                    @if($option->correct == 1 && $option->explanation != null)
                                                        <p class="text-dark">
                                                            <b>@lang('labels.frontend.formation.explanation')</b><br>
                                                            {{$option->explanation}}
                                                        </p>
                                                    @endif
                                                </li>

                                            @endforeach
                                        </ul>
                                        <br/>
                                    @endforeach

                                @else
                                    <h3>@lang('labels.general.no_data_available')</h3>

                                @endif
                            @else
                                <div class="test-form">
                                    @if(count($module->questions) > 0  )
                                        <form action="{{ route('modules.test', [$module->slug]) }}" method="post">
                                            {{ csrf_field() }}
                                            @foreach ($module->questions as $question)
                                                <h4 class="mb-0">{{ $loop->iteration }}. {!! $question->question !!}  </h4>
                                                <br/>
                                                @foreach ($question->options as $option)
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="questions[{{ $question->id }}]"
                                                                   value="{{ $option->id }}"/>
                                                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                            {{ $option->option_text }}<br/>
                                                        </label>
                                                    </div>
                                                @endforeach
                                                <br/>
                                            @endforeach
                                            <input class="btn gradient-bg text-white font-weight-bold" type="submit"
                                                   value=" @lang('labels.frontend.formation.submit_results') "/>
                                        </form>
                                    @else
                                        <h3>@lang('labels.general.no_data_available')</h3>

                                    @endif
                                </div>
                            @endif
                            <hr/>
                        @else
                            <div class="formation-single-text">
                                <div class="formation-title mt10 headline relative-position">
                                    <h3>
                                        <b>{{$module->title}}</b>
                                    </h3>
                                </div>
                                <div class="formation-details-content">
                                    {!! $module->full_text !!}
                                </div>
                            </div>
                        @endif

                        @if($module->mediaPDF)
                            <div class="formation-single-text mb-5">
                                {{--<iframe src="{{asset('storage/uploads/'.$module->mediaPDF->name)}}" width="100%"--}}
                                {{--height="500px">--}}
                                {{--</iframe>--}}
                                <div id="myPDF"></div>

                            </div>
                        @endif


                        @if($module->mediaVideo && $module->mediavideo->count() > 0)
                            <div class="formation-single-text">
                                @if($module->mediavideo != "")
                                    <div class="formation-details-content mt-3">
                                        <div class="video-container mb-5" data-id="{{$module->mediavideo->id}}">
                                            @if($module->mediavideo->type == 'youtube')


                                                <div id="player" class="js-player" data-plyr-provider="youtube"
                                                     data-plyr-embed-id="{{$module->mediavideo->file_name}}"></div>
                                            @elseif($module->mediavideo->type == 'vimeo')
                                                <div id="player" class="js-player" data-plyr-provider="vimeo"
                                                     data-plyr-embed-id="{{$module->mediavideo->file_name}}"></div>
                                            @elseif($module->mediavideo->type == 'upload')
                                                <video poster="" id="player" class="js-player" playsinline controls>
                                                    <source src="{{$module->mediavideo->url}}" type="video/mp4"/>
                                                </video>
                                            @elseif($module->mediavideo->type == 'embed')
                                                {!! $module->mediavideo->url !!}
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($module->mediaAudio)
                            <div class="formation-single-text mb-5">
                                <audio id="audioPlayer" controls>
                                    <source src="{{$module->mediaAudio->url}}" type="audio/mp3"/>
                                </audio>
                            </div>
                        @endif


                        @if(($module->downloadableMedia != "") && ($module->downloadableMedia->count() > 0))
                            <div class="formation-single-text mt-4 px-3 py-1 gradient-bg text-white">
                                <div class="formation-title mt10 headline relative-position">
                                    <h4 class="text-white">
                                        @lang('labels.frontend.formation.download_files')
                                    </h4>
                                </div>

                                @foreach($module->downloadableMedia as $media)
                                    <div class="formation-details-content text-white">
                                        <p class="form-group">
                                            <a href="{{ route('download',['filename'=>$media->name,'module'=>$module->id]) }}"
                                               class="text-white font-weight-bold"><i
                                                        class="fa fa-download"></i> {{ $media->name }}
                                                ({{ number_format((float)$media->size / 1024 , 2, '.', '')}} @lang('labels.frontend.formation.mb')
                                                )</a>
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <!-- /formation-details -->

                    <!-- /market guide -->

                    <!-- /review overview -->
                </div>

                <div class="col-md-3">
                    <div id="sidebar" class="sidebar">
                        <div class="formation-details-category ul-li">
                            @if ($previous_module)
                                <p><a class="btn btn-block gradient-bg font-weight-bold text-white"
                                      href="{{ route('modules.show', [$previous_module->formation_id, $previous_module->model->slug]) }}"><i
                                                class="fa fa-angle-double-left"></i>
                                        @lang('labels.frontend.formation.prev')</a></p>
                            @endif

                            <p id="nextButton">
                                @if($next_module)
                                    @if((int)config('module_timer') == 1 && $module->isCompleted() )
                                        <a class="btn btn-block gradient-bg font-weight-bold text-white"
                                           href="{{ route('modules.show', [$next_module->formation_id, $next_module->model->slug]) }}">@lang('labels.frontend.formation.next')
                                            <i class='fa fa-angle-double-right'></i> </a>
                                    @else
                                        <a class="btn btn-block gradient-bg font-weight-bold text-white"
                                           href="{{ route('modules.show', [$next_module->formation_id, $next_module->model->slug]) }}">@lang('labels.frontend.formation.next')
                                            <i class='fa fa-angle-double-right'></i> </a>
                                    @endif
                                @endif
                            </p>
                            @if($module->formation->progress() == 100)
                                @if(!$module->formation->isUserCertified())
                                    <form method="post" action="{{route('admin.certificates.generate')}}">
                                        @csrf
                                        <input type="hidden" value="{{$module->formation->id}}" name="formation_id">
                                        <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                id="finish">@lang('labels.frontend.formation.finish_formation')</button>
                                    </form>
                                @else
                                    <div class="alert alert-success">
                                        @lang('labels.frontend.formation.certified')
                                    </div>
                                @endif
                            @endif


                            <span class="float-none">@lang('labels.frontend.formation.formation_timeline')</span>
                            <ul class="formation-timeline-list">
                                @foreach($module->formation->formationTimeline()->orderBy('sequence')->get() as $key=>$item)
                                    @if($item->model && $item->model->published == 1)
                                        {{--@php $key++; @endphp--}}
                                        <li class="@if($module->id == $item->model->id) active @endif ">
                                            <a @if(in_array($item->model->id,$completed_modules))href="{{route('modules.show',['id' => $module->formation->id,'slug'=>$item->model->slug])}}"@endif>
                                                {{$item->model->title}}
                                                @if($item->model_type == 'App\Models\Test')
                                                    <p class="mb-0 text-primary">
                                                        - @lang('labels.frontend.formation.test')</p>
                                                @endif
                                                @if(in_array($item->model->id,$completed_modules)) <i
                                                        class="fa text-success float-right fa-check-square"></i> @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="couse-feature ul-li-block">
                            <ul>
                                <li>@lang('labels.frontend.formation.chapters')
                                    <span> {{$module->formation->chapterCount()}} </span></li>
                                <li>@lang('labels.frontend.formation.category') <span><a
                                                href="{{route('formations.category',['category'=>$module->formation->category->slug])}}"
                                                target="_blank">{{$module->formation->category->name}}</a> </span></li>
                                <li>@lang('labels.frontend.formation.author') <span>

                   @foreach($module->formation->teachers as $key=>$teacher)
                                            @php $key++ @endphp
                                            <a href="{{route('teachers.show',['id'=>$teacher->id])}}" target="_blank">
                           {{$teacher->full_name}}@if($key < count($module->formation->teachers )), @endif
                       </a>
                                        @endforeach
                                    </span>
                                </li>
                                <li>@lang('labels.frontend.formation.progress') <span> <b> {{ $module->formation->progress()  }}
                                            % @lang('labels.frontend.formation.completed')</b></span></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of formation details section
    ============================================= -->

@endsection

@push('after-scripts')
    {{--<script src="//www.youtube.com/iframe_api"></script>--}}
    <script src="{{asset('plugins/sticky-kit/sticky-kit.js')}}"></script>
    <script src="https://cdn.plyr.io/3.5.3/plyr.polyfilled.js"></script>
    <script src="{{asset('plugins/touchpdf-master/pdf.compatibility.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/pdf.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/jquery.touchSwipe.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/jquery.touchPDF.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/jquery.panzoom.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/jquery.mousewheel.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>


    <script>
        @if($module->mediaPDF)
        $(function () {
            $("#myPDF").pdf({
                source: "{{asset('storage/uploads/'.$module->mediaPDF->name)}}",
                loadingHeight: 800,
                loadingWidth: 800,
                loadingHTML: ""
            });

        });
                @endif

        var storedDuration = 0;
        var storedModule;
        storedDuration = Cookies.get("duration_" + "{{auth()->user()->id}}" + "_" + "{{$module->id}}" + "_" + "{{$module->formation->id}}");
        storedModule = Cookies.get("module" + "{{auth()->user()->id}}" + "_" + "{{$module->id}}" + "_" + "{{$module->formation->id}}");
        var user_module;

        if (parseInt(storedModule) != parseInt("{{$module->id}}")) {
            Cookies.set('module', parseInt('{{$module->id}}'));
        }


                @if($module->mediaVideo && $module->mediaVideo->type != 'embed')
        var current_progress = 0;


        @if($module->mediaVideo->getProgress(auth()->user()->id) != "")
            current_progress = "{{$module->mediaVideo->getProgress(auth()->user()->id)->progress}}";
                @endif



        const player2 = new Plyr('#audioPlayer');

        const player = new Plyr('#player');
        duration = 10;
        var progress = 0;
        var video_id = $('#player').parents('.video-container').data('id');
        player.on('ready', event => {
            player.currentTime = parseInt(current_progress);
            duration = event.detail.plyr.duration;


            if (!storedDuration || (parseInt(storedDuration) === 0)) {
                Cookies.set("duration_" + "{{auth()->user()->id}}" + "_" + "{{$module->id}}" + "_" + "{{$module->formation->id}}", duration);
            }

        });

        {{--if (!storedDuration || (parseInt(storedDuration) === 0)) {--}}
        {{--Cookies.set("duration_" + "{{auth()->user()->id}}" + "_" + "{{$module->id}}" + "_" + "{{$module->formation->id}}", player.duration);--}}
        {{--}--}}


        setInterval(function () {
            player.on('timeupdate', event => {
                if ((parseInt(current_progress) > 0) && (parseInt(current_progress) < parseInt(event.detail.plyr.currentTime))) {
                    progress = current_progress;
                } else {
                    progress = parseInt(event.detail.plyr.currentTime);
                }
            });
            if(duration !== 0 || parseInt(progress) !== 0 ) {
                saveProgress(video_id, duration, parseInt(progress));
            }
        }, 3000);


        function saveProgress(id, duration, progress) {
            $.ajax({
                url: "{{route('update.videos.progress')}}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'video': parseInt(id),
                    'duration': parseInt(duration),
                    'progress': parseInt(progress)
                },
                success: function (result) {
                    if (progress === duration) {
                        location.reload();
                    }
                }
            });
        }


        $('#notice').on('hidden.bs.modal', function () {
            location.reload();
        });

        @endif

        $("#sidebar").stick_in_parent();


        @if((int)config('module_timer') != 0)
        //Next Button enables/disable according to time

        var readTime, totalQuestions, testTime;
        user_module = Cookies.get("user_module_" + "{{auth()->user()->id}}" + "_" + "{{$module->id}}" + "_" + "{{$module->formation->id}}");

        @if ($test_exists )
            totalQuestions = '{{count($module->questions)}}'
        readTime = parseInt(totalQuestions) * 30;
        @else
            readTime = parseInt("{{$module->readTime()}}") * 60;
        @endif

                @if(!$module->isCompleted())
            storedDuration = Cookies.get("duration_" + "{{auth()->user()->id}}" + "_" + "{{$module->id}}" + "_" + "{{$module->formation->id}}");
        storedModule = Cookies.get("module" + "{{auth()->user()->id}}" + "_" + "{{$module->id}}" + "_" + "{{$module->formation->id}}");


        var totalModuleTime = readTime + (parseInt(storedDuration) ? parseInt(storedDuration) : 0);
        var storedCounter = (Cookies.get("storedCounter_" + "{{auth()->user()->id}}" + "_" + "{{$module->id}}" + "_" + "{{$module->formation->id}}")) ? Cookies.get("storedCounter_" + "{{auth()->user()->id}}" + "_" + "{{$module->id}}" + "_" + "{{$module->formation->id}}") : 0;
        var counter;
        if (user_module) {
            if (user_module === 'true') {
                counter = 1;
            }
        } else {
            if ((storedCounter != 0) && storedCounter < totalModuleTime) {
                counter = storedCounter;
            } else {
                counter = totalModuleTime;
            }
        }
        var interval = setInterval(function () {
            counter--;
            // Display 'counter' wherever you want to display it.
            if (counter >= 0) {
                // Display a next button box
                $('#nextButton').html("<a class='btn btn-block bg-danger font-weight-bold text-white' href='#'>@lang('labels.frontend.formation.next') (in " + counter + " seconds)</a>")
                Cookies.set("duration_" + "{{auth()->user()->id}}" + "_" + "{{$module->id}}" + "_" + "{{$module->formation->id}}", counter);

            }
            if (counter === 0) {
                Cookies.set("user_module_" + "{{auth()->user()->id}}" + "_" + "{{$module->id}}" + "_" + "{{$module->formation->id}}", 'true');
                Cookies.remove('duration');

                @if ($test_exists && (is_null($test_result)))
                $('#nextButton').html("<a class='btn btn-block bg-danger font-weight-bold text-white' href='#'>@lang('labels.frontend.formation.complete_test')</a>")
                @else
                @if($next_module)
                $('#nextButton').html("<a class='btn btn-block gradient-bg font-weight-bold text-white'" +
                    " href='{{ route('modules.show', [$next_module->formation_id, $next_module->model->slug]) }}'>@lang('labels.frontend.formation.next')<i class='fa fa-angle-double-right'></i> </a>");
                @else
                $('#nextButton').html("<form method='post' action='{{route("admin.certificates.generate")}}'>" +
                    "<input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}' />" +
                    "<input type='hidden' value='{{$module->formation->id}}' name='formation_id'> " +
                    "<button class='btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold' id='finish'>@lang('labels.frontend.formation.finish_formation')</button></form>");

                @endif

                @if(!$module->isCompleted())
                formationCompleted("{{$module->id}}", "{{get_class($module)}}");
                @endif
                @endif
                clearInterval(counter);
            }
        }, 1000);

        @endif
        @endif

        function formationCompleted(id, type) {
            $.ajax({
                url: "{{route('update.formation.progress')}}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'model_id': parseInt(id),
                    'model_type': type,
                },
            });
        }

    </script>
@endpush
