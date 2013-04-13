$(function(){
	$('#submit').click(function(){
		if ($('#url')[0].checkValidity() && $.trim($('#url').val())) {
			var url = $('#url').val();
			$('#url').prop('disabled', true);
			$('#submit').prop('disabled', true);
			$.post(
				'doscrape.php',
				{'url' : url},
				function(json) {
					if (json.success) {
						if ($.trim(json.ogp.title) != '') {
							$('#scraped-content').fadeOut('slow', function(){
								$('#title').text(json.ogp.title);
								$('#title').attr('href', json.ogp.url);
								$('#description').text(json.ogp.description);
								$('#image').attr('src', json.ogp.image);
								$('#dump').text(json.dump);
								$('#scraped-content').fadeIn();
							});
						} else {
							$('#scraped-content').fadeOut('slow', function(){
								$('#title').text('Title will appear here...');
								$('#title').attr('href', 'javascript:void(0)');
								$('#description').text('... and description here');
								$('#image').attr('src', 'img/image.jpg');
								$('#dump').text(json.dump);
								$('#scraped-content').fadeIn();
							});
						}
						$('#url').val('').prop('disabled', false);
						$('#submit').prop('disabled', false);
					} else {
						alert('Something went wrong. Please, look the console.');
						console.log(json.log);
					}
				},
				'json'
			);
		} else {
			alert('Invalid URL.');
		}
		return false;
	});
	
	$('.navscroll a').click(function(event){
		var $anchor = $(this);
 
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top - 40
        }, 1500,'easeInOutExpo');
        /*
        if you don't want to use the easing effects:
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1000);
        */
        return false;
    });
});