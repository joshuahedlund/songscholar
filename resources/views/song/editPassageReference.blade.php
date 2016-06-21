{{ Form::open(array('route' => array('songRef.updatePassageReference',$songRef->id))) }}
<div class="form-group">
  {{ Form::select('book', $books, $pv->passage->book, array('id'=>'book', 'class'=>'form-control auto')) }}
  <span id="chapterSpan">
    {{ Form::select('chapter', $chapters, $pv->passage->chapter, array('id'=>'chapter', 'class'=>'form-control auto')) }} 
  </span>
  : 
  <span id="verseSpan">
    {{ Form::select('verse', $verses, $pv->passage->verse, array('id'=>'verse', 'class'=>'form-control auto')) }}
  </span>
</div>
  <div class="form-group">
  {{ Form::button('Update to choose version', array('class' => 'btn btn-default', 'onclick' => 'ajaxUpdatePassageReference('.$songRef->id.',this.form);')) }}
  {{ Form::button('Cancel',array('class' => 'btn btn-default', 'onclick' => 'ajaxIndexPassage('.$songRef->id.');')) }}
  </div>
  {{ Form::token() }}
{{ Form::close() }}