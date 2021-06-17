@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary pull-right">Add Video</a>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        @foreach($videos as $video)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6> {{$video->name}}</h6>
                        <video id="video-element" width="150" height="150" controls style="padding-top: 50px">
                            <source type="video/mp4" src="{{ asset('storage/'.$video->full) }}">
                        </video>
                        {{--                                                    <canvas id="canvas"></canvas>--}}
                        {{--                                                    <img id="videoThumbnail" class="img-fluid" alt="img">--}}
                        {{--                                                    <div id="thumbnail-container">--}}
                        {{--                                                        Seek to <select id="set-video-seconds"></select> seconds <a id="download-link" href="#">Download Thumbnail</a>--}}
                        {{--                                                    </div>--}}
                        <div class="btn-group" role="group" aria-label="Second group">
                            <a href="{{ route('admin.categories.edit', $video->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('admin.categories.delete', $video->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush
