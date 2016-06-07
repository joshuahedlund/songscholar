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
  <span id="chapterSpan">
    {{ Form::select('chapter', $chapters, null, array('id'=>'chapter')) }} 
  </span>
  : 
  <span id="verseSpan">
    {{ Form::select('verse', $verses, null, array('id'=>'verse')) }}
  </span>
</div>

</div>
  {{ Form::token() }}
  {{ Form::submit(null, array('class' => 'btn btn-default')) }}
{{ Form::close() }}
@endsection
