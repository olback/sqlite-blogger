/**
 *  SQLite Blogger by olback @ 2018
 *  github.com/olback/sqlite-blogger
 */


const articles = document.getElementsByTagName('article');

for(let article of articles) {

    let id = article.getAttribute('post-id');

    article.onclick = () => {

       window.location = window.location.origin + '/post/' + id;

    }

}
