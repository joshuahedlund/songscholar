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
            <table class="table table-striped task-table">
                <thead>
                        <th class="col-xs-6">Lyric</th>
                        <th class="col-xs-6">Passage</th>
                </thead>
                <tbody>
                @foreach ($song->songRefs as $songRef)
                <?php $passage = $songRef->passageVersion->passage; ?>
                    <tr>
                        <td>
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
                            
                        </td>
                                
                        <td>
                            <div id="editPassage-{{$songRef->id}}"> 
                                @include('song.indexPassage')
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            
                {{--Print the delete form--}}
                @if(Auth::user()->isAdmin)
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
        
        <div class="panel panel-default">
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
