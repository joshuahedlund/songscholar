@extends('layouts.master')

@section('title', 'Correct This Passage')

@section('content')
<h2>{{ $pv->passage->passageConcat() }} - Correct This Passage</h2>
{{ Form::open(array('route' => array('songRef.updatePassage',$songRef->id))) }}
<div class="form-group">
  {{ Form::label('book','Passage') }}
  <div>
  {{ Form::select('book', $books, $pv->passage->book) }}
  {{ Form::text('chapter', $pv->passage->chapter, array('class'=>'xs')) }} : {{ Form::text('verse',$pv->passage->verse, array('class'=>'xs')) }}
  Version: {{ Form::text('version', $pv->version, array('class'=>'xs')) }}
  </div>
<div class="form-group">
  {{ Form::label('text','Text') }}
  {{ Form::textarea('text', $pv->text, array('class' => 'form-control', 'rows' => 3)) }}
</div>

</div>
  {{ Form::token() }}
  {{ Form::submit(null, array('class' => 'btn btn-default')) }}
{{ Form::close() }}
@endsection
