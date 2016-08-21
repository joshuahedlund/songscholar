<?php
$types = ['bug' => 'Bug: something that is here but not working right',
          'feature' => 'Feature: something that is not here but would be cool',
          'data' => 'Data: the song/lyric/verse/something is incorrect',
          'other' => 'Other: maybe just how much you love this site or not'];
?>

{{ Form::open(['id' => 'frmModalFeedback']) }}

  {{ Form::select('type', $types, null, ['class' => 'form-control auto']) }}
  
  {{ Form::textarea('text', null, ['class' => 'form-control', 'rows' => 3]) }}

  {{ Form::submit(null, ['class' => 'btn btn-default']) }}
    
{{ Form::close() }}