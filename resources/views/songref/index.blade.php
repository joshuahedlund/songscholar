@extends('layouts.master')

@section('title', 'Song References')

@section('content')
    @if (count($songs) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Songs
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <thead>
                        <th>Song</th>
                        <th>Album</th>
                        <th>Artist</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($songs as $song)
                            <tr>
                                <td class="table-text">
                                    <div>{{ $song->name }}</div>
                                </td>

                                <td>
                                    <div> @if($song->album) {{ $song->album->name }} @endif </div>
                                </td>


                                <td>
                                    <div> @if($song->album && $song->album->artist) {{ $song->album->artist->name }} @endif </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
