@extends('layouts.master')

@section('title', 'Add an Artist')

@section('content')
        <div class="panel panel-primary">
            <div class="panel-heading panel-title">
                Add An Artist
            </div>

            <div class="panel-body">
            {{ Form::open(['route' => 'artist.store']) }}
            <div class="form-group">
                {{ Form::text('artistname', null, ['class'=>'form-control m']) }}
            </div>
            
            {{ Form::submit(null, ['class'=>'btn btn-default']) }}
            
            {{ Form::close() }}
            </div>
        </div>
@endsection
