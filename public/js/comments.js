function answer(id, open=true) {
    if(open) {
        document.getElementById(id).style.display = 'block';
    } else {
        document.getElementById(id).style.display = 'none';
    }
}

function replies(id) {
    if (document.getElementById(id).style.display === 'none') document.getElementById(id).style.display = 'block';
    else document.getElementById(id).style.display = 'none';

}
