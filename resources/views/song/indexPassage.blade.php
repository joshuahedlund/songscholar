<?php $passage = $songRef->passageVersion->passage; ?>
                                <p>
                                    <i><?php echo nl2br($songRef->passageVersion->text); ?></i>
                                </p>
                                <p>
                                    @if($passage) {{ HTML::linkAction('BookController@index',$passage->book,[str_replace(' ','-',$passage->book)]) }}
                                        {{$passage->chapter}}:{{$passage->verse}} ({{$songRef->passageVersion->version }})
                                    @endif
                                    @if(!Auth::guest())
                                    [<a href="javascript:void(0);" onclick="ajaxEditPassageReference({{$songRef->id}});">correct this reference</a>]
                                    [<a href="javascript:void(0);" onclick="ajaxEditPassageVersion({{$songRef->id}});">correct this version</a>]
                                    @endif
                                </p>