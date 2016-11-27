{{ Form::open(['route' => ['song.updateSongAssoc', $song->id]]) }}

Other artists associated with this song:<br/>

@if(!empty($artists))
    @foreach($artists as $artist)
        {{ $artist }} <br/>
    @endforeach
@endif

{{ Form::text('artist', null, ['class' => 'form-control m']) }} <br/>

{{ Form::submit(null, array('class' => 'btn btn-default')) }}

{{ Form::close() }}