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
                <?php $passage = $songRef->passageVersion->passage; ?>
                    <tr>
                        <td class="table-text">
                            <div> @if($songRef->song) {{ $songRef->song->name }} @endif </div>
                        </td>
                                
                        <td>
                            <div>{{ $songRef->lyric }}</div>
                        </td>

                        <td>
                            <div> @if($passage) {{$passage->book}} {{$passage->chapter}}:{{$passage->verse}} @endif </div>
                        </td>
                        
                        <td>
                            <div> @if($songRef->passageVersion) {{$songRef->passageVersion->text}} @endif </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
            </div>
        </div>
@endsection
