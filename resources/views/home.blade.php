@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading panel-title">Welcome!</div>

                <div class="panel-body">
                    <p>SongRefs is a database of song lyrics that reference Bible verses. <a href="/register">Create an account</a> to contribute!</p>
                </div>
            </div>
        </div>
    </div>
            
    <div class="row">
            
        @if (count($artists)>0)
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">View References by Artist</div>

                <div class="panel-body">
                @foreach ($artists as $artist)
                    
                        {{HTML::linkAction('ArtistController@index',$artist->artistname,array(str_replace(' ','-',$artist->artistname))) }}
                        ({{ $artist->cnt }})
                    <br/>
                @endforeach
                </div>
            </div>
        </div>
        @endif
            
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
            
        @if (count($newRefs)>0)
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">New References</div>
                <div class="panel-body">
                @foreach ($newRefs as $newRef)
                    <p>
                        {{HTML::linkAction('SongController@index',$newRef->songname.' - '.$newRef->artistname,$newRef->songid) }}
                        <br/><b>{{$newRef->book.' '.$newRef->chapter.':'.$newRef->verse}}</b>
                         (added {{date('m/d/y',strtotime($newRef->dateadded))}})
                    </p>
                @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
