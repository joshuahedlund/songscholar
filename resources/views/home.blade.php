@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading panel-title">Welcome!</div>

                <div class="panel-body">
                    <img src="/img/songRefs.png" style="float:left;">
                    <p>
                        SongRefs is a database of song lyrics that reference Bible verses.
                        @if(Auth::guest())
                            <a href="/register">Create an account</a> to contribute!
                        @else
                            {{HTML::linkAction('ArtistController@index','Find an artist')}} and add a reference!
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
            
    <div class="row">
            
        @if (count($books)>0)
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">View References by Book</div>

                <div class="panel-body">
                @foreach ($books as $book)             
                    
                        {{HTML::linkAction('BookController@index',$book->bookname,array(str_replace(' ','-',$book->bookname))) }} 
                        ({{ $book->cnt }})
                    <br/>
                @endforeach
                </div>
            </div>
        </div>
        @endif
            
        
        @if (count($artists)>0)
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">View References by Artist</div>

                <div class="panel-body">
                @foreach ($artists as $artist)
                    
                        {{HTML::linkAction('ArtistController@displayArtist',$artist->artistname,array(str_replace(' ','-',$artist->artistname))) }}
                        ({{ $artist->cnt }})
                    <br/>
                @endforeach
                <b>{{HTML::linkAction('ArtistController@index','View Full List...')}}</b>
                </div>
            </div>
        </div>
        @endif
            
        <div class="col-md-6">        
        @if (count($newComments)>0)
            <div class="panel panel-default">
                <div class="panel-heading">New Comments</div>
                <div class="panel-body">
                @foreach ($newComments as $comment)
                    <p>
                        {{HTML::linkAction('SongController@index',$comment->songname.' - '.$comment->artistname,$comment->songid) }}
                        <br/>
                         ({{date('m/d/y h:i a',strtotime($comment->created_at))}} by {{$comment->name}})
                    </p>
                @endforeach
                </div>
            </div>
        @endif
        
        @if (count($newRefs)>0)
            <div class="panel panel-default">
                <div class="panel-heading">New References</div>
                <div class="panel-body">
                @foreach ($newRefs as $newRef)
                    <p>
                        {{HTML::linkAction('SongController@index',$newRef->songname.' - '.$newRef->artistname,$newRef->songid) }}
                        <br/><b>{{$newRef->book.' '.$newRef->chapter.':'.$newRef->verse}}</b>
                         ({{date('m/d/y',strtotime($newRef->dateadded))}} by {{$newRef->username}})
                    </p>
                @endforeach
                </div>
            </div>
        @endif
        </div>        
    </div>
</div>
@endsection
