<?php

//科目の合計
$senkiso = 0;
$agun = 0;
$b_1gun = 0;
$b_2gun = 0;
$cgun = 0;
$tokusyu = 0;
$other = 0;
$ryugaku = 0;
$semi = 0;
$gakka = "";
if(isset($_POST["gakka"])){$gakka = $_POST["gakka"];}//ラジオボタン
$result = 0;
$other_more = 0;//その他開講学部の授業で取得できる単位数
$part_aless = 0;//a群の足りない分
$part_b1less = 0;//b_1群の足りない分
$part_b2less = 0;//b_2群の足りない分
$part_cless = 0;//c群の足りない分
$sum_less = 0;//合計の足りない分
$error = "";

//各値の計算
if(isset($_POST["senkiso"])){
	foreach($_POST["senkiso"] as $value){
		$senkiso += intval($value);
	}
}
if(isset($_POST["agun"])){
	foreach($_POST["agun"] as $value){
		$agun += intval($value);
	}
}
if(isset($_POST["b_1gun"])){
	foreach($_POST["b_1gun"] as $value){
		$b_1gun += intval($value);
	}
}
if(isset($_POST["b_2gun"])){
	foreach($_POST["b_2gun"] as $value){
		$b_2gun += intval($value);
	}
}
if(isset($_POST["cgun"])){
	foreach($_POST["cgun"] as $value){
		$cgun += intval($value);
	}
}
if(isset($_POST["tokusyu"])){
	foreach($_POST["tokusyu"] as $value){
		$tokusyu += intval($value);
	}
}
if(isset($_POST["other"])){
	foreach($_POST["other"] as $value){
		$other += intval($value);
	}
	$other_more = 12 - $other;
}
if(isset($_POST["ryugaku"])){
	foreach($_POST["ryugaku"] as $value){
		$ryugaku += intval($value);
	}
}
if(isset($_POST["semi"])){
	foreach($_POST["semi"] as $value){
		$semi += intval($value);
	}
}

//学科ごとの計算
if($gakka == "keishisu"){
	if($agun < 12){
		$part_aless = 12 - $agun;
	}
	if($b_1gun < 24){
		$part_b1less = 24 - $b_1gun;
	}
	$result = $senkiso + $agun + $b_1gun + $b_2gun +$cgun + $tokusyu + $other + $ryugaku + $semi;
	if($result < 82){
		$sum_less = 82 - $result;
	}
}elseif($gakka == "houkei"){
	if($agun < 12){
		$part_aless = 12 - $agun;
	}
	if($b_2gun < 24){
		$part_b2less = 24 - $b_2gun;
	}
	$result = $senkiso + $agun + $b_1gun + $b_2gun +$cgun + $tokusyu + $other + $ryugaku + $semi;
	if($result < 82){
		$sum_less = 82 - $result;
	}
}elseif($gakka == "kokukei"){
	if($agun < 12){
		$part_aless = 12 - $agun;
	}
	if($cgun < 24){
		$part_cless = 24 - $cgun;
	}
	$result = $senkiso + $agun + $b_1gun + $b_2gun +$cgun + $tokusyu + $other + $ryugaku + $semi;
	if($result < 82){
		$sum_less = 82 - $result;
	}
}else{
	$error = "学科が選択されていません";
}



?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8" />
		<title>YNU経済学部必要単位チェッカー(結果)</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>
	</head>
<body>
<div data-role="page" id="home">
	<div data-role="header">
		<h1><font color="#4169e1">result</font></h1>
	</div>
	<div data-role="content">
	<?php if($gakka=="keishisu"):?>
	<h2>あなたは<font color="#4169e1"><i>「経済システム学科・経済コース」</i></font>です</h2>
	<?php elseif($gakka=="houkei"):?>
	<h2>あなたは<font color="#4169e1"><i>「経済システム学科・法と経済コース」</i></font>です</h2>
	<?php elseif($gakka=="kokukei"):?>
	<h2>あなたは<font color="#4169e1"><i>「国際経済学科」</i></font>です</h2>
	<?php else:?>
	<h2><?php echo $error;?></h2>
	<?php endif;?>
	<p>＊赤文字になっているところはあなたが最低限取得すべき単位です</p>
	<br/>
	<hr>
	<ul data-role="listview">
		<li>
			<h3>総取得単位数 :<?php echo htmlspecialchars($result,ENT_QUOTES,"UTF-8");?>単位</h3>
			<?php if($sum_less > 0):?>
			<h4>不足分：<font color="red"><?php echo htmlspecialchars($sum_less,ENT_QUOTES,"UTF-8");?>単位</font></h4>
			<?php else:?>
			<h4>不足分：<?php echo htmlspecialchars($sum_less,ENT_QUOTES,"UTF-8");?>単位</h4>
		<?php endif;?>
		<p>＊たとえ総取得単位数の不足分が0でも赤字の箇所がある場合は卒業認定されません</p>
		</li>
		<li>
			<h3>専門基礎科目: <?php echo htmlspecialchars($senkiso,ENT_QUOTES,"UTF-8");?>単位</h3>
		</li>
		<li>
			<h3>A群（学部共通）: <?php echo htmlspecialchars($agun,ENT_QUOTES,"UTF-8");?>単位</h3>
			<?php if($part_aless > 0):?>
			<h4>最低限取得すべき単位数：<font color="red"><?php echo htmlspecialchars($part_aless,ENT_QUOTES,"UTF-8");?>単位</font></h4>
			<?php else:?>
			<h4>最低限取得すべき単位数：<?php echo htmlspecialchars($part_aless,ENT_QUOTES,"UTF-8");?>単位</h4>
		<?php endif;?>
		</li>
		<li>
			<h3>B-1群（経済システム学科・経済コース）: <?php echo htmlspecialchars($b_1gun,ENT_QUOTES,"UTF-8");?>単位</h3>
			<?php if($part_b1less > 0):?>
			<h4>最低限取得すべき単位数：<font color="red"><?php echo htmlspecialchars($part_b1less,ENT_QUOTES,"UTF-8");?>単位</font></h4>
			<?php else:?>
			<h4>最低限取得すべき単位数：<?php echo htmlspecialchars($part_b1less,ENT_QUOTES,"UTF-8");?>単位</h4>
		<?php endif;?>
		</li>
		<li>
			<h3>B-2群（経済システム学科・法と経済コース）: <?php echo htmlspecialchars($b_2gun,ENT_QUOTES,"UTF-8");?>単位</h3>
			<?php if($part_b2less > 0):?>
			<h4>最低限取得すべき単位数：<font color="red"><?php echo htmlspecialchars($part_b2less,ENT_QUOTES,"UTF-8");?>単位</font></h4>
			<?php else:?>
			<h4>最低限取得すべき単位数：<?php echo htmlspecialchars($part_b2less,ENT_QUOTES,"UTF-8");?>単位</h4>
		<?php endif;?>
		</li>
		<li>
			<h3>C群（国際経済学科）: <?php echo htmlspecialchars($cgun,ENT_QUOTES,"UTF-8");?>単位</h3>
			<?php if($part_cless > 0):?>
			<h4>最低限取得すべき単位数：<font color="red"><?php echo htmlspecialchars($part_cless,ENT_QUOTES,"UTF-8");?>単位</font></h4>
			<?php else:?>
			<h4>最低限取得すべき単位数：<?php echo htmlspecialchars($part_cless,ENT_QUOTES,"UTF-8");?>単位</h4>
		<?php endif;?>
		</li>
		<li>
			<h3>他学部開講の専門科目: <?php echo htmlspecialchars($other,ENT_QUOTES,"UTF-8");?>単位</h3>
			<h4>取得できる単位数：<?php echo htmlspecialchars($other_more,ENT_QUOTES,"UTF-8");?>単位</h4>
			<p><small>＊経済学部以外の専門科目の取得には制限があります</small></p>
		</li>
	</ul>
	</div>
	<div data-role="footer">
		<h4>気になる点などは<a href="http://twitter.com/razokulover">Yuhei Nakasaka</a>までリプライをいただけるとありがたいです</h4>
		<h4>Copyright &copy; 2012 <a href="http://twitter.com/razokulover">Yuhei Nakasaka</a></h4>
	</div>
</div>
</body>
</html>