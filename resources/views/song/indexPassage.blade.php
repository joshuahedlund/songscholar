<?php $passage = $songRef->passageVersion->passage; ?>
                                <p>
                                    <?php echo nl2br($songRef->passageVersion->text); ?> ({{$songRef->passageVersion->version }})
                                </p>
                                <p>
                                    @if($passage) {{ HTML::linkAction('BookController@index',$passage->book,[str_replace(' ','-',$passage->book)]) }}
                                        {{$passage->chapter}}:{{$passage->verse}}
                                    @endif
                                    @if(!Auth::guest())
                                    [<a href="javascript:void(0);" onclick="ajaxEditPassageReference({{$songRef->id}});">correct this reference</a>]
                                    [<a href="javascript:void(0);" onclick="ajaxEditPassageVersion({{$songRef->id}});">correct this version</a>]
                                    @endif
                                </p>