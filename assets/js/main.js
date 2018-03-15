/**
 *  SQLite Blogger Main JS
 *  github.com/olback/sqlite-blogger
 */

window.onload = () => {

    // Tell the user if the search box is empty
    const searchBox = document.getElementById('search');
    document.getElementById('search-submit').onclick = () => {
        if(typeof(searchBox.value) == 'string' && searchBox.value !== '') {
            window.location = window.location.origin + '/search/' + searchBox.value.replace(/ /g, '+');
        } else {
            document.getElementById('search-error').style.display = 'inline-block';
        }
    }

    // Search when pressing enter
    searchBox.onkeypress = (e) => {
        e = e || window.event;
        if(e.keyCode === 13) {
            window.location = window.location.origin + '/search/' + searchBox.value.replace(/ /g, '+');
        }
    }

    // Close modal button
    document.getElementById('close-modal').onclick = () => {
        document.getElementById('modal').style.display = 'none';
    }

    // Strip get parameters from url for a cleaner look
    window.history.replaceState(null, null, window.location.pathname);

}
