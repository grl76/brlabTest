$(document).ready(function(){
    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    if(REST_API_data.idSingle){
        let betCookie = getCookie('bets' + REST_API_data.idSingle);
        if(!betCookie)
            $('#addBet').removeClass('disabled');
    }

    createBet = function(){
        $(this).addClass('disabled');
        let termId      = $(".sidebar select option:selected").val(),
            betName     = $("#betName").val(),
            betContent  = $("#betContent").val(),
            betMeta     = { description: betContent };
            if(betName){
                let data = {
                    'title'     : betName,
                    'typeBet'   : termId,
                    'statusBet' : REST_API_data.statusTerm,
                    'meta'      : betMeta,
                    'status'    : 'publish'
                };
                fetch(
                    REST_API_data.root + 'wp/v2/bets',
                    {
                        method: 'POST',
                        headers: {
                            'X-WP-Nonce': REST_API_data.nonce,
                            'Content-Type': 'application/json;charset=utf-8'
                        },
                        body: JSON.stringify(data)
                    }
                )
                    .then( response => {
                        $("#betName").val('') ;
                        $("#betContent").val('');
                        $(this).removeClass('disabled');

                        if ( response.status !== 200 && response.status !== 201 ) {
                            throw new Error( 'Problem! Status Code: ' + response.status );
                        }
                        response.json().then( posts => {
                            let
                                postText = '<article class="col-12"><a class="box" href="'+posts.guid.rendered+'">';
                            postText +='<h3>'+betName+'<span></span></h3>';
                            postText +='<div class="description">'+betContent+'</div>';
                            postText +='<div class="d-flex justify-content-between">';
                            postText +='<div class="d-flex align-items-center">';
                            postText +='<div class="status">Активная</div>';
                            postText +='</div>';
                            postText +='<div class="button">Перейти ></div>';
                            postText +='</div>';
                            postText +='</a></article>';
                            $(".listBet h4").after(postText);

                        });
                    })
                    .catch(function(err) {
                        console.log( 'Error: ', err );
                    });
            } else {
                $("#betName").addClass('error');
                $(this).removeClass('disabled');
            }
    },
    addBet = function(e){
        e.preventDefault();
        $(this).addClass('disabled');
        let bet = $('#flying').val(),
            data = {
            'meta'      : { 'bet_vote': bet},
        };
        document.cookie = 'bets' + REST_API_data.idSingle + '=' + bet;
        fetch(
            REST_API_data.root + 'wp/v2/bets/' + REST_API_data.idSingle,
            {
                method: 'POST',
                headers: {
                    'X-WP-Nonce': REST_API_data.nonce,
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(data)
            }
        )
            .then( response => {
                if ( response.status !== 200 ) {
                    throw new Error( 'Problem! Status Code: ' + response.status );
                }
                response.json().then( posts => { console.log( posts ); });
            })
            .catch(function(err) {
                console.log( 'Error: ', err );
            });
    },

    initClick = () => {
        $(document).on('click', '#createBet', createBet);
        $(document).on('click', '#addBet', addBet);
    }
    initClick();
});