@extends('layouts.master')

@section('title','Song Scholar')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome!</div>

                <div class="panel-body">
                    <p>SongScholar is a database of song lyrics that reference Bible verses.</p>
                </div>
            </div>
            
            @if (count($artists)>0)
            <div class="panel panel-default">
                <div class="panel-heading">View References by Artist</div>

                <div class="panel-body">
                @foreach ($artists as $artist)
                    <p>{{HTML::linkAction('ArtistController@index',$artist->name,array(str_replace(' ','-',$artist->name))) }}</p>
                @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
