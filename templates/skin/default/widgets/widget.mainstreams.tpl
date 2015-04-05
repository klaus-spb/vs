<div class="span6 ">

    <header class="block-header sep">
        <h5>Онлайн трансляции</h5>
    </header>
	
	<div class="block-content">	
		<ul class="nav nav-pills custom " {if $sItemsHook}style="display: none;"{/if}>
			<li class="active " data-type="mainstreams"><a href="#">Все</a></li>
		</ul>
		
		<div class="js-block-mainstreams-content" id="mainstreams">
			
		</div>
	</div>
</div>

<script>

function UpdateStreamsList(){
		var content = $( '#mainstreams' );
		var params = {}; 
		params['security_ls_key']=ALTO_SECURITY_KEY;
		ls.ajax(aRouter['ajax']+'main/streams/', params, function(result){
			content.html(result.sText);
		}.bind(this));
		
		setTimeout(function() { UpdateStreamsList(); }, 1000 * 300);
	}
	
$(function() {
	UpdateStreamsList();
});
</script>
