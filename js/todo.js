(function(){
    'use strict';
    document.addEventListener("DOMContentLoaded",function(e){
        
        // 削除ボタン
        const form = document.querySelector('form');
        let check = document.querySelectorAll('input[type="checkbox"].check');

        for(let i=0; i<check.length; i++){
            check[i].addEventListener("change",function(e){
                form.setAttribute("action",`/todo/update/${check[i].dataset.id}`);
                form.submit();
            },false);
        };

    },false);

})();
