@extends('layouts.master')

@section('title', 'Correct This Lyric')

@section('content')
<h2>{{ $songRef->song->name }} - Correct This Lyric</h2>
{{ Form::open(array('route' => array('songRef.updateLyric',$songRef->id))) }}
<div class="form-group">
  {{ Form::label('lyric','Lyric') }}
  {{ Form::textarea('lyric', $songRef->lyric, array('class' => 'form-control', 'rows' => 3)) }}
</div>
  {{ Form::token() }}
  {{ Form::submit(null, array('class' => 'btn btn-default')) }}
{{ Form::close() }}
@endsection
