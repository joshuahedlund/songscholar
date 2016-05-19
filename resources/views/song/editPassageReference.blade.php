{{ Form::open(array('route' => array('songRef.updatePassageReference',$songRef->id))) }}
<div class="form-group">
  <div>
  {{ Form::select('book', $books, $pv->passage->book) }}
  {{ Form::text('chapter', $pv->passage->chapter, array('class'=>'xs')) }} : {{ Form::text('verse',$pv->passage->verse, array('class'=>'xs')) }}
  </div>

</div>
  {{ Form::token() }}
  {{ Form::submit('Update to choose version', array('class' => 'btn btn-default')) }}
  {{ Form::button('Cancel',array('class' => 'btn btn-default', 'onclick' => 'ajaxIndexPassage('.$songRef->id.');')) }}
{{ Form::close() }}