/**
 *  SQLite Blogger Form validation JS
 *  github.com/olback/sqlite-blogger
 */

const title = document.getElementsByName('title')[0];
const body = document.getElementsByName('body')[0];
const message = document.getElementById('form-validation');

document.forms['new-post'].addEventListener('submit', (e) => {
    
    e.preventDefault();

    if(title.value.trim() == '') {
        message.innerHTML = 'Title may not be empty';
    } else if(body.value.trim() == '') {
        message.innerHTML = 'Body may not be empty';
    } else {
        e.path[0].submit();
    }

})
