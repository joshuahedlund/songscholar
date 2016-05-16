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
                        <th class="col-xs-6">Lyric</th>
                        <th class="col-xs-6">Passage</th>
                </thead>
                <tbody>
                @foreach ($songRefs as $songRef)
                <?php $passage = $songRef->passageVersion->passage; ?>
                    <tr>
                        <td>
                            <div id="editLyric-{{$songRef->id}}"> 
                                <?php echo nl2br($songRef->lyric); ?>
                            @if (!Auth::guest())
                            <p>[<a href="javascript:void(0);" onclick="ajaxEditLyric({{$songRef->id}});">correct this lyric</a>]</p>
                            @endif
                            </div>
                            
                        </td>
                                
                        <td>
                            <div id="editPassage-{{$songRef->id}}"> 
                                <p>
                                    @if($passage) {{$passage->book}} {{$passage->chapter}}:{{$passage->verse}} @endif
                                    @if(!Auth::guest())
                                    [<a href="javascript:void(0);" onclick="ajaxEditPassage({{$songRef->id}});">correct this reference</a>]
                                    @endif
                                </p>
                                <p>
                                    <?php echo nl2br($songRef->passageVersion->text); ?> ({{$songRef->passageVersion->version }})
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
