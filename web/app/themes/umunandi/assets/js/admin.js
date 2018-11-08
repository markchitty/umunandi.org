var $ = jQuery.noConflict();

$(document).ready(function() {
	// Replace all leading em dashes from the post/page titles with plain whitespace.
	$('.pages .page-title .row-title').each(function() {
		$this = $(this);
		oldIndent = '— '; // emdash
		newIndent = '<span class="indenter"></span>';
		newTitle = $this.text()
									.split(oldIndent)
									.map(function(s) {
										return s.length == 0 ? newIndent : s;
									})
									.join('');
		$this.html(newTitle);
	});
});
