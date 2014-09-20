<?php

function redirectTo($direction, $seconds = 0){
	echo '<META http-equiv="refresh" content="'.$seconds.';URL='.$direction.'">';
}

?>