{{ Form::open(array('route' => array('songRef.updatePassageReference',$songRef->id))) }}
<div class="form-group">
  <div>
  {{ Form::select('book', $books, $pv->passage->book) }}
  <span id="chapterSpan">
    {{ Form::select('chapter', $chapters, $pv->passage->chapter, array('id'=>'chapter')) }} 
  </span>
  : 
  <span id="verseSpan">
    {{ Form::select('verse', $verses, $pv->passage->verse, array('id'=>'verse')) }}
  </span>
</div>
  {{ Form::token() }}
  {{ Form::button('Update to choose version', array('class' => 'btn btn-default', 'onclick' => 'ajaxUpdatePassageReference('.$songRef->id.',this.form);')) }}
  {{ Form::button('Cancel',array('class' => 'btn btn-default', 'onclick' => 'ajaxIndexPassage('.$songRef->id.');')) }}
{{ Form::close() }}