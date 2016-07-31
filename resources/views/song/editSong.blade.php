{{ Form::open(['route' => ['song.updateSong', $song->id]]) }}


Album: {{ Form::text('albumname', @$album, array('class' => 'form-control m')) }}
Song: {{ Form::text('songname', @$song->name, array('class' => 'form-control m')) }}

{{ Form::token() }}
{{ Form::submit(null, array('class' => 'btn btn-default')) }}

{{ Form::close() }}