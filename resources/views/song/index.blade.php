@extends('layouts.master')

@section('title', $song->name.' by '.$song->album->artist->name);

@section('content')
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ HTML::linkAction('ArtistController@index',$song->album->artist->name, str_replace(' ','-',$song->album->artist->name)) }} &gt; {{ $song->name }}
            </div>

            <div class="panel-body">
            @if(count($songRefs)>0)
            <table class="table table-striped task-table">
                <thead>
                        <th>Lyric</th>
                        <th>Passage</th>
                </thead>
                <tbody>
                @foreach ($songRefs as $songRef)
                <?php $passage = $songRef->passageVersion->passage; ?>
                    <tr>
                        <td class="table-text">
                            <div> {{$songRef->lyric }}</div>
                            <p>[{{ HTML::linkAction('SongRefController@editLyric','correct this lyric',$songRef->id) }}]</p>
                        </td>
                                
                        <td>
                            <div> 
                                <p>
                                    <b>Verse:</b> @if($passage) {{$passage->book}} {{$passage->chapter}}:{{$passage->verse}} @endif
                                </p>
                                <p>
                                    <b>Best Match:</b> {{$songRef->passageVersion->version }}
                                </p>
                                <p>
                                    {{$songRef->passageVersion->text}}
                                </p>
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
