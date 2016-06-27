@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <!-- <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
    <div class="panel-heading">Dashboard</div>
    <div class="panel-body">
  </div>
</div>
</div> -->
<div class="col-md-9 col-md-push-2">

</div>
<div class="col-md-3 col-md-pull-10">
  <!-- Button trigger modal -->
  <div class="jumbotron">
    <h2 class="text-center">Actions</h2>
    <button type="button" class="bbtn btn-danger btn-lg btn-block" data-toggle="modal" data-target="#myModal">
      Download video
    </button>
  </div>
</div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Download Video</h4>
      </div>
      <!-- form to download video -->
      <form class="form-horizontal" role="form" action="{{ url('/video') }}" method="POST">
        {{ csrf_field() }}
        <div class="modal-body">
          <div class="form-group">
            <label class="col-xs-3 control-label">Video URL</label>
            <div class="col-xs-9">
              <input name="url" id="url" type="text" class="form-control" placeholder="Video URL" aria-describedby="basic-addon1">
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-3 control-label">Format</label>
            <div class="col-xs-9 selectContainer">
              <select class="form-control" name="format">
                <!-- <option value="default">Default</option> -->
                <option value="mp4">mp4</option>
                <option value="3gp">3gp</option>
                <option value="webm">webm</option>
                <option value="m4a">m4a (Audio Only)</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="sumbit" class="btn btn-danger btn-lg btn-block">
            <span class="glyphicon glyphicon-download-alt" aria-hidden="true">
            </span>
          </button>
          <button type="button" class="btn btn-default btn-lg btn-block" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- table video -->

<table class="table table-hover">
    <thead>
        <tr>
          <td>URL</td>
            <td>State</td>
        </tr>
    </thead>
    <tbody>
    @foreach($videos as $key => $value)
      @if ( $value->state == 'ready')
        <tr class="success">
          <td>{{ $value->video_url }}</td>
          <td>{{ $value->state }}</td>
          <!-- "/download/{{json_encode(array('location'=>$value->video_location))}}" -->
          <td><form class="" action="/download/" method="post">  {{ csrf_field() }}
            <input type="hidden" name="location" id="location" value="{{$value}}">
            <button  type="submit" class="btn btn-success btn-lg btn-block">
              <span class="glyphicon glyphicon-download-alt" aria-hidden="true">
              </span>
            </button>
          </form>
          </td>
        </tr>
        @else
        <tr class="active">
          <td>{{ $value->video_url }}</td>
          <td>{{ $value->state }}</td>
          <td><button type="sumbit" action="" class="btn disabled btn-danger btn-lg btn-block">
              <span class="glyphicon glyphicon-download-alt" aria-hidden="true">
              </span>
            </button>
          </td>
        </tr>
          @endif
    @endforeach
    </tbody>
</table>
@endsection
