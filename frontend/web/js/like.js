let buttonLike = $('button.yii2-project__like');
let buttonUnlike = $('button.yii2-project__dislike');
let commentTextarea = $('textarea.yii2-project__textarea_comment');

$(document).on('click', '.yii2-project__like', (e)=>{
   console.log('Like!!!');
   const id = e.currentTarget.dataset.post_id;
   $.post('/post/default/like', {
       id: id
   }, (data)=>{
       if(data.result === 'success'){
           $('span.likes_count').html(data.count);
           buttonLike.hide();
           buttonUnlike.show();
       }
       console.log(data);
   })
});

$(document).on('click', '.yii2-project__dislike', (e)=>{
    console.log('Dislike!!!');
    const id = e.currentTarget.dataset.post_id;
    $.post('/post/default/dislike', {
        id: id
    }, (data)=>{
        if(data.result === 'success'){
            $('span.likes_count').html(data.count);
            buttonUnlike.hide();
            buttonLike.show();
        }
        console.log(data);
    })
});

$(document).on('click', 'button.yii2-project__add_new_comment', (e)=>{
    let comment = commentTextarea.val();
    if(!comment){
        return;
    }
    $.post('/post/default/add-comment',
        {
            id: commentTextarea.data().post_id,
            content: comment
        },
        (data)=>{
            console.log(data);
            commentTextarea.val('');
        }
    )
});