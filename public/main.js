function attachArtistChange(artist){
    $(artist).change(function(){
        if(this.value==0){ //new
            $(this.form.artistname).show();
            $(this.form.albumname).show();      $(this.form.album).hide();
        }else{ //select or existing
            $(this.form.artistname).hide();
            $(this.form.albumname).hide();
        }
        $(this.form.songname).show();
        $(this.form.song).hide();
        loadAlbumsByArtist(this.value,this.form);
    });
}
function loadAlbumsByArtist(artistId,frm){
    if(artistId>0){
        $.get('/artist/'+artistId+'/selectAlbums',function(t){
            $('#albumSpan').html(t);
            attachAlbumChange($('#albumSpan').find('select'));
        });
    }else{ //new or select
        $('#album').hide();
        $(frm.albumname).show();
    }
}
function attachAlbumChange(album){
    $(album).change(function(){
        if(this.value==0){
            $(this.form.albumname).show();
            $(this.form.songname).show();       $(this.form.song).hide();
        }else{ //select or existing
            $(this.form.albumname).hide();
            $(this.form.songname).hide();
        }
        loadSongsByAlbum(this.value,this.form);
    });
}
function loadSongsByAlbum(albumId,frm){
    if(albumId>0){
        $.get('/artist/'+albumId+'/selectSongsByAlbum',function(t){
            $('#songSpan').html(t);
            attachSongChange($('#songSpan').find('select'));
        });
    }else{
        $('#song').hide();
        $(frm.songname).show();
    }
}
function attachSongChange(song){
    $(song).change(function(){
        if(this.value==0){
            $(this.form.songname).show();
        }else{
            $(this.form.songname).hide();
        }
    });
}
function attachBookChange(book){
    $(book).change(function(){
        loadChaptersByBook(this.value);
    });
}
function loadChaptersByBook(bookName){
    if(bookName!='-1'){
        $.get('/book/'+encodeURIComponent(bookName)+'/numChapters',function(t){
            var numChapters=t*1; //convert string to int
            if(numChapters>0){
                var ch=$('#chapter');
                ch.find('option').remove(); //clear existing selects
                ch.append($('<option/>').val(-1).text('Ch')); //build new list up to the max
                for(var i=1;i<=numChapters;i++){
                    ch.append($('<option/>').val(i).text(i));
                }
                $('#verse').val(-1); //deselect verse
            }
        });
    }
}
function attachChapterChange(chapter){
    $(chapter).change(function(){
        loadVersesByChapter(this.form.book.value,this.value*1);
    });
}
function loadVersesByChapter(bookName,ch){
    if(bookName!='-1' && ch>0){
        $.get('/book/'+encodeURIComponent(bookName)+'/'+ch+'/numVerses',function(t){
            var numVerses=t*1; //convert string to int
            if(numVerses>0){
                var v=$('#verse');
                v.find('option').remove(); //clear existing selects
                v.append($('<option/>').val(-1).text('V')); //build new list up to the max
                for(var i=1;i<=numVerses;i++){
                    v.append($('<option/>').val(i).text(i));
                }
            }
        });
    }
}
function attachVerseChange(verse){
    $(verse).change(function(){
        ajaxEditPassageVersionFields(this);
    });
}
function ajaxEditPassageVersionFields(verse){
    if(verse.value!='-1'){
        var frm = verse.form,bookName=frm.book.value,ch=frm.chapter.value,v=frm.verse.value;
        $.get('/book/'+encodeURIComponent(bookName)+'/'+ch+'/'+v+'/editPassageVersionFields',function(t){
            $('#editPassageVersionFields').html(t);
            $('#version').click(function(){
                this.form.pvid.value=0;
            });
        });
    }
}

function validateAddRef(E){
    var frm=E.target,errs=[];
    if(frm.artist.value=='-1'||(frm.artist.value=='0'&&(!frm.artistname||frm.artistname.value==''))){
        errs.push('Artist is required');
    }
    if((frm.song&&frm.song.value=='-1')||((!frm.song||frm.song.value=='0')&&(!frm.songname||frm.songname.value==''))){
        errs.push('Song is required');
    }
    if(!frm.pvid||!frm.pvid.value.length){
        errs.push('Passage is required');
    }
    if(errs.length){
        var errStr='<ul>';
        for(var err in errs){
            errStr+='<li>'+errs[err]+'</li>';
        }
        errStr+='</ul>';
        $('#jsErrors').html(errStr).show();
        return false;
    }else{
        $('#jsErrors').hide();
        return true;
    }
}


//Editing existing song references
function ajaxEditSong(E){
    var songId = $(E.target).data('song-id');
    $.get('/song/'+songId+'/edit',function(t){
        $('#editSong-'+songId).html(t);
    });
}
function ajaxEditLyric(songRefId){
    $.get('/songRef/'+songRefId+'/editLyric',function(t){
        $('#editLyric-'+songRefId).html(t);
    });
}
function ajaxIndexPassage(songRefId){
    $.get('/songRef/'+songRefId+'/indexPassage',function(t){
        $('#editPassage-'+songRefId).html(t);
    });
}
function ajaxEditPassageReference(songRefId){
    $.get('/songRef/'+songRefId+'/editPassageReference',function(t){
        $('#editPassage-'+songRefId).html(t);
        attachBookChange($('#book'));
        attachChapterChange($('#chapter'));
    });
}
function ajaxUpdatePassageReference(songRefId,frm){
    $.post('/songRef/'+songRefId+'/updatePassageReference',$(frm).serialize(),function(t){
        $('#editPassage-'+songRefId).html(t);
    });
}
function ajaxEditPassageVersion(songRefId){
    $.get('/songRef/'+songRefId+'/editPassageVersion',function(t){
        $('#editPassage-'+songRefId).html(t);
        $('#version').click(function(){
                this.form.pvid.value=0;
        });
    });
}
function editPV(pvId){
    var spanEdit = $('#editPv-'+pvId), spanVersion = $(spanEdit).find('.pv-version'), spanText = $(spanEdit).find('.pv-text');
    var html = '<input type="text" name="pvversion'+pvId+'" class="xs" value="'+$(spanVersion).html()+'">';
    html += ' : ' + '<input type="text" name="pvtext'+pvId+'" value="'+$(spanText).html()+'">';
    $(spanEdit).html(html);
}

//Modals
function modalFeedbackLoad(){
    $.get('/modal/feedback/',function(t){
        modal = $('#myModal');
        $(modal).find('.modal-title').text('Give Me Some Feedback!');
        $(modal).find('.modal-body').html(t);
        $(modal).modal();
        $('#frmModalFeedback').on('submit',modalFeedbackSubmit);
    });
}
function modalFeedbackSubmit(E){
    E.preventDefault();
    $.post('/modal/feedback',$(E.target).serialize(),function(t){
        modal = $('#myModal');
        $(modal).find('.modal-body').html(t);
    });
}

//Comments
function attachDeleteComment(){
    $('.delete-comment').on('click',ajaxDeleteComment);
}
function ajaxAddComment(frm){
    $.post('/comment/',$(frm).serialize(),function(t){
        $('#divComments').html(t);
        attachDeleteComment();
    });
}
function ajaxDeleteComment(E){
    if(confirm('Are you sure you want to delete this comment?')){
        var el=E.target,frm=$('#frmComDel')[0];
        frm.delete_id.value=$(el).data('id');
        $.post('/comment/delete/',$(frm).serialize(),function(t){
           $('#divComments').html(t); 
           attachDeleteComment();
        });
    }
}

//when dom is ready
$(function(){
    //attach events
    attachArtistChange($('#artist'));
    attachBookChange($('#book'));
    attachChapterChange($('#chapter'));
    attachVerseChange($('#verse'));
    attachDeleteComment();
    
    $("#frmAddRef").on('submit',validateAddRef);
    $('#ajaxEditSong').on('click',ajaxEditSong);
    $('#modalFeedback').on('click',modalFeedbackLoad);
});