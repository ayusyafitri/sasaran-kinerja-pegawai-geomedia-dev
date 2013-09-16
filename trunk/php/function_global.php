<?php
function space($num=0,$mime='&nbsp;',$print=false) {
	for($loop=0; $loop<$num; $loop++)
		$space.=$mime;
	if($print)
		echo $space;
	else
		return $space;
}
?>