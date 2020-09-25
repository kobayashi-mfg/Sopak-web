(function(){
    'use strict';

    //headerのnavのactiveクラス
    var navs = document.getElementsByClassName('nav-element');
    var path = location.pathname ;
    var loc = path.split('/');

    if(loc[4] == 'estimates'){
        if(loc[5] == null){
            navs[2].classList.add('active');
        }else{
            navs[1].classList.add('active');
        }
    }else if(loc[4] == 'purchases'){
        if(loc[5] == 'create'){
            navs[4].classList.add('active');
        }else{
            navs[3].classList.add('active');
        }
    }else{
        navs[0].classList.add('active');
    }

})();
