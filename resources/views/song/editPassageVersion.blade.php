{{ Form::open(array('route' => array('songRef.updatePassageVersion',$songRef->id))) }}
{{ Form::hidden('passageId',$passage->id) }}
<div class="form-group">
    <p>Which version is the best for this lyric?</p>
  @if(!empty($pvs))
  @foreach($pvs as $pv)
    <span id="pv-{{ $pv->id }}">
    <?php $isThisPv = ($pv->id == $songRef->passageVersion->id); ?>
    <label>{{ Form::radio('pvid',$pv->id,$isThisPv) }} {{ $pv->version }} : {{ $pv->text }}</label> [edit]
    </span>
    <br/>
  @endforeach
  @endif
    <label>{{ Form::radio('pvid',0) }} Add a version: {{ Form::text('version', null, array('class'=>'xs')) }}</label>
    <br/>
    <div class="form-group">
    Text:
  {{ Form::textarea('text', null, array('class' => 'form-control', 'rows' => 3)) }}
  </div>
</div>
</div>
  {{ Form::token() }}
  {{ Form::submit(null, array('class' => 'btn btn-default')) }}
  {{ Form::button('Cancel',array('class' => 'btn btn-default', 'onclick' => 'ajaxIndexPassage('.$songRef->id.');')) }}
{{ Form::close() }}