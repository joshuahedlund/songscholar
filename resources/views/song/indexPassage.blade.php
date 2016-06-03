<?php $passage = $songRef->passageVersion->passage; ?>
                                <p>
                                    @if($passage) {{$passage->book}} {{$passage->chapter}}:{{$passage->verse}} @endif
                                    @if(!Auth::guest())
                                    [<a href="javascript:void(0);" onclick="ajaxEditPassageReference({{$songRef->id}});">correct this reference</a>]
                                    [<a href="javascript:void(0);" onclick="ajaxEditPassageVersion({{$songRef->id}});">correct this version</a>]
                                    @endif
                                </p>
                                <p>
                                    <?php echo nl2br($songRef->passageVersion->text); ?> ({{$songRef->passageVersion->version }})
                                </p>