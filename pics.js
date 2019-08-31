
// var id = 0;

function updateText(id)
{
	var l;
	if (id < 4)
	{
		setFlickClick(id + 1);
		l = document.getElementById('flickrmorelink');
	}
	else
		l = document.getElementById('instagrammorelink');
       	switch(id) {
               	case 1: l.innerHTML = '[+]Even more from flickr...'; break;
                case 2: l.innerHTML = '[+]More more more from flickr...'; break;
       	        case 3:
		case 4: l.style.display = 'none'; break;
        }
}

function get(event)
{
	id = event.data.id;
	var params = document.getElementById('flickrmore' + id + 'params').innerHTML;
	// alert('/flickr/flickrSearch.php?' + unescape(params));
	$.ajax({
		//url: '/flickr/flickrSearch.php?f=' + params,
		url: '/flickr/' + params,
		success: function(xml) { showPics(xml, id) },
		error: 
				function (xhr, textStatus, thrownError) 
				{ 
					alert("An error occured contacting " + url + " status " + xhr.status + " error message: \n" + xhr.responseText); 
				}
	});
	return false;
}

function showPics(pics, id)
{
	// alert(pics);
	$('#flickrmore' + id + 'params').html(pics);
     	$('#flickrmore' + id).slideDown('slow', function() { updateText(id); } );
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

function setFlickClick(aid)
{
	$('#flickrmorelink').unbind('click');
	$('#flickrmorelink').click( { id : aid }, get );
}

$(document).ready(function() 
{
	setFlickClick(1);
	$('#instagrammorelink').click( { id : 4 }, get );
	$('h2').prepend('<span class="control">[-] </span>');
	$('h2 a').css('position', 'absolute');
	$('.control').click( function() { toggle($(this)); } );
});

