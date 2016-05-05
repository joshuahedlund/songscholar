@extends('layouts.app')

@section('title', 'Add a Song Reference')

@section('content')
<h2>Add a Song Reference</h2>
{{ Form::open(array('route' => 'songrefs.store')) }}
<div class="form-group">
  {{ Form::label('artist','Artist') }}
  {{ Form::text('artist', null, array('class' => 'form-control')) }}
</div>
<div class="form-group">
  {{ Form::label('album','Album') }}
  {{ Form::text('album', null, array('class' => 'form-control')) }}
</div>
<div class="form-group">
  {{ Form::label('song','Song') }}
  {{ Form::text('song', null, array('class' => 'form-control')) }}
</div>
<div class="form-group">
  {{ Form::label('songRefs.lyric','Lyric') }}
  {{ Form::textarea('songRefs.lyric', null, array('class' => 'form-control', 'rows' => 3)) }}
</div>
<div class="form-group">
  {{ Form::label('books.name','Passage') }}
  <div>
  {{ Form::select('books.name', $books) }}
  {{ Form::text('chapter', null) }} : {{ Form::text('verse',null) }}
  Version: {{ Form::text('version', null) }}
  </div>
<div class="form-group">
  {{ Form::label('passages.text','Text') }}
  {{ Form::textarea('passages.text', null, array('class' => 'form-control', 'rows' => 3)) }}
</div>

</div>
  {{ Form::token() }}
  {{ Form::submit(null, array('class' => 'btn btn-default')) }}
{{ Form::close() }}
@endsection
