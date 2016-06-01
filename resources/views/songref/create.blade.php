@extends('layouts.master')

@section('title', 'Add a Song Reference')

@section('content')
<h2>Add a Song Reference</h2>
{{ Form::open(array('route' => 'songrefs.store')) }}
<div class="form-group">
  {{ Form::label('artist','Artist') }}
  {{ Form::select('artist', $artists) }}
  {{ Form::text('artistname', null, array('class' => 'form-control','style' => 'display:none;')) }}
</div>
<div class="form-group">
  {{ Form::label('album','Album (optional)') }}
  <span id="albumSpan">
  </span>
  {{ Form::text('albumname', null, array('class' => 'form-control')) }}
</div>
<div class="form-group">
  {{ Form::label('song','Song') }}
  <span id="songSpan">
  </span>
  {{ Form::text('songname', null, array('class' => 'form-control')) }}
</div>
<div class="form-group">
  {{ Form::label('lyric','Lyric') }}
  {{ Form::textarea('lyric', null, array('class' => 'form-control', 'rows' => 3)) }}
</div>
<div class="form-group">
  {{ Form::label('book','Passage') }}
  <div>
  {{ Form::select('book', $books) }}
  {{ Form::text('chapter', null, array('class'=>'xs')) }} : {{ Form::text('verse',null,array('class'=>'xs')) }}
  Version: {{ Form::text('version', null, array('class'=>'xs')) }}
  </div>
<div class="form-group">
  {{ Form::label('text','Text') }}
  {{ Form::textarea('text', null, array('class' => 'form-control', 'rows' => 3)) }}
</div>

</div>
  {{ Form::token() }}
  {{ Form::submit(null, array('class' => 'btn btn-default')) }}
{{ Form::close() }}
@endsection
