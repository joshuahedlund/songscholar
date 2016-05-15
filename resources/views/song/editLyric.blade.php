{{ Form::open(array('route' => array('songRef.updateLyric',$songRef->id))) }}
<div class="form-group">
  {{ Form::textarea('lyric', $songRef->lyric, array('class' => 'form-control', 'rows' => 3)) }}
</div>
  {{ Form::token() }}
  {{ Form::submit(null, array('class' => 'btn btn-default')) }}
{{ Form::close() }}