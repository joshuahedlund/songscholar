@extends('layouts.master')

@section('title', $book)

@section('content')
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $book }}
            </div>

            <div class="panel-body">
            @if(count($songRefs)>0)
            <table class="table table-striped task-table">
                <thead>
                        <th class="col-xs-6">Lyric</th>
                        <th class="col-xs-6">Passage</th>
                </thead>
                <tbody>
                @foreach ($songRefs as $songRef)
                <?php $passage = $songRef->passageVersion->passage; ?>
                    <tr>
                        <td>
                            <div>
                                <?php echo nl2br($songRef->lyric); ?>
                                @if($songRef->song && $songRef->song->artist) 
                                    <br/>(
                                    {{ HTML::linkAction('SongController@index',$songRef->song->artist->name.' - '.$songRef->song->name,$songRef->song->id) }}
                                    )
                                @endif
                            
                            </div>
                        </td>

                        <td>
                            <div> 
                                @if($passage) {{$passage->chapter}}:{{$passage->verse}} @endif
                        
                                @if($songRef->passageVersion)
                                <?php echo nl2br($songRef->passageVersion->text); ?>
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
