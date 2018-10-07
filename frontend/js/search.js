$( document ).ready(function() {

	$('#search_input').keyup(function() {
		console.log( $(this).val() );
		if( $(this).val().length >= 2 ) {
			$.ajax({
				method: 'POST',
				url: 'backend/ajax/search.php',
				dataType: 'json',
				data: { search: $(this).val() },
				success: function(answer) {
					console.log(answer);
					if(answer.status == true) {
						$('#search_result').html('');
						var htmlString = '';
						var articleId;
						var articleTitleSubtitle;
						for(var i=0; i < answer.data.length; i++) {
							articleId = answer.data[i].id;
							articleTitleSubtitle = answer.data[i].title_subtitle;
							htmlString = htmlString + '<a class="search-link" href="frontend/html/article.php?id='+articleId+'">'+articleTitleSubtitle+'</a><br/>';
						}
						$('#search_result').html(htmlString);
						$('#search_result').show();
					} else {
						$('#search_result').hide();
						$('#search_result').html('');
					}
				}
			});
		} else {
			$('#search_result').hide();
			$('#search_result').html('');
		}
	});

});