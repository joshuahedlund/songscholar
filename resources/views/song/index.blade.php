@extends('layouts.master')

@section('title', $song->name.' by '.$song->artist->name);

@section('content')
        <div class="panel panel-primary">
            <div class="panel-heading panel-title">
                {{ HTML::linkAction('ArtistController@index',$song->artist->name, str_replace(' ','-',$song->artist->name)) }} &gt; {{ $song->name }}
            </div>

            <div class="panel-body">
            @if (!Auth::guest())
            <p id="editSong-{{$song->id}}"><a href="javascript:void(0);" id="ajaxEditSong" data-song-id="{{$song->id}}">Edit song details</a></p>
            @endif
            
            @if(count($song->songRefs)>0)
            <div class="row">
                        <div class="col-sm-6"><b>Lyric</b></div>
                        <div class="col-sm-6"><b><i>Passage</i></b></div>
            </div>
                @foreach ($song->songRefs as $songRef)
                <?php $passage = $songRef->passageVersion->passage; ?>
                <div class="row borderTop">
                        <div class="col-sm-6 padBottom">
                            <div id="editLyric-{{$songRef->id}}"> 
                                <?php echo nl2br($songRef->lyric); ?>
                            @if (!Auth::guest())
                            <p>
                                [<a href="javascript:void(0);" onclick="ajaxEditLyric({{$songRef->id}});">correct this lyric</a>]
                                @if(Auth::user()->isAdmin)
                                    &nbsp; [<a href="javascript:void(0);" onclick="ajaxDeleteRef({{$songRef->id}});">delete this reference</a>]
                                @endif
                            </p>
                            @endif
                            </div>
                            
                        </div>
                                
                        <div class="col-sm-6">
                            <div id="editPassage-{{$songRef->id}}"> 
                                @include('song.indexPassage')
                            </div>
                        </div>
                </div>
                @endforeach
            
                {{--Print the delete form--}}
                @if(!Auth::guest() && Auth::user()->isAdmin)
                    {{ Form::open(['route' => 'songRef.delete','id' => 'frmRefDel']) }}
                    {{ Form::hidden('ref_id',0) }}
                    {{ Form::close() }}
                @endif   
            @endif
            </div>
            <div class="panel-body">
                @if(!Auth::guest())
                <p>
                    {{ HTML::linkAction('SongRefController@add','Add another reference for this song',$song->id) }}
                </p>
                    @if(count($songRefs)>=2)
                    <p>
                        {{ HTML::linkAction('SongController@editOrder','Edit order of these references',$song->id) }}
                    </p>
                    @endif
                @endif
            </div>
        </div>
        
        <div class="panel panel-info">
            <div class="panel-heading">
                External Links
            </div>
            <div class="panel-body">
                {{ HTML::link('https://www.youtube.com/results?search_query='.urlencode($song->artist->name.' '.$song->name),'Search for "'.$song->artist->name.' '.$song->name.'" on YouTube',['target'=>'_blank']) }}
            
            </div>
        </div>
        
        <div class="panel panel-default" id="divComments">
        @include('comment.index')
        </div>
        
@endsection
