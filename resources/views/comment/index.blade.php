<?php if(!isset($comments) && isset($song)){$comments=$song->comments;}?>

<div class="panel-heading">Comments ({{ count($comments) }})</div>
<div class="panel-body">
@if(count($comments))
<table>
    @foreach ($comments as $comment)
    <tr>
        <td class="col-xs-3" valign="top">
            <p><b>{{ $comment->user->name }}</b><br/>
            {{ date_format($comment->created_at,'F j, Y') }}
            </p>
        </td>
        <td valign="top">
            <p>{{ $comment->text }}</p>
        </td>
        <td valign="top">
        @if(!Auth::guest() && ($comment->user_id = $user->id || $user->isAdmin))
            <p><a href="javascript:void(0);" class="delete-comment" data-id="{{ $comment->id }}">[X]</a></p>
        @endif
        </td>
    </tr>
    @endforeach
@endif
</table>
{{-- Delete comment form (js will fill with correct id) --}}
@if(!Auth::guest())
    {{ Form::open(['route' => 'comment.delete','id' => 'frmComDel']) }}
    {{ Form::hidden('delete_id',0) }}
    {{ Form::close() }}
@endif

{{-- New comment form --}}                   
@if(!Auth::guest())
    {{ Form::open(['route' => 'comment.store']) }}
    {{ Form::hidden('song_id',$songId) }}
    <div class="form-group">
      {{ Form::textarea('text', null, array('class' => 'form-control', 'rows' => 3)) }}
    </div>
    
    {{ Form::submit('Add Comment', array('class' => 'btn btn-default')) }}
    {{ Form::close() }}
@endif
</div>