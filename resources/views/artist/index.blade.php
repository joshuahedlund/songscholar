@extends('layouts.master')

@section('title', 'Artists')

@section('content')
        <div class="panel panel-primary">
            <div class="panel-heading panel-title">
                Artists
            </div>

            <div class="panel-body">
            @if(count($artists)>0)
                <p>
                        @foreach($letters as $l)
                            &nbsp; 
                            @if(!is_null($filterL) && $filterL==$l->letter)
                                <b>{{$l->letter}}</b>
                            @else
                                {{ HTML::linkAction('ArtistController@indexFiltered',$l->letter,[$l->letter]) }}
                            @endif
                        @endforeach
                    </p>
            
            
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
            
            {{ $artists->links() }}
            @endif
            
            @if (!Auth::guest())
            <p>
                <b>{{ HTML::link('/add-artist','Add A New Artist') }}</b>
            </p>
            @endif
            </div>
        </div>
@endsection
