{{ Form::open(array('route' => array('songRef.updatePassageVersion',$songRef->id))) }}
{{ Form::hidden('passageId',$passage->id) }}

@include('song.editPassageVersionFields')

  {{ Form::token() }}
  {{ Form::submit(null, array('class' => 'btn btn-default')) }}
  {{ Form::button('Cancel',array('class' => 'btn btn-default', 'onclick' => 'ajaxIndexPassage('.$songRef->id.');')) }}
{{ Form::close() }}