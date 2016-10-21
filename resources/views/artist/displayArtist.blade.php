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
                        <th class="text-right">Comments</th>
                </thead>
                <tbody>
                @foreach ($songs as $song)
                    <tr>
                        <td class="table-text">
                            <div> {{ HTML::linkAction('SongController@index',$song->name,$song->id) }} </div>
                        </td>
                                
                        <td>
                            <div>@if($song->albumname) {{ $song->albumname }} @endif</div>
                        </td>

                        <td class="text-right">
                            
                            <div>
                                {{ $song->cnt_comment }}
                            </div>
                        </td>                   
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
            
            @if (!Auth::guest())
                <b>{{ HTML::linkAction('SongRefController@addByArtist','Add A Song Reference',$artist->id) }}</b>
            @endif
            </div>
        </div>
@endsection
