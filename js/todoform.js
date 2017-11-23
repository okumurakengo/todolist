(function(){
    'use strict';
    document.addEventListener("DOMContentLoaded",function(e){
        
        // 削除ボタン
        const form = document.querySelector('form');
        const del = document.getElementById('del');

        del.addEventListener("click",function(e){
            e.preventDefault();

            if(!confirm('削除してよろしいですか？')){
                return;
            }

            form.setAttribute("action",`/todo/del/${del.dataset.id}`);
            form.submit();
        },false);

    },false);

})();
