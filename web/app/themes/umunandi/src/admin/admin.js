var $ = jQuery.noConflict();

$(document).ready(function() {
	// Replace all leading em dashes from the post/page titles with plain whitespace.
	$('.pages .page-title .row-title').each(function() {
		$this = $(this);
		oldIndent = '— '; // emdash
		newIndent = '<span class="indenter"></span>';
		newTitle = $this.text().split(oldIndent);
		$this.text(newTitle.join(''));
		indentCount = newTitle.filter(function(s) {	return s.length == 0; }).length;
		$this.before(newIndent.repeat(indentCount));

		// And while we're here, let's get the expand button in the right place
		$this.before($this.nextAll('.expand_link'));
	});
});
