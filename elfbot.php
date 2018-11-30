<?php
		$main_content .=
		'<div class="news-top"></div>
<div class="news-mid"><div class="title-news">
<div class="title-news-text">Spis skryptow do Elf Bota</div class="title-news-text"></div class="title-news"><div class="title-news-buy">
Jak szybko zaznaczac caly skrypt ?<br>
kliknij w pole tekstowe ze stryptem<br>

i uzyj kombinacji klawiszy <b>Ctrl + A</b><br>
<br><br><br>


<b>auto haste (utani hur)</b>
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 haste" />
</form>
<b><br>

auto stronghaste (utani gran hur)
<form>
	<input type="text" name="nazwa" size="50" value="auto 150 stronghaste" />

</form>
<br><br>

auto magic shield (utamo vita)
<form>
	<input type="text" name="nazwa" size="50" value="auto 200 manashield" />
</form>
<br><br>

Jak sa kolo ciebie 3 potwory (widzi ich 4 kratki od siebie) i jak nie ma gracza + ma urzyc czar jak bedzie wiecej niz 1500 many bedzie bil z \'exevo gran mas frigo\', <br>a gdy bedzie czlowiek lub jak bedzie mniej niz 3 potwory (liczac 4 kratki ode mnie) to zeby bilo z exori frigo.
<form>
	<input type="text" name="nazwa" size="50" value="auto 1000 ifnoplayeronscreen { if [$monstersaround.4 >= 3 && $mp >= 1500] { say \'exevo gran mas frigo\' } } | ifplayeronscreen { if [$attacked.ismonster] { say \'exori frigo\' }" />
</form>
<br><br>

Ostatnia osoba exivowana
<form>
	<input type="text" name="nazwa" size="50" value="exivalast" />
</form>
<br><br>

Zaklada "Ston Skin Amulet"
<form>
	<input type="text" name="nazwa" size="50" value="auto 50 if [$amuletslot.id != 3081] equipammy 3081" />
</form>
<br><br>

Bije z runy o id 3187
<form>

	<input type="text" name="nazwa" size="50" value="auto 500 useoncreature 3187 target" />
</form>
<br><br>

Anty paral
<form>
	<input type="text" name="nazwa" size="50" value="auto 150 healparalysis utani hur" />
</form>
<br><br>

Bije z SD + reattack
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 useoncreature 3155 target | wait 500" />
</form>

<br><br>

Gdy masz x hp urzyje UHa
<form>
	<input type="text" name="nazwa" size="50" value="auto 200 if [$hp <= X] useoncreature 3160 self" />
</form>
<br><br>

Leczenie przyjaciela UH-ami
<form>
	<input type="text" name="nazwa" size="50" value="auto 200 foreach \'shootableplayers\' $blok {if [$blok.name == \'TuWpiszImieGracza\' && $blok.hp < X] uhpc 100 \'$blok.name\'} " />
</form>
<br><br>

UCHA PRZYJACIOL<br>

Dodaj kolege do \'List\' i wlacz ponizszy skrypt:
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 safe uhpc 70 friend" />
</form>
<br><br>

Re-attack
<form>
	<input type="text" name="nazwa" size="50" value="auto 200 attack target" />
</form>
<br><br>

Magwall target czyli rzuca Magic Walle 2 kratki przed "twarz" jezeli mamy ja zaznaczona.(F12)
<form>
	<input type="text" name="nazwa" size="50" value="magwall target" />

</form>
<br><br>

!soft gdy sie skoncza.<br>
id zepsutych softow: 6530
<form>
	<input type="text" name="nazwa" size="50" value="auto 500 if [$bootsslot.id == 6530] say !soft" />
</form>
<br><br>

Szybkie zatrzymywanie cavebota i targetingu
<form>
	<input type="text" name="nazwa" size="50" value="if [$targetingon || $waypointson] {statusmessage \'ElfBot NG - CaveBot Paused\' | settargeting off | setfollowwaypoints off | stopattack} else {statusmessage \'ElfBot NG - CaveBot Resumed\' | settargeting on | setfollowwaypoints on}" />
</form>

<br><br>

Alarm, jezeli GM wysle Ci wiadomosc albo pojawi sie czerwona wiadomosc
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 if [$curmsg.sender ? \'GM\' || ($curmsg.isredtext && $curmsg.isbroadcast)] {playsound \'gmdetected.wav\' | flash}" />
</form>
<br><br>

Auto lod po restarcie
<form>
	<input type="text" name="nazwa" size="50" value="auto 1000 if [$ss != 1] {if [$sstime != 0] set $ss 1} | if [$connected != 1 && $ss == 1] {wait (20 * 60 * 1000) | reconnect | wait 2000 | openbpitem | set $ss 0} | if [$connected != 1 && $ss != 1] {reconnect | wait 2000 | openbpitem}" />
</form>
<br><br>

Anty kick

<form>
	<input type="text" name="nazwa" size="50" value="auto 1000 listas \'Anti Idle\' | set $MIN 14 | turns | wait 300 | turnn | wait 300 | turne | wait 300 | turnw | wait [$MIN * 60000]" />
</form>
<br><br>

Jezeli bot sie zatnie to pojdzie jedna kratke w dol
<form>
	<input type="text" name="nazwa" size="50" value="auto 200 if [$standtime >= 10000] moves" />
</form>
<br><br>

Skrypt bedzie leczyl wszystkich przyjaciol ultimate healthpotionem<br>
Dodaj kolegow do \'List\'
<form>

	<input type="text" name="nazwa" size="50" value="auto 200 safe uhealth 70 friend" />
</form>
<br><br>

Jak zaznaczy target to atakuje z czaru "exori flam"
<form>
	<input type="text" name="nazwa" size="50" value="auto 250 isattacking say \'Exori Flam\' " />
</form>
<br><br>

Sprawdzanie pozycji x y z
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 listas \'$posx$ $posy$ $posz$\'" />
</form>

<br><br>

Reconect po deadzie
<form>
	<input type="text" name="nazwa" size="50" value="auto 200 if [$hp == 0] { reconnect } | wait 1000 | " />
</form>
<br><br>

Auto haste, kazdy rodzaj mozna ustawic
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 if [$hastetime <= 2000] say \'utamo tempo san\'" />
</form>
<br><br>

Auto "exura sio" na przyjaciela.

<form>
	<input type="text" name="nazwa" size="50" value="auto 200 sio 90 FriendName " />
</form>
<br><br>

Screen jesli awansujemy z lvl / skill.(ss)
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 foreach \'newmessages\' $v if [$v.color == 33516287 && $v.content ? \'You advanced\'] savescreen" />
</form>
<br><br>

Auto Utana vid (sam wrzuca utana vid jak sie skonczy)
<form>
	<input type="text" name="nazwa" size="50" value="auto 200 if [$invisible <= 300] say \'utana vid\' " />

</form>
<br><br>

Eat food
<form>
	<input type="text" name="nazwa" size="50" value="auto 1000 eatfood " />
</form>
<br><br>

Bot wysyla prywatna wiadomosc z informacja o exp/h ile brakuje do next lvl itd
<form>
	<input type="text" name="nazwa" size="50" value="pm \'$name\' \'$name l Exp Left: $exptnl l Exp/Hour: $exph l Time Left:$formattime.$timetnl l Gained this session: $expgained l Played this session: $formattime.$deltatime\'" />
</form>
<br><br>

Zmienia wyglad danego gracza np. w potwora
<form>
	<input type="text" name="nazwa" size="50" value="auto 2000 setoutfit \'NickGracza\' 110 " />
</form>
<br><br>

automatyczne siohanie przyjaciol<br>
jak ma sie wiecej niz 2k many
<form>
	<input type="text" name="nazwa" size="50" value="auto 200 if [$mp >= 2000] sio 70 friend | wait 800" />
</form>
<br><br>

gdy nastapi godzina 12:25:31, nasza postac bedzie juz zalogowana

<form>
	<input type="text" name="nazwa" size="50" value="auto 200 if [$systime == 12:25:31] connect \'swiat\' \'login\' \'haslo\' \'nick postaci\'" />
</form>
<br><br>

Alarm gdy Pk
<form>
	<input type="text" name="nazwa" size="50" value="auto 2000 listas \'AlarmPK\' | if [$attacker.isplayer == 1] {playsound \'playeronscreen.wav\' | flash}" />
</form>
<br><br>

Alarm gdy X Cap
<form>
	<input type="text" name="nazwa" size="50" value="auto 2000 listas \'AlarmCAP\' | if [$cap =< X] {playsound playeronscreen.wav | flash}" />

</form>
<br><br>

Alarm Bezczynnosci
<form>
	<input type="text" name="nazwa" size="50" value="auto 2000 listas \'Alarm Bezczynnosci\' | if [ $standtime >= 60*1000 ] {playsound playeronscreen.wav | flash}" />
</form>
<br><br>

Anty-Trap czyli przechodzenie przez skrzynki, parcele, boxy
<form>
	<input type="text" name="nazwa" size="50" value="auto 200 listas \'Anty-Trap\' | allowwalk 145 398 831 832 833 834 897 898 899 2775 2776 2777 2778 2779 2780 2781 2782 2783 2784 2785 2786 2787 2788 2789 2790 2791 2792 2793 2794 2795 2796 2797 2798 2799 2800 2801 2802 2803 2804 2805 2806 2984 2983 649 2774 6114 2523 6372 7864 2812 2981 2808 2811 6371 2807 6115 2809 2810 2468 2470" />
</form>
<br><br>

Auto Utito Tempo
<form>
	<input type="text" name="nazwa" size="50" value="auto 500 listas \'Utito Tempo\' | if [$strengthtime == 0] say \'utito tempo\'" />
</form>
<br><br>

Msg Box czyli widzimy 6 ostatich wiadomosci w lewym dolnym rogu [Trzeba miec zaznaczone w HUD "On-Screen Info Enabled"] od siebie dodam ze jest to swietna opcja 
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 listas \'MSG Box\'| listboxsetup 1 [$screenleft+6] [$screenbottom-2] 6 4500000 \'up\' | if $curmsg.isprivate { ifnot $curmsg.isbotlook { listboxaddline 1 $setcolor 237 242 \'$systime [$curmsg.sender]: [$curmsg.content]\' }}" />
</form>
<br><br>

Jesli nasza stamina spadnie do 14h bot stanie, zgubi pz i sie wyloguje
<form>
	<input type="text" name="nazwa" size="50" value="auto 1000 listas \'Log if 14h stamina\' | if [$stamina <= 60*14] {setcavebot off | $battlesign == 0] logout}" />

</form>
<br><br>

"Combo" leczenie [Spell + Potion]<br>
W miejsce NICK trzeba wpisac nick naszej postaci np Alex.<br>
W miejsce SPELL trzeba wpisac jakis czar leczacy np Exana Mort, badz Exura Gran<br>
W miejsce ID trzeba wpisac ID potiona.
<form>
	<input type="text" name="nazwa" size="50" value="auto 10 if [$curmsg.sender == \'NICK\' && $curmsg.content == \'SPELL\' && $curmsg.isdefault] useoncreature ID self" />
</form>
<br><br>

Rzuca magic walla tak aby odgrodzic dany cel od Twoich wrogow<br>

Wrogow dodac do \'List\'
<form>
	<input type="text" name="nazwa" size="50" value="auto 50 mwallcover target " />
</form>
<br><br>

Rzuca magic wall w miejsce, ktore ochroni Cie on przed najwieksza iloscia wrogow<br>
Wrogow dodac do \'List\'
<form>
	<input type="text" name="nazwa" size="50" value="auto 50 mwallshield" />
</form>
<br><br>

Jesli przypadkiem zaznaczysz kogos z danej gildii (lub swojej) to skrypt go odznaczy

<form>
	<input type="text" name="nazwa" size="50" value="auto 100 if [$target.haslookinfo && $target.guild == \'NAZWA GILDI\'] {stopattack | clear $target}" />
</form>
<br><br>

Wyswietla aktualne hp postaci w liczbie i w procentach
Wrogow dodac do \'List\'
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 dontlist | setpos 100 100 | setcolor 745769 | displaytext \'HP: $hp $hppc %\'" />
</form>
<br><br>

Wyswietla aktualna mane postaci w liczbie i w procentach
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 dontlist | setpos 100 100 | setcolor 745769 | displaytext \'MP: $mp $mppc %\'" />

</form>
<br><br>

Ilosc postaci, ktore znajduja sie wogol postaci
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 dontlist | setpos 100 100 | setcolor 745769 | displaytext \'Gracze wogol postaci: $playeraround.1\'" />
</form>
<br><br>

Ilosc kolegow  (dodanych w lists), ktorzy aktualnie sa na ekranie
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 dontlist | setpos 100 100 | setcolor 745769 | displaytext \'Przyjaciele na ekranie: $friendcount\'" />
</form>
<br><br>

Ilosc wrogow (dodanych w lists), ktorzy aktualnie sa na ekranie
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 dontlist | setpos 100 100 | setcolor 745769 | displaytext \'Wrogowie na ekranie: $enemycount\'" />
</form>
<br><br>

Ilosc potworow, ktore znajduja sie wokol postaci
<form>
	<input type="text" name="nazwa" size="50" value="auto 100 dontlist | setpos 100 100 | setcolor 745769 | displaytext \'Potwory wokol postaci: $monsteraround.1\'" />
</form>
<br><br>

Jesli postac posiada ponizej 50 SD wylacza cavebota i probuje sie wylogowac
<form>
	<input type="text" name="nazwa" size="50" value="auto 1000 if [$itemcount.\'Sudden Death Rune\'< 50] {setfollowwaypoints off | logout}" />

</form>
<br><br>

Jesli postac jest w pz wylaczy targeting a jesli jest poza pz wlaczy go.
<form>
	<input type="text" name="nazwa" size="50" value="auto 2000 if $inpz settargeting off | ifnot $inpz settargeting on " />
</form>
<br><br>

Zamiana w szczora poprzez uzycie czaru Utevo res ina
<form>
	<input type="text" name="nazwa" size="50" value="auto 500 if [$self.outfit != 21] say \'Utevo Res Ina "Rat\'" />
</form>
<br><br>

Jesli braknie SD bedzie bic z exori frigo.
<form>
	<input type="text" name="nazwa" size="50" value="auto 200 isattacking {if [$itemcount.\'Sudden Death\' < 2] say \'Exori Frigo\'} " />
</form>
<br><br>

Dash za potworem. Jesli zamiast NAZWA_STWORZENIA podstawisz Dragon, to postac bedzie "dashowac" za celem (dragonem)
<form>
	<input type="text" name="nazwa" size="50" value="auto 50 dashchase NAZWA_STWORZENIA " />
</form>
<br><br>
</b>




</div></div>
<div class="news-bottom"></div>
';
?>