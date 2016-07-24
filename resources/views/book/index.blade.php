@extends('layouts.master')

@section('title', $book)

@section('content')
        <div class="panel panel-primary">
            <div class="panel-heading panel-title">
                {{ $book }}
            </div>

            <div class="panel-body">
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
            @endif
            </div>
        </div>
@endsection
