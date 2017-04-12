function enableKatTheme() {
    var name = 'kat_theme=';
    var ca = document.cookie.split(';');
    var cookie_val = '';
    var today = new Date();
    today.setDate(today.getDate() + 100);
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            cookie_val = c.substring(name.length, c.length);
        }
    }
    if (cookie_val) {
        document.cookie = "kat_theme=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
    }
    else {
        document.cookie = "kat_theme=true; expires=" + today + "; path=/";
    }
    location.reload();
}