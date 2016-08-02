@extends('layouts.master')

@section('title', $artist->name)

@section('content')
        <div class="panel panel-primary">
            <div class="panel-heading panel-title">
                {{ $artist->name }}
            </div>

            <div class="panel-body">
            @if(count($songs)>0)
            <table class="table table-striped task-table">
                <thead>
                        <th>Song</th>
                        <th>Album</th>
                        <th>Passage</th>
                </thead>
                <tbody>
                @foreach ($songs as $song)
                    <tr>
                        <td class="table-text">
                            <div> {{ HTML::linkAction('SongController@index',$song->name,$song->id) }} </div>
                        </td>
                                
                        <td>
                            <div>@if($song->album) {{ $song->album->name }} @endif</div>
                        </td>

                        <td>
                            
                            <div> @if($song->songRefs)
                                    <?php
                                    $c='';
                                    foreach($song->songRefs as $songRef){ //couldn't get comma spacing right with blade templating
                                        echo $c.$songRef->passageVersion->passage->passageConcat();
                                        $c=', ';
                                    }
                                    ?>
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
