@extends('layouts.master')

@section('title', $book)

@section('content')
        <div class="panel panel-primary">
            <div class="panel-heading panel-title">
                {{ $book }}
            </div>

            <div class="panel-body">
            @if(count($chapters)>=4)
                    <p>
                        <b>Filter by Chapter:</b>
                            @foreach($chapters as $ch)
                                &nbsp; 
                                @if(!is_null($filterCh) && $filterCh==$ch->chapter)
                                    <b>{{$ch->chapter}}</b>
                                @else
                                    {{ HTML::linkAction('BookController@index',$ch->chapter,[str_replace(' ','-',$book),$ch->chapter]) }}
                                @endif
                            @endforeach
                    </p>
                @endif
            
            @if(count($songRefs)>0)
            <table class="table table-striped task-table">
                <thead>
                        <th class="col-xs-6">Passage</th>
                        <th class="col-xs-6">Lyric</th>
                </thead>
                <tbody>
                @foreach ($songRefs as $songRef)
                    <tr>
                    <td>
                            <div>
                                {{ $songRef->chapter }}:{{$songRef->verse}}
                                <?php echo nl2br($songRef->text); ?>
                            </div>
                        </td>
                        <td>
                            <div>
                                <?php echo nl2br($songRef->lyric); ?>
                                @if($songRef->song_id && $songRef->artist_name) 
                                    <br/>(
                                    {{ HTML::linkAction('SongController@index',$songRef->artist_name.' - '.$songRef->song_name,$songRef->song_id) }}
                                    )
                                @endif
                            
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            
            {{ $songRefs->links() }}
            
            @endif
            </div>
        </div>
@endsection
