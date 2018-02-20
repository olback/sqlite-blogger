/**
 *  SQLite Blogger Form validation JS
 *  github.com/olback/sqlite-blogger
 */

const articles = document.getElementsByTagName('article');
if(articles.length > 0) {
    for(let article of articles) {
        let id = article.getAttribute('post-id');
        article.onclick = () => {
            window.location = window.location.origin + '/post/' + id;
        }
    }
} else {
    document.getElementById('no-posts').style.display = 'block';
}
