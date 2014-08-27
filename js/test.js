$(
	function () {
		$( "#left" ).imageScroller( {loading:'Espere por favor...',speed:'6000', direction:'left'} );
		
		$( "#right" ).imageScroller( {loading:'Espere por favor...',speed:'6000', direction:'right'} );
		
		$( "#top" ).imageScroller( {direction:'top'} );

		$( "#bottom" ).imageScroller( {speed:'3500', direction:'bottom'} );
	}
)