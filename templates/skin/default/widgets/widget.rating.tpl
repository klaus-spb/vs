<div class="span6 ">

    <header class="block-header sep">
        <h5>Лучшие игроки</h5>
    </header>
	
	<div class="block-content">
	
		<ul class="nav nav-pills custom js-block-rating-nav" {if $sItemsHook}style="display: none;"{/if}>
			<li class="active js-block-rating-item" data-type="rating" data-game="24" data-gametype="1"><a href="#">NHL 15</a></li>
			<li class=" js-block-rating-item" data-type="rating" data-game="28" data-gametype="1"><a href="#">FIFA 15</a></li>
			<li class=" js-block-rating-item" data-type="rating" data-game="30" data-gametype="1"><a href="#">NBA2K15</a></li>
			<li class=" js-block-rating-item" data-type="rating" data-game="23" data-gametype="8"><a href="#">UFC</a></li>

		</ul>
		
		<div class="js-block-rating-content">
			
			{$sRatings}
			
		</div>
	</div>
</div>
{if 1 ==2 && $oUserCurrent && ($oUserCurrent->getLogin()=='Klaus' || $oUserCurrent->getLogin()=='toomanyfaces')}
<style>

#match-com .stars-match {
width: 100%;
float: left;
}

#match-com .stars-match ul li .ava {
width: 20%;
}
#match-com .stars-match ul li .logo {
width: 42%;
}
#match-com .stars-match ul li .gonschik {
width: 42%;
}
</style>
<div class="span6 " id="match-com">
<header class="block-header sep">
        <h5>Игроки тимплея</h5>
    </header>
<div class="stars-match">
                       
            <ul>
				 <li>
                    <span class="ava"><a href="http://virtualsports.ru/profile/BURMISTROV10/"><img class="rounded" src="http://virtualsports.ru/uploads/images/00/02/69/2012/11/06/a72cce.jpg" alt=""></a></span>                    <span class="logo"><img src="http://img.virtualsports.ru/teams/teamplay/003_sos.png" alt="Название комманды"></span>
                    <span class="gonschik"><a href="http://virtualsports.ru/profile/BURMISTROV10/" class="star-author">Artur Khamatshin</a> <br>
                    <span class="nick">BURMISTROV10</span> </span>
                </li>
				<li>
					<span class="ava"><a href="http://virtualsports.ru/profile/toomanyfaces/"><img class="rounded" src="http://virtualsports.ru/uploads/images/00/00/11/2012/10/07/7ed906.jpg" alt=""></a></span>					<span class="logo"><img src="http://img.virtualsports.ru/teams/teamplay/003_sos.png" alt="Название комманды"></span>
					<span class="gonschik"><a href="http://virtualsports.ru/profile/toomanyfaces/" class="star-author">Anton Vinogradov</a> <br>
					<span class="nick">toomanyfaces</span> </span>
				</li>
			
						 
                	 
               
				<li>
                    <span class="ava"><a href="http://virtualsports.ru/profile/gorod12/"><img class="rounded" src="http://virtualsports.ru/uploads/images/00/00/06/2012/10/07/dfe538.png" alt=""></a></span>                    <span class="logo"><img src="http://img.virtualsports.ru/teams/teamplay/003_sos.png" alt="Название комманды"></span>
                    <span class="gonschik"><a href="http://virtualsports.ru/profile/gorod12/" class="star-author">Alexander Gorodetsky</a> <br>
                    <span class="nick">gorod12</span> </span>
                </li>
			
            </ul>
    </div> 
</div>
{/if}