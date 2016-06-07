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


//Editing existing song references
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
    });
}
function editPV(pvId){
    var spanEdit = $('#editPv-'+pvId), spanVersion = $(spanEdit).find('.pv-version'), spanText = $(spanEdit).find('.pv-text');
    var html = '<input type="text" name="pvversion'+pvId+'" class="xs" value="'+$(spanVersion).html()+'">';
    html += ' : ' + '<input type="text" name="pvtext'+pvId+'" value="'+$(spanText).html()+'">';
    $(spanEdit).html(html);
}

//when dom is ready
$(function(){
    //attach events
    attachArtistChange($('#artist'));
    attachBookChange($('#book'));
    attachChapterChange($('#chapter'));
});