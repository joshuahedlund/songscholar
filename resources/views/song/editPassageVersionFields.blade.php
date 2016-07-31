<div class="form-group">
    <p>Which version of {{ $passage->passageConcat() }} is the best for this lyric?</p>
  @if(!empty($pvs))
  @foreach($pvs as $pv)
    <span id="pv-{{ $pv->id }}">
        <?php $isThisPv = (isset($songRef) && $pv->id == $songRef->passageVersion->id); ?>
        <label>
            {{ Form::radio('pvid',$pv->id,$isThisPv) }}
            <span id="editPv-{{ $pv->id }}">
                <span class="pv-version">{{ $pv->version }}</span> : 
                <span class="pv-text">{{ $pv->text }}</span>
                [<a href="javascript:void(0);" onclick="editPV({{ $pv->id }})">edit</a>]
            </span>
        </label>
    </span>
    <br/>
  @endforeach
  @endif
    <label>{{ Form::radio('pvid',0) }} Add a version: {{ Form::text('version', null, array('class'=>'xs','id'=>'version')) }}</label>
    <?php $book = str_replace(['psalm','song of solomon',' '],['psalms','songs','_'],strtolower($passage->book)); ?>
    &nbsp; <a href="http://www.biblehub.com/{{$book}}/{{$passage->chapter}}-{{$passage->verse}}.htm" target="_blank">Look up this verse on biblehub</a>
    <br/>
    <div class="form-group">
    Text:
  {{ Form::textarea('text', null, array('class' => 'form-control', 'rows' => 3)) }}
  </div>
</div>
</div>