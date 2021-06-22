@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/html-duration-picker/dist/html-duration-picker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/js/plugins/dropzone/dist/min/dropzone.min.css') }}"/>
@endsection
@section('content')
<div class="app-title">
    <div>
        <h1>{{ $pageTitle }} - {{ $subTitle }}</h1>
    </div>
</div>
@include('admin.partials.flash')
<div class="row user">
    <div class="col-md-3">
        <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
                <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">General</a></li>
                <li class="nav-item"><a class="nav-link" href="#content" data-toggle="tab">Content</a></li>
                <li class="nav-item"><a class="nav-link" href="#attributes" data-toggle="tab">Attributes</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content">
            @if ($errors->any())

                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach

            @endif
            <div class="tab-pane" id="content">
                <div class="tile">
                    <h3 class="tile-title">Upload new content</h3>
                    <hr>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="content-type">Select content type<span class="m-l-5 text-danger"> *</span></label>
                            <select id="content-type" class="form-control custom-select mt-15 @error('content-type') is-invalid @enderror" name="parent_id">--}}
                                    <option value="html" selected> Html </option>
                                    <option value="video" selected> Video </option>
                                    <option value="powerpoint" selected> Powerpoint </option>
                                    <option value="pdf" selected> Pdf </option>
                            </select>
                            <input type="hidden" name="course_id" value="{{ $targetCourse->id }}">
                            @error('content-type') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content-name">Name</label>
                            <input type="text" class="form-control" placeholder="Enter name for content" name="content-name" id="content-name">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content-description">Description (Enter description of content)</label>
                            <textarea class="form-control" rows="4" name="content-description" id="content-description">{{ old('description', $targetCourse->description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="duration-input">Duration (Enter the duration for the content)</label>
                            <p></p>
                            <input class="html-duration-picker " id="duration-input" name="duration-input">
                        </div>
                        <hr>
                        <h3 class="tile-title">Add File</h3>

                        <div class="row">
                            <div class="col-md-12">

                                <form action="" class="dropzone" id="dropzone" style="border: 2px dashed rgba(0,0,0,0.3)">

                                    <input type="hidden" name="course_id" value="{{ $targetCourse->id }}">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                        <div class="row d-print-none mt-2">
                            <div class="col-12 text-right">
                                <button class="btn btn-success" type="button" id="uploadButton">
                                    <i class="fa fa-fw fa-lg fa-upload"></i>Upload Content
                                </button>
                            </div>
                        </div>
                        @if ($videos != null)

                            <div class="row">
                                @foreach($videos as $video)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <video id="video-element" width="100" height="100" controls>
                                                    <source type="video/mp4" src="{{ asset('storage/'.$video->full) }}">
                                                </video>
                                                {{--                                                    <canvas id="canvas"></canvas>--}}
                                                {{--                                                    <img id="videoThumbnail" class="img-fluid" alt="img">--}}
                                                {{--                                                    <div id="thumbnail-container">--}}
                                                {{--                                                        Seek to <select id="set-video-seconds"></select> seconds <a id="download-link" href="#">Download Thumbnail</a>--}}
                                                {{--                                                    </div>--}}
                                                <a class="card-link float-right text-danger" href="#">
                                                    <i class="fa fa-fw fa-lg fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                        </div>
                    @endif
                </div>
            </div>
            </div>
            <div class="tab-pane active" id="general">
                <div class="tile">
                    <form action="{{ route('admin.courses.update') }}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf
                        <h3 class="tile-title">Course Information</h3>
                        <hr>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="name">Name</label>
                                <input
                                    class="form-control @error('name') is-invalid @enderror"
                                    type="text"
                                    placeholder="Enter course name"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $targetCourse->name) }}"
                                />
                                <input type="hidden" name="course_id"  id="course_id" value="{{ $targetCourse->id }}">
                                <div class="invalid-feedback active">
                                    <i class="fa fa-exclamation-circle fa-fw"></i> @error('name') <span>{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="description">Description</label>
                                <textarea name="description" id="description" rows="8" class="form-control">{{ old('description', $targetCourse->description) }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="categories">Categories</label>
                                        <select name="categories[]" id="categories" class="form-control" multiple>

                                            @foreach($categories as $category)
                                                {{--                                                    @php $check = in_array($category->id, $targetCourse->categories->pluck('id')->toArray()) ? 'selected' : '' @endphp--}}
                                                {{--                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>--}}
                                                @if(in_array($category->id , $targetCourse->categories->pluck('id')->toArray()))
                                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                                @else
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label class="control-label" for="duration-input">Duration</label>--}}
{{--                                        <input class="html-duration-picker " id="duration-input" name="duration-input">--}}
{{--                                        <input>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               id="status"
                                               name="status"
                                            {{ $targetCourse->status == 1 ? 'checked' : '' }}
                                        />Status
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               id="featured"
                                               name="featured"
                                            {{ $targetCourse->featured == 1 ? 'checked' : '' }}
                                        />Featured
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($targetCourse->image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('storage/'.$targetCourse->image) }}" id="courseImage" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Course Image</label>
                                    <input class="form-control" type="file" id="image" name="image"/>
                                    @error('image'){{ $message }} @enderror
                                    {{--                                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>--}}
                                    {{--                                        @error('image') {{ $message }} @enderror--}}
                                </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <div class="row d-print-none mt-2">
                                <div class="col-12 text-right">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Product</button>
                                    <a class="btn btn-danger" href="{{ route('admin.courses.index') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
{{--                </div>--}}
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/select2.min.js') }}"></script>
    {{--    <script type="text/javascript" src="{{ asset('backend/js/app.js') }}"></script>--}}
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plu-gins/bootstrap-notify.min.js') }}"></script>
    <script>
        $( document ).ready(function() {
            $('#categories').select2();
        });
    </script>
    <script>
        Dropzone.autoDiscover = false;
        $( document ).ready(function() {
            $('#categories').select2();

            let myDropzone = new Dropzone("#dropzone", {
                paramName: "video",
                addRemoveLinks: false,
                acceptedFiles: ".mp4,.avi,.WebRip,.gif",
                maxFilesize: 40,
                parallelUploads: 2,
                uploadMultiple: false,
                url: "{{ route('admin.courses.videos.upload') }}",
                autoProcessQueue: false,
                init: function (){
                    this.on("success", function(file, responseText) {
                        showNotification('Completed', 'All videos uploaded', 'success', 'fa-check');
                        console.log(responseText);
                        window.location.reload();
                    });
                    this.on("error", function(file, responseText) {
                        showNotification('Error', responseText, 'danger', 'fa-close');
                        console.log(responseText);
                        window.location.reload();
                    });
                },
                // error: function(response){
                //     console.log(response);
                //     showNotification('Error','alert','fa-check');
                // },
                // success: function(response){
                //     console.log(response);
                //     showNotification()
                // }
            });

            myDropzone.on("queuecomplete", function (file,response) {
                //window.location.reload();
                //console.log(response);
                //showNotification('Completed', 'All videos uploaded', 'success', 'fa-check');
            });
            $('#uploadButton').click(function(){
                if (myDropzone.files.length === 0) {
                    showNotification('Error', 'Please select files to upload.', 'danger', 'fa-close');
                } else {
                    myDropzone.processQueue();
                }
            });
            function showNotification(title, message, type, icon)
            {
                $.notify({
                    title: title + ' : ',
                    message: message,
                    icon: 'fa ' + icon
                },{
                    type: type,
                    allow_dismiss: true,
                    placement: {
                        from: "top",
                        align: "right"
                    },
                });
            }
        });

        {{--    document.querySelector('#video-element source').setAttribute('src',{!! json_encode($video->full, JSON_HEX_TAG) !!})--}}
        {{--console.log({!! json_encode($video->full, JSON_HEX_TAG) !!});--}}
    </script>
@endpush
