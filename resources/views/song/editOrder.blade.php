@extends('layouts.master')

@section('title', $song->name.' by '.$song->artist->name);

@section('content')
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ HTML::linkAction('ArtistController@index',$song->artist->name, str_replace(' ','-',$song->artist->name)) }} &gt; {{ $song->name }}
            </div>

            {{ Form::open(['route' => ['song.updateOrder',$song->id]]) }}
            <div class="panel-body">
            @if(count($songRefs)>0)
            <table class="table table-striped task-table">
                <thead>
                        <th class="col-xs-1">Order</th>
                        <th class="col-xs-6">Lyric</th>
                </thead>
                <tbody>
                @foreach ($songRefs as $songRef)
                    <tr>
                        <td>
                                {{ Form::text('songref'.$songRef->id,$songRef->order,['class'=>'xs text-right']) }}
                        </td>
                        <td>
                                <?php echo nl2br($songRef->lyric); ?>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            
            
            {{ Form::token() }}
            {{ Form::submit(null, array('class' => 'btn btn-default')) }}
            
            @endif
            </div>
            {{ Form::close() }}
        </div>
@endsection
