
var id = 0;

function updateText()
{
	var l = document.getElementById('flickrmorelink');
       	switch(id) {
               	case 1: l.innerHTML = '[+]Even more from flickr...'; break;
                case 2: l.innerHTML = '[+]More more more from flickr...'; break;
       	        case 3: l.style.display = 'none';
        }
}

function get()
{
	id += 1;
	var params = document.getElementById('flickrmore' + id + 'params').innerHTML;
	// alert('/flickr/flickrSearch.php?' + unescape(params));
	$.ajax({
		url: '/flickr/flickrSearch.php?f=flickr' + params,
		success: showPics,
		error: 
				function (xhr, textStatus, thrownError) 
				{ 
					alert("An error occured contacting " + url + " status " + xhr.status + " error message: \n" + xhr.responseText); 
				}
	});
	return false;
}

function showPics(pics)
{
	// alert(pics);
	$('#flickrmore' + id + 'params').html(pics);
     	$('#flickrmore' + id).slideDown('slow', updateText);
}

function toggle(e)
{
	e.parent().next().slideToggle("slow");
	if (e.text() == '[-] ')
	{
		e.text('[+] ');
	}
	else
	{
		e.text('[-] ');
	}
}

$(document).ready(function() 
{
	$('#flickrmorelink').click(get);
	$('h2').prepend('<span class="control">[-] </span>');
	$('h2 a').css('position', 'absolute');
	$('.control').click( function() { toggle($(this)); } );
});

