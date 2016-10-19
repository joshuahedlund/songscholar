@extends('layouts.master')

@section('title', 'Add a Song Reference')

@section('content')
<h2>{{ $artist_name }}: Add a Song Reference</h2>

@if (Auth::user()->points <= 30)
<p><a href="javascript:void(0);" class="modalHints">(Read the Hopefully Helpful Hints!)</a></p>
@endif


{{ Form::open(array('route' => 'songrefs.store', 'id' => 'frmAddRef')) }}

{{ Form::hidden('artist',$artist_id) }}
<div class="form-group">
  {{ Form::label('album','Album (optional)') }}
  <div>
  {{ Form::select('album', $albums, @$album, array('class' => 'form-control auto','id'=>'album')) }}
 `{{ Form::text('albumname', null, array('class' => 'form-control m','style' => 'display:none;')) }}
`</div>
</div>
<div class="form-group">
  {{ Form::label('song','Song') }}
  <div>
  <span id="songSpan">
  </span>
  {{ Form::text('songname', @$song, array('class' => 'form-control m')) }}
  </div>
</div>
<div class="form-group">
  {{ Form::label('lyric','Lyric') }}
  {{ Form::textarea('lyric', null, array('class' => 'form-control', 'rows' => 3)) }}
</div>
<div class="form-group">
  {{ Form::label('book','Passage') }}
  {{ Form::select('book', $books, null, array('class'=>'form-control auto')) }}
  <span id="chapterSpan">
    {{ Form::select('chapter', $chapters, null, array('id'=>'chapter', 'class'=>'form-control auto')) }} 
  </span>
  : 
  <span id="verseSpan">
    {{ Form::select('verse', $verses, null, array('id'=>'verse', 'class'=>'form-control auto')) }}
  </span>
</div>
<div class="form-group" id="editPassageVersionFields">
    <i>Select passage to choose a version</i>
    <br/>
    <br/>
</div>

<div class="alert alert-danger" id="jsErrors" style="display:none">
</div>


  {{ Form::submit(null, array('class' => 'btn btn-default')) }}
    
{{ Form::close() }}
@endsection
