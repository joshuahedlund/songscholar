@extends('layouts.master')

@section('title', 'Search for '.$searchTerm)

@section('content')
        <div class="panel panel-primary">
            <div class="panel-heading panel-title">
                {{ 'Search for '.$searchTerm }}
            </div>
        </div>
           
           @if(count($artists)>0)
           <div class="panel panel-default">
                <div class="panel-heading">Artists</div>

                <div class="panel-body">
                @foreach($artists as $artist)
                <p>{{HTML::linkAction('ArtistController@displayArtist',$artist->name,array(str_replace(' ','-',$artist->name))) }}</p>
                @endforeach
                </div>
            </div>
            @endif
            
            @if(count($songs)>0)
           <div class="panel panel-default">
                <div class="panel-heading">Songs</div>

                <div class="panel-body">
                @foreach($songs as $song)
                <p>{{HTML::linkAction('SongController@index',$song->name.' - '.$song->artist->name,$song->id) }}</p>
                @endforeach
                </div>
            </div>
            @endif
            
            @if(count($songRefs)>0)
           <div class="panel panel-default">
                <div class="panel-heading">Song References</div>

                <div class="panel-body">
                @foreach($songRefs as $songRef)
                <p>{{HTML::linkAction('SongController@index',$songRef->songname.' - '.$songRef->artistname,$songRef->songid) }}<br/>
                "{{$songRef->lyric}}"
                </p>
                @endforeach
                </div>
            </div>
            @endif
           
@endsection
