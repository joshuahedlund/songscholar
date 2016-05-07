@extends('layouts.master')

@section('title', $artist->name)

@section('content')
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $artist->name }}
            </div>

            <div class="panel-body">
            @if(count($songRefs)>0)
            <table class="table table-striped task-table">
                <thead>
                        <th>Song</th>
                        <th>Lyric</th>
                        <th>Passage</th>
                        <th>Text</th>
                </thead>
                <tbody>
                @foreach ($songRefs as $songRef)
                    <tr>
                        <td class="table-text">
                            <div> @if($songRef->song) {{ $songRef->song->name }} @endif </div>
                        </td>
                                
                        <td>
                            <div>{{ $songRef->lyric }}</div>
                        </td>

                        <td>
                            <div> @if($songRef->passage) {{$songRef->passage->book}} {{$songRef->passage->chapter}}:{{$songRef->passage->verse}} @endif </div>
                        </td>
                        
                        <td>
                            <div> @if($songRef->passage) {{$songRef->passage->text}} @endif </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
            </div>
        </div>
@endsection
