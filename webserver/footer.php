<!-- FOOTER -->
<div class="well" style="text-align: center">
	<p>
		<span class="glyphicon glyphicon-triangle-right" aria-hidden="false"></span>
			Redesign by
			<a href="https://steamcommunity.com/id/porcusorulmagic/">
			PorcusorulMagic
			</a>
		<span class="glyphicon glyphicon-triangle-left" aria-hidden="false"></span>
	</p>
</div>

<!-- BACK TO TOP BUTTON -->
<span id="top-link-block" class="hidden">
	<a href="#top" class="well well-sm" onclick="$(\'html,body\').animate({scrollTop:0},\'slow\');return false;">
		<i class="glyphicon glyphicon-chevron-up"></i> Back to Top
	</a>
</span>

<script>
		if ( ($(window).height() + 500) < $(document).height() )
		{
			$('#top-link-block').removeClass('hidden').affix(
			{
				offset: {top:500}
			});
		}
</script>
