@extends('layouts.master')

@section('title', 'Artists')

@section('content')
        <div class="panel panel-primary">
            <div class="panel-heading panel-title">
                Artists
            </div>

            <div class="panel-body">
            @if(count($artists)>0)
            <table class="table table-striped task-table">
                <thead>
                        <th>Artist</th>
                        <th>Songs</th>
                </thead>
                <tbody>
                @foreach ($artists as $artist)
                    <tr>
                        <td class="table-text">
                            <div> {{ HTML::linkAction('ArtistController@displayArtist',$artist->artistname,array(str_replace(' ','-',$artist->artistname))) }} </div>
                        </td>
                                
                        <td>
                            <div> {{ $artist->cnt }}</div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
            
            @if (!Auth::guest())
                <b>{{ HTML::link('/add-artist','Add A New Artist') }}</b>
            @endif
            </div>
        </div>
@endsection
