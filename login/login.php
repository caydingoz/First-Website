<?php
session_start();

$iller = array( 'Adana', 'Adıyaman', 'Afyon', 'Ağrı', 'Amasya','Ankara', 'Antalya', 'Artvin',
'Aydın', 'Balıkesir', 'Bilecik', 'Bingöl', 'Bitlis', 'Bolu', 'Burdur', 'Bursa', 'Çanakkale',
'Çankırı', 'Çorum', 'Denizli', 'Diyarbakır', 'Edirne', 'Elazığ', 'Erzincan', 'Erzurum', 'Eskişehir',
'Gaziantep', 'Giresun', 'Gümüşhane', 'Hakkari', 'Hatay', 'Isparta', 'Mersin', 'İzmir', 
'Kars', 'Kastamonu', 'Kayseri', 'Kırklareli', 'Kırşehir', 'Kocaeli', 'Konya', 'Kütahya', 'Malatya', 
'Manisa', 'Kahramanmaraş', 'Mardin', 'Muğla', 'Muş', 'Nevşehir', 'Niğde', 'Ordu', 'Rize', 'Sakarya',
'Samsun', 'Siirt', 'Sinop', 'Sivas', 'Tekirdağ', 'Tokat', 'Trabzon', 'Tunceli', 'Şanlıurfa', 'Uşak',
'Van', 'Yozgat', 'Zonguldak', 'Aksaray', 'Bayburt', 'Karaman', 'Kırıkkale', 'Batman', 'Şırnak',
'Bartın', 'Ardahan', 'Iğdır', 'Yalova', 'Karabük', 'Kilis', 'Osmaniye', 'Düzce');

?>

<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript">
			function tologin(){
			var x = document.getElementById("login_container");
		    x.style.display = "block";
			var y = document.getElementById("signup_container");
			y.style.display = "none";
		}

		function tosignup(){
			var x = document.getElementById("signup_container");
		    x.style.display = "block";
			var y = document.getElementById("login_container");
			y.style.display = "none";
		}
		</script>

		<link href="../css/login.css" rel="stylesheet" type="text/css">
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="login">
<!----------------------------------GİRİŞ BÖLÜMÜ  --------------------------------------------------------->
			<div id="login_container">
				<h1>Login</h1>
				<?php //ERROR MESAJLARI--------------------------------------------------------------------------------
					$fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					if (strpos($fullUrl, "signup=empty")==true) {
						echo '<script type="text/javascript">tologin();</script>';
						echo "<p class='errormsg'>*Lütfen Hepsini Doldurunuz.</p>";
					}
					elseif (strpos($fullUrl, "password=incorrect")==true) {
						echo '<script type="text/javascript">tologin();</script>';
						echo "<p class='errormsg'>*Lütfen Şifreyi Doğru Giriniz.</p>";
					}
					elseif (strpos($fullUrl, "email=nouser")==true) {
						echo '<script type="text/javascript">tologin();</script>';
						echo "<p class='errormsg'>*Kullanıcı Bulunamadı.</p>";
					} 
					//ERROR MESAJLARI----------------------------------------------------------------------------?>
					
				<form  action="signin.php" method="POST">
					<label for="username">
						<i class="fas fa-envelope"></i>
					</label>
					<input type="text" name="loginemail" placeholder="E-mail" id="loginemail" required>
					<label for="password">
						<i class="fas fa-lock"></i>
					</label>
					<input type="password" name="loginpass" placeholder="Password" id="loginpass" required>
					<input type="submit" value="Login">
					<input type="button" id="tosignup_btn" onclick="tosignup();" value="Sign Up ">
				</form>
			</div>
<!--------------------------------------------KAYIT OLMA BÖLÜMÜ  --------------------------------------------------------->
			<div id="signup_container" style="display:none;">
				<h1>Sign Up</h1>
			<?php   
			//ERROR MESAJLARI--------------------------------------------------------------------------------
				$fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				if (strpos($fullUrl, "signup=empty")==true) {
					echo '<script type="text/javascript">tosignup();</script>';
					echo "<p class='errormsg'>*Lütfen Hepsini Doldurunuz.</p>";
				}
				elseif (strpos($fullUrl, "password=nomatch")==true) {
					echo '<script type="text/javascript">tosignup();</script>';
					echo "<p class='errormsg'>*Şifreniz Eşleşmiyor.</p>";
				}
				elseif (strpos($fullUrl, "name=invalid")==true) {
					echo '<script type="text/javascript">tosignup();</script>';
					echo "<p class='errormsg'>*Adınızı Kurallara Uygun Giriniz.</p>";
				}
				elseif (strpos($fullUrl, "email=used")==true) {
					echo '<script type="text/javascript">tosignup();</script>';
					echo "<p class='errormsg'>*E-Mail Kullanılmış.</p>";
				}
				elseif (strpos($fullUrl, "email=invalid")==true) {
					echo '<script type="text/javascript">tosignup();</script>';
					echo "<p class='errormsg'>*E-Mailinizi Kurallara Uygun Giriniz.</p>";
				}//ERROR MESAJLARI--------------------------------------------------------------------------------?>  

				<form action="signup.php" method="POST" >
					
					<label for="username">
						<i class="fas fa-user"></i>
					</label>
					<input type="text" name="name" placeholder="Adınız Soyadınız" id="name" required>

					<label for="email">
						<i class="fas fa-envelope"></i>
					</label>
					<input type="text" name="email" placeholder="E-mail" id="email" required>

					<label for="email">
						<i class="fas fa-map-marked-alt"></i>
					</label>
					<select id="il" name="il">
						<option value="33" >İstanbul</option>
						<?php
						foreach($iller as $key => $value)://key idsi.
						echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
						endforeach;
						?>
					</select>

					<label for="password">
						<i class="fas fa-lock"></i>
					</label>
					<input type="password" name="pass" placeholder="Password" id="pass" required>

					<label for="password">
						<i class="fas fa-lock"></i>
					</label>
					<input type="password" name="passConf" placeholder="Password Again" id="passConf" required>

					<input type="submit" value="Sign Up">
					<input type="button" id="tosignup_btn" onclick="tologin();" value="Login">
				</form>
		</div>
	</body>
</html>